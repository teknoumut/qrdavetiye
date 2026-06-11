<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\SubscriptionService;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefundController extends Controller
{
    public function index()
    {
        $requests = Invoice::with(['user', 'plan'])
            ->where('refund_status', 'requested')
            ->latest('refund_requested_at')
            ->paginate(30);

        $refunded = Invoice::with(['user', 'plan', 'refundApprover'])
            ->where('refund_status', 'refunded')
            ->latest('refunded_at')
            ->paginate(30);

        return view('admin.refund-requests.index', compact('requests', 'refunded'));
    }

    public function approve(Invoice $invoice)
    {
        if ($invoice->refund_status !== 'requested') {
            return back()->with('error', 'Bu fatura için bekleyen iade talebi bulunmuyor.');
        }

        try {
            DB::beginTransaction();

            $service = new SubscriptionService;
            $service->cancel($invoice->user);

            $invoice->update([
                'refund_status' => 'refunded',
                'refunded_at' => now(),
                'refunded_by' => auth()->id(),
            ]);

            DB::commit();

            Log::info('Refund approved', [
                'invoice_id' => $invoice->id,
                'user_id' => $invoice->user_id,
                'amount' => $invoice->amount + $invoice->tax_amount,
                'approved_by' => auth()->id(),
            ]);

            return back()->with('success', $invoice->user->name.' kullanıcısının iade talebi onaylandı. Aboneliği iptal edildi.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Refund approval failed', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'İade onaylanırken hata oluştu: '.$e->getMessage());
        }
    }

    public function reject(Request $request, Invoice $invoice)
    {
        if ($invoice->refund_status !== 'requested') {
            return back()->with('error', 'Bu fatura için bekleyen iade talebi bulunmuyor.');
        }

        $data = $request->validate([
            'reason' => 'nullable|string|max:1000',
        ]);

        $invoice->update([
            'refund_status' => 'rejected',
            'refund_reason' => $data['reason'] ?? $invoice->refund_reason,
        ]);

        Log::info('Refund rejected', [
            'invoice_id' => $invoice->id,
            'user_id' => $invoice->user_id,
            'rejected_by' => auth()->id(),
        ]);

        return back()->with('success', 'İade talebi reddedildi.');
    }
}
