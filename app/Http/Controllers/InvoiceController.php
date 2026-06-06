<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }

        return view('invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download('fatura-'.$invoice->invoice_no.'.pdf');
    }
}
