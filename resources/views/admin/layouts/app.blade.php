<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'senin 💝 davetiyen') }} - Admin Panel</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="Yönetim Paneli - {{ config('app.name', 'senin 💝 davetiyen') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800|dancing-script:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Figtree',sans-serif; background:#f1f5f9; color:#1e293b; }
        [x-cloak] { display: none !important; }

        @php
            $c = \App\Models\Setting::getValue('admin_primary_color', '#4f46e5');
            $r = min(255, hexdec(substr($c, 1, 2)) + 200);
            $g = min(255, hexdec(substr($c, 3, 2)) + 200);
            $b = min(255, hexdec(substr($c, 5, 2)) + 200);
            $cl = sprintf('#%02x%02x%02x', $r, $g, $b);
            $r = max(0, hexdec(substr($c, 1, 2)) - 40);
            $g = max(0, hexdec(substr($c, 3, 2)) - 40);
            $b = max(0, hexdec(substr($c, 5, 2)) - 40);
            $cd = sprintf('#%02x%02x%02x', $r, $g, $b);
            $cr = hexdec(substr($c,1,2)); $cg = hexdec(substr($c,3,2)); $cb = hexdec(substr($c,5,2));
        @endphp
        :root {
            --sidebar-w: 270px;
            --bg-primary: #f8fafc;
            --bg-sidebar: #ffffff;
            --border-color: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --accent: {{ $c }};
            --accent-light: {{ $cl }};
            --accent-dark: {{ $cd }};
        }

        .admin-sidebar {
            width: var(--sidebar-w);
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            position: fixed;
            left: 0; top: 0; bottom: 0;
            z-index: 50;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(.4,0,.2,1);
        }
        .admin-sidebar .logo-area {
            padding: 22px 24px 18px;
            border-bottom: 1px solid var(--border-color);
        }
        .admin-sidebar .logo-area a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .admin-sidebar .logo-area .logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 1rem; color: white;
            flex-shrink: 0;
        }
        .admin-sidebar .logo-area .logo-text { color: var(--text-primary); font-weight: 700; font-size: 1rem; letter-spacing: -0.01em; }
        .admin-sidebar .logo-area .logo-sub { color: var(--text-muted); font-size: 0.6rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; margin-top: 1px; line-height: 1.3; }

        .admin-sidebar .nav-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 8px 0;
        }
        .admin-sidebar .nav-scroll::-webkit-scrollbar { width: 3px; }
        .admin-sidebar .nav-scroll::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 10px; }

        .admin-sidebar .nav-section {
            padding: 20px 24px 6px;
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
        }
        .admin-sidebar .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            margin: 2px 12px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
            white-space: nowrap;
        }
        .admin-sidebar .nav-item:hover {
            background: var(--accent-light);
            color: var(--accent);
        }
        .admin-sidebar .nav-item.active {
            background: var(--accent-light);
            color: var(--accent);
            font-weight: 600;
        }
        .admin-sidebar .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%; transform: translateY(-50%);
            width: 3px; height: 18px;
            background: var(--accent);
            border-radius: 0 4px 4px 0;
        }
        .admin-sidebar .nav-item .nav-icon {
            width: 20px; height: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .admin-sidebar .sidebar-footer {
            padding: 12px 20px;
            border-top: 1px solid var(--border-color);
        }
        .admin-sidebar .sidebar-footer form button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-muted);
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            transition: all 0.2s;
        }
        .admin-sidebar .sidebar-footer form button:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        .admin-main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            background: var(--bg-primary);
        }

        .admin-topbar {
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            background: white;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 20;
        }
        .admin-topbar .left { display: flex; align-items: center; gap: 14px; }
        .admin-topbar .hamburger {
            display: none;
            width: 36px; height: 36px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: white;
            color: var(--text-secondary);
            cursor: pointer;
            align-items: center; justify-content: center;
        }
        .admin-topbar .hamburger:hover { background: var(--accent-light); color: var(--accent); }
        .admin-topbar .page-title { font-size: 1.1rem; font-weight: 700; color: var(--text-primary); }
        .admin-topbar .page-title .sub { display: block; font-size: 0.72rem; font-weight: 400; color: var(--text-muted); margin-top: 1px; line-height: 1.3; }
        .admin-topbar .right { display: flex; align-items: center; gap: 14px; }
        .admin-topbar .user-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 10px 5px 14px;
            border-radius: 10px;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
        }
        .admin-topbar .user-badge .avatar {
            width: 34px; height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 0.8rem;
            flex-shrink: 0;
        }
        .admin-topbar .user-badge .user-text { text-align: right; line-height: 1.3; }
        .admin-topbar .user-badge .user-name { font-size: 0.8rem; font-weight: 600; color: var(--text-primary); }
        .admin-topbar .user-badge .user-role { font-size: 0.65rem; color: var(--text-muted); }

        .admin-body {
            padding: 28px 32px;
            position: relative;
            z-index: 1;
        }
        .admin-body > .alerts { margin-bottom: 20px; }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.3);
            z-index: 45;
        }

        .glass-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 22px 24px;
            transition: all 0.25s;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        .stat-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transform: translateY(-2px);
        }
        .stat-card .stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1.2;
            letter-spacing: -0.02em;
        }
        .stat-card .stat-label {
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-top: 3px;
            line-height: 1.3;
        }
        .stat-card .stat-bar {
            margin-top: 12px;
            height: 4px;
            background: #f1f5f9;
            border-radius: 4px;
            overflow: hidden;
        }
        .stat-card .stat-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.6s ease;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 600;
            white-space: nowrap;
            line-height: 1.3;
        }

        .table-wrap { overflow-x: auto; }
        .table-wrap table { width: 100%; border-collapse: collapse; }
        .table-wrap th, .table-wrap td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.85rem;
            color: var(--text-secondary);
            line-height: 1.4;
        }
        .table-wrap td { white-space: nowrap; }
        .table-wrap td:first-child { white-space: normal; }
        .table-wrap td:last-child { white-space: nowrap; }
        .table-wrap th {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }
        .table-wrap td .font-medium { color: var(--text-primary); font-weight: 600; }
        .table-wrap tr:hover td { background: #f8fafc; }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.25s;
            white-space: nowrap;
        }
        .btn-primary:hover { box-shadow: 0 4px 16px rgba({{ $cr }}, {{ $cg }}, {{ $cb }}, 0.25); transform: translateY(-1px); }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            background: transparent;
            cursor: pointer;
            white-space: nowrap;
        }
        .btn-ghost:hover { background: var(--accent-light); color: var(--accent); border-color: var(--accent); }

        input, textarea, select {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.875rem;
            color: var(--text-primary);
            outline: none;
            transition: all 0.2s;
            width: 100%;
            font-family: 'Figtree',sans-serif;
        }
        input:focus, textarea:focus, select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba({{ $cr }}, {{ $cg }}, {{ $cb }}, 0.08);
        }
        input::placeholder, textarea::placeholder { color: var(--text-muted); }
        label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 5px;
        }

        @media (max-width: 1024px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
            .admin-main { margin-left: 0; }
            .admin-topbar .hamburger { display: flex; }
            .admin-topbar { padding: 0 16px; }
            .admin-body { padding: 20px 16px; }
            .admin-topbar .user-badge .user-text { display: none; }
        }
        @media (max-width: 768px) {
            .stat-card { padding: 16px; }
            .stat-card .stat-value { font-size: 1.4rem; }
            .table-wrap th, .table-wrap td { padding: 8px 10px; font-size: 0.75rem; }
            .table-wrap td:last-child { white-space: normal; }
            .admin-body { padding: 14px 10px; }
            .admin-topbar .page-title { font-size: 0.95rem; }
            .admin-topbar .right .user-badge .user-text { display: none; }
        }
        @media (max-width: 480px) {
            .stat-card { padding: 12px; }
            .stat-card .stat-value { font-size: 1.15rem; }
            .stat-card .stat-label { font-size: 0.65rem; }
            .table-wrap th, .table-wrap td { padding: 6px 6px; font-size: 0.7rem; }
            .table-wrap td .btn-ghost, .table-wrap td .btn-primary { font-size: 0.65rem; padding: 4px 8px; }
            .table-wrap td:last-child .flex { flex-wrap: wrap; justify-content: flex-end; gap: 2px; }
            .admin-body { padding: 10px 6px; }
            .admin-topbar { height: 56px; padding: 0 10px; }
            .admin-topbar .page-title { font-size: 0.85rem; }
            .glass-card { border-radius: 10px; }
            .pagination { font-size: 0.7rem; }
        }
    </style>
</head>
@php
    $pendingNotificationCount = \App\Models\PaymentNotification::where('status', 'pending')->count()
        + \App\Models\Review::where('is_approved', false)->count()
        + \App\Models\Invoice::where('refund_status', 'requested')->count()
        + \App\Models\ContactMessage::where('is_read', false)->count();
@endphp

<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="admin-sidebar" id="sidebar">
        <div class="logo-area">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="senin 💝 davetiyen" class="w-14 h-14 object-contain">
                <div>
                    <div class="logo-text" style="font-family:'Dancing Script',cursive;font-weight:700;font-size:1.8rem;letter-spacing:normal"><span style="color:#06b6d4">Senin</span> <span style="color:#ec4899">Davetiyen</span></div>
                    <div class="logo-sub">Yönetim Paneli</div>
                </div>
            </a>
        </div>
        <div class="nav-scroll">
            <div class="nav-section">Ana Menü</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon">📊</span> Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <span class="nav-icon">👥</span> Kullanıcılar
            </a>
            <a href="{{ route('admin.plans.index') }}" class="nav-item {{ request()->routeIs('admin.plans*') ? 'active' : '' }}">
                <span class="nav-icon">📦</span> Paketler
            </a>
            <a href="{{ route('admin.themes.index') }}" class="nav-item {{ request()->routeIs('admin.themes*') ? 'active' : '' }}">
                <span class="nav-icon">🎨</span> Temalar
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="nav-item {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                <span class="nav-icon">💬</span> Yorumlar
            </a>
            <a href="{{ route('admin.contact-messages.index') }}" class="nav-item {{ request()->routeIs('admin.contact-messages*') ? 'active' : '' }}">
                <span class="nav-icon">✉️</span> Mesajlar
            </a>
            <a href="{{ route('admin.payment-notifications.index') }}" class="nav-item {{ request()->routeIs('admin.payment-notifications*') ? 'active' : '' }}">
                <span class="nav-icon">💳</span> Ödemeler
                @php $paymentCount = \App\Models\PaymentNotification::where('status', 'pending')->count(); @endphp
                @if($paymentCount > 0)
                    <span class="ml-auto inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[10px] font-bold text-white bg-red-500 rounded-full">{{ $paymentCount }}</span>
                @endif
            </a>
            <div class="nav-section">Sistem</div>
            <a href="{{ route('admin.visitors.index') }}" class="nav-item {{ request()->routeIs('admin.visitors*') ? 'active' : '' }}">
                <span class="nav-icon">🌐</span> Ziyaretçiler
            </a>
            <a href="{{ route('admin.refund-requests.index') }}" class="nav-item {{ request()->routeIs('admin.refund-requests*') ? 'active' : '' }}">
                <span class="nav-icon">🔄</span> İade Talepleri
                @php $refundCount = \App\Models\Invoice::where('refund_status', 'requested')->count(); @endphp
                @if($refundCount > 0)
                    <span class="ml-auto inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[10px] font-bold text-white bg-red-500 rounded-full">{{ $refundCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <span class="nav-icon">⚙️</span> Ayarlar
            </a>
            <a href="{{ route('dashboard') }}" class="nav-item">
                <span class="nav-icon">🔙</span> Kullanıcı Paneli
            </a>
        </div>
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <span class="nav-icon">🚪</span> Çıkış Yap
                </button>
            </form>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div class="left">
                <button class="hamburger" onclick="toggleSidebar()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="page-title">
                    @if(isset($header))
                        {{ $header }}
                    @else
                        Admin Panel
                        <span class="sub">Yönetim paneline hoş geldiniz</span>
                    @endif
                </h1>
            </div>
            <div class="right">
                <a href="{{ route('admin.payment-notifications.index') }}" class="relative mr-2 flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 transition-all" title="Bildirimler">
                    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @if($pendingNotificationCount > 0)
                        <span class="absolute -top-1.5 -right-1.5 flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-white bg-red-500 rounded-full leading-none">{{ $pendingNotificationCount > 99 ? '99+' : $pendingNotificationCount }}</span>
                    @endif
                </a>
                <div class="user-badge">
                    <div class="user-text">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">Yönetici</div>
                    </div>
                    <div class="avatar relative">
                        @if(Auth::user()->photo_url)
                            <img src="{{ Auth::user()->photo_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full rounded-[10px] object-cover">
                        @else
                            {{ Auth::user()->initial }}
                        @endif
                        @if(Auth::user()->isOnline())
                            <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <main class="admin-body">
            @if(session('success'))
                <div class="alerts">
                    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3.5 rounded-xl text-sm">
                        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="alerts">
                    <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-xl text-sm">
                        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif
            {{ $slot }}
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }

        var notifCtx = null;

        function initAudioCtx() {
            if (!notifCtx) {
                try {
                    notifCtx = new (window.AudioContext || window.webkitAudioContext)();
                } catch(e) {}
            }
            if (notifCtx && notifCtx.state === 'suspended') {
                notifCtx.resume();
            }
        }

        document.addEventListener('click', initAudioCtx, { once: true });
        document.addEventListener('touchstart', initAudioCtx, { once: true });

        function playNotificationSound() {
            initAudioCtx();
            if (!notifCtx) return;
            try {
                var g = notifCtx.createGain();
                g.connect(notifCtx.destination);
                g.gain.value = 0.12;

                var o1 = notifCtx.createOscillator();
                o1.type = 'sine';
                o1.frequency.value = 523.25;
                o1.connect(g);
                o1.start();
                o1.stop(notifCtx.currentTime + 0.12);

                var o2 = notifCtx.createOscillator();
                o2.type = 'sine';
                o2.frequency.value = 659.25;
                o2.connect(g);
                o2.start(notifCtx.currentTime + 0.13);
                o2.stop(notifCtx.currentTime + 0.28);

                var o3 = notifCtx.createOscillator();
                o3.type = 'sine';
                o3.frequency.value = 783.99;
                o3.connect(g);
                o3.start(notifCtx.currentTime + 0.29);
                o3.stop(notifCtx.currentTime + 0.45);
            } catch(e) {}
        }

        (function() {
            var lastCount = {{ $pendingNotificationCount ?? 0 }};
            setInterval(function() {
                fetch('{{ route('admin.payment-notifications.pending-count') }}')
                    .then(function(r) { return r.json(); })
                    .then(function(d) {
                        if (d.count > lastCount) {
                            playNotificationSound();
                        }
                        lastCount = d.count;
                    })
                    .catch(function() {});
            }, 15000);
        })();
    </script>
</body>
</html>
