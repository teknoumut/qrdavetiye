<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentGateway;
use App\Http\Services\SubscriptionService;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(
        private PaymentGateway $gateway,
    ) {}

    private function validateInterval(string $interval): bool
    {
        return in_array($interval, ['monthly', 'yearly']);
    }

    private function getPrice(Plan $plan, string $interval): ?float
    {
        return $interval === 'yearly' ? $plan->yearly_price : $plan->monthly_price;
    }

    private function validatePlan(Plan $plan): ?string
    {
        if (! $plan->is_active) {
            return 'Bu plan şu anda aktif değil.';
        }

        return null;
    }

    private function calculateUpgradePrice(User $user, Plan $newPlan, string $newInterval): ?array
    {
        $oldPlan = $user->plan;
        if (! $oldPlan || ! $user->subscription_end || ! now()->lessThan($user->subscription_end)) {
            return null;
        }

        $remainingDays = max(0, now()->diffInDays($user->subscription_end, false));

        $oldInterval = 'monthly';
        if ($user->subscription_start) {
            $diffDays = $user->subscription_start->diffInDays($user->subscription_end);
            if ($diffDays >= 360) {
                $oldInterval = 'yearly';
            }
        }

        $oldIntervalDays = $oldInterval === 'yearly' ? 365 : 30;
        $newIntervalDays = $newInterval === 'yearly' ? 365 : 30;

        $oldPrice = $this->getPrice($oldPlan, $oldInterval);
        $newPrice = $this->getPrice($newPlan, $newInterval);

        if (! $oldPrice || ! $newPrice || $newPrice <= $oldPrice) {
            return null;
        }

        $oldDailyRate = $oldPrice / $oldIntervalDays;
        $newDailyRate = $newPrice / $newIntervalDays;

        $remainingValue = $remainingDays * $oldDailyRate;
        $proratedNewPrice = $remainingDays * $newDailyRate;
        $difference = max(0, $proratedNewPrice - $remainingValue);

        return [
            'remaining_days' => (int) ceil($remainingDays),
            'total_days' => $oldIntervalDays,
            'old_plan' => $oldPlan,
            'old_price' => $oldPrice,
            'new_price' => $newPrice,
            'remaining_value' => round($remainingValue, 2),
            'prorated_new_price' => round($proratedNewPrice, 2),
            'difference' => round($difference, 2),
        ];
    }

    public function checkout(Plan $plan)
    {
        $error = $this->validatePlan($plan);
        if ($error) {
            return redirect()->route('home')->with('error', $error);
        }

        $user = auth()->user();
        $upgrade = null;

        if ($user && $user->subscription_status === User::STATUS_ACTIVE
            && $user->subscription_end && Carbon::parse($user->subscription_end)->isFuture()
        ) {
            if ($user->plan_id === $plan->id) {
                return redirect()->route('home')->with('error', 'Zaten bu pakete abonesiniz.');
            }
            $upgrade = $this->calculateUpgradePrice($user, $plan, 'monthly');
            if (! $upgrade) {
                return redirect()->route('home')->with('error', 'Bu pakete yükseltme yapılamaz. Mevcut paketinizden daha düşük veya aynı fiyatlı paketler için yükseltme yapılamaz.');
            }
        }

        return view('checkout', compact('plan', 'upgrade'));
    }

    public function pay(Plan $plan, string $interval)
    {
        if (! $this->validateInterval($interval)) {
            return redirect()->route('home');
        }

        $error = $this->validatePlan($plan);
        if ($error) {
            return redirect()->route('home')->with('error', $error);
        }

        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $upgradeData = null;
        $isUpgrade = $user->subscription_status === User::STATUS_ACTIVE
            && $user->subscription_end && Carbon::parse($user->subscription_end)->isFuture();

        if ($isUpgrade) {
            $upgradeData = $this->calculateUpgradePrice($user, $plan, $interval);
            if (! $upgradeData) {
                return redirect()->route('payment.fail', ['plan' => $plan->id])
                    ->with('error', 'Bu pakete yükseltme yapılamaz.');
            }
        }

        $price = $isUpgrade ? $upgradeData['difference'] : $this->getPrice($plan, $interval);

        if (is_null($price) || $price < 0) {
            return redirect()->route('payment.fail', ['plan' => $plan->id])
                ->with('error', 'Bu plan için geçerli bir fiyat bulunamadı.');
        }

        $result = $this->gateway->initialize($user, $plan, $interval, $isUpgrade ? (float) $price : null);

        if ($result->success && $result->redirectUrl) {
            return view('payment.pay', compact('redirectUrl'));
        }

        if ($result->success && ! $result->redirectUrl) {
            try {
                DB::beginTransaction();

                $service = new SubscriptionService;
                if ($isUpgrade) {
                    $service->upgrade($user, $plan);
                } else {
                    $service->activate($user, $plan, $interval);
                }

                $invoice = $this->createInvoice($user, $plan, $interval, $price, $result->transactionId, $isUpgrade);

                DB::commit();

                Log::info('Payment processed successfully', [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'invoice_id' => $invoice->id,
                    'transaction_id' => $result->transactionId,
                    'is_upgrade' => $isUpgrade,
                ]);

                return redirect()->route('payment.success', ['plan' => $plan->id, 'invoice' => $invoice->id]);
            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error('Payment process failed', [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'error' => $e->getMessage(),
                ]);

                return redirect()->route('payment.fail', ['plan' => $plan->id])
                    ->with('error', 'Ödeme kaydedilirken bir hata oluştu.');
            }
        }

        Log::warning('Payment initialization failed', [
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'gateway' => $this->gateway->getName(),
            'error' => $result->message,
        ]);

        return redirect()->route('payment.fail', ['plan' => $plan->id])
            ->with('error', $result->message ?? 'Ödeme başlatılamadı.');
    }

    public function callback(Request $request)
    {
        if (! auth()->check()) {
            Log::warning('Payment callback received without auth', [
                'ip' => $request->ip(),
                'plan' => $request->plan,
            ]);

            return redirect()->guest(route('login'));
        }

        $plan = Plan::find($request->plan);
        if (! $plan) {
            Log::warning('Payment callback with invalid plan', [
                'user_id' => auth()->id(),
                'plan_id' => $request->plan,
            ]);

            return redirect()->route('home')->with('error', 'Plan bulunamadı.');
        }

        $error = $this->validatePlan($plan);
        if ($error) {
            return redirect()->route('home')->with('error', $error);
        }

        $interval = $request->interval;
        if (! $this->validateInterval($interval)) {
            return redirect()->route('home');
        }

        $user = auth()->user();

        $isUpgrade = $request->upgrade === '1'
            && $user->subscription_status === User::STATUS_ACTIVE
            && $user->subscription_end && Carbon::parse($user->subscription_end)->isFuture();

        if (! $isUpgrade) {
            if ($user->subscription_status === User::STATUS_ACTIVE
                && $user->subscription_end && Carbon::parse($user->subscription_end)->isFuture()
            ) {
                return redirect()->route('payment.fail', ['plan' => $plan->id])
                    ->with('error', 'Mevcut aboneliğiniz devam ederken yeni bir paket satın alamazsınız. Lütfen önce mevcut aboneliğinizi iptal edin.');
            }
        }

        $price = $isUpgrade ? (float) ($request->difference ?? 0) : $this->getPrice($plan, $interval);

        if (is_null($price) || $price < 0) {
            return redirect()->route('payment.fail', ['plan' => $plan->id])
                ->with('error', 'Bu plan için geçerli bir fiyat bulunamadı.');
        }

        try {
            $result = $this->gateway->verify($request->all());

            if ($result->success) {
                if ($result->transactionId && $this->transactionAlreadyUsed($result->transactionId)) {
                    Log::warning('Duplicate callback prevented', [
                        'user_id' => $user->id,
                        'transaction_id' => $result->transactionId,
                    ]);
                    $invoice = Invoice::where('transaction_id', $result->transactionId)->first();
                    if ($invoice) {
                        return redirect()->route('payment.success', ['plan' => $plan->id, 'invoice' => $invoice->id]);
                    }

                    return redirect()->route('payment.success', ['plan' => $plan->id]);
                }

                DB::beginTransaction();

                $service = new SubscriptionService;

                if ($isUpgrade) {
                    $service->upgrade($user, $plan);
                } else {
                    $service->activate($user, $plan, $interval);
                }

                $invoice = $this->createInvoice($user, $plan, $interval, $price, $result->transactionId, $isUpgrade);

                DB::commit();

                Log::info('Payment callback verified successfully', [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'invoice_id' => $invoice->id,
                    'transaction_id' => $result->transactionId,
                    'is_upgrade' => $isUpgrade,
                ]);

                return redirect()->route('payment.success', ['plan' => $plan->id, 'invoice' => $invoice->id]);
            }

            Log::warning('Payment callback verification failed', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'error' => $result->message,
            ]);

            return redirect()->route('payment.fail', ['plan' => $plan->id])
                ->with('error', $result->message ?? 'Ödeme doğrulanamadı.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Payment callback exception', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('payment.fail', ['plan' => $plan->id])
                ->with('error', 'Ödeme doğrulanırken bir hata oluştu.');
        }
    }

    public function success(Plan $plan)
    {
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $invoice = Invoice::where('user_id', $user->id)
            ->where('plan_id', $plan->id)
            ->latest()
            ->first();

        return view('payment.success', compact('plan', 'invoice'));
    }

    public function fail(Plan $plan)
    {
        return view('payment.fail', compact('plan'));
    }

    private function transactionAlreadyUsed(string $transactionId): bool
    {
        return Invoice::where('transaction_id', $transactionId)->exists();
    }

    private function getTaxRate(): float
    {
        return (float) Setting::getValue('tax_rate', 20);
    }

    private function createInvoice($user, $plan, $interval, $price, ?string $transactionId = null, bool $isUpgrade = false): Invoice
    {
        $last = Invoice::latest()->first();
        $seq = $last ? (intval(substr($last->invoice_no, -4)) + 1) : 1;
        $taxRate = $this->getTaxRate();

        return Invoice::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'invoice_no' => 'INV-'.now()->format('Ymd').'-'.str_pad($seq, 4, '0', STR_PAD_LEFT),
            'interval' => $interval,
            'amount' => $price,
            'tax_rate' => $taxRate,
            'tax_amount' => round($price * $taxRate / 100, 2),
            'status' => 'paid',
            'gateway' => $this->gateway->getName(),
            'transaction_id' => $transactionId,
            'is_upgrade' => $isUpgrade,
        ]);
    }
}
