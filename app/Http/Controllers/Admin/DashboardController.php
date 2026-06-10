<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Invoice;
use App\Models\PaymentNotification;
use App\Models\Rsvp;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'passive_users' => User::where('is_active', false)->count(),
            'expiring_soon' => User::where('is_active', true)
                ->whereNotNull('subscription_end')
                ->whereBetween('subscription_end', [now(), now()->addDays(7)])
                ->count(),
            'expired' => User::where('is_active', true)
                ->whereNotNull('subscription_end')
                ->where('subscription_end', '<', now())
                ->count(),
            'total_invitations' => Invitation::count(),
            'total_views' => Invitation::sum('views'),
            'total_qr_scans' => Invitation::sum('qr_scans'),
            'total_rsvps' => Rsvp::count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_invitations' => Invitation::with('user')->latest()->take(5)->get(),
            'pending_payments' => PaymentNotification::pending()->count(),
            'recent_payments' => PaymentNotification::with(['user', 'plan'])->pending()->latest()->take(5)->get(),
            'total_revenue' => Invoice::where('status', 'paid')->sum('amount')
                + PaymentNotification::approved()->sum('amount'),
            'recent_invoices' => Invoice::with(['user', 'plan'])
                ->latest()
                ->take(5)
                ->get(),
            'recent_approved_payments' => PaymentNotification::with(['user', 'plan'])
                ->approved()
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', $data);
    }
}
