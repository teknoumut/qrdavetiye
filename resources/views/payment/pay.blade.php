@php
    $sp = \App\Models\Setting::getValue('site_primary_color', '#d4a61e');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'senin davetiyen') }} - Yönlendiriliyor</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="refresh" content="3;url={{ $redirectUrl }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
            background: #f6f5f3;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: #fff;
            border-radius: 20px;
            padding: 48px 32px;
            text-align: center;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 4px 24px rgba(0,0,0,0.03);
            border: 1px solid #eceef2;
        }
        .spinner {
            width: 44px; height: 44px;
            border: 4px solid #eceef2;
            border-top-color: {{ $sp }};
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        h2 { font-size: 1.2rem; font-weight: 700; color: #0f1119; margin-bottom: 8px; }
        p { color: #8893ac; font-size: 0.9rem; line-height: 1.5; margin-bottom: 16px; }
        .secure-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 14px; border-radius: 20px;
            background: #f0fdf4; border: 1px solid #bbf7d0;
            font-size: 0.75rem; font-weight: 600; color: #166534;
        }
        .fallback { margin-top: 20px; font-size: 0.8rem; color: #b1b8c9; }
        .fallback a { color: {{ $sp }}; }
    </style>
</head>
<body>
    <div class="card">
        <div class="spinner"></div>
        <h2>Iyzico'ya Yönlendiriliyorsunuz</h2>
        <p>Güvenli ödeme sayfasına yönlendiriliyorsunuz, lütfen bekleyin...</p>
        <div class="secure-badge">🔒 256-bit SSL ile güvenli ödeme</div>
        <div class="fallback">
            Yönlendirme çalışmazsa <a href="{{ $redirectUrl }}">buraya tıklayın</a>.
        </div>
    </div>

    <script>
        window.location.href = {{ Js::from($redirectUrl) }};
    </script>
</body>
</html>
