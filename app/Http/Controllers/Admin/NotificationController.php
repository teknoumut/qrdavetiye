<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Invoice;
use App\Models\PaymentNotification;
use App\Models\Review;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    public function index()
    {
        session(['notifications_viewed_at' => now()]);

        $payments = PaymentNotification::with(['user', 'plan'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $reviews = Review::with('user')
            ->where('is_approved', false)
            ->latest()
            ->get();

        $messages = ContactMessage::where('is_read', false)
            ->latest()
            ->get();

        $refunds = Invoice::with('user')
            ->where('refund_status', 'requested')
            ->latest()
            ->get();

        $notifications = collect()
            ->merge($payments->map(fn ($i) => [
                'id' => $i->id,
                'type' => 'payment',
                'title' => 'Yeni Ödeme Bildirimi',
                'description' => $i->user?->name.' - '.$i->plan?->name.' ('.number_format($i->amount, 2).' TL)',
                'time' => $i->created_at,
                'url' => route('admin.payment-notifications.index'),
                'icon' => '💳',
            ]))
            ->merge($reviews->map(fn ($i) => [
                'id' => $i->id,
                'type' => 'review',
                'title' => 'Yeni Yorum',
                'description' => $i->user?->name.': '.Str::limit($i->comment, 80),
                'time' => $i->created_at,
                'url' => route('admin.reviews.index'),
                'icon' => '💬',
            ]))
            ->merge($messages->map(fn ($i) => [
                'id' => $i->id,
                'type' => 'message',
                'title' => 'Yeni İletişim Mesajı',
                'description' => $i->name.' - '.Str::limit($i->message, 80),
                'time' => $i->created_at,
                'url' => route('admin.contact-messages.index'),
                'icon' => '✉️',
            ]))
            ->merge($refunds->map(fn ($i) => [
                'id' => $i->id,
                'type' => 'refund',
                'title' => 'İade Talebi',
                'description' => $i->user?->name.' - '.($i->plan?->name ?? '').' ('.number_format($i->amount, 2).' TL)',
                'time' => $i->created_at,
                'url' => route('admin.refund-requests.index'),
                'icon' => '🔄',
            ]))
            ->sortByDesc('time')
            ->values();

        $stats = [
            'total' => $notifications->count(),
            'payments' => $payments->count(),
            'reviews' => $reviews->count(),
            'messages' => $messages->count(),
            'refunds' => $refunds->count(),
        ];

        return view('admin.notifications.index', compact('notifications', 'stats'));
    }

    public function markRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);

        return back()->with('success', 'Mesaj okundu olarak işaretlendi.');
    }
}
