<?php

namespace App\Http\Services;

use App\Models\Invitation;

class InvitationService
{
    public function publish(Invitation $invitation): void
    {
        $invitation->update(['is_published' => true]);

        $qrService = app(QrCodeService::class);
        $qrService->generate($invitation);
    }

    public function unpublish(Invitation $invitation): void
    {
        $invitation->update(['is_published' => false]);
    }

    public function clone(Invitation $invitation): Invitation
    {
        $clone = $invitation->replicate();
        $clone->title = $invitation->title.' (Kopya)';
        $clone->slug = $invitation->slug.'-copy-'.uniqid();
        $clone->is_published = false;
        $clone->views = 0;
        $clone->qr_scans = 0;
        $clone->save();

        foreach ($invitation->images as $image) {
            $clone->images()->create($image->toArray());
        }

        return $clone;
    }

    public function getStats(Invitation $invitation): array
    {
        return [
            'views' => $invitation->views,
            'qr_scans' => $invitation->qr_scans,
            'rsvp_attending' => $invitation->rsvps()->where('status', 'attending')->count(),
            'rsvp_not_attending' => $invitation->rsvps()->where('status', 'not_attending')->count(),
            'rsvp_maybe' => $invitation->rsvps()->where('status', 'maybe')->count(),
            'total_guests' => $invitation->rsvps()->sum('guest_count'),
            'images_count' => $invitation->images()->count(),
            'videos_count' => $invitation->videos()->count(),
        ];
    }
}
