@php
    $primaryColor = $invitation->primary_color ?: '#d4af37';
    $hex = ltrim($primaryColor, '#');
    $r = max(0, hexdec(substr($hex, 0, 2)) - 25);
    $g = max(0, hexdec(substr($hex, 2, 2)) - 20);
    $b = max(0, hexdec(substr($hex, 4, 2)) - 30);
    $primaryDark = sprintf('#%02x%02x%02x', $r, $g, $b);
    $fontFamily = $invitation->font_family ?: 'Playfair Display';
    $isBlacksword = str_contains($fontFamily, 'Blacksword');
    $fixText = function($txt) use ($isBlacksword) {
        return $isBlacksword ? str_replace(['ı', 'İ'], ['i', 'İ'], $txt ?? '') : ($txt ?? '');
    };
    $fixName = $fixText;

    $eventType = $invitation->event_type ?: 'wedding';
    $eventLabels = [
        'wedding' => ['title' => 'Düğün Davetiyesi', 'slug' => 'Düğün', 'sub' => 'Aşkın Davetiyesi', 'couple' => true, 'parents' => true, 'showStory' => true, 'locationLabel' => 'Düğün Yeri', 'countdownLabel' => 'Düğün Günü', 'rsvpIcon' => '💍'],
        'engagement' => ['title' => 'Nişan Davetiyesi', 'slug' => 'Nişan', 'sub' => 'Mutluluğa İlk Adım', 'couple' => true, 'parents' => true, 'showStory' => true, 'locationLabel' => 'Nişan Yeri', 'countdownLabel' => 'Nişan Günü', 'rsvpIcon' => '💍'],
        'circumcision' => ['title' => 'Sünnet Davetiyesi', 'slug' => 'Sünnet', 'sub' => 'Bizimle Kutlayın', 'couple' => false, 'parents' => true, 'showStory' => false, 'locationLabel' => 'Etkinlik Yeri', 'countdownLabel' => 'Sünnet Günü', 'rsvpIcon' => '🎊'],
        'birthday' => ['title' => 'Doğum Günü Davetiyesi', 'slug' => 'Doğum Günü', 'sub' => 'Kutlamaya Davetlisiniz', 'couple' => false, 'parents' => true, 'showStory' => false, 'locationLabel' => 'Parti Yeri', 'countdownLabel' => 'Doğum Günü', 'rsvpIcon' => '🎂'],
        'corporate' => ['title' => 'Kurumsal Davetiye', 'slug' => 'Kurumsal', 'sub' => 'Davetimize Hoş Geldiniz', 'couple' => false, 'parents' => false, 'showStory' => false, 'locationLabel' => 'Etkinlik Yeri', 'countdownLabel' => 'Etkinlik Günü', 'rsvpIcon' => '📋'],
        'graduation' => ['title' => 'Mezuniyet Davetiyesi', 'slug' => 'Mezuniyet', 'sub' => 'Mezuniyet Sevincini Paylaşın', 'couple' => false, 'parents' => true, 'showStory' => false, 'locationLabel' => 'Mezuniyet Yeri', 'countdownLabel' => 'Mezuniyet Günü', 'rsvpIcon' => '🎓'],
    ];
    $ev = $eventLabels[$eventType] ?? $eventLabels['wedding'];

    $googleFontParams = [
        'Cormorant Garamond' => 'ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500',
        'Playfair Display' => 'ital,wght@0,400;0,500;0,600;0,700;1,400;1,500',
        'Great Vibes' => '',
        'Montserrat' => 'wght@300;400;500;600',
        'Lora' => 'ital,wght@0,400;0,500;0,600;1,400;1,500',
        'Poppins' => 'wght@300;400;500;600;700',
        'Inter' => 'wght@300;400;500;600;700',
        'Manrope' => 'wght@300;400;500;600;700',
        'Outfit' => 'wght@300;400;500;600;700',
        'Plus Jakarta Sans' => 'wght@300;400;500;600;700',
        'Cinzel' => 'wght@400;500;600;700',
        'Bodoni Moda' => 'ital,wght@0,400;0,500;0,600;0,700;1,400;1,500',
        'DM Serif Display' => '',
        'Space Grotesk' => 'wght@300;400;500;600;700',
        'Sora' => 'wght@300;400;500;600;700',
        'Exo 2' => 'wght@300;400;500;600;700',
        'Orbitron' => 'wght@400;500;600;700',
        'Rajdhani' => 'wght@300;400;500;600;700',
        'Bebas Neue' => '',
        'Anton' => '',
        'League Spartan' => 'wght@300;400;500;600;700',
        'Oswald' => 'wght@300;400;500;600;700',
        'Teko' => 'wght@300;400;500;600;700',
        'Allura' => '',
        'Parisienne' => '',
        'Alex Brush' => '',
    ];

    $gfUrl = 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500';
    if (isset($googleFontParams[$fontFamily])) {
        $param = $googleFontParams[$fontFamily];
        $slug = str_replace(' ', '+', $fontFamily);
        $gfUrl .= '&family=' . $slug . ($param ? ':' . $param : '');
    }
    $gfUrl .= '&display=swap';

    $cdnFontSlugs = [
        'Brittany Signature' => 'brittany-signature',
        'Anydore' => 'anydore',
        'Blacksword' => 'blacksword',
    ];
    $cdnFontUrl = null;
    if (isset($cdnFontSlugs[$fontFamily])) {
        $cdnFontUrl = 'https://fonts.cdnfonts.com/css/' . $cdnFontSlugs[$fontFamily];
    }
    // Anydore her zaman yüklensin (& işareti için)
    $anydoreFontUrl = 'https://fonts.cdnfonts.com/css/anydore';
@endphp
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@if($ev['couple']){{ $fixName($invitation->groom_name) }} & {{ $fixName($invitation->bride_name) }}@else{{ $fixName($invitation->groom_name) }}@endif - {{ $ev['title'] }}</title>
    <meta property="og:title" content="@if($ev['couple']){{ $fixName($invitation->groom_name) }} & {{ $fixName($invitation->bride_name) }}@else{{ $fixName($invitation->groom_name) }}@endif">
    <meta property="og:description" content="{{ $invitation->welcome_message ? Str::limit(strip_tags($invitation->welcome_message), 200) : $ev['title'] }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    @if($invitation->cover_image)
        <meta property="og:image" content="{{ \Illuminate\Support\Facades\Storage::url($invitation->cover_image) }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ $gfUrl }}" rel="stylesheet">
    @if($cdnFontUrl)<link href="{{ $cdnFontUrl }}" rel="stylesheet">@endif
    @if($fontFamily !== 'Anydore')<link href="{{ $anydoreFontUrl }}" rel="stylesheet">@endif
    <link href="{{ asset('css/invitation.css') }}" rel="stylesheet">
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Event",
        "name": "{{ $ev['couple'] ? $fixName($invitation->groom_name) . ' & ' . $fixName($invitation->bride_name) : $fixName($invitation->groom_name) }} - {{ $ev['title'] }}",
        "description": "{{ $invitation->welcome_message ? Str::limit(strip_tags($invitation->welcome_message), 300) : $ev['title'] }}",
        "startDate": "{{ $invitation->event_date ? $invitation->event_date->format('Y-m-d') : '' }}",
        "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
        "eventStatus": "https://schema.org/EventScheduled",
        "location": {
            "@type": "Place",
            "name": "{{ $invitation->venue_name ?? '' }}",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "{{ $invitation->city ?? '' }}",
                "addressCountry": "TR"
            }
        },
        "organizer": {
            "@type": "Organization",
            "name": "Senin Davetiyen",
            "url": "{{ config('app.url') }}"
        }
    }
    </script>
    <style>
        :root {
            --primary: {{ $primaryColor }};
            --primary-dark: {{ $primaryDark }};
            --bg: {{ $invitation->secondary_color ?: '#fefcf8' }};
            --font-body: 'Cormorant Garamond', serif;
            --font-display: '{{ $fontFamily }}', serif;
            --envelope-text: {{ $invitation->envelope_text_color ?: '#333333' }};
            --envelope-bg: {{ $invitation->envelope_bg_color ?: '#ffffff' }};
            --envelope-flap-bg: {{ $invitation->envelope_flap_color ?: '#ffffff' }};
        }
    </style>
    <style>
        body {

            font-family: var(--font-body);
            background: var(--bg);
            color: #2d2a24;
            line-height: 1.7;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        @media (prefers-color-scheme: dark) {
            body { background: #12121a; color: rgba(255,255,255,0.82); }
            .section { background: transparent !important; }
            .countdown-item { background: rgba(255,255,255,0.06); backdrop-filter: blur(10px); border-color: rgba(255,255,255,0.06); }
            .countdown-number { color: var(--primary); }
            .parent-card { background: rgba(255,255,255,0.04); backdrop-filter: blur(10px); border-color: rgba(255,255,255,0.06); }
            .parent-card .name { color: rgba(255,255,255,0.9); }
            .parent-card .relation { color: rgba(255,255,255,0.5); }
            .gallery img { box-shadow: 0 8px 30px rgba(0,0,0,0.3); }
            .rsvp-form { background: rgba(255,255,255,0.04); backdrop-filter: blur(16px); border-color: rgba(255,255,255,0.06); }
            .rsvp-form label { color: rgba(255,255,255,0.6); }
            .rsvp-form .field-icon { opacity: 0.5; }
            .rsvp-form input, .rsvp-form select, .rsvp-form textarea { background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.08); color: rgba(255,255,255,0.85); }
            .rsvp-form input::placeholder, .rsvp-form textarea::placeholder { color: rgba(255,255,255,0.2); }
            .rsvp-form input:focus, .rsvp-form select:focus, .rsvp-form textarea:focus { border-color: var(--primary); background: rgba(255,255,255,0.08); }
            .rsvp-form .status-options label { background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.08); color: rgba(255,255,255,0.6); }
            .rsvp-form .status-options input[type="radio"]:checked + label { background: color-mix(in srgb, var(--primary) 18%, transparent); }
            .rsvp-form .guest-count-wrapper { background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.08); }
            .rsvp-form .guest-count-wrapper input { background: transparent; color: rgba(255,255,255,0.85); }
            .rsvp-form .guest-btn { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.4); }
            .story-text { opacity: 0.6; }
            .music-label { background: rgba(0,0,0,0.4); color: rgba(255,255,255,0.5); }
        }

        .primary-color { color: var(--primary); }
        .bg-primary { background: var(--primary); }
        .border-primary { border-color: var(--primary); }

        .section { padding: 70px 24px; max-width: 800px; margin: 0 auto; text-align: center; overflow-x: hidden; }
        .section-title { font-family: var(--font-display); font-size: 3rem; margin-bottom: 16px; line-height: 1.2; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; letter-spacing: -0.5px; }
        .section-subtitle { font-family: var(--font-body); font-size: 0.8rem; letter-spacing: 4px; text-transform: uppercase; color: var(--primary); margin-bottom: 8px; font-weight: 500; position: relative; display: inline-block; }
        .section-subtitle::before,
        .section-subtitle::after { content: ' • '; opacity: 0.4; }
        .countdown { display: flex; justify-content: center; gap: 24px; margin: 30px 0; }
        .countdown-item { text-align: center; min-width: 70px; background: rgba(255,255,255,0.6); backdrop-filter: blur(10px); border-radius: 16px; padding: 16px 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.04); }
        .countdown-number { font-size: 2.5rem; font-weight: 600; font-family: 'Playfair Display', serif; }
        .countdown-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 2px; opacity: 0.5; margin-top: 6px; font-family: 'Montserrat', sans-serif; }
        .divider { width: 60px; height: 2px; margin: 20px auto; border-radius: 2px; background: linear-gradient(90deg, transparent, var(--primary), transparent); }
        .story-text { font-size: 1.05rem; line-height: 1.9; max-width: 560px; margin: 0 auto; opacity: 0.75; }
        .gallery { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; padding: 20px; }
        .gallery img { width: 100%; height: 280px; object-fit: contain; background: rgba(0,0,0,0.03); border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.06); transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.6s ease; }
        .gallery img:hover { transform: scale(1.04) translateY(-4px); box-shadow: 0 20px 60px rgba(0,0,0,0.1); }
        .rsvp-form {
            max-width: 520px; margin: 0 auto; text-align: left;
            background: rgba(255,255,255,0.45); backdrop-filter: blur(16px);
            border-radius: 24px; padding: 40px 36px;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 12px 48px rgba(0,0,0,0.04);
            position: relative; overflow: hidden;
        }
        .rsvp-form::before {
            content: ''; position: absolute; top: -60%; right: -40%;
            width: 280px; height: 280px;
            background: radial-gradient(circle, color-mix(in srgb, var(--primary) 10%, transparent), transparent 70%);
            border-radius: 50%; pointer-events: none;
        }
        .rsvp-form .field-group { margin-bottom: 18px; }
        .rsvp-form label {
            display: flex; align-items: center; gap: 6px;
            margin-bottom: 6px; font-weight: 500; font-size: 0.82rem;
            letter-spacing: 0.5px; color: rgba(0,0,0,0.55);
            font-family: 'Montserrat', sans-serif;
        }
        .rsvp-form .field-icon { font-size: 0.85rem; opacity: 0.7; }
        .rsvp-form input, .rsvp-form select, .rsvp-form textarea {
            width: 100%; padding: 13px 16px;
            border: 1.5px solid rgba(0,0,0,0.06); border-radius: 14px;
            font-size: 0.95rem; font-family: var(--font-body);
            background: rgba(255,255,255,0.85);
            transition: border-color 0.3s, box-shadow 0.3s, background 0.3s;
            outline: none; color: #2d2a24;
        }
        .rsvp-form input:focus, .rsvp-form select:focus, .rsvp-form textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--primary) 16%, transparent);
            background: rgba(255,255,255,0.96);
        }
        .rsvp-form input::placeholder, .rsvp-form textarea::placeholder {
            color: rgba(0,0,0,0.2); font-style: italic;
        }
        .rsvp-form select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23999' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 14px center;
            padding-right: 40px; cursor: pointer;
        }
        .rsvp-form button {
            width: 100%; padding: 15px 20px; border: none; border-radius: 14px;
            font-size: 1rem; cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600; letter-spacing: 0.5px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white; position: relative; overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .rsvp-form button::before {
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.12), transparent);
            transform: rotate(45deg) translateX(-100%); transition: transform 0.6s;
        }
        .rsvp-form button:hover::before { transform: rotate(45deg) translateX(100%); }
        .rsvp-form button:hover { transform: translateY(-2px); box-shadow: 0 8px 24px color-mix(in srgb, var(--primary) 30%, transparent); }
        .rsvp-form button:active { transform: translateY(0); }
        .rsvp-form .status-options {
            display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; margin-bottom: 18px;
        }
        .rsvp-form .status-options input[type="radio"] { display: none; }
        .rsvp-form .status-options label {
            display: flex; flex-direction: column; align-items: center; gap: 4px;
            padding: 12px 8px; border-radius: 14px;
            border: 1.5px solid rgba(0,0,0,0.06); cursor: pointer;
            font-size: 0.75rem; font-weight: 500; text-align: center;
            background: rgba(255,255,255,0.6);
            transition: all 0.25s; margin: 0;
        }
        .rsvp-form .status-options label:hover {
            border-color: var(--primary); background: color-mix(in srgb, var(--primary) 6%, transparent);
        }
        .rsvp-form .status-options input[type="radio"]:checked + label {
            border-color: var(--primary);
            background: color-mix(in srgb, var(--primary) 12%, transparent);
            box-shadow: 0 2px 8px color-mix(in srgb, var(--primary) 15%, transparent);
        }
        .rsvp-form .status-options .status-icon { font-size: 1.3rem; }
        .rsvp-form .guest-count-wrapper {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,0.6);
            border: 1.5px solid rgba(0,0,0,0.06); border-radius: 14px;
            padding: 4px; margin-bottom: 18px;
        }
        .rsvp-form .guest-count-wrapper input {
            border: none; margin: 0; text-align: center; font-size: 1.2rem;
            font-weight: 600; padding: 8px 4px; background: transparent;
            box-shadow: none; flex: 1;
        }
        .rsvp-form .guest-count-wrapper input:focus { box-shadow: none; background: transparent; }
        .rsvp-form .guest-btn {
            width: 38px; height: 38px; border-radius: 10px; border: none;
            background: rgba(0,0,0,0.04); cursor: pointer;
            font-size: 1.1rem; display: flex; align-items: center; justify-content: center;
            transition: background 0.2s; flex-shrink: 0;
            color: rgba(0,0,0,0.4);
        }
        .rsvp-form .guest-btn:hover { background: color-mix(in srgb, var(--primary) 15%, transparent); }
        .rsvp-form .guest-count-label { font-size: 0.75rem; color: rgba(0,0,0,0.35); font-family: 'Montserrat', sans-serif; white-space: nowrap; padding-right: 8px; }
        .map-container { width: 100%; height: 320px; border-radius: 16px; margin-top: 24px; overflow: hidden; box-shadow: 0 8px 30px rgba(0,0,0,0.06); }
        .footer { padding: 50px 24px; text-align: center; position: relative; overflow: hidden; }
        .footer::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); opacity: 0.9; }
        .footer > * { position: relative; z-index: 1; }
        .music-player { position: fixed; bottom: 24px; right: 24px; z-index: 100; display: flex; flex-direction: column; align-items: flex-end; gap: 8px; }
        .music-btn { width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.12); transition: all 0.3s; }
        .music-btn:hover { transform: scale(1.1); box-shadow: 0 8px 30px rgba(0,0,0,0.18); }
        .music-label { font-size: 0.65rem; color: rgba(0,0,0,0.4); letter-spacing: 1px; font-family: 'Montserrat', sans-serif; padding: 4px 12px; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px); border-radius: 20px; }

        /* ===== ENVELOPE SCREEN ===== */
        .envelope-screen {
            position: fixed; inset: 0; z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; overflow: hidden;
            background: var(--envelope-bg);
            transition: background 0.5s;
        }
        .envelope-screen.event-wedding,
        .envelope-screen.event-engagement,
        .envelope-screen.event-birthday,
        .envelope-screen.event-circumcision,
        .envelope-screen.event-graduation,
        .envelope-screen.event-corporate {
            background: var(--envelope-bg);
        }
        .envelope-screen.event-birthday .envelope-body,
        .envelope-screen.event-graduation .envelope-body,
        .envelope-screen.event-circumcision .envelope-body,
        .envelope-screen.event-corporate .envelope-body,
        .envelope-screen.event-wedding .envelope-body,
        .envelope-screen.event-engagement .envelope-body {
            background: var(--envelope-bg) !important;
        }
        .envelope-screen .envelope-seal {
            background: none;
        }
        .envelope-screen .particle-bg {
            position: absolute; inset: 0; pointer-events: none; overflow: hidden;
        }

        .envelope-screen .sparkle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            animation: sparkleFloat 4s ease-in-out infinite;
        }
        @keyframes sparkleFloat {
            0%, 100% { opacity: 0; transform: translateY(0) scale(0); }
            50% { opacity: 0.8; transform: translateY(-30px) scale(1); }
        }

        .envelope-screen .ring {
            position: absolute;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 50%;
            animation: ringExpand 5s ease-out infinite;
            pointer-events: none;
        }
        @keyframes ringExpand {
            0% { transform: scale(0.3); opacity: 0.5; }
            100% { transform: scale(2.5); opacity: 0; }
        }

        .envelope-screen .hint {
            position: absolute; bottom: 44px;
            color: rgba(255,255,255,0.3); font-size: 0.8rem;
            letter-spacing: 3px; animation: hintPulse 2.5s ease-in-out infinite;
            font-family: 'Montserrat', sans-serif; text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        @keyframes hintPulse {
            0%, 100% { transform: translateY(0); opacity: 0.2; }
            50% { transform: translateY(-8px); opacity: 0.6; }
        }

        .envelope-screen .floating-hearts {
            position: absolute; inset: 0; pointer-events: none; overflow: hidden;
        }
        .envelope-screen .floating-hearts span {
            position: absolute; font-size: 1.2rem; opacity: 0;
            animation: heartRise 6s ease-in infinite;
        }
        @keyframes heartRise {
            0% { opacity: 0; transform: translateY(100vh) rotate(0deg) scale(0.5); }
            20% { opacity: 0.3; }
            80% { opacity: 0.3; }
            100% { opacity: 0; transform: translateY(-100px) rotate(360deg) scale(1); }
        }

        .envelope-wrapper {
            position: relative;
            perspective: 1400px;
            z-index: 2;
            transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .envelope-wrapper:hover {
            transform: scale(1.04) translateY(-6px);
        }

        /* ===== 3D GERCEKCI ZARF ===== */
        .envelope {
            width: 460px; height: 310px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 1.2s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s, opacity 0.8s ease 0.2s;
            filter: drop-shadow(0 30px 80px rgba(0,0,0,0.2));
            transform: rotateX(3deg) rotateY(-4deg);
        }
        .envelope-wrapper:hover .envelope {
            transform: rotateX(2deg) rotateY(-7deg);
            filter: drop-shadow(0 40px 100px rgba(0,0,0,0.25));
        }
        .envelope.open {
            transform: scale(1.7) translateY(-70px) rotateX(6deg);
            opacity: 0;
            pointer-events: none;
            filter: drop-shadow(0 60px 120px rgba(0,0,0,0.25));
        }

        /* Zarf govdesi (arka yuz) */
        .envelope-body {
            position: absolute; inset: 0;
            background-color: var(--envelope-bg);
            border-radius: 3px;
            box-shadow:
                inset 0 -1px 0 rgba(0,0,0,0.04),
                0 1px 4px rgba(0,0,0,0.06);
            overflow: hidden;
            transform: translateZ(0);
        }
        /* Kagit lif dokusu */
        .envelope-body::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                repeating-linear-gradient(88deg, transparent, transparent 2px, rgba(255,255,255,0.012) 2px, rgba(255,255,255,0.012) 4px),
                repeating-linear-gradient(2deg, transparent, transparent 3px, rgba(255,255,255,0.008) 3px, rgba(255,255,255,0.008) 6px);
            pointer-events: none;
            z-index: 0;
        }
        /* Yan gussetler - zarfin yan katlanma cizgileri */
        .envelope-body .gusset-left,
        .envelope-body .gusset-right {
            position: absolute; top: 0; bottom: 0;
            width: 28px;
            pointer-events: none;
            z-index: 1;
        }
        .envelope-body .gusset-left {
            left: 0;
            background: linear-gradient(90deg, rgba(0,0,0,0.12) 0%, rgba(0,0,0,0.04) 35%, transparent 100%);
        }
        .envelope-body .gusset-left::after {
            content: '';
            position: absolute; left: 24px; top: 0; bottom: 0;
            width: 1px;
            background: linear-gradient(180deg, transparent, rgba(0,0,0,0.08), transparent);
        }
        .envelope-body .gusset-right {
            right: 0;
            background: linear-gradient(270deg, rgba(0,0,0,0.12) 0%, rgba(0,0,0,0.04) 35%, transparent 100%);
        }
        .envelope-body .gusset-right::after {
            content: '';
            position: absolute; right: 24px; top: 0; bottom: 0;
            width: 1px;
            background: linear-gradient(180deg, transparent, rgba(0,0,0,0.08), transparent);
        }
        /* Alt kat izi */
        .envelope-body .bottom-fold {
            position: absolute; bottom: 0; left: 0; right: 0;
            height: 20px;
            background: linear-gradient(0deg, rgba(0,0,0,0.08) 0%, transparent 100%);
            pointer-events: none;
            z-index: 1;
        }
        .envelope-body .bottom-fold::after {
            content: '';
            position: absolute; top: 0; left: 24px; right: 24px;
            height: 1px;
            background: rgba(0,0,0,0.05);
        }
        /* Watermark desen */
        .envelope-body .pattern-watermark,
        .envelope-inner .pattern-watermark {
            position: absolute; inset: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.15;
            pointer-events: none;
            z-index: 1;
            mix-blend-mode: soft-light;
        }
        /* Ucgen gusset - zarfin yan ucgen katlantilari */
        .envelope-body .triangle-left,
        .envelope-body .triangle-right {
            position: absolute;
            width: 24px; height: 40px;
            pointer-events: none;
            z-index: 1;
        }
        .envelope-body .triangle-left {
            left: 0; top: 50%;
            margin-top: -20px;
            background: linear-gradient(135deg, rgba(0,0,0,0.05) 0%, transparent 100%);
            clip-path: polygon(0 0, 100% 50%, 0 100%);
        }
        .envelope-body .triangle-right {
            right: 0; top: 50%;
            margin-top: -20px;
            background: linear-gradient(-135deg, rgba(0,0,0,0.05) 0%, transparent 100%);
            clip-path: polygon(100% 0, 0 50%, 100% 100%);
        }

        /* Flap - zarf kapağı (içe dönük) */
        .envelope-flap {
            position: absolute; top: 0; left: 0; right: 0;
            height: 90px;
            transform: translateZ(0);
            transform-origin: top center;
            transition: transform 0.9s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s;
            z-index: 3;
            background: transparent;
            overflow: visible;
        }
        .envelope-flap .flap-bg {
            position: absolute; inset: 0;
            clip-path: polygon(0% 0%, 50% 105%, 100% 0%);
            -webkit-clip-path: polygon(0% 0%, 50% 105%, 100% 0%);
            pointer-events: none;
        }

        .envelope.open .envelope-flap {
            transform: rotateX(185deg);
        }
        /* Flap gölge - kaldirildi */

        /* Flap içindeki kalp */
        .flap-heart {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.6rem;
            z-index: 5;
            pointer-events: none;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));
        }
        .envelope.open .flap-heart {
            opacity: 0;
            transform: translate(-50%, -50%) scale(0) rotate(380deg);
            transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s;
        }

        /* Ic kisim - mektup */
        .envelope-inner {
            position: absolute;
            top: 12px; left: 12px; right: 12px; bottom: 12px;
            background: linear-gradient(160deg, #fffdf7, #fefcf8);
            border-radius: 2px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 26px;
            text-align: center;
            z-index: 1;
            box-shadow:
                inset 0 2px 8px rgba(0,0,0,0.03),
                0 0 0 1px rgba(0,0,0,0.02);
        }
        .envelope-inner::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                repeating-linear-gradient(0deg, transparent, transparent 1px, rgba(0,0,0,0.006) 1px, rgba(0,0,0,0.006) 2px);
            pointer-events: none;
        }
        /* Mektup kat izi */
        .envelope-inner .letter-fold {
            position: absolute;
            left: 0; right: 0; top: 50%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0,0,0,0.03), transparent);
        }
        .envelope-inner::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                repeating-linear-gradient(0deg, transparent, transparent 1px, rgba(0,0,0,0.008) 1px, rgba(0,0,0,0.008) 2px);
            pointer-events: none;
        }
        .envelope-inner .heart {
            font-size: 2.8rem;
            animation: heartBeat 1.8s ease-in-out infinite;
            filter: drop-shadow(0 2px 8px rgba(255,0,0,0.2));
            margin-bottom: 4px;
        }
        @keyframes heartBeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.12); }
        }
        .envelope-inner .names {
            font-family: var(--font-display);
            font-size: 2.8rem;
            color: var(--envelope-text);
            margin: 8px 0 6px;
            line-height: 1.3;
            text-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        .envelope-inner .names .ampersand {
            font-family: 'Anydore', cursive;
            font-size: 3.8rem;
            color: var(--primary);
            display: inline-block;
            margin: 0 4px;
            line-height: 1;
            filter: drop-shadow(0 1px 3px rgba(0,0,0,0.08));
        }
        .envelope-inner .sub {
            font-size: 0.7rem;
            color: var(--envelope-text);
            text-transform: uppercase;
            letter-spacing: 3px;
            font-family: 'Montserrat', sans-serif;
            opacity: 0.8;
            font-weight: 500;
        }
        .envelope-inner .env-message {
            font-size: 0.7rem;
            color: var(--envelope-text);
            opacity: 0.7;
            margin-top: 10px;
            line-height: 1.5;
            max-width: 90%;
            font-family: 'Montserrat', sans-serif;
            display: -webkit-box;
            -webkit-line-clamp: 6;
            -webkit-box-orient: vertical;
            overflow: hidden;
            overflow-wrap: break-word;
            word-break: break-word;
        }
        .envelope-inner .deco-line {
            width: 50px;
            height: 1.5px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            margin: 8px auto;
            opacity: 0.5;
            border-radius: 2px;
        }

        .envelope-glow {
            position: absolute; top: 50%; left: 50%;
            width: 140px; height: 140px;
            background: radial-gradient(circle, color-mix(in srgb, var(--primary) 20%, transparent), transparent 70%);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0.8);
            transition: all 1.2s ease;
            pointer-events: none;
            z-index: 0;
        }
        .envelope.open ~ .envelope-glow { transform: translate(-50%, -50%) scale(5); opacity: 0; }

        /* Floating letter */
        .floating-letter {
            position: absolute;
            width: 250px; height: 170px;
            background: linear-gradient(160deg, #fffdf7, #fff);
            border-radius: 10px;
            box-shadow: 0 24px 70px rgba(0,0,0,0.18);
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 24px;
            opacity: 0;
            transform: translateY(30px) scale(0.7) rotate(-5deg);
            transition: all 1s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s;
            pointer-events: none;
            border: 1px solid rgba(255,255,255,0.5);
        }
        .floating-letter.show {
            opacity: 1;
            transform: translateY(-70px) scale(1) rotate(0deg);
            box-shadow: 0 40px 100px rgba(0,0,0,0.2);
            pointer-events: auto;
        }
        .envelope-inner { user-select: text; }
        .floating-letter { user-select: text; }
        .floating-letter .heart-icon { font-size: 1.6rem; margin-bottom: 8px; animation: heartBeat 2s ease-in-out infinite; }
        .floating-letter .letter-names { font-family: var(--font-display); font-size: 1rem; color: #555; }
        .floating-letter .letter-names .ampersand { font-family: 'Anydore', cursive; font-size: 1.4rem; color: var(--primary); display: inline-block; line-height: 1; }
        .floating-letter .letter-sub { font-size: 0.6rem; color: #999; letter-spacing: 3px; text-transform: uppercase; font-family: 'Montserrat', sans-serif; margin-top: 6px; font-weight: 500; }
        .floating-letter .letter-msg { font-size: 0.6rem; color: #888; line-height: 1.5; margin-top: 6px; max-width: 85%; font-family: 'Montserrat', sans-serif; display: -webkit-box; -webkit-line-clamp: 5; -webkit-box-orient: vertical; overflow: hidden; overflow-wrap: break-word; word-break: break-word; }
        .floating-letter .letter-deco {
            width: 36px; height: 1.5px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            margin: 8px auto;
            opacity: 0.4;
        }

        /* Particle burst */
        .particle {
            position: absolute;
            border-radius: 50%;
            opacity: 0;
            pointer-events: none;
            z-index: 3;
        }
        .particle.burst {
            animation: particleBurst 1.5s ease-out forwards;
        }
        @keyframes particleBurst {
            0% { opacity: 1; transform: translate(0, 0) scale(1); }
            100% { opacity: 0; transform: translate(var(--tx), var(--ty)) scale(0); }
        }
        .particle.heart-shape {
            border-radius: 0;
            clip-path: path('M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z');
        }

        /* Confetti */
        .confetti-piece {
            position: absolute;
            opacity: 0;
            pointer-events: none;
            z-index: 3;
        }
        .confetti-piece.burst {
            animation: confettiFall 2.5s ease-out forwards;
        }
        @keyframes confettiFall {
            0% { opacity: 1; transform: translate(0, 0) rotate(0deg) scale(1); }
            100% { opacity: 0; transform: translate(var(--tx), var(--ty)) rotate(1080deg) scale(0.2); }
        }

        .invitation-content {
            opacity: 0;
            transition: opacity 1s ease 0.5s;
        }
        .invitation-content.visible {
            opacity: 1;
        }

        /* Cover */
        /* ===== KAPAK BOLUMU ===== */
        .cover-section {
            min-height: 100vh;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 24px;
            overflow: hidden;
            isolation: isolate;
            -webkit-transform: translate3d(0,0,0);
            transform: translate3d(0,0,0);
        }
        .cover-section .cover-video {
            position: absolute; inset: 0; width: 100%; height: 100%;
            object-fit: cover; pointer-events: none; z-index: -1;
            overflow: hidden;
        }
        .cover-section .cover-video iframe {
            position: absolute; top: 50%; left: 50%; width: 200%; height: 200%;
            border: 0; z-index: -1; pointer-events: none;
            transform: translate(-50%, -50%) scale(1.6);
        }
        .cover-section .cover-video video {
            position: absolute; top: 50%; left: 50%; width: 200%; height: 200%;
            border: 0; z-index: -1;
            transform: translate(-50%, -50%) scale(1.6);
        }
        .cover-section .cover-bg {
            position: absolute; inset: 0; z-index: 3;
            background: @if($invitation->cover_image) url("{{ \Illuminate\Support\Facades\Storage::url($invitation->cover_image) }}") @else linear-gradient(145deg, #1a1a2e, #0f3460) @endif;
            background-size: cover;
            background-position: center;
            filter: saturate(1.1);
            transform: scale(1.05) translateZ(0);
            transition: transform 0.1s ease-out;
            will-change: transform;
        }
        .cover-section.has-video .cover-bg {
            opacity: 0.55;
        }
        .cover-section .cover-bg::after {
            content: ''; position: absolute; inset: 0; z-index: 1;
            background: linear-gradient(180deg, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.4) 30%, rgba(0,0,0,0.45) 60%, rgba(0,0,0,0.7) 100%);
            transform: translateZ(0);
        }
        .cover-section .cover-bg::before {
            content: ''; position: absolute; inset: 0; z-index: 2;
            background: radial-gradient(ellipse at 50% 30%, transparent 0%, rgba(0,0,0,0.35) 100%);
            transform: translateZ(0);
        }
        .cover-section .cover-overlay {
            position: absolute; inset: 0; z-index: 4;
            background: radial-gradient(ellipse at center, transparent 0%, rgba(0,0,0,0.2) 100%);
            transform: translateZ(0);
        }
        /* Cover dekoratif cizgi */
        .cover-section .cover-deco {
            position: absolute; left: 50%; top: 50%;
            transform: translate(-50%, -50%);
            width: 80vmin; height: 80vmin;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
            animation: coverRing 4s ease-in-out infinite;
        }
        .cover-section .cover-deco:nth-child(2) {
            width: 60vmin; height: 60vmin;
            border-color: rgba(255,255,255,0.04);
            animation-delay: -1.5s;
        }
        .cover-section .cover-deco:nth-child(3) {
            width: 40vmin; height: 40vmin;
            border-color: rgba(255,255,255,0.03);
            animation-delay: -3s;
        }
        @keyframes coverRing {
            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; }
            50% { transform: translate(-50%, -50%) scale(1.08); opacity: 1; }
        }
        .cover-section .cover-particles {
            position: absolute; inset: 0; pointer-events: none; overflow: hidden;
            z-index: 5;
        }
        .cover-section .cover-particle {
            position: absolute; width: 2px; height: 2px; background: rgba(255,255,255,0.3); border-radius: 50%;
            animation: coverParticle 6s linear infinite;
        }
        @keyframes coverParticle {
            0% { transform: translateY(100vh) translateX(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-10vh) translateX(50px); opacity: 0; }
        }
        .cover-section .names {
            font-family: var(--font-display);
            font-size: 4.5rem;
            margin-bottom: 8px;
            text-shadow: 0 4px 40px rgba(0,0,0,0.4);
            position: relative;
            line-height: 1.15;
            animation: coverFadeUp 1.2s cubic-bezier(0.22, 1, 0.36, 1);
            z-index: 10;
            letter-spacing: -0.5px;
        }
        .cover-section .names .groom,
        .cover-section .names .bride {
            display: block;
        }
        .cover-section .date {
            font-size: 1rem;
            letter-spacing: 5px;
            text-transform: uppercase;
            opacity: 0.8;
            position: relative;
            font-family: 'Montserrat', sans-serif;
            font-weight: 300;
            animation: coverFadeUp 1.2s cubic-bezier(0.22, 1, 0.36, 1) 0.2s both;
            z-index: 10;
            margin-top: 16px;
        }
        .cover-section .date::before,
        .cover-section .date::after {
            content: '——';
            margin: 0 12px;
            opacity: 0.3;
            letter-spacing: -2px;
        }
        .cover-section .ampersand {
            font-family: 'Anydore', cursive;
            font-size: 5.5rem;
            opacity: 0.5;
            margin: 0 12px;
            display: inline-block;
            filter: drop-shadow(0 2px 20px rgba(255,255,255,0.1));
            line-height: 0;
            vertical-align: middle;
        }
        .cover-section .scroll-indicator {
            position: absolute; bottom: 36px; z-index: 10;
            color: rgba(255,255,255,0.35); font-size: 0.7rem; letter-spacing: 3px; text-transform: uppercase;
            font-family: 'Montserrat', sans-serif; cursor: pointer;
            animation: coverFadeUp 1.2s cubic-bezier(0.22, 1, 0.36, 1) 0.8s both;
            display: flex; flex-direction: column; align-items: center; gap: 8px;
            transition: opacity 0.3s;
        }
        .cover-section .scroll-indicator:hover { opacity: 0.7; }
        .cover-section .scroll-indicator .line {
            width: 1px; height: 30px; background: linear-gradient(180deg, rgba(255,255,255,0.4), transparent);
            animation: scrollLine 2s ease-in-out infinite;
        }
        @keyframes scrollLine {
            0%, 100% { transform: scaleY(0.3); opacity: 0.2; }
            50% { transform: scaleY(1); opacity: 0.8; }
        }
        @keyframes coverFadeUp {
            from { opacity: 0; transform: translateY(40px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ===== AILELER BOLUMU ===== */
        .parents-grid {
            display: flex; flex-wrap: wrap; justify-content: center; gap: 32px;
            max-width: 620px; margin: 0 auto;
        }
        .parent-card {
            min-width: 230px;
            padding: 28px 24px; border-radius: 20px;
            background: rgba(255,255,255,0.5); backdrop-filter: blur(12px);
            border: 1px solid rgba(0,0,0,0.04);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        .parent-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            opacity: 0.3;
        }
        .parent-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.06);
        }
        .parent-card .name {
            font-family: var(--font-display);
            font-size: 1.5rem;
            margin-bottom: 6px;
            position: relative;
        }
        .parent-card .relation {
            font-size: 0.85rem;
            opacity: 0.55;
            font-style: italic;
            font-family: var(--font-body);
        }

        /* Scroll progress bar */
        .scroll-progress {
            position: fixed; top: 0; left: 0; right: 0; height: 3px; z-index: 10000;
            background: linear-gradient(90deg, var(--primary), color-mix(in srgb, var(--primary) 60%, #e05278));
            transform-origin: left; transform: scaleX(0);
            transition: transform 0.1s linear;
        }

        /* Parallax cover */
        .cover-parallax {
            transform: translateZ(0);
            will-change: transform;
        }

        /* Floating decorative elements */
        .float-deco {
            position: fixed; pointer-events: none; z-index: 0;
            font-size: 1.4rem; opacity: 0;
            transition: opacity 1s ease;
        }
        .float-deco.visible { opacity: 0.12; }

        .animate-on-scroll {
            opacity: 0;
            transition: opacity 0.9s cubic-bezier(0.22, 1, 0.36, 1), transform 0.9s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .animate-on-scroll.fade-up {
            transform: translateY(50px);
        }
        .animate-on-scroll.fade-left {
            transform: translateX(-50px);
        }
        .animate-on-scroll.fade-right {
            transform: translateX(50px);
        }
        .animate-on-scroll.zoom-in {
            transform: scale(0.88);
        }
        .animate-on-scroll.zoom-out {
            transform: scale(1.08);
        }
        .animate-on-scroll.rotate-in {
            transform: perspective(800px) rotateX(8deg) translateY(40px);
            transform-origin: top center;
        }
        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0) translateX(0) scale(1) perspective(800px) rotateX(0);
        }

        @media (max-width: 768px) {
            .cover-section .names { font-size: 2.6rem; }
            .cover-section .ampersand { font-size: 3.2rem; }
            .cover-section .date { font-size: 0.75rem; letter-spacing: 3px; }
            .cover-section .date::before,
            .cover-section .date::after { margin: 0 6px; }
            .cover-section .cover-video { display: none; }
            .cover-section.has-video .cover-bg { opacity: 1; }
            .section-title { font-size: 2rem; }
            .section { padding: 50px 20px; }
            .countdown { gap: 12px; flex-wrap: wrap; }
            .countdown-item { min-width: 60px; padding: 12px 8px; }
            .countdown-number { font-size: 1.8rem; }
            .envelope { width: 360px; height: 250px; }
            .envelope-flap { top: 0; height: 80px; }
            .envelope-inner { top: 8px; left: 8px; right: 8px; bottom: 8px; padding: 18px; }
            .envelope-inner .names { font-size: 1.8rem; }
            .envelope-inner .heart { font-size: 2.4rem; }
            .envelope-inner .env-message { font-size: 0.65rem; -webkit-line-clamp: 6; }
            .envelope.open { transform: scale(1.5) translateY(-50px) rotateX(5deg); }
            .envelope-body .gusset-left,
            .envelope-body .gusset-right { width: 20px; }
            .envelope-body .bottom-fold { height: 16px; }
            .floating-letter { width: 220px; height: 150px; padding: 16px; }
            .floating-letter .letter-names { font-size: 0.9rem; }
            .floating-letter .letter-msg { font-size: 0.55rem; -webkit-line-clamp: 4; }
            .parents-grid { gap: 24px; }
            .parent-card { min-width: 160px; }
            .gallery { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); }
            .gallery img { height: 200px; object-fit: contain; }
            .rsvp-form { padding: 24px; }
        }

        @media (max-width: 420px) {
            .envelope { width: 300px; height: 216px; }
            .envelope-flap { top: 0; height: 68px; }
            .envelope-inner { top: 8px; left: 8px; right: 8px; bottom: 8px; padding: 16px; }
            .envelope-inner .heart { font-size: 2rem; }
            .envelope-inner .names { font-size: 1.8rem; }
            .envelope-inner .sub { font-size: 0.6rem; }
            .envelope-inner .env-message { font-size: 0.6rem; -webkit-line-clamp: 5; }
            .envelope.open { transform: scale(1.3) translateY(-40px) rotateX(4deg); }
            .floating-letter { width: 190px; height: 125px; padding: 14px; }
            .floating-letter .letter-msg { font-size: 0.5rem; -webkit-line-clamp: 3; }
            .floating-letter.show { transform: translateY(-40px) scale(1) rotate(0deg); }
        }

        @media (max-width: 640px) {
            .section-title { font-size: 1.6rem; }
            .section { padding: 36px 16px; }
            .story-text { font-size: 0.92rem; }
            .parents-grid { gap: 16px; }
            .parent-card { min-width: 140px; padding: 20px 16px; }
            .parent-card .name { font-size: 1.2rem; }
            .parent-card .relation { font-size: 0.75rem; }
            .countdown { gap: 8px; }
            .countdown-item { min-width: 48px; padding: 10px 6px; }
            .countdown-number { font-size: 1.5rem; }
            .countdown-label { font-size: 0.6rem; }
            .gallery { padding: 12px; gap: 10px; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); }
            .gallery img { height: 140px; border-radius: 14px; }
            .map-container { height: 220px; border-radius: 12px; }
            .rsvp-form { padding: 28px 20px; }
            .rsvp-form .field-group { margin-bottom: 22px; }
            .rsvp-form .status-options { grid-template-columns: 1fr 1fr; gap: 6px; }
            .rsvp-form .status-options label { flex-direction: row; padding: 10px 12px; }
            .rsvp-form .guest-count-wrapper { gap: 6px; }
            .rsvp-form .guest-btn { width: 36px; height: 36px; }
            .rsvp-form input, .rsvp-form select, .rsvp-form textarea { padding: 13px 14px; font-size: 0.95rem; min-height: 48px; box-sizing: border-box; }
            .rsvp-form label { font-size: 0.78rem; }
            .cover-section { padding: 16px; }
            .cover-section .names { font-size: 2rem; }
            .cover-section .ampersand { font-size: 2.5rem; }
            .cover-section .date { font-size: 0.65rem; letter-spacing: 2px; margin-top: 10px; }
            .cover-section .date::before, .cover-section .date::after { margin: 0 4px; }
            .cover-section .scroll-indicator { bottom: 20px; font-size: 0.6rem; }
            .footer { padding: 32px 16px; }
        }
        @media (max-width: 480px) {
            .rsvp-form { padding: 22px 14px; }
            .rsvp-form .status-options { grid-template-columns: 1fr; }
        }
        @media (max-width: 380px) {
            .rsvp-form { padding: 18px 12px; }
            .rsvp-form .field-group { margin-bottom: 18px; }
            .rsvp-form .guest-count-wrapper { gap: 4px; }
            .rsvp-form .guest-btn { width: 32px; height: 32px; font-size: 0.9rem; }
            .rsvp-form input, .rsvp-form select, .rsvp-form textarea { padding: 11px 10px; font-size: 0.9rem; min-height: 44px; }
            .section-title { font-size: 1.4rem; }
            .section { padding: 28px 12px; }
            .story-text { font-size: 0.85rem; }
            .parent-card { min-width: 120px; padding: 16px 12px; }
            .parent-card .name { font-size: 1.1rem; }
            .countdown-item { min-width: 42px; padding: 8px 4px; }
            .countdown-number { font-size: 1.2rem; }
            .gallery { padding: 8px; gap: 6px; grid-template-columns: 1fr; }
            .gallery img { height: 200px; }
        }

        /* ===== ENVELOPE PATTERNS (body only) ===== */
        .envelope-body.pattern-lace {
            background-image: repeating-linear-gradient(45deg, rgba(255,255,255,0.35) 0px, rgba(255,255,255,0.35) 2px, transparent 2px, transparent 8px),
                              repeating-linear-gradient(-45deg, rgba(255,255,255,0.35) 0px, rgba(255,255,255,0.35) 2px, transparent 2px, transparent 8px),
                              linear-gradient(160deg, var(--primary), var(--primary-dark));
        }
        .envelope-body.pattern-lace::after,
        .envelope-body.pattern-floral::after,
        .envelope-body.pattern-geometric::after,
        .envelope-body.pattern-stars::after,
        .envelope-body.pattern-damask::after,
        .envelope-body.pattern-minimal::after,
        .envelope-body.pattern-leaf::after,
        .envelope-body.pattern-vine::after,
        .envelope-body.pattern-blossom::after,
        .envelope-body.pattern-botanic::after,
        .envelope-body.pattern-fern::after,
        .envelope-body.pattern-petal::after {
            display: none;
        }
        .envelope-body.pattern-floral {
            background-image: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.35) 0%, rgba(255,255,255,0.35) 3px, transparent 3px),
                              radial-gradient(circle at 80% 70%, rgba(255,255,255,0.35) 0%, rgba(255,255,255,0.35) 3px, transparent 3px),
                              radial-gradient(circle at 50% 50%, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0.18) 5px, transparent 5px),
                              linear-gradient(160deg, var(--primary), var(--primary-dark));
            background-size: 40px 40px, 40px 40px, 60px 60px, auto;
        }
        .envelope-body.pattern-geometric {
            background-image: repeating-linear-gradient(0deg, rgba(255,255,255,0.35) 0px, rgba(255,255,255,0.35) 2px, transparent 2px, transparent 22px),
                              repeating-linear-gradient(90deg, rgba(255,255,255,0.35) 0px, rgba(255,255,255,0.35) 2px, transparent 2px, transparent 22px),
                              linear-gradient(160deg, var(--primary), var(--primary-dark));
            background-size: 24px 24px, 24px 24px, auto;
        }
        .envelope-body.pattern-stars {
            background-image: radial-gradient(circle at 15% 20%, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0.4) 3px, transparent 3px),
                              radial-gradient(circle at 85% 25%, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.3) 2px, transparent 2px),
                              radial-gradient(circle at 45% 75%, rgba(255,255,255,0.35) 0%, rgba(255,255,255,0.35) 3px, transparent 3px),
                              radial-gradient(circle at 70% 60%, rgba(255,255,255,0.28) 0%, rgba(255,255,255,0.28) 2px, transparent 2px),
                              linear-gradient(160deg, var(--primary), var(--primary-dark));
            background-size: 60px 60px, 60px 60px, 60px 60px, 60px 60px, auto;
        }
        .envelope-body.pattern-hearts {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 40 40'%3E%3Cpath fill='rgba(255,255,255,0.3)' d='M20 36.7l-2.4-2.2C9 26.3 3.3 21.2 3.3 14.8c0-5 4-9 9-9 2.9 0 5.7 1.4 7.7 3.5 2-2.1 4.8-3.5 7.7-3.5 5 0 9 4 9 9 0 6.4-5.7 11.5-14.3 19.7L20 36.7z'/%3E%3C/svg%3E"),
                              linear-gradient(160deg, var(--primary), var(--primary-dark));
            background-size: 36px 36px, auto;
        }
        .envelope-body.pattern-hearts::after {
            display: none;
        }
        .envelope-body.pattern-damask {
            background-image: repeating-conic-gradient(rgba(255,255,255,0.28) 0% 25%, transparent 0% 50%),
                              linear-gradient(160deg, var(--primary), var(--primary-dark));
            background-size: 28px 28px, auto;
        }
        .envelope-body.pattern-minimal {
            background-image: repeating-linear-gradient(90deg, rgba(255,255,255,0.35) 0px, rgba(255,255,255,0.35) 2px, transparent 2px, transparent 18px),
                              linear-gradient(160deg, var(--primary), var(--primary-dark));
            background-size: 20px 100%, auto;
        }
        .envelope-body.pattern-leaf {
            background-image: repeating-linear-gradient(12deg, transparent 0px, transparent 14px, rgba(255,255,255,0.28) 14px, rgba(255,255,255,0.28) 16px, transparent 16px, transparent 30px),
                              linear-gradient(90deg, transparent 46%, rgba(255,255,255,0.32) 46%, rgba(255,255,255,0.32) 54%, transparent 54%),
                              linear-gradient(160deg, var(--primary), var(--primary-dark));
        }
        .envelope-body.pattern-vine {
            background-image: repeating-linear-gradient(50deg, transparent 0px, transparent 24px, rgba(255,255,255,0.25) 24px, rgba(255,255,255,0.25) 27px, transparent 27px, transparent 48px),
                              repeating-linear-gradient(-50deg, transparent 0px, transparent 14px, rgba(255,255,255,0.18) 14px, rgba(255,255,255,0.18) 16px, transparent 16px, transparent 40px),
                              linear-gradient(160deg, var(--primary), var(--primary-dark));
        }
        .envelope-body.pattern-blossom {
            background-image: radial-gradient(circle at 15% 25%, rgba(255,255,255,0.32) 0%, rgba(255,255,255,0.32) 3px, transparent 3px),
                              radial-gradient(circle at 10% 30%, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.2) 2px, transparent 2px),
                              radial-gradient(circle at 20% 30%, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.2) 2px, transparent 2px),
                              radial-gradient(circle at 15% 34%, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.2) 2px, transparent 2px),
                              radial-gradient(circle at 45% 65%, rgba(255,255,255,0.32) 0%, rgba(255,255,255,0.32) 3px, transparent 3px),
                              radial-gradient(circle at 40% 70%, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.2) 2px, transparent 2px),
                              radial-gradient(circle at 50% 70%, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.2) 2px, transparent 2px),
                              radial-gradient(circle at 45% 74%, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.2) 2px, transparent 2px),
                              radial-gradient(circle at 75% 25%, rgba(255,255,255,0.32) 0%, rgba(255,255,255,0.32) 3px, transparent 3px),
                              radial-gradient(circle at 70% 30%, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.2) 2px, transparent 2px),
                              radial-gradient(circle at 80% 30%, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.2) 2px, transparent 2px),
                              radial-gradient(circle at 75% 34%, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.2) 2px, transparent 2px),
                              linear-gradient(160deg, var(--primary), var(--primary-dark));
        }
        .envelope-body.pattern-botanic {
            background-image: repeating-linear-gradient(0deg, rgba(255,255,255,0.2) 0px, rgba(255,255,255,0.2) 1px, transparent 1px, transparent 10px),
                              repeating-linear-gradient(90deg, rgba(255,255,255,0.2) 0px, rgba(255,255,255,0.2) 1px, transparent 1px, transparent 10px),
                              radial-gradient(circle at 25% 25%, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0.25) 1.5px, transparent 1.5px),
                              radial-gradient(circle at 75% 75%, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0.25) 1.5px, transparent 1.5px),
                              linear-gradient(160deg, var(--primary), var(--primary-dark));
        }
        .envelope-body.pattern-fern {
            background-image: repeating-linear-gradient(30deg, rgba(255,255,255,0.25) 0px, rgba(255,255,255,0.25) 2px, transparent 2px, transparent 20px),
                              repeating-linear-gradient(-30deg, rgba(255,255,255,0.18) 0px, rgba(255,255,255,0.18) 1.5px, transparent 1.5px, transparent 20px),
                              linear-gradient(90deg, transparent 46%, rgba(255,255,255,0.28) 46%, rgba(255,255,255,0.28) 54%, transparent 54%),
                              linear-gradient(160deg, var(--primary), var(--primary-dark));
        }
        .envelope-body.pattern-petal {
            background-image: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0.25) 7px, transparent 7px),
                              radial-gradient(circle at 50% 20%, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0.18) 6px, transparent 6px),
                              radial-gradient(circle at 80% 20%, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0.25) 7px, transparent 7px),
                              radial-gradient(circle at 35% 50%, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0.18) 6px, transparent 6px),
                              radial-gradient(circle at 65% 50%, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0.18) 6px, transparent 6px),
                              radial-gradient(circle at 20% 80%, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0.25) 7px, transparent 7px),
                              radial-gradient(circle at 50% 80%, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0.18) 6px, transparent 6px),
                              radial-gradient(circle at 80% 80%, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0.25) 7px, transparent 7px),
                              linear-gradient(160deg, var(--primary), var(--primary-dark));
            background-size: 60px 60px, 60px 60px, 60px 60px, 60px 60px, 60px 60px, 60px 60px, 60px 60px, 60px 60px, auto;
        }

        /* ===== 3D ANIMASYON TURLERI ===== */

        /* Klasik - 3D perspektifli acilma */
        .anim-classic .envelope {
            transform: rotateX(2deg) rotateY(-3deg);
        }
        .anim-classic .envelope-wrapper:hover .envelope {
            transform: rotateX(1deg) rotateY(-6deg);
        }
        .anim-classic .envelope.open {
            transform: scale(1.7) translateY(-70px) rotateX(6deg);
        }

        /* 3D Flip - Zarf 3D uzayda doner */
        .anim-flip .envelope {
            transform: rotateX(3deg) rotateY(-5deg);
        }
        .anim-flip .envelope-wrapper:hover .envelope {
            transform: rotateX(2deg) rotateY(-10deg);
        }
        .anim-flip .envelope.open {
            transform: scale(1.8) translateY(-90px) rotateX(12deg) rotateY(15deg);
        }
        .anim-flip .envelope-flap {
            transition: transform 1.1s cubic-bezier(0.34, 1.56, 0.64, 1) 0.15s;
        }
        .anim-flip .envelope-screen {
            background: linear-gradient(145deg, #2a1a2e, #1a1a2e 40%, #0f2030 100%);
        }

        /* Kalp Patlamasi - 3D one dogru gelir */
        .anim-heart .envelope {
            transform: rotateX(-2deg) rotateY(4deg) scale(0.95);
        }
        .anim-heart .envelope-wrapper:hover .envelope {
            transform: rotateX(-1deg) rotateY(6deg) scale(0.98);
        }
        .anim-heart .envelope.open {
            transform: scale(2.0) translateY(-50px) rotateX(-8deg) translateZ(80px);
        }
        .anim-heart .envelope-flap {
            border-radius: 0 0 30% 30%;
        }
        .anim-heart .envelope-flap .flap-bg {
            clip-path: polygon(0% 0%, 50% 105%, 100% 0%);
            -webkit-clip-path: polygon(0% 0%, 50% 105%, 100% 0%);
            border-radius: 0 0 30% 30%;
        }
        .anim-heart .envelope-seal {
            background: linear-gradient(145deg, #ff6b6b, #c0392b);
            border-color: rgba(255,255,255,0.3);
            box-shadow: 0 0 30px rgba(255,107,107,0.4);
        }
        .anim-heart .envelope-screen {
            background: linear-gradient(145deg, #2d1b2e, #1a1a2e 40%, #0f3460 100%);
        }

        /* Sihirli Isilti - Yavas ve zarif 3D */
        .anim-magic .envelope {
            transform: rotateX(4deg) rotateY(2deg);
        }
        .anim-magic .envelope-wrapper:hover .envelope {
            transform: rotateX(2deg) rotateY(4deg);
        }
        .anim-magic .envelope.open {
            transition: transform 1.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s, opacity 1.2s ease 0.4s;
            transform: scale(1.6) translateY(-100px) rotateX(15deg) rotateY(8deg) translateZ(40px);
        }
        .anim-magic .envelope-flap {
            transition: transform 1.3s cubic-bezier(0.34, 1.56, 0.64, 1) 0.15s;
        }
        .anim-magic .envelope-screen {
            background: linear-gradient(145deg, #1a1a3e, #0d0d2b 40%, #1a0a2e 100%);
        }

        /* Dalga Efekti - 3D dalga ile acilma */
        .anim-ripple .envelope {
            transform: rotateX(2deg) scale(1);
        }
        .anim-ripple .envelope-wrapper:hover .envelope {
            transform: rotateX(0deg) scale(1.02);
        }
        .anim-ripple .envelope.open {
            transform: scale(1.7) translateY(-60px) rotateX(5deg);
        }
        .anim-ripple .envelope.open ~ .envelope-glow {
            transform: translate(-50%, -50%) scale(8);
            background: radial-gradient(circle, color-mix(in srgb, var(--primary) 40%, transparent), transparent 70%);
        }
        .anim-ripple .envelope-flap {
            transition: transform 1.0s cubic-bezier(0.34, 1.56, 0.64, 1) 0.25s;
        }

        /* Mobil uyum */
        @media (max-width: 768px) {
            .envelope { transform: rotateX(1deg) rotateY(-2deg); }
            .envelope-wrapper:hover .envelope { transform: rotateX(0deg) rotateY(-3deg); }
            .anim-flip .envelope.open { transform: scale(1.5) translateY(-60px) rotateX(10deg) rotateY(10deg); }
            .anim-heart .envelope.open { transform: scale(1.6) translateY(-40px) rotateX(-4deg) translateZ(40px); }
            .anim-magic .envelope.open { transform: scale(1.3) translateY(-70px) rotateX(10deg) rotateY(4deg) translateZ(20px); }
            .anim-ripple .envelope.open { transform: scale(1.4) translateY(-40px) rotateX(3deg); }
        }
    </style>
</head>
<body>
    <div class="scroll-progress" id="scrollProgress"></div>
    <div id="floatDecos"></div>
    @php
        $showMusic = $invitation->music->isNotEmpty();
        $musicFile = $invitation->music->first();
        $musicIsEmbed = $musicFile && $musicFile->embed_url && !$musicFile->file_path;
        $ytVideoId = '';
        if ($musicIsEmbed) {
            $url = $musicFile->embed_url;
            if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $m)) {
                $ytVideoId = $m[1];
            }
        }
        $envelopeAnim = $invitation->envelope_animation ?: 'classic';
        $envelopePattern = $invitation->envelope_pattern ?: '';
        $adminPatternUrl = '';
        if (str_starts_with($envelopePattern, 'a_')) {
            $patternSlug = substr($envelopePattern, 2);
            $patternModel = \App\Models\Pattern::where('slug', $patternSlug)->first();
            if ($patternModel && $patternModel->image_path) {
                $adminPatternUrl = \Illuminate\Support\Facades\Storage::url($patternModel->image_path);
            }
        }
        function embedUrl($url) {
            if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $m)) {
                return 'https://www.youtube-nocookie.com/embed/'.$m[1];
            }
            return $url;
        }
        $coverVideoUrl = $invitation->cover_video && str_starts_with($invitation->cover_video, 'http')
            ? embedUrl($invitation->cover_video) : '';
        $coverYtId = '';
        if ($coverVideoUrl && preg_match('/\/embed\/([a-zA-Z0-9_-]+)/', $coverVideoUrl, $m)) {
            $coverYtId = $m[1];
        }
        $eventMusicLabels = [
            'wedding' => '🎵 Düğün Şarkısı',
            'engagement' => '🎵 Nişan Şarkısı',
            'circumcision' => '🎵 Sünnet Şarkısı',
            'birthday' => '🎵 Doğum Günü Şarkısı',
            'corporate' => '🎵 Kurumsal Müzik',
            'graduation' => '🎵 Mezuniyet Şarkısı',
        ];
        $musicLabel = $eventMusicLabels[$eventType] ?? '🎵 Düğün Şarkısı';
    @endphp

    <div class="envelope-screen event-{{ $eventType }} @if($envelopeAnim !== 'classic') anim-{{ $envelopeAnim }} @endif" id="envelopeScreen" onclick="openEnvelope()">
        <div class="particle-bg" id="envBgParticles"></div>
        <div class="floating-hearts" id="floatingHearts"></div>
        <div class="envelope-wrapper">
            <div class="envelope" id="envelope">
                <div class="envelope-body @if($envelopePattern && !str_starts_with($envelopePattern, 'a_')) pattern-{{ $envelopePattern }} @endif">
                    <div class="gusset-left"></div>
                    <div class="gusset-right"></div>
                    <div class="bottom-fold"></div>
                    @if($adminPatternUrl)
                        <div class="pattern-watermark" style="background-image: url('{{ $adminPatternUrl }}'); background-size: cover; background-position: center; opacity: 0.25; mix-blend-mode: normal;"></div>
                    @endif
                </div>
                <div class="envelope-flap" style="--flap-color: {{ $invitation->envelope_flap_color ?: '#ffffff' }}">
                    <div class="flap-bg" style="background-color: var(--flap-color);"></div>
                    <div class="flap-heart" style="color: #000;">@if($eventType === 'birthday') 🎂 @else 💖 @endif</div>
                </div>
                    <div class="envelope-inner">
                        @if($adminPatternUrl)
                            <div class="pattern-watermark" style="background-image: url('{{ $adminPatternUrl }}'); background-size: cover; background-position: center; opacity: 0.2; mix-blend-mode: normal;"></div>
                        @endif
                        <div class="names">@if($ev['couple']){{ $fixName($invitation->groom_name) }} <span class="ampersand">&</span> {{ $fixName($invitation->bride_name) }}@else{{ $fixName($invitation->groom_name) }}@if($eventType === 'birthday' && $invitation->bride_name) <span style="font-size:0.5em;opacity:0.6;display:block;margin-top:2px;">{{ $invitation->bride_name }} Yaşında</span>@endif @endif</div>
                        <div class="sub">{{ $ev['title'] }}</div>
                        @if($invitation->welcome_message)
                            <div class="env-message">{{ strip_tags($invitation->welcome_message) }}</div>
                        @endif
                    </div>
            </div>
            <div class="envelope-glow"></div>
            <div class="floating-letter" id="floatingLetter">
                <div class="heart-icon">@if($eventType === 'birthday') 🎂 @else 💕 @endif</div>
                <div class="letter-names">@if($ev['couple']){{ $fixName($invitation->groom_name) }}<br><span class="ampersand">&</span><br>{{ $fixName($invitation->bride_name) }}@else{{ $fixName($invitation->groom_name) }}@if($eventType === 'birthday' && $invitation->bride_name)<br><span style="font-size:0.7rem;opacity:0.6;">{{ $invitation->bride_name }} Yaşında</span>@endif @endif</div>
                <div class="letter-sub">{{ $ev['sub'] }}</div>
                @if($invitation->welcome_message)
                    <div class="letter-msg">{{ strip_tags($invitation->welcome_message) }}</div>
                @endif
            </div>
        </div>
        <div class="hint">✨ Dokunarak Aç ✨</div>
    </div>

    <div class="invitation-content" id="invitationContent">
        <div class="cover-section @if($invitation->cover_video) has-video @endif">
            @if($invitation->cover_video)
                @if(str_starts_with($invitation->cover_video, 'http'))
                    <div class="cover-video">
                        <iframe src="{{ $coverVideoUrl }}?controls=0&modestbranding=1&iv_load_policy=3&playsinline=1&rel=0&showinfo=0&enablejsapi=1"
                            frameborder="0" allow="autoplay; encrypted-media" allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            id="coverVideoIframe">
                        </iframe>
                    </div>
                @else
                    <video class="cover-video" autoplay muted loop playsinline preload="metadata">
                        <source src="{{ \Illuminate\Support\Facades\Storage::url($invitation->cover_video) }}" type="{{ str_ends_with($invitation->cover_video, '.webm') ? 'video/webm' : (str_ends_with($invitation->cover_video, '.mov') ? 'video/quicktime' : 'video/mp4') }}">
                    </video>
                @endif
            @endif
            <div class="cover-bg"></div>
            <div class="cover-overlay"></div>
            <div class="cover-deco"></div>
            <div class="cover-deco"></div>
            <div class="cover-deco"></div>
            <div class="cover-particles" id="coverParticles"></div>
            <div class="names">
                @if($ev['couple'])
                    <span class="groom">{{ $fixName($invitation->groom_name) }}</span>
                    <span class="ampersand">&</span>
                    <span class="bride">{{ $fixName($invitation->bride_name) }}</span>
                @else
                    {{ $fixName($invitation->groom_name) }}
                @endif
            </div>
            <div class="date">
                @if($invitation->event_date){{ $invitation->event_date->format('d.m.Y') }}@endif
                @if($invitation->event_time) / {{ $invitation->event_time }}@endif
            </div>
            <div class="scroll-indicator" onclick="document.querySelector('.animate-on-scroll').scrollIntoView({behavior:'smooth'})">
                <span>{{ $fixText('Kaydır') }}</span>
                <div class="line"></div>
            </div>
        </div>

        @if($invitation->welcome_message)
            <div class="section animate-on-scroll">
                <div class="section-subtitle">Hoş Geldiniz</div>
                <div class="section-title">Davetimize</div>
                <div class="divider"></div>
                <p class="story-text">{{ $invitation->welcome_message }}</p>
            </div>
        @endif

        @if($invitation->groom_father || $invitation->groom_mother || $invitation->bride_father || $invitation->bride_mother)
            <div class="section animate-on-scroll rotate-in" style="background: rgba(0,0,0,0.015);">
                <div class="section-subtitle">Ailelerimiz</div>
                <div class="section-title">@if($ev['couple'])Aile Büyüklerimiz @else Ailemiz @endif</div>
                <div class="divider"></div>
                <div class="parents-grid">
                    <div class="parent-card">
                        <div class="name">{{ $fixName($invitation->groom_name) }}</div>
                        @if($ev['couple'])
                            @if($invitation->groom_father && $invitation->groom_mother)
                                <div class="relation">{{ $fixName($invitation->groom_father)}} & {{ $fixName($invitation->groom_mother) }}'nın oğlu</div>
                            @elseif($invitation->groom_father)
                                <div class="relation">{{ $fixName($invitation->groom_father) }}'ın oğlu</div>
                            @elseif($invitation->groom_mother)
                                <div class="relation">{{ $fixName($invitation->groom_mother) }}'nın oğlu</div>
                            @endif
                        @else
                            @if($invitation->groom_father && $invitation->groom_mother)
                                <div class="relation">{{ $fixName($invitation->groom_father)}} & {{ $fixName($invitation->groom_mother) }}'nın oğlu/kızı</div>
                            @elseif($invitation->groom_father)
                                <div class="relation">{{ $fixName($invitation->groom_father) }}'ın oğlu/kızı</div>
                            @elseif($invitation->groom_mother)
                                <div class="relation">{{ $fixName($invitation->groom_mother) }}'nın oğlu/kızı</div>
                            @endif
                        @endif
                    </div>
                    @if($ev['couple'])
                    <div class="parent-card">
                        <div class="name">{{ $fixName($invitation->bride_name) }}</div>
                        @if($invitation->bride_father && $invitation->bride_mother)
                            <div class="relation">{{ $fixName($invitation->bride_father) }} & {{ $fixName($invitation->bride_mother) }}'nın kızı</div>
                        @elseif($invitation->bride_father)
                            <div class="relation">{{ $fixName($invitation->bride_father) }}'ın kızı</div>
                        @elseif($invitation->bride_mother)
                            <div class="relation">{{ $fixName($invitation->bride_mother) }}'nın kızı</div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        @endif

            <div class="section animate-on-scroll zoom-in" style="background: rgba(0,0,0,0.015);">
                <div class="section-subtitle">{{ $ev['countdownLabel'] }}</div>
                <div class="section-title">Kalan Süre</div>
                <div class="divider"></div>
                <div id="countdown" class="countdown">
                    <div class="countdown-item"><div class="countdown-number" id="days">00</div><div class="countdown-label">Gün</div></div>
                    <div class="countdown-item"><div class="countdown-number" id="hours">00</div><div class="countdown-label">Saat</div></div>
                    <div class="countdown-item"><div class="countdown-number" id="minutes">00</div><div class="countdown-label">Dakika</div></div>
                    <div class="countdown-item"><div class="countdown-number" id="seconds">00</div><div class="countdown-label">Saniye</div></div>
                </div>
            </div>

        @if($ev['showStory'] && $invitation->story)
            <div class="section animate-on-scroll rotate-in">
                <div class="section-subtitle">Hikayemiz</div>
                <div class="section-title">{{ $fixText('Nasıl Başladı') }}</div>
                <div class="divider"></div>
                <p class="story-text">{{ $invitation->story }}</p>
            </div>
        @endif

        @if($invitation->images->count() > 0)
            <div class="section animate-on-scroll fade-right" style="background: rgba(0,0,0,0.015);">
                <div class="section-subtitle">Galeri</div>
                <div class="section-title">{{ $fixText('Anılarımız') }}</div>
                <div class="divider"></div>
                <div class="gallery">
                    @foreach($invitation->images as $image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($image->image_path) }}" alt="{{ $image->caption ?? '' }}" loading="lazy">
                    @endforeach
                </div>
            </div>
        @endif

        @if($invitation->videos->count() > 0)
            <div class="section animate-on-scroll">
                <div class="section-subtitle">Videolar</div>
                <div class="section-title">Özel Anlar</div>
                <div class="divider"></div>
                <div class="gallery">
                    @php
                        if (!function_exists('nocookieEmbedUrl')) {
                            function nocookieEmbedUrl($url) {
                                if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $m)) {
                                    return 'https://www.youtube-nocookie.com/embed/'.$m[1];
                                }
                                return $url;
                            }
                        }
                    @endphp
                    @foreach($invitation->videos as $video)
                        @if($video->file_path)
                            <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:16px;box-shadow:0 8px 30px rgba(0,0,0,0.06);background:#000;">
                                <video controls style="position:absolute;top:0;left:0;width:100%;height:100%;" preload="metadata">
                                    <source src="{{ \Illuminate\Support\Facades\Storage::url($video->file_path) }}" type="{{ $video->file_path ? (str_ends_with($video->file_path, '.webm') ? 'video/webm' : (str_ends_with($video->file_path, '.mov') ? 'video/quicktime' : 'video/mp4')) : 'video/mp4' }}">
                                </video>
                            </div>
                        @else
                            <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:16px;box-shadow:0 8px 30px rgba(0,0,0,0.06);">
                                <iframe src="{{ nocookieEmbedUrl($video->url) }}" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allowfullscreen referrerpolicy="no-referrer-when-downgrade" sandbox="allow-same-origin allow-scripts allow-popups allow-presentation"></iframe>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        @if($invitation->event_address || $invitation->event_location)
            <div class="section animate-on-scroll fade-left" style="background: rgba(0,0,0,0.015);">
                <div class="section-subtitle">Konum</div>
                <div class="section-title">{{ $ev['locationLabel'] }}</div>
                <div class="divider"></div>
                @if($invitation->event_address)<p style="margin-bottom:8px;opacity:0.65;font-size:1.05rem;">{{ $invitation->event_address }}</p>@endif
                @if($invitation->event_lat && $invitation->event_lng)
                    <div class="map-container">
                        <iframe width="100%" height="100%" style="border:0;" loading="lazy"
                            src="https://www.google.com/maps?q={{ $invitation->event_lat }},{{ $invitation->event_lng }}&output=embed">
                        </iframe>
                    </div>
                @endif
            </div>

        @if($invitation->special_note)
            <div class="section animate-on-scroll zoom-out">
                <div class="section-subtitle">Not</div>
                <div class="section-title">Özel Bir Not</div>
                <div class="divider"></div>
                <p class="story-text">{{ $invitation->special_note }}</p>
            </div>
        @endif
            </div>
        @endif

        <div class="section animate-on-scroll zoom-in" style="background: rgba(0,0,0,0.015);">
            <div class="section-subtitle">Katılım</div>
            <div class="section-title">RSVP</div>
            <div class="divider"></div>
            <div class="rsvp-form">
                <form id="rsvpForm" action="{{ route('invitation.rsvp', $invitation->slug) }}" method="POST">
                    @csrf
                    <div class="field-group">
                        <label><span class="field-icon">👤</span> Ad Soyad <span style="color:var(--primary)">*</span></label>
                        <input type="text" name="name" required placeholder="Adın ve soyadın">
                    </div>
                    <div class="field-group">
                        <label><span class="field-icon">📧</span> E-posta</label>
                        <input type="email" name="email" placeholder="ornek@email.com">
                    </div>
                    <div class="field-group">
                        <label><span class="field-icon">📞</span> Telefon</label>
                        <input type="tel" name="phone" placeholder="05XX XXX XX XX">
                    </div>
                    <div class="field-group">
                        <label><span class="field-icon">{{ $ev['rsvpIcon'] }}</span> Katılım Durumu <span style="color:var(--primary)">*</span></label>
                        <div class="status-options">
                            <input type="radio" name="status" value="attending" id="rsvpAttending" checked>
                            <label for="rsvpAttending">
                                <span class="status-icon">🎉</span>
                                Katılıyorum
                            </label>
                            <input type="radio" name="status" value="maybe" id="rsvpMaybe">
                            <label for="rsvpMaybe">
                                <span class="status-icon">🤔</span>
                                Belki
                            </label>
                            <input type="radio" name="status" value="not_attending" id="rsvpNotAttending">
                            <label for="rsvpNotAttending">
                                <span class="status-icon">😔</span>
                                Katılamam
                            </label>
                        </div>
                    </div>
                    <div class="field-group">
                        <label><span class="field-icon">👥</span> Kişi Sayısı <span style="color:var(--primary)">*</span></label>
                        <div class="guest-count-wrapper">
                            <button type="button" class="guest-btn" onclick="var i=this.parentElement.querySelector('input');if(parseInt(i.value)>1)i.value=parseInt(i.value)-1">−</button>
                            <input type="number" name="guest_count" value="1" min="1" max="10" required readonly onfocus="this.blur()">
                            <button type="button" class="guest-btn" onclick="var i=this.parentElement.querySelector('input');if(parseInt(i.value)<10)i.value=parseInt(i.value)+1">+</button>
                            <span class="guest-count-label">kişi</span>
                        </div>
                    </div>
                    <div class="field-group">
                        <label><span class="field-icon">💬</span> Mesaj</label>
                        <textarea name="message" rows="3" placeholder="Bir not bırakmak ister misin?"></textarea>
                    </div>
                    <button type="submit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22L11 13L2 9L22 2Z"/></svg>
                        Gönder
                    </button>
                </form>
                <div id="rsvpSuccess" style="display:none;text-align:center;padding:40px 20px;">
                    <div style="font-size:3.5rem;margin-bottom:16px;animation:heartBeat 1.8s ease-in-out infinite;">💌</div>
                    <div style="font-family:var(--font-display);font-size:1.8rem;color:var(--primary);margin-bottom:8px;">Teşekkür Ederiz!</div>
                    <div style="width:40px;height:2px;margin:12px auto;border-radius:2px;background:linear-gradient(90deg,transparent,var(--primary),transparent);"></div>
                    <p style="opacity:0.5;font-size:0.9rem;">Katılım durumunuz başarıyla kaydedildi.</p>
                    <p style="opacity:0.35;font-size:0.75rem;margin-top:16px;font-family:'Montserrat',sans-serif;">Sizi aramızda görmekten mutluluk duyacağız 🎊</p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p style="font-family: var(--font-display); font-size: 1.6rem; color: white;">@if($ev['couple']){{ $fixName($invitation->groom_name) }} & {{ $fixName($invitation->bride_name) }}@else{{ $fixName($invitation->groom_name) }}@endif</p>
            <p style="margin-top: 12px; font-size: 0.85rem; opacity: 0.7; color: white; font-family: 'Montserrat', sans-serif; letter-spacing: 1px;">
                @if($invitation->event_date){{ $invitation->event_date->format('d.m.Y') }}@endif
                @if($invitation->event_time) / {{ $invitation->event_time }}@endif
            </p>

        </div>

        @if($showMusic && $musicFile)
            @if($musicIsEmbed && $ytVideoId)
                <div class="music-player">
                    <div class="music-label" id="musicLabel">🎵 Düğün Şarkısı</div>
                    <button id="musicBtn" class="music-btn" style="background:linear-gradient(135deg, {{ $invitation->primary_color ?: '#d4af37' }}, {{ $invitation->primary_color ?: '#b8952e' }}); color:white;" onclick="toggleMusic()">
                        <svg id="musicIcon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
                        </svg>
                    </button>
                    <iframe id="bgMusicEmbed" src="https://www.youtube.com/embed/{{ $ytVideoId }}?enablejsapi=1&autoplay=0" style="display:none;" allow="autoplay; encrypted-media"></iframe>
                </div>
            @elseif($musicFile->file_path)
                <div class="music-player">
                    <div class="music-label" id="musicLabel">🎵 Düğün Şarkısı</div>
                    <button id="musicBtn" class="music-btn" style="background:linear-gradient(135deg, {{ $invitation->primary_color ?: '#d4af37' }}, {{ $invitation->primary_color ?: '#b8952e' }}); color:white;" onclick="toggleMusic()">
                        <svg id="musicIcon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
                        </svg>
                    </button>
                    <audio id="bgMusic" src="{{ \Illuminate\Support\Facades\Storage::url($musicFile->file_path) }}" loop preload="auto"></audio>
                </div>
            @endif
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var envFlap = document.querySelector('.envelope-flap');
            if (envFlap) envFlap.style.setProperty('--flap-color', '{{ $invitation->envelope_flap_color ?: '#ffffff' }}');
        });

        var invContent = document.getElementById('invitationContent');
        var envelopeOpened = false;

        function unMuteCoverVideo() {}

        function openEnvelope() {
            if (envelopeOpened) return;
            envelopeOpened = true;

            var envelope = document.getElementById('envelope');
            var screen = document.getElementById('envelopeScreen');
            var letter = document.getElementById('floatingLetter');
            var seal = envelope.querySelector('.envelope-seal');

            // Önce hafif bir titreme
            envelope.style.transition = 'transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
            envelope.style.transform = 'scale(1.04)';
            setTimeout(function() {
                envelope.style.transform = 'scale(1)';
            }, 300);

            // 400ms sonra asil acilma
            setTimeout(function() {
                envelope.style.transition = '';
                envelope.style.transform = '';
                envelope.classList.add('open');
                letter.classList.add('show');

                @if($invitation->cover_video)
                setTimeout(function() { unMuteCoverVideo(); }, 500);
                @endif

                @if($eventType === 'wedding' || $eventType === 'engagement')
                createWeddingMagic(screen);
                @elseif($eventType === 'graduation')
                createGraduationCaps(screen);
                @elseif($eventType === 'birthday')
                createBirthdayCake(screen);
                @elseif($eventType === 'circumcision')
                createConfetti(screen);
                @else
                createConfetti(screen);
                @endif

                @if($showMusic && $musicFile)
                setTimeout(function() {
                    startMusic();
                }, 300);
                @endif

                setTimeout(function() {
                    screen.style.display = 'none';
                    invContent.classList.add('visible');
                    window.scrollTo({ top: 0, behavior: 'instant' });
                    window.dispatchEvent(new Event('scroll'));
                    initScrollAnimation();
                    initCoverParticles();
                }, 1400);
            }, 400);
        }

        @if($showMusic && $musicFile)
        @if($musicIsEmbed && $ytVideoId)
        var isPlaying = false;
        var embedIframe = document.getElementById('bgMusicEmbed');

        function startMusic() {
            embedIframe.src = embedIframe.src.replace('autoplay=0', 'autoplay=1');
            isPlaying = true;
            updateMusicIcon();
        }

        function toggleMusic() {
            if (!embedIframe) return;
            if (isPlaying) {
                embedIframe.src = embedIframe.src.replace('autoplay=1', 'autoplay=0');
            } else {
                embedIframe.src = embedIframe.src.replace('autoplay=0', 'autoplay=1');
            }
            isPlaying = !isPlaying;
            updateMusicIcon();
        }

        function updateMusicIcon() {
            var icon = document.getElementById('musicIcon');
            var label = document.getElementById('musicLabel');
            if (isPlaying) {
                icon.innerHTML = '<rect x="6" y="4" width="4" height="16" rx="1"/><rect x="14" y="4" width="4" height="16" rx="1"/>';
                if (label) label.textContent = '🔊 Çalıyor';
            } else {
                icon.innerHTML = '<path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>';
                if (label) label.textContent = '🎵 Düğün Şarkısı';
            }
        }
        @elseif($musicFile->file_path)
        var isPlaying = false;
        var audio = document.getElementById('bgMusic');

        function startMusic() {
            audio.play().then(function() {
                isPlaying = true;
                updateMusicIcon();
            }).catch(function() {});
        }

        function toggleMusic() {
            if (!audio) return;
            if (isPlaying) {
                audio.pause();
            } else {
                audio.play().catch(function() {});
            }
            isPlaying = !isPlaying;
            updateMusicIcon();
        }

        function updateMusicIcon() {
            var icon = document.getElementById('musicIcon');
            var label = document.getElementById('musicLabel');
            if (isPlaying) {
                icon.innerHTML = '<rect x="6" y="4" width="4" height="16" rx="1"/><rect x="14" y="4" width="4" height="16" rx="1"/>';
                if (label) label.textContent = '🔊 Çalıyor';
            } else {
                icon.innerHTML = '<path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>';
                if (label) label.textContent = '🎵 Düğün Şarkısı';
            }
        }
        @endif
        @endif

        function createParticles(container) {
            var colors = ['#ffd700', '#ff6b6b', '#ff9ff3', '#feca57', '#48dbfb', '#ff9f43', '#a29bfe', '#54a0ff', '#5f27cd', '#ff4757', '#ff6348'];
            var rect = container.getBoundingClientRect();
            var cx = rect.width / 2;
            var cy = rect.height / 2;
            var count = 60;

            for (var i = 0; i < count; i++) {
                var p = document.createElement('div');
                p.className = 'particle';
                var size = 2 + Math.random() * 6;
                p.style.width = size + 'px';
                p.style.height = size + 'px';
                p.style.background = colors[Math.floor(Math.random() * colors.length)];
                p.style.left = (cx + (Math.random() - 0.5) * 60) + 'px';
                p.style.top = (cy + (Math.random() - 0.5) * 60) + 'px';
                var angle = Math.random() * Math.PI * 2;
                var dist = 60 + Math.random() * 280;
                p.style.setProperty('--tx', Math.cos(angle) * dist + 'px');
                p.style.setProperty('--ty', Math.sin(angle) * dist + 'px');
                p.style.animationDelay = (Math.random() * 0.4) + 's';
                p.style.animationDuration = (1 + Math.random() * 0.8) + 's';
                if (Math.random() > 0.7) {
                    p.style.borderRadius = '2px';
                    p.style.width = size * 1.5 + 'px';
                    p.style.height = size * 0.6 + 'px';
                }
                container.appendChild(p);
                requestAnimationFrame(function() { p.classList.add('burst'); });
            }

            for (var i = 0; i < 8; i++) {
                var h = document.createElement('div');
                h.className = 'particle';
                h.textContent = '❤️';
                h.style.fontSize = (12 + Math.random() * 16) + 'px';
                h.style.background = 'none';
                h.style.width = 'auto';
                h.style.height = 'auto';
                h.style.left = (cx + (Math.random() - 0.5) * 100) + 'px';
                h.style.top = (cy + (Math.random() - 0.5) * 80) + 'px';
                var angle = -Math.PI / 2 + (Math.random() - 0.5) * Math.PI * 0.6;
                var dist = 120 + Math.random() * 250;
                h.style.setProperty('--tx', Math.cos(angle) * dist + 'px');
                h.style.setProperty('--ty', Math.sin(angle) * dist - 80 + 'px');
                h.style.animationDelay = (Math.random() * 0.5) + 's';
                h.style.animationDuration = (1.5 + Math.random() * 1) + 's';
                container.appendChild(h);
                requestAnimationFrame(function() { h.classList.add('burst'); });
            }

            setTimeout(function() {
                container.querySelectorAll('.particle').forEach(function(el) { el.remove(); });
            }, 3000);
        }

        function createWeddingMagic(container) {
            var rect = container.getBoundingClientRect();
            var cx = rect.width / 2;
            var cy = rect.height / 2;
            var colors = ['#ffd700', '#ff6b6b', '#ff9ff3', '#f48fb1', '#f06292', '#ec407a', '#ffd54f', '#ffcc02', '#fff176', '#ce93d8'];

            for (var i = 0; i < 45; i++) {
                var p = document.createElement('div');
                p.className = 'particle';
                var size = 3 + Math.random() * 8;
                p.style.width = size + 'px';
                p.style.height = size + 'px';
                p.style.background = colors[Math.floor(Math.random() * colors.length)];
                p.style.left = (cx + (Math.random() - 0.5) * 60) + 'px';
                p.style.top = (cy + (Math.random() - 0.5) * 60) + 'px';
                var angle = Math.random() * Math.PI * 2;
                var dist = 60 + Math.random() * 280;
                p.style.setProperty('--tx', Math.cos(angle) * dist + 'px');
                p.style.setProperty('--ty', Math.sin(angle) * dist + 'px');
                p.style.animationDelay = (Math.random() * 0.4) + 's';
                p.style.animationDuration = (1.2 + Math.random() * 0.8) + 's';
                if (Math.random() > 0.7) {
                    p.style.borderRadius = '50%';
                    p.style.width = size * 2 + 'px';
                    p.style.height = size * 2 + 'px';
                    p.style.opacity = '0.6';
                }
                container.appendChild(p);
                requestAnimationFrame(function() { p.classList.add('burst'); });
            }

            for (var i = 0; i < 14; i++) {
                var h = document.createElement('div');
                h.className = 'particle';
                h.textContent = ['❤️', '💕', '💗', '💖', '💝', '✨'][Math.floor(Math.random() * 6)];
                h.style.fontSize = (14 + Math.random() * 18) + 'px';
                h.style.background = 'none';
                h.style.width = 'auto';
                h.style.height = 'auto';
                h.style.left = (cx + (Math.random() - 0.5) * 100) + 'px';
                h.style.top = (cy + (Math.random() - 0.5) * 80) + 'px';
                var angle = -Math.PI / 2 + (Math.random() - 0.5) * Math.PI * 0.6;
                var dist = 100 + Math.random() * 260;
                h.style.setProperty('--tx', Math.cos(angle) * dist + 'px');
                h.style.setProperty('--ty', Math.sin(angle) * dist - 100 + 'px');
                h.style.animationDelay = (Math.random() * 0.4) + 's';
                h.style.animationDuration = (1.5 + Math.random() * 1) + 's';
                container.appendChild(h);
                requestAnimationFrame(function() { h.classList.add('burst'); });
            }

            setTimeout(function() {
                container.querySelectorAll('.particle').forEach(function(el) { el.remove(); });
            }, 3500);
        }

        function createConfetti(container) {
            var colors = ['#ffd700', '#ff6b6b', '#ff9ff3', '#feca57', '#48dbfb', '#ff9f43', '#a29bfe', '#54a0ff', '#5f27cd', '#ff4757', '#2ed573', '#1e90ff'];
            var rect = container.getBoundingClientRect();
            var cx = rect.width / 2;

            for (var i = 0; i < 70; i++) {
                var c = document.createElement('div');
                c.className = 'confetti-piece';
                c.style.background = colors[Math.floor(Math.random() * colors.length)];
                var w = 4 + Math.random() * 8;
                var h = 4 + Math.random() * 8;
                c.style.width = w + 'px';
                c.style.height = h + 'px';
                c.style.left = (cx + (Math.random() - 0.5) * 160) + 'px';
                c.style.top = (rect.height / 2 + (Math.random() - 0.5) * 120) + 'px';
                var angle = -Math.PI / 2 + (Math.random() - 0.5) * Math.PI * 0.9;
                var dist = 80 + Math.random() * 350;
                c.style.setProperty('--tx', Math.cos(angle) * dist + 'px');
                c.style.setProperty('--ty', Math.sin(angle) * dist + 'px');
                c.style.animationDelay = (Math.random() * 0.6) + 's';
                c.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
                if (Math.random() > 0.6) {
                    c.style.width = h * 2 + 'px';
                    c.style.height = h + 'px';
                    c.style.borderRadius = '0';
                }
                container.appendChild(c);
                requestAnimationFrame(function() { c.classList.add('burst'); });
            }

            setTimeout(function() {
                container.querySelectorAll('.confetti-piece').forEach(function(el) { el.remove(); });
            }, 4000);
        }

        function createGraduationCaps(container) {
            var rect = container.getBoundingClientRect();
            var cx = rect.width / 2;
            var caps = ['🎓', '🎓', '🎓', '📜', '🎓', '🎓', '🎓', '⭐'];

            for (var i = 0; i < 60; i++) {
                var cap = document.createElement('div');
                cap.className = 'particle';
                cap.innerHTML = caps[Math.floor(Math.random() * caps.length)];
                var size = 36 + Math.random() * 36;
                cap.style.fontSize = size + 'px';
                cap.style.background = 'none';
                cap.style.width = 'auto';
                cap.style.height = 'auto';
                cap.style.textShadow = '0 0 20px rgba(255,215,0,0.4), 0 0 40px rgba(255,215,0,0.2)';
                cap.style.left = (cx + (Math.random() - 0.5) * 260) + 'px';
                cap.style.top = (rect.height / 2 + 20) + 'px';
                var angle = -Math.PI / 2 + (Math.random() - 0.5) * Math.PI * 0.8;
                var dist = 180 + Math.random() * 380;
                cap.style.setProperty('--tx', Math.cos(angle) * dist + 'px');
                cap.style.setProperty('--ty', Math.sin(angle) * dist - 160 + 'px');
                cap.style.animationDelay = (Math.random() * 0.3) + 's';
                cap.style.animationDuration = (2 + Math.random() * 1.2) + 's';
                container.appendChild(cap);
                requestAnimationFrame(function() { cap.classList.add('burst'); });
            }

            setTimeout(function() {
                container.querySelectorAll('.particle').forEach(function(el) { el.remove(); });
            }, 5000);
        }

        function createBirthdayCake(container) {
            var rect = container.getBoundingClientRect();
            var cx = rect.width / 2;
            var cy = rect.height / 2;

            for (var i = 0; i < 25; i++) {
                var cake = document.createElement('div');
                cake.className = 'particle';
                cake.innerHTML = ['🎂', '🎉', '🎊', '🎈', '✨', '💫'][Math.floor(Math.random() * 6)];
                cake.style.fontSize = (16 + Math.random() * 22) + 'px';
                cake.style.background = 'none';
                cake.style.width = 'auto';
                cake.style.height = 'auto';
                cake.style.left = (cx + (Math.random() - 0.5) * 180) + 'px';
                cake.style.top = (cy + (Math.random() - 0.5) * 100) + 'px';
                var angle = -Math.PI / 2 + (Math.random() - 0.5) * Math.PI * 0.7;
                var dist = 90 + Math.random() * 280;
                cake.style.setProperty('--tx', Math.cos(angle) * dist + 'px');
                cake.style.setProperty('--ty', Math.sin(angle) * dist - 80 + 'px');
                cake.style.animationDelay = (Math.random() * 0.4) + 's';
                cake.style.animationDuration = (1.2 + Math.random() * 0.8) + 's';
                container.appendChild(cake);
                requestAnimationFrame(function() { cake.classList.add('burst'); });
            }

            for (var i = 0; i < 50; i++) {
                var conf = document.createElement('div');
                conf.className = 'confetti-piece';
                var colors = ['#ff6b6b', '#feca57', '#ff9ff3', '#ffd700', '#ff4757', '#ff6348', '#ff9f43'];
                conf.style.background = colors[Math.floor(Math.random() * colors.length)];
                var w = 4 + Math.random() * 8;
                var h = 4 + Math.random() * 8;
                conf.style.width = w + 'px';
                conf.style.height = h + 'px';
                conf.style.left = (cx + (Math.random() - 0.5) * 160) + 'px';
                conf.style.top = (cy + (Math.random() - 0.5) * 120) + 'px';
                var angle = -Math.PI / 2 + (Math.random() - 0.5) * Math.PI * 0.9;
                var dist = 80 + Math.random() * 320;
                conf.style.setProperty('--tx', Math.cos(angle) * dist + 'px');
                conf.style.setProperty('--ty', Math.sin(angle) * dist + 'px');
                conf.style.animationDelay = (Math.random() * 0.5) + 's';
                conf.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
                if (Math.random() > 0.6) {
                    conf.style.width = h * 2 + 'px';
                    conf.style.height = h + 'px';
                    conf.style.borderRadius = '0';
                }
                container.appendChild(conf);
                requestAnimationFrame(function() { conf.classList.add('burst'); });
            }

            setTimeout(function() {
                container.querySelectorAll('.particle, .confetti-piece').forEach(function(el) { el.remove(); });
            }, 4000);
        }

        function initCoverParticles() {
            var container = document.getElementById('coverParticles');
            if (!container) return;
            for (var i = 0; i < 30; i++) {
                var p = document.createElement('div');
                p.className = 'cover-particle';
                p.style.left = Math.random() * 100 + '%';
                p.style.animationDelay = Math.random() * 6 + 's';
                p.style.animationDuration = (5 + Math.random() * 4) + 's';
                p.style.width = p.style.height = (1 + Math.random() * 2) + 'px';
                container.appendChild(p);
            }
        }

        function initScrollAnimation() {
            var els = document.querySelectorAll('.animate-on-scroll');
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
            els.forEach(function(el) { observer.observe(el); });
        }

        // Scroll progress + parallax + floating decos
        var progressBar = document.getElementById('scrollProgress');
        var coverBg = document.querySelector('.cover-bg');
        var floatContainer = document.getElementById('floatDecos');
        var decoEmojis = ['🌸', '✨', '🕊️', '💫', '🌿', '✨'];

        for (var i = 0; i < 6; i++) {
            var d = document.createElement('div');
            d.className = 'float-deco';
            d.textContent = decoEmojis[i];
            d.style.left = (10 + Math.random() * 80) + '%';
            d.style.top = (Math.random() * 100) + '%';
            d.style.fontSize = (1 + Math.random() * 1.2) + 'rem';
            d.style.animationDelay = (i * 1.5) + 's';
            d.dataset.speed = 0.03 + Math.random() * 0.04;
            d.dataset.offsetY = Math.random() * 100;
            floatContainer.appendChild(d);
        }

        window.addEventListener('scroll', function() {
            var scrollTop = window.scrollY;
            var docHeight = document.documentElement.scrollHeight - window.innerHeight;
            var progress = docHeight > 0 ? scrollTop / docHeight : 0;
            progressBar.style.transform = 'scaleX(' + Math.min(progress, 1) + ')';

            if (coverBg) {
                coverBg.style.transform = 'translateY(' + (scrollTop * 0.15) + 'px)';
            }

            var decos = floatContainer.querySelectorAll('.float-deco');
            decos.forEach(function(d) {
                var speed = parseFloat(d.dataset.speed);
                var offset = parseFloat(d.dataset.offsetY);
                var top = (offset + scrollTop * speed) % 100;
                d.style.top = top + '%';
                if (top > 5 && top < 95) {
                    d.classList.add('visible');
                } else {
                    d.classList.remove('visible');
                }
            });
        });

        // Floating symbols on envelope screen (per event type)
        (function() {
            var container = document.getElementById('floatingHearts');
            var typeSymbols = {
                wedding: ['♥', '♡', '❤', '💕', '💗'],
                engagement: ['♥', '♡', '❤', '💕', '💗'],
                circumcision: ['✂️', '⭐', '🌟', '✨', '🎊'],
                birthday: ['🎂', '🎉', '🎊', '🎈', '🎁'],
                corporate: ['📋', '⭐', '📈', '📑', '✨'],
                graduation: ['🎓', '⭐', '🌟', '✨', '📜'],
            };
            var symbols = typeSymbols['{{ $eventType }}'] || typeSymbols.wedding;
            for (var i = 0; i < 14; i++) {
                var h = document.createElement('span');
                h.textContent = symbols[Math.floor(Math.random() * symbols.length)];
                h.style.left = Math.random() * 100 + '%';
                h.style.fontSize = (12 + Math.random() * 18) + 'px';
                h.style.animationDelay = Math.random() * 6 + 's';
                h.style.animationDuration = (5 + Math.random() * 4) + 's';
                container.appendChild(h);
            }
        })();

        // Envelope screen sparkles and rings
        (function() {
            var sc = document.getElementById('envelopeScreen');
            for (var i = 0; i < 40; i++) {
                var s = document.createElement('div');
                s.className = 'sparkle';
                var size = 1 + Math.random() * 3;
                s.style.width = size + 'px';
                s.style.height = size + 'px';
                s.style.left = Math.random() * 100 + '%';
                s.style.top = Math.random() * 100 + '%';
                s.style.animationDelay = Math.random() * 5 + 's';
                s.style.animationDuration = (2 + Math.random() * 4) + 's';
                sc.appendChild(s);
            }
            for (var i = 0; i < 3; i++) {
                var r = document.createElement('div');
                r.className = 'ring';
                var s = 100 + i * 100;
                r.style.width = s + 'px'; r.style.height = s + 'px';
                r.style.left = '50%'; r.style.top = '50%';
                r.style.marginLeft = -(s/2) + 'px';
                r.style.marginTop = -(s/2) + 'px';
                r.style.animationDelay = (i * 1.5) + 's';
                sc.appendChild(r);
            }
        })();

        @if($invitation->event_date)
        (function() {
            var target = new Date("{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time ?: '00:00' }}").getTime();
            function update() {
                var now = new Date().getTime();
                var diff = target - now;
                if (diff <= 0) { document.getElementById('countdown').innerHTML = '<p style="font-family:var(--font-display);font-size:1.5rem;color:var(--primary);">Etkinlik günü! 🎉</p>'; return; }
                document.getElementById('days').textContent = Math.floor(diff / (1000*60*60*24)).toString().padStart(2,'0');
                document.getElementById('hours').textContent = Math.floor((diff%(1000*60*60*24))/(1000*60*60)).toString().padStart(2,'0');
                document.getElementById('minutes').textContent = Math.floor((diff%(1000*60*60))/(1000*60)).toString().padStart(2,'0');
                document.getElementById('seconds').textContent = Math.floor((diff%(1000*60))/1000).toString().padStart(2,'0');
            }
            update(); setInterval(update, 1000);
        })();
        @endif

        document.getElementById('rsvpForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            var form = this;
            var formData = new FormData(form);
            fetch(form.action, { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function(r) { return r.json(); })
                .then(function(d) {
                    if (d.success) {
                        form.style.display = 'none';
                        document.getElementById('rsvpSuccess').style.display = 'block';
                    }
                })
                .catch(function() { form.submit(); });
        });

        // 3D Fare takibi - zarf fareyle doner
        (function() {
            var env = document.getElementById('envelope');
            var wrapper = document.querySelector('.envelope-wrapper');
            if (!env || !wrapper) return;
            var screen = document.getElementById('envelopeScreen');

            screen.addEventListener('mousemove', function(e) {
                if (envelopeOpened) return;
                var rect = screen.getBoundingClientRect();
                var x = (e.clientX - rect.left) / rect.width;
                var y = (e.clientY - rect.top) / rect.height;
                var rotY = -8 + x * 16;
                var rotX = 6 - y * 12;
                env.style.transition = 'transform 0.15s ease-out';
                env.style.transform = 'rotateX(' + rotX + 'deg) rotateY(' + rotY + 'deg)';
            });

            screen.addEventListener('mouseleave', function() {
                if (envelopeOpened) return;
                env.style.transition = 'transform 0.5s ease-out';
                env.style.transform = '';
            });
        })();

        @if($invitation->cover_video && str_starts_with($invitation->cover_video, 'http'))
        var coverPlayer;
        function onYouTubeIframeAPIReady() {
            coverPlayer = new YT.Player('coverVideoIframe', {
                playerVars: {
                    autoplay: 1,
                    mute: 1,
                    loop: 1,
                    playlist: '{{ $coverYtId }}',
                    controls: 0,
                    modestbranding: 1,
                    iv_load_policy: 3,
                    playsinline: 1,
                    rel: 0,
                    showinfo: 0
                },
                events: {
                    'onReady': function(e) {
                        e.target.playVideo();
                    }
                }
            });
        }
        function unMuteCoverVideo() {
            if (coverPlayer && coverPlayer.unMute) {
                coverPlayer.unMute();
                coverPlayer.setVolume(50);
            }
        }
        var tag = document.createElement('script');
        tag.src = 'https://www.youtube.com/iframe_api';
        var first = document.getElementsByTagName('script')[0];
        first.parentNode.insertBefore(tag, first);
        @endif
    </script>
</body>
</html>
