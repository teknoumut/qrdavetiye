<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class InvitationPublicController extends Controller
{
    public function shortLink($shortLink)
    {
        $invitation = Invitation::where('short_link', $shortLink)
            ->where('is_published', true)
            ->where('is_active', true)
            ->firstOrFail();

        return redirect()->route('invitation.show', $invitation->slug);
    }

    public function show($slug)
    {
        $invitation = Invitation::where('slug', $slug)
            ->where('is_published', true)
            ->where('is_active', true)
            ->firstOrFail();

        return view('invitation.show', compact('invitation'));
    }

    public function rsvp(Request $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)
            ->where('is_published', true)
            ->where('is_active', true)
            ->firstOrFail();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:attending,not_attending,maybe',
            'guest_count' => 'required|integer|min:1|max:10',
            'message' => 'nullable|string|max:1000',
        ]);

        $invitation->rsvps()->create($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'RSVP kaydedildi.']);
        }

        return back()->with('success', 'Katılım durumunuz kaydedildi. Teşekkür ederiz!');
    }

    public function trackQrScan(Request $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        if ($invitation->qrCode) {
            $invitation->qrCode->increment('scan_count');
            $invitation->qrCode->scans()->create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        $invitation->increment('qr_scans');

        return redirect()->route('invitation.show', $slug);
    }

    public function sitemap()
    {
        $invitations = Invitation::published()->latest()->get();

        return response()->view('sitemap', compact('invitations'))->header('Content-Type', 'text/xml');
    }

    public function robots()
    {
        $sitemapUrl = route('sitemap');

        return response("User-agent: *\nAllow: /\nSitemap: $sitemapUrl\n")->header('Content-Type', 'text/plain');
    }
}
