<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'senin 💝 davetiyen') }} - Giriş</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800|dancing-script:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            overflow: hidden;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
        }

        .login-left {
            width: 50%;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px;
        }

        .login-left .bg-img {
            position: absolute;
            inset: -10px;
            background-image: linear-gradient(rgba(0, 0, 0, 0.25), rgba(139, 92, 246, 0.15)),
                url("https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D");
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            animation: zoomBg 20s ease-in-out infinite alternate;
            z-index: 0;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.12) 0%, transparent 70%);
            top: -250px;
            right: -200px;
            border-radius: 50%;
            animation: pulse 8s ease-in-out infinite;
            z-index: 1;
        }

        .login-left::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.08) 0%, transparent 70%);
            bottom: -150px;
            left: -150px;
            border-radius: 50%;
            animation: pulse 10s ease-in-out infinite reverse;
            z-index: 1;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.4;
            }

            50% {
                transform: scale(1.15);
                opacity: 0.8;
            }
        }

        .login-left .content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }

        .login-left .brand-icon {
            width: 88px;
            height: 88px;
            background: #ffffff;
            border-radius: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }

        .login-left h1 {
            font-size: 2.75rem;
            font-weight: 800;
            margin-bottom: 14px;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #fff, rgba(255, 255, 255, 0.8));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-left p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.05rem;
            max-width: 400px;
            line-height: 1.7;
        }

        .login-left .features-mini {
            display: flex;
            gap: 20px;
            margin-top: 40px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .login-left .features-mini span {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.35);
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .floating-shapes {
            position: absolute;
            inset: 0;
            overflow: hidden;
            z-index: 0;
        }

        .shape {
            position: absolute;
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            animation: float linear infinite;
        }

        .shape:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 15%;
            left: 8%;
            animation-duration: 25s;
        }

        .shape:nth-child(2) {
            width: 140px;
            height: 140px;
            top: 55%;
            right: 12%;
            animation-duration: 30s;
            animation-direction: reverse;
        }

        .shape:nth-child(3) {
            width: 70px;
            height: 70px;
            bottom: 25%;
            left: 35%;
            animation-duration: 18s;
        }

        .shape:nth-child(4) {
            width: 110px;
            height: 110px;
            top: 8%;
            right: 25%;
            animation-duration: 28s;
            animation-direction: reverse;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-40px) rotate(180deg);
            }

            100% {
                transform: translateY(0) rotate(360deg);
            }
        }

        @keyframes zoomBg {
            0% { transform: scale(1); }
            100% { transform: scale(1.08); }
        }

        .login-right {
            width: 45%;
            display: flex;
            margin-top:4em;
            align-items: center;
            justify-content: center;
            padding: 60px;
            background: #f8fafc;
            position: relative;
        }



        .login-card {
            width: 100%;
            max-width: 400px;
        }

        .login-card .header-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            background: #eef2ff;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .login-card h2 {
            font-size: 1.65rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }

        .login-card .subtitle {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 16px;
        }

        .login-card>p:last-of-type {
            margin-top: 0 !important;
            margin-bottom: 16px;
        }

        .login-card .form-group {
            margin-bottom: 20px;
        }

        .login-card label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .login-card .input-wrap {
            position: relative;
        }

        .login-card .input-wrap svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #94a3b8;
        }

        .login-card input {
            width: 100%;
            padding: 13px 14px 13px 44px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.9rem;
            transition: all 0.2s;
            background: white;
            outline: none;
            font-family: 'Figtree', sans-serif;
        }

        .login-card input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
        }

        .login-card input::placeholder {
            color: #cbd5e1;
        }

        .login-card .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .login-card .remember-row label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #475569;
            margin: 0;
            cursor: pointer;
            text-transform: none;
            letter-spacing: normal;
        }

        .login-card .remember-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 2px solid #cbd5e1;
            accent-color: #6366f1;
        }

        .login-card .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Figtree', sans-serif;
            letter-spacing: 0.3px;
        }

        .login-card .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(99, 102, 241, 0.35);
        }

        .login-card .btn-login:active {
            transform: translateY(0);
        }

        .login-card .forgot-link {
            font-size: 0.85rem;
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
        }

        .login-card .forgot-link:hover {
            text-decoration: underline;
        }

        .login-card .error-msg {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        .login-card .success-msg {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        @media (max-width: 1024px) {
            body {
                overflow: auto;
            }

            .login-container {
                flex-direction: column;
            }

            .login-left {
                width: 100%;
                display: flex;
                min-height: 200px;
                padding: 32px;
                flex: none;
            }

            .login-left .content p,
            .login-left .features-mini,
            .login-left::before,
            .login-left::after,
            .floating-shapes {
                display: none;
            }

            .login-left .content {
                color: white;
            }

            .login-left .brand-icon {
                width: 72px;
                height: 72px;
                margin-bottom: 8px;
            }

            .login-left .content h1 {
                font-size: 2.2rem !important;
            }

            .login-right {
                width: 100%;
                margin-top: 0;
                padding: 2px 24px 16px;
            }

            .login-right .login-card {
                text-align: center;
            }

            .login-right .login-card h2 {
                margin-bottom: 12px;
            }

            .login-right .login-card .subtitle {
                margin-bottom: 0;
            }

            .login-right .login-card p:last-of-type {
              
                margin-bottom: 12px;
            }

            .login-right .login-card .form-group {
                margin-bottom: 20px;
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-left md:flex">
            <div class="bg-img"></div>
            <div class="floating-shapes">
                <div class="shape"></div>
                <div class="shape"></div>
                <div class="shape"></div>
                <div class="shape"></div>
            </div>
            <div class="content">
                <div class="brand-icon">
                    <img src="{{ asset('images/logo.svg') }}" alt="senin 💝 davetiyen" class="w-20 h-20 object-contain mx-auto">
                </div>
                <h1 style="font-family:'Dancing Script',cursive;font-weight:700;font-size:4.5rem"><span style="color:#06b6d4;background:none;-webkit-text-fill-color:#06b6d4">Senin</span> <span style="color:#ec4899;background:none;-webkit-text-fill-color:#ec4899">Davetiyen</span></h1>
                
                <p>Özel günleriniz için dijital davetiyeler oluşturun, QR kodlarla paylaşın.</p>
                <div class="features-mini">
                    <span>✦ QR Kod</span>
                    <span>✦ RSVP Takibi</span>
                    <span>✦ Özel Temalar</span>
                </div>
            </div>
        </div>
        <div class="login-right flex justify-center mx-auto">
            <div class="login-card">
                <div class="flex gap-3 flex-col mb-5">
                         <h2>Hoş Geldiniz</h2>
                <p class="subtitle">Hesabınıza giriş yaparak davetiyenizi yönetin</p>
                <p style="margin-top:4px;font-size:0.75rem;color:#94a3b8">Hesabınız varsa giriş yapın. Hesabınız yoksa yöneticinizle iletişime geçin.</p>
                </div>
                

                @if(session('status'))
                <div class="success-msg">{{ session('status') }}</div>
                @endif

                @if($errors->any())
                <div class="error-msg">
                    @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="gap-4 flex flex-col">
                    @csrf
                    <div class="form-group  ">
                        <label for="email">E-posta Adresi</label>
                        <div class="input-wrap ">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="ornek@email.com" required autofocus autocomplete="username">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Şifre</label>
                        <div class="input-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0110 0v4" />
                            </svg>
                            <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                        </div>
                    </div>

                    <button type="submit" class="btn-login">Giriş Yap</button>

                    <div class="text-center mt-4">
                        <button type="button" onclick="clearAll()" class="text-xs text-gray-400 hover:text-red-500 transition-colors underline cursor-pointer" style="background:none;border:none;font-family:inherit">Çerezleri temizle & yeniden dene</button>
                    </div>

                    <script>
                        function clearAll() {
                            var cookies = document.cookie.split('; ');
                            for (var i = 0; i < cookies.length; i++) {
                                var c = cookies[i].split('=')[0];
                                document.cookie = c + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                                document.cookie = c + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=' + location.hostname + ';';
                            }
                            try { localStorage.clear(); } catch(e) {}
                            try { sessionStorage.clear(); } catch(e) {}
                            location.reload();
                        }
                    </script>
                </form>
            </div>
        </div>
    </div>
</body>

</html>