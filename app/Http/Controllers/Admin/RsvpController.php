<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rsvp;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function index(Request $request)
    {
        $query = Rsvp::with('invitation.user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
                    ->orWhere('phone', 'like', "%{$s}%")
                    ->orWhereHas('invitation', function ($q) use ($s) {
                        $q->where('title', 'like', "%{$s}%");
                    });
            });
        }

        $total = (clone $query)->count();
        $attending = (clone $query)->where('status', 'attending')->sum('guest_count');
        $notAttending = (clone $query)->where('status', 'not_attending')->count();
        $maybe = (clone $query)->where('status', 'maybe')->count();

        $rsvps = $query->latest()->paginate(30)->withQueryString();

        return view('admin.rsvps.index', compact('rsvps', 'total', 'attending', 'notAttending', 'maybe'));
    }
}
