@php
    $sp = \App\Models\Setting::getValue('site_primary_color', '#d4a61e');
    $ss = \App\Models\Setting::getValue('site_secondary_color', '#e05278');
    $pr = hexdec(substr($sp,1,2)); $pg = hexdec(substr($sp,3,2)); $pb = hexdec(substr($sp,5,2));
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'senin 💝 davetiyen') }} - Kayıt Ol</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
            background: #faf9f7;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: -1;
            background:
                radial-gradient(ellipse at 20% 30%, rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.06) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 70%, rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.04) 0%, transparent 60%);
        }

        .register-wrap {
            width: 100%;
            max-width: 460px;
        }

        .logo {
            text-align: center;
            margin-bottom: 28px;
        }
        .logo a {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 1.2rem;
            color: #0f1119;
        }
        .logo .mark {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, {{ $sp }}, {{ $ss }});
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 4px 16px rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.25);
        }

        .card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid #eceef2;
            padding: 36px 32px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.03), 0 4px 16px rgba(0,0,0,0.02);
        }

        @if (request()->has('purchase'))
        .purchase-banner {
            background: linear-gradient(135deg, {{ $sp }}, {{ $ss }});
            color: #fff;
            padding: 18px 22px;
            border-radius: 16px;
            margin-bottom: 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .purchase-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.10), transparent);
            pointer-events: none;
        }
        .purchase-banner .icon {
            font-size: 1.6rem;
            margin-bottom: 8px;
        }
        .purchase-banner .title {
            font-weight: 800;
            font-size: 1rem;
            margin-bottom: 4px;
        }
        .purchase-banner .sub {
            font-size: 0.82rem;
            opacity: 0.9;
            line-height: 1.5;
        }
        @endif

        .card h2 {
            font-size: 1.3rem;
            font-weight: 800;
            color: #0f1119;
            text-align: center;
            margin-bottom: 4px;
        }
        .card .desc {
            text-align: center;
            color: #8893ac;
            font-size: 0.88rem;
            margin-bottom: 28px;
        }

        .field {
            margin-bottom: 18px;
        }
        .field label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #464e62;
            margin-bottom: 5px;
        }
        .field input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e8eaef;
            border-radius: 12px;
            font-size: 0.9rem;
            outline: none;
            background: #fff;
            color: #0f1119;
            transition: all 0.25s;
        }
        .field input::placeholder { color: #c5c9d4; }
        .field input:focus {
            border-color: {{ $sp }};
            box-shadow: 0 0 0 4px rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.08);
            background: #fffdf7;
        }
        .field .error {
            color: #ef4444;
            font-size: 0.78rem;
            margin-top: 4px;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 14px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            background: linear-gradient(135deg, {{ $sp }}, {{ $ss }});
            color: #fff;
            transition: all 0.3s;
            box-shadow: 0 8px 24px rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.20);
            margin-top: 6px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.30);
        }
        .btn-submit:active {
            transform: translateY(0);
        }

        .card .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: #8893ac;
        }
        .card .footer a {
            color: {{ $sp }};
            font-weight: 600;
            text-decoration: none;
        }
        .card .footer a:hover {
            text-decoration: underline;
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: #8893ac;
        }
        .login-link a {
            color: {{ $sp }};
            font-weight: 600;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .card { padding: 24px 20px; }
        }
    </style>
</head>
<body>
    <div class="register-wrap">
        <div class="logo">
            <a href="/">
                <img src="{{ asset('images/logo.svg') }}" alt="senin 💝 davetiyen" class="w-7 h-7 object-contain inline-block align-middle">
                senin 💝 davetiyen
            </a>
        </div>

        <div class="card">
            @if (request()->has('purchase'))
            <div class="purchase-banner">
                <div class="icon">🎉</div>
                <div class="title">Satın Almaya Çok Yakınsın!</div>
                <div class="sub">Hemen ücretsiz üye ol, planını seçip ödemeye başla. Kaydın 30 saniye sürer.</div>
            </div>
            @endif

            <h2>Hesap Oluştur</h2>
            <p class="desc">Ücretsiz üye ol, dijital davetiyeni oluşturmaya başla</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field">
                    <label for="name">Ad Soyad</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Adın ve soyadın" required autofocus autocomplete="name">
                    @error('name') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="email">E-posta</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="ornek@email.com" required autocomplete="username">
                    @error('email') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="password">Şifre</label>
                    <input id="password" type="password" name="password" placeholder="En az 8 karakter" required autocomplete="new-password">
                    @error('password') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Şifre Tekrar</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Şifreni tekrar gir" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn-submit">Üye Ol</button>
            </form>

            <div class="login-link">
                Zaten üye misin? <a href="{{ route('login') }}">Giriş Yap</a>
            </div>
        </div>
    </div>
</body>
</html>
