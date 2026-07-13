<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $invitation = Invitation::with(['images', 'videos', 'music'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->where('is_active', true)
            ->firstOrFail();

        if (! session()->has('viewed_'.$invitation->id)) {
            $invitation->increment('views');
            session()->put('viewed_'.$invitation->id, true);
        }

        return view('invitation.show', compact('invitation'));
    }

    public function download($slug)
    {
        $invitation = Invitation::where('slug', $slug)
            ->where('is_published', true)
            ->where('is_active', true)
            ->firstOrFail();

        $ev = $this->eventLabels($invitation->event_type);
        $fixName = function ($txt) {
            return $txt ?? '';
        };

        $pdf = Pdf::loadView('invitation.pdf', compact('invitation', 'ev', 'fixName'));
        $filename = $ev['couple']
            ? $invitation->groom_name.'_'.$invitation->bride_name.'_davetiye.pdf'
            : $invitation->groom_name.'_davetiye.pdf';

        return $pdf->download($filename);
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

    private function eventLabels(?string $type): array
    {
        $labels = [
            'wedding' => ['title' => 'Düğün Davetiyesi', 'couple' => true],
            'engagement' => ['title' => 'Nişan Davetiyesi', 'couple' => true],
            'circumcision' => ['title' => 'Sünnet Davetiyesi', 'couple' => false],
            'birthday' => ['title' => 'Doğum Günü Davetiyesi', 'couple' => false],
            'corporate' => ['title' => 'Kurumsal Davetiye', 'couple' => false],
            'graduation' => ['title' => 'Mezuniyet Davetiyesi', 'couple' => false],
        ];

        return $labels[$type ?? 'wedding'] ?? $labels['wedding'];
    }
}
