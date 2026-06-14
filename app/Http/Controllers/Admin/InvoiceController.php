<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['user', 'plan'])
            ->latest()
            ->paginate(30);

        $totalRevenue = Invoice::where('status', 'paid')->sum('amount');
        $totalTax = Invoice::where('status', 'paid')->sum('tax_amount');

        return view('admin.invoices.index', compact('invoices', 'totalRevenue', 'totalTax'));
    }
}
