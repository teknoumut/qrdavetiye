<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentGateway;
use App\Http\Services\SubscriptionService;
use App\Models\Invoice;
use App\Models\Plan;
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

    public function checkout(Plan $plan)
    {
        $error = $this->validatePlan($plan);
        if ($error) {
            return redirect()->route('home')->with('error', $error);
        }

        return view('checkout', compact('plan'));
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

        $price = $this->getPrice($plan, $interval);

        if (is_null($price) || $price < 0) {
            return redirect()->route('payment.fail', ['plan' => $plan->id])
                ->with('error', 'Bu plan için geçerli bir fiyat bulunamadı.');
        }

        $result = $this->gateway->initialize($user, $plan, $interval);

        if ($result->success && $result->redirectUrl) {
            return view('payment.pay', compact('redirectUrl'));
        }

        if ($result->success && ! $result->redirectUrl) {
            try {
                DB::beginTransaction();

                $service = new SubscriptionService;
                $service->activate($user, $plan, $interval);

                $invoice = $this->createInvoice($user, $plan, $interval, $price, $result->transactionId);

                DB::commit();

                Log::info('Payment processed successfully', [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'invoice_id' => $invoice->id,
                    'transaction_id' => $result->transactionId,
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
        $price = $this->getPrice($plan, $interval);

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
                $service->activate($user, $plan, $interval);

                $invoice = $this->createInvoice($user, $plan, $interval, $price, $result->transactionId);

                DB::commit();

                Log::info('Payment callback verified successfully', [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'invoice_id' => $invoice->id,
                    'transaction_id' => $result->transactionId,
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

    private function createInvoice($user, $plan, $interval, $price, ?string $transactionId = null): Invoice
    {
        $last = Invoice::latest()->first();
        $seq = $last ? (intval(substr($last->invoice_no, -4)) + 1) : 1;

        return Invoice::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'invoice_no' => 'INV-'.now()->format('Ymd').'-'.str_pad($seq, 4, '0', STR_PAD_LEFT),
            'interval' => $interval,
            'amount' => $price,
            'status' => 'paid',
            'gateway' => $this->gateway->getName(),
            'transaction_id' => $transactionId,
        ]);
    }
}
