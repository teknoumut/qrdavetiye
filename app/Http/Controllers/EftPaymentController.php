<?php

namespace App\Http\Controllers;

use App\Models\PaymentNotification;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EftPaymentController extends Controller
{
    public function checkout(Plan $plan)
    {
        if (! $plan->is_active) {
            return redirect()->route('home')->with('error', 'Bu plan şu anda aktif değil.');
        }

        return view('payment.eft-checkout', compact('plan'));
    }

    public function show(Plan $plan, string $interval, Request $request)
    {
        if (! in_array($interval, ['monthly', 'yearly'])) {
            return redirect()->route('home');
        }

        if (! $plan->is_active) {
            return redirect()->route('home')->with('error', 'Bu plan şu anda aktif değil.');
        }

        $user = auth()->user();
        $isUpgrade = $request->boolean('upgrade');

        if (! $isUpgrade) {
            if ($user && $user->subscription_status === User::STATUS_ACTIVE
                && $user->subscription_end && Carbon::parse($user->subscription_end)->isFuture()
            ) {
                return redirect()->route('payment.eft.checkout', $plan)
                    ->with('error', 'Mevcut aboneliğiniz devam ederken yeni bir paket satın alamazsınız. Lütfen önce mevcut aboneliğinizi iptal edin.');
            }
        }

        if ($isUpgrade) {
            if (! $user || $user->subscription_status !== User::STATUS_ACTIVE || ! $user->subscription_end || ! Carbon::parse($user->subscription_end)->isFuture()) {
                return redirect()->route('payment.checkout', $plan)->with('error', 'Yükseltme için aktif bir aboneliğiniz bulunmuyor.');
            }

            $price = (float) ($request->difference ?? 0);
            if ($price <= 0) {
                return redirect()->route('payment.checkout', $plan)->with('error', 'Geçersiz yükseltme fiyatı.');
            }
        } else {
            $price = $interval === 'yearly' ? $plan->yearly_price : $plan->monthly_price;
        }

        if (is_null($price) || $price < 0) {
            return redirect()->route('home')->with('error', 'Geçersiz fiyat.');
        }

        $taxRate = (float) Setting::getValue('tax_rate', 20);
        $taxAmount = round($price * $taxRate / 100, 2);
        $total = round($price + $taxAmount, 2);

        $orderNo = PaymentNotification::generateOrderNo($isUpgrade ? 'UPG' : 'EFT');

        $bankName = Setting::getValue('bank_name', 'Ziraat Bankası');
        $iban = Setting::getValue('bank_iban', 'TR00 0000 0000 0000 0000 0000');
        $bankHolder = Setting::getValue('bank_holder', 'senindavetiyen.com.tr');

        return view('payment.eft', compact('plan', 'interval', 'price', 'taxRate', 'taxAmount', 'total', 'orderNo', 'bankName', 'iban', 'bankHolder', 'isUpgrade'));
    }

    public function notify(Request $request)
    {
        $data = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'interval' => 'required|in:monthly,yearly',
            'order_no' => 'required|string|max:50|unique:payment_notifications,order_no',
            'amount' => 'required|numeric|min:0',
            'is_upgrade' => 'boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        $plan = Plan::findOrFail($data['plan_id']);
        $isUpgrade = $request->boolean('is_upgrade');

        if ($isUpgrade) {
            $expectedPrice = (float) $data['amount'];
            $expectedTotal = $expectedPrice;
            $taxRate = 0;
            $taxAmount = 0;
        } else {
            $expectedPrice = $data['interval'] === 'yearly' ? $plan->yearly_price : $plan->monthly_price;
            $taxRate = (float) Setting::getValue('tax_rate', 20);
            $expectedTotal = round($expectedPrice * (1 + $taxRate / 100), 2);
            $taxAmount = round($expectedPrice * $taxRate / 100, 2);

            if (abs((float) $data['amount'] - $expectedTotal) > 0.01) {
                return back()->with('error', 'Gönderilen tutar plan ücreti ile uyuşmuyor. Lütfen doğru tutarı gönderdiğinizden emin olun.');
            }
        }

        try {
            $notification = PaymentNotification::create([
                'user_id' => auth()->id(),
                'plan_id' => $data['plan_id'],
                'order_no' => $data['order_no'],
                'interval' => $data['interval'],
                'amount' => $data['amount'],
                'subtotal' => $isUpgrade ? $data['amount'] : $expectedPrice,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'is_upgrade' => $isUpgrade,
                'status' => 'pending',
                'notes' => $data['notes'] ?? null,
            ]);

            Log::info('EFT payment notification submitted', [
                'user_id' => auth()->id(),
                'notification_id' => $notification->id,
                'order_no' => $data['order_no'],
                'is_upgrade' => $isUpgrade,
            ]);

            return redirect()->route('payment.eft.success', [
                'plan' => $plan->id,
                'order_no' => $data['order_no'],
            ])->with('success', 'Ödeme bildiriminiz alındı. Onay süreci tamamlandığında aboneliğiniz aktifleşecektir.');
        } catch (\Throwable $e) {
            Log::error('EFT notification creation failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Bildirim gönderilirken bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function success(Plan $plan, Request $request)
    {
        $orderNo = $request->order_no;

        return view('payment.eft-success', compact('plan', 'orderNo'));
    }
}
