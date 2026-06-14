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

        $oldInterval = $this->getUserInterval($user);

        $oldIntervalDays = $oldInterval === 'yearly' ? 365 : 30;
        $newIntervalDays = $newInterval === 'yearly' ? 365 : 30;

        $oldPrice = $this->getPrice($oldPlan, $oldInterval);
        $newPrice = $this->getPrice($newPlan, $newInterval);

        if (! $oldPrice || ! $newPrice) {
            return null;
        }

        $oldDailyRate = $oldPrice / $oldIntervalDays;
        $remainingValue = $remainingDays * $oldDailyRate;

        if ($oldInterval === $newInterval) {
            $newDailyRate = $newPrice / $newIntervalDays;

            if ($newDailyRate <= $oldDailyRate) {
                return null;
            }

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

        $difference = max(0, $newPrice - $remainingValue);

        if ($difference <= 0) {
            return null;
        }

        return [
            'remaining_days' => (int) ceil($remainingDays),
            'total_days' => $oldIntervalDays,
            'old_plan' => $oldPlan,
            'old_price' => $oldPrice,
            'new_price' => $newPrice,
            'remaining_value' => round($remainingValue, 2),
            'prorated_new_price' => round($newPrice, 2),
            'difference' => round($difference, 2),
        ];
    }

    private function getUserInterval(User $user): string
    {
        if ($user->subscription_start) {
            $diffDays = $user->subscription_start->diffInDays($user->subscription_end);

            return $diffDays >= 360 ? 'yearly' : 'monthly';
        }

        return 'monthly';
    }

    private function calculateSwitchPrice(User $user, Plan $plan): array
    {
        $oldInterval = $this->getUserInterval($user);

        if ($oldInterval !== 'monthly') {
            return ['monthly' => null, 'yearly' => null];
        }

        $remainingDays = max(0, now()->diffInDays($user->subscription_end, false));
        $oldDailyRate = $this->getPrice($plan, 'monthly') / 30;
        $newPrice = $this->getPrice($plan, 'yearly');

        if (! $oldDailyRate || ! $newPrice) {
            return ['monthly' => null, 'yearly' => null];
        }

        $remainingValue = $remainingDays * $oldDailyRate;
        $switchPrice = max(0, $newPrice - $remainingValue);

        return [
            'monthly' => null,
            'yearly' => [
                'type' => 'interval_switch',
                'difference' => round($switchPrice, 2),
                'remaining_days' => (int) ceil($remainingDays),
                'remaining_value' => round($remainingValue, 2),
                'old_price' => $this->getPrice($plan, 'monthly'),
                'new_price' => $newPrice,
            ],
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
        $switchType = null;

        if ($user && $user->subscription_status === User::STATUS_ACTIVE
            && $user->subscription_end && Carbon::parse($user->subscription_end)->isFuture()
        ) {
            $currentPlan = $user->plan;

            if ($currentPlan && $currentPlan->id === $plan->id) {
                $upgrade = $this->calculateSwitchPrice($user, $plan);
                $hasValid = false;
                foreach (['monthly', 'yearly'] as $int) {
                    if ($upgrade[$int] && $upgrade[$int]['difference'] > 0) {
                        $hasValid = true;
                        break;
                    }
                }
                if (! $hasValid) {
                    return redirect()->route('home')->with('error', 'Zaten bu pakete abonesiniz ya da geçerli bir periyot değişikliği bulunmuyor.');
                }
                $switchType = 'interval_switch';
            } else {
                $upgradeMonthly = $this->calculateUpgradePrice($user, $plan, 'monthly');
                $upgradeYearly = $this->calculateUpgradePrice($user, $plan, 'yearly');

                if ($upgradeMonthly || $upgradeYearly) {
                    $switchType = 'upgrade';
                    $upgrade = [
                        'monthly' => $upgradeMonthly,
                        'yearly' => $upgradeYearly,
                    ];
                } else {
                    return redirect()->route('home')->with('error', 'Daha düşük fiyatlı bir pakete geçiş yapmak için mevcut aboneliğinizi iptal etmeniz gerekmektedir. İptal ettikten sonra dilediğiniz paketi satın alabilirsiniz.');
                }
            }
        }

        return view('checkout', compact('plan', 'upgrade', 'switchType'));
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
