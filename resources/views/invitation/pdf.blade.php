<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page { margin: 40px; }
    body { font-family: 'DejaVu Sans', sans-serif; color: #333; line-height: 1.6; }
    .header { text-align: center; margin-bottom: 30px; }
    .header h1 { font-size: 24px; margin: 0 0 5px; }
    .header p { font-size: 14px; color: #888; margin: 0; }
    .details { margin: 20px 0; }
    .details table { width: 100%; }
    .details td { padding: 8px 0; font-size: 13px; }
    .details td:first-child { font-weight: bold; width: 140px; color: #666; }
    .divider { border: none; border-top: 2px solid #d4af37; margin: 20px 0; }
    .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #999; }
    .invite-text { font-size: 14px; margin: 20px 0; padding: 20px; background: #fafafa; border-radius: 8px; }
</style>
</head>
<body>
<div class="header">
    <h1>{{ $ev['couple'] ? $fixName($invitation->groom_name) . ' & ' . $fixName($invitation->bride_name) : $fixName($invitation->groom_name) }}</h1>
    <p>{{ $ev['title'] }}</p>
</div>
<hr class="divider">
<div class="details">
    <table>
        @if($invitation->event_date)
        <tr><td>Tarih</td><td>{{ $invitation->event_date->format('d.m.Y') }}</td></tr>
        @endif
        @if($invitation->event_time)
        <tr><td>Saat</td><td>{{ $invitation->event_time }}</td></tr>
        @endif
        @if($invitation->event_location)
        <tr><td>Yer</td><td>{{ $invitation->event_location }}</td></tr>
        @endif
        @if($invitation->event_address)
        <tr><td>Adres</td><td>{{ $invitation->event_address }}</td></tr>
        @endif
    </table>
</div>
<hr class="divider">
@if($invitation->welcome_message)
<div class="invite-text">{{ strip_tags($invitation->welcome_message) }}</div>
@endif
<div class="footer">
    <p>senindavetiyen.com.tr</p>
</div>
</body>
</html>