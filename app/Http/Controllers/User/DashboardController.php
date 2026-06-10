<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\PaymentNotification;
use App\Models\Plan;
use App\Models\Rsvp;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $invitations = $user->invitations()->latest()->take(5)->get();
        $invitationIds = $user->invitations()->pluck('id');

        $plan = $user->plan;

        $features = [
            ['key' => 'music_feature', 'label' => 'Müzik Desteği', 'emoji' => '🎵', 'desc' => 'Davetiyene arka plan müziği ekle'],
            ['key' => 'video_feature', 'label' => 'Video Desteği', 'emoji' => '🎬', 'desc' => 'Davetiyene video ekle'],
            ['key' => 'rsvp_feature', 'label' => 'RSVP Katılım Takibi', 'emoji' => '✅', 'desc' => 'Davetlilerden online yanıt al'],
            ['key' => 'qr_download', 'label' => 'QR Kod İndirme', 'emoji' => '📱', 'desc' => 'QR kodunu indirip basılı davetiye yap'],
        ];

        $invoices = Invoice::where('user_id', $user->id)
            ->with('plan')
            ->latest()
            ->take(10)
            ->get();

        $missing_features = [];
        if ($plan) {
            foreach ($features as $f) {
                if (! $plan->{$f['key']}) {
                    $missing_features[] = $f;
                }
            }
        }

        $suggested_plan = null;
        if ($plan) {
            $suggested_plan = Plan::active()->where('monthly_price', '>', $plan->monthly_price)->orderBy('monthly_price')->first();
        } else {
            $suggested_plan = Plan::active()->orderBy('monthly_price')->first();
        }

        $latestPayment = PaymentNotification::where('user_id', $user->id)
            ->latest()
            ->first();

        $hasPendingPayment = PaymentNotification::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        $data = [
            'plan' => $plan,
            'payment_notification' => $latestPayment,
            'has_pending_payment' => $hasPendingPayment,
            'invoices' => $invoices,
            'missing_features' => $missing_features,
            'suggested_plan' => $suggested_plan,
            'total_invitations' => $invitationIds->count(),
            'published_invitations' => $user->invitations()->where('is_published', true)->count(),
            'total_views' => $user->invitations()->sum('views'),
            'total_qr_scans' => $user->invitations()->sum('qr_scans'),
            'total_rsvps' => Rsvp::whereIn('invitation_id', $invitationIds)->count(),
            'attending_rsvps' => Rsvp::whereIn('invitation_id', $invitationIds)->where('status', 'attending')->sum('guest_count'),
            'upcoming_events' => $user->invitations()->where('event_date', '>=', now())->orderBy('event_date')->take(5)->get(),
            'recent_invitations' => $invitations,
            'recent_rsvps' => Rsvp::whereIn('invitation_id', $invitationIds)->with('invitation')->latest()->take(10)->get(),
            'subscription_start' => $user->subscription_start,
            'subscription_end' => $user->subscription_end,
            'subscription_status' => $user->subscription_status,
            'is_subscribed' => $user->isSubscribed(),
            'is_cancelled' => $user->isCancelled(),
            'expiring_soon' => $user->isExpiringSoon(),
            'subscription_expired' => request()->attributes->get('subscription_expired', false),
            'needs_subscription' => request()->attributes->get('needs_subscription', false),
        ];

        return view('user.dashboard', $data);
    }
}
