<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'senin davetiyen') }} - Sayfa Bulunamadı</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #faf9f7;
            padding: 24px;
        }
        .error-card {
            text-align: center;
            max-width: 440px;
        }
        .error-code {
            font-size: 7rem;
            font-weight: 800;
            background: linear-gradient(135deg, #d4a61e, #e05278);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: 8px;
        }
        .error-card h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f1119;
            margin-bottom: 10px;
        }
        .error-card p {
            color: #8893ac;
            font-size: 0.95rem;
            margin-bottom: 28px;
            line-height: 1.6;
        }
        .btn-home {
            display: inline-block;
            padding: 14px 36px;
            background: linear-gradient(135deg, #d4a61e, #e05278);
            color: #fff;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 8px 24px rgba(212, 166, 30, 0.2);
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(212, 166, 30, 0.3);
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-code">404</div>
        <h2>Sayfa Bulunamadı</h2>
        <p>Aradığınız sayfa mevcut değil veya taşınmış olabilir.</p>
        <a href="/" class="btn-home">Ana Sayfaya Dön</a>
    </div>
</body>
</html>