<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id() && ! auth()->user()?->is_admin) {
            abort(403);
        }

        $canRequestRefund = $invoice->status === 'paid'
            && $invoice->refund_status === null
            && $invoice->created_at->diffInDays(now()) <= 7
            && ! auth()->user()?->is_admin;

        return view('invoices.show', compact('invoice', 'canRequestRefund'));
    }

    public function download(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id() && ! auth()->user()?->is_admin) {
            abort(403);
        }

        $logoBase64 = base64_encode(file_get_contents(public_path('images/logo.svg')));

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice', 'logoBase64'));

        return $pdf->download('fatura-'.$invoice->invoice_no.'.pdf');
    }

    public function requestRefund(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }

        if ($invoice->status !== 'paid' || $invoice->refund_status !== null) {
            return back()->with('error', 'Bu fatura için iade talebinde bulunamazsınız.');
        }

        if ($invoice->created_at->diffInDays(now()) > 7) {
            return back()->with('error', 'İade süresi (7 gün) dolmuştur.');
        }

        $data = $request->validate([
            'reason' => 'nullable|string|max:1000',
        ]);

        $invoice->update([
            'refund_status' => 'requested',
            'refund_requested_at' => now(),
            'refund_reason' => $data['reason'] ?? null,
        ]);

        return back()->with('success', 'İade talebiniz alındı. En kısa sürede tarafınıza dönüş yapılacaktır.');
    }
}
