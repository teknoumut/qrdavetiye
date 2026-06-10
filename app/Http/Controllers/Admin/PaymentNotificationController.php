<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\SubscriptionService;
use App\Models\Invoice;
use App\Models\PaymentNotification;
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
            $service->activate($notification->user, $notification->plan, $notification->interval);

            $notification->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
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
}
