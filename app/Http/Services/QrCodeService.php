<?php

namespace App\Http\Services;

use App\Models\Invitation;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    public function generate(Invitation $invitation): void
    {
        $url = route('invitation.show', $invitation->slug);

        $svg = QrCode::format('svg')
            ->size(400)
            ->margin(1)
            ->color(30, 30, 30)
            ->backgroundColor(255, 255, 255)
            ->generate($url);

        $path = 'invitations/qrcodes/'.$invitation->id;
        Storage::disk('public')->put($path.'/qrcode.svg', $svg);

        $qrData = $invitation->qrCode()->firstOrNew([]);
        $qrData->svg_path = $path.'/qrcode.svg';
        $qrData->save();
    }

    public function regenerateAll(): void
    {
        $invitations = Invitation::where('is_published', true)->get();
        foreach ($invitations as $invitation) {
            $this->generate($invitation);
        }
    }
}
