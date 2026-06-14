<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\SubscriptionService;
use App\Models\Invoice;
use App\Models\PaymentNotification;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentNotificationController extends Controller
{
    public function index()
    {
        $notifications = PaymentNotification::with(['user', 'plan', 'approver'])
            ->latest()
            ->paginate(30);

        $invoices = Invoice::with(['user', 'plan'])
            ->latest()
            ->paginate(30);

        return view('admin.payment-notifications.index', compact('notifications', 'invoices'));
    }

    public function approve(PaymentNotification $notification)
    {
        if ($notification->status !== 'pending') {
            return back()->with('error', 'Bu bildirim zaten işlenmiş.');
        }

        try {
            DB::beginTransaction();

            $service = new SubscriptionService;
            if ($notification->is_upgrade) {
                $service->upgrade($notification->user, $notification->plan);
            } else {
                $service->activate($notification->user, $notification->plan, $notification->interval);
            }

            $notification->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            $lastInvoice = Invoice::latest()->first();
            $seq = $lastInvoice ? (intval(substr($lastInvoice->invoice_no, -4)) + 1) : 1;

            $subtotal = $notification->subtotal ?? $notification->amount;
            $taxRate = $notification->tax_rate ?? (float) Setting::getValue('tax_rate', 20);
            $taxAmount = $notification->tax_amount ?? round($subtotal * $taxRate / 100, 2);

            Invoice::create([
                'user_id' => $notification->user_id,
                'plan_id' => $notification->plan_id,
                'invoice_no' => 'INV-'.now()->format('Ymd').'-'.str_pad($seq, 4, '0', STR_PAD_LEFT),
                'interval' => $notification->interval,
                'amount' => $subtotal,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'status' => 'paid',
                'gateway' => 'EFT/Havale',
                'transaction_id' => $notification->order_no,
                'is_upgrade' => $notification->is_upgrade,
            ]);

            DB::commit();

            Log::info('EFT payment approved', [
                'notification_id' => $notification->id,
                'order_no' => $notification->order_no,
                'user_id' => $notification->user_id,
                'approved_by' => auth()->id(),
            ]);

            return back()->with('success', $notification->user->name.' kullanıcısının aboneliği aktifleştirildi.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('EFT payment approval failed', [
                'notification_id' => $notification->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Onaylama sırasında bir hata oluştu: '.$e->getMessage());
        }
    }

    public function reject(Request $request, PaymentNotification $notification)
    {
        if ($notification->status !== 'pending') {
            return back()->with('error', 'Bu bildirim zaten işlenmiş.');
        }

        $data = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $notification->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'notes' => $data['notes'] ?? null,
        ]);

        Log::info('EFT payment rejected', [
            'notification_id' => $notification->id,
            'order_no' => $notification->order_no,
            'user_id' => $notification->user_id,
            'approved_by' => auth()->id(),
            'reason' => $data['notes'] ?? '',
        ]);

        return back()->with('success', 'Ödeme bildirimi reddedildi.');
    }

    public function resetRevenue()
    {
        DB::beginTransaction();
        try {
            Invoice::truncate();
            PaymentNotification::truncate();
            DB::commit();

            Log::warning('All payment records reset', ['by' => auth()->id()]);

            return redirect()->route('admin.payment-notifications.index')->with('success', 'Tüm ödeme kayıtları ve faturalar silindi. Gelir sıfırlandı.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Sıfırlama sırasında hata: '.$e->getMessage());
        }
    }

    public function destroy(PaymentNotification $notification)
    {
        $notification->delete();

        Log::info('Payment notification deleted', [
            'notification_id' => $notification->id,
            'deleted_by' => auth()->id(),
        ]);

        return back()->with('success', 'Ödeme bildirimi silindi.');
    }
}
