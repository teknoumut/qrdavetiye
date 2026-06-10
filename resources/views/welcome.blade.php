<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="senin 💝 davetiyen - Özel günleriniz için modern ve şık davetiyeler">
    <title>Dijital Davetiye Platformu</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900|playfair-display:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
        $sp = \App\Models\Setting::getValue('site_primary_color', '#d4a61e');
        $ss = \App\Models\Setting::getValue('site_secondary_color', '#e05278');
        $spd = sprintf('#%02x%02x%02x', max(0, hexdec(substr($sp,1,2))-30), max(0, hexdec(substr($sp,3,2))-30), max(0, hexdec(substr($sp,5,2))-30));
        $ssd = sprintf('#%02x%02x%02x', max(0, hexdec(substr($ss,1,2))-30), max(0, hexdec(substr($ss,3,2))-30), max(0, hexdec(substr($ss,5,2))-30));
        $spe = rawurlencode($sp);
        $pr = hexdec(substr($sp,1,2)); $pg = hexdec(substr($sp,3,2)); $pb = hexdec(substr($sp,5,2));
        $sr = hexdec(substr($ss,1,2)); $sg = hexdec(substr($ss,3,2)); $sb = hexdec(substr($ss,5,2));
        $sdr = hexdec(substr($ssd,1,2)); $sdg = hexdec(substr($ssd,3,2)); $sdb = hexdec(substr($ssd,5,2));
    @endphp
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --site-primary: {{ $sp }};
            --site-primary-dark: {{ $spd }};
            --site-secondary: {{ $ss }};
            --site-secondary-dark: {{ $ssd }};
        }
        body { font-family: 'Figtree', sans-serif; overflow-x: hidden; background: #faf9f7; color: #0f1119; scroll-behavior: smooth; -webkit-font-smoothing: antialiased; }
        ::selection { background: rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.20); color: #634319; }

        .hamburger span { transition: all 0.25s; }
        .hamburger.open span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
        .hamburger.open span:nth-child(2) { opacity: 0; }
        .hamburger.open span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }

        .mobile-menu {
            opacity: 0; visibility: hidden; transition: all 0.3s;
        }
        .mobile-menu.open { opacity: 1; visibility: visible; }

        /* Hero */
        .hero {
            min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 100px 24px 60px; text-align: center; position: relative; overflow: hidden;
        }
        .hero-bg {
            position: absolute; inset: 0; z-index: -1;
            background: radial-gradient(ellipse at 20% 40%, #fdf8ed 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 60%, #fce7ea 0%, transparent 60%),
                        radial-gradient(ellipse at 50% 100%, #f0fdf4 0%, transparent 50%),
                        linear-gradient(180deg, #faf9f7 0%, #fff 50%, #faf9f7 100%);
        }
        .hero-floating {
            position: absolute; inset: 0; z-index: -1; pointer-events: none; overflow: hidden;
        }
        .hero-floating .orb {
            position: absolute; border-radius: 50%;
            filter: blur(60px); opacity: 0.15;
            animation: orbFloat 8s ease-in-out infinite;
        }
        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -40px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.95); }
            75% { transform: translate(40px, 10px) scale(1.05); }
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 18px; border-radius: 100px; font-size: 0.8rem; font-weight: 600;
            background: rgba(253,248,237,0.8); backdrop-filter: blur(10px);
            border: 1px solid rgba(242,217,149,0.4); color: #8f6513;
            margin-bottom: 28px; animation: fadeUp 0.7s ease-out;
            position: relative;
        }
        .hero-badge .dot {
            width: 6px; height: 6px; border-radius: 50%; background: var(--site-primary);
            animation: dotPulse 2s ease-in-out infinite;
        }
        @keyframes dotPulse { 0%,100% { opacity: 0.4; } 50% { opacity: 1; } }
        .hero h1 {
            font-size: clamp(2.4rem, 6vw, 4.2rem); font-weight: 900; letter-spacing: -0.03em;
            line-height: 1.08; margin-bottom: 20px; animation: fadeUp 0.7s ease-out 0.1s both;
        }
        .hero h1 .highlight {
            background: linear-gradient(135deg, var(--site-primary), var(--site-secondary));
            -webkit-text-fill-color: transparent; -webkit-background-clip: text; background-clip: text;
            position: relative;
        }
        .hero h1 .highlight::after {
            content: ''; position: absolute; bottom: 4px; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--site-primary), var(--site-secondary), transparent);
            border-radius: 2px; animation: lineGlow 3s ease-in-out infinite;
        }
        @keyframes lineGlow { 0%,100% { opacity: 0.3; } 50% { opacity: 1; } }
        .hero p {
            font-size: clamp(0.95rem, 1.4vw, 1.1rem); color: #8893ac; max-width: 520px;
            line-height: 1.8; margin-bottom: 40px; animation: fadeUp 0.7s ease-out 0.2s both;
        }
        .hero .btns { display: flex; gap: 14px; flex-wrap: wrap; justify-content: center; animation: fadeUp 0.7s ease-out 0.3s both; }
        .hero .btns .primary {
            padding: 15px 36px; border-radius: 14px; font-size: 0.95rem; font-weight: 700; text-decoration: none;
            background: linear-gradient(135deg, var(--site-primary), var(--site-secondary)); color: white; transition: all 0.3s;
            box-shadow: 0 8px 32px rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.30);
            position: relative; overflow: hidden;
        }
        .hero .btns .primary::before {
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.08), transparent);
            transform: rotate(45deg) translateX(-100%);
            transition: transform 0.6s;
        }
        .hero .btns .primary:hover::before { transform: rotate(45deg) translateX(100%); }
        .hero .btns .primary:hover { transform: translateY(-2px) scale(1.02); box-shadow: 0 12px 40px rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.40); }
        .hero .btns .secondary {
            padding: 15px 36px; border-radius: 14px; font-size: 0.95rem; font-weight: 600; text-decoration: none;
            background: rgba(255,255,255,0.8); backdrop-filter: blur(10px);
            color: #464e62; border: 1px solid rgba(226,232,240,0.5); transition: all 0.3s;
        }
        .hero .btns .secondary:hover { border-color: var(--site-primary); color: #0f1119; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.04); }
        .hero-scroll {
            position: absolute; bottom: 32px; left: 50%; transform: translateX(-50%);
            display: flex; flex-direction: column; align-items: center; gap: 10px;
            color: #b1b8c9; font-size: 0.7rem; font-weight: 600; letter-spacing: 2px; text-transform: uppercase;
            animation: fadeUp 0.7s ease-out 0.5s both; cursor: pointer;
            transition: opacity 0.4s;
        }
        .hero-scroll.hidden { opacity: 0; pointer-events: none; }
        .hero-scroll .mouse {
            width: 22px; height: 34px; border: 2px solid #d5d9e2; border-radius: 12px; position: relative;
            transition: border-color 0.3s;
        }
        .hero-scroll:hover .mouse { border-color: var(--site-primary); }
        .hero-scroll .mouse::after {
            content: ''; position: absolute; top: 6px; left: 50%; transform: translateX(-50%);
            width: 3px; height: 8px; border-radius: 2px; background: var(--site-primary);
            animation: scrollWheel 1.5s ease-in-out infinite;
        }
        @keyframes scrollWheel { 0% { opacity: 1; transform: translateX(-50%) translateY(0); } 100% { opacity: 0; transform: translateX(-50%) translateY(12px); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }

        /* Envelope Section */
        .env-section { position: relative; background: linear-gradient(180deg, #faf9f7 0%, #fff 30%, #fdf8ed 70%, #faf9f7 100%); overflow-x: hidden; }
        .env-sticky {
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; position: relative; z-index: 0; padding: 80px 24px 100px;
        }
        .env-sticky::before {
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background: radial-gradient(ellipse at 50% 60%, rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.04) 0%, transparent 60%);
        }
        .env-sticky::after {
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='{{ $spe }}' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .env-scene {
            perspective: 1600px; text-align: center; position: relative;
            will-change: transform;
        }

        .env-label {
            position: absolute; top: -90px; left: 50%; transform: translateX(-50%);
            white-space: nowrap;
            display: flex; align-items: center; gap: 10px;
            font-size: 0.8rem; font-weight: 600; color: #8893ac;
            letter-spacing: 3px; text-transform: uppercase;
            transition: all 0.5s;
        }
        .env-label.hidden { opacity: 0; transform: translateX(-50%) translateY(10px); }
        .env-label .arrow { animation: arrowBounce 2s ease-in-out infinite; }
        @keyframes arrowBounce { 0%,100% { transform: translateY(0); } 50% { transform: translateY(6px); } }

        .env-3d {
            position: relative; width: 380px; height: 280px; margin: 0 auto;
            transform-style: preserve-3d;
        }
        .env-3d .card-body {
            position: absolute; inset: 0; border-radius: 20px;
            background: linear-gradient(160deg, var(--site-primary), var(--site-primary-dark));
            box-shadow: 0 40px 100px rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.20);
            transform: translateZ(0); overflow: hidden;
        }
        .env-3d .card-body::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, transparent 50%);
        }
        .env-3d .card-body::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 50%;
            background: linear-gradient(0deg, rgba(0,0,0,0.06), transparent);
        }

        .env-3d .card-flap {
            position: absolute; top: -4px; left: -4px; right: -4px;
            height: 54%; border-radius: 20px 20px 0 0;
            background: linear-gradient(160deg, var(--site-primary), var(--site-primary-dark));
            clip-path: polygon(0 0, 50% 100%, 100% 0);
            transform-origin: bottom; z-index: 3;
            transition: transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s;
        }
        .env-3d .card-flap::after {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
            clip-path: polygon(0 0, 50% 100%, 100% 0);
        }
        .env-3d.open .card-flap { transform: rotateX(180deg); }

        .env-3d .seal {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            width: 46px; height: 46px; border-radius: 50%; z-index: 4;
            background: linear-gradient(145deg, var(--site-secondary), var(--site-secondary-dark));
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.1rem; font-weight: 700;
            box-shadow: 0 4px 20px rgba({{ $sdr }}, {{ $sdg }}, {{ $sdb }}, 0.30), 0 0 30px rgba({{ $sdr }}, {{ $sdg }}, {{ $sdb }}, 0.10);
            transition: all 0.5s ease;
        }
        .env-3d.open .seal {
            opacity: 0; transform: translate(-50%, -50%) scale(0) rotate(180deg);
        }

        .env-3d .letter {
            position: absolute; left: 50%; transform: translateX(-50%);
            width: 88%; height: 88%; top: 6%;
            background: linear-gradient(160deg, #fffdf7, #fff);
            border-radius: 16px; z-index: 1; padding: 28px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.04);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s;
            opacity: 0; transform: translateX(-50%) scale(0.9);
        }
        .env-3d.open .letter {
            top: -80%; opacity: 1;
            transform: translateX(-50%) rotate(-4deg) scale(1);
            box-shadow: 0 40px 100px rgba(0,0,0,0.12);
        }

        .env-3d .letter .couple {
            display: flex; align-items: center; gap: 22px; margin-bottom: 12px;
        }
        .env-3d .letter .fig {
            width: 60px; height: 60px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .env-3d .letter .fig.groom { background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; }
        .env-3d .letter .fig.bride { background: linear-gradient(135deg, #ec4899, #db2777); color: white; }
        .env-3d .letter .heart-icon { font-size: 2rem; animation: heartBeat 1.5s ease-in-out infinite; }
        @keyframes heartBeat { 0%,100% { transform: scale(1); } 50% { transform: scale(1.2); } }
        .env-3d .letter .title { font-weight: 800; font-size: 1.15rem; color: #0f1119; margin-top: 6px; }
        .env-3d .letter .sub { font-size: 0.7rem; color: #b1b8c9; letter-spacing: 2px; text-transform: uppercase; margin-top: 6px; }

        .env-3d .env-shadow {
            position: absolute; bottom: -20px; left: 5%; right: 5%;
            height: 40px;
            background: radial-gradient(ellipse, rgba(0,0,0,0.1), transparent);
            border-radius: 50%; transition: all 0.8s ease;
        }
        .env-3d.open .env-shadow { transform: scale(1.6); opacity: 0.5; }

        .env-glow {
            position: absolute; top: 50%; left: 50%;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.06), transparent 70%);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 1s ease;
            pointer-events: none;
        }
        .env-3d.open ~ .env-glow { transform: translate(-50%, -50%) scale(3); opacity: 0; }

        .env-progress {
            position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%);
            display: flex; align-items: center; gap: 16px; opacity: 0;
            transition: opacity 0.6s;
        }
        .env-progress.visible { opacity: 1; }
        .env-progress .bar {
            width: 140px; height: 3px; border-radius: 2px; background: rgba(0,0,0,0.06); overflow: hidden;
        }
        .env-progress .bar .fill {
            height: 100%; width: 0%; border-radius: 2px;
            background: linear-gradient(90deg, var(--site-primary), var(--site-secondary));
            transition: width 0.3s;
        }
        .env-progress .pct { font-size: 0.8rem; font-weight: 700; color: #b1b8c9; min-width: 36px; font-variant-numeric: tabular-nums; }

        /* Particles */
        .env-particles {
            position: absolute; inset: 0; pointer-events: none; overflow: hidden;
        }
        .env-particle {
            position: absolute; border-radius: 50%;
            animation: particleFloat 3s ease-out forwards;
        }
        @keyframes particleFloat {
            0% { opacity: 0; transform: translateY(0) scale(0); }
            15% { opacity: 0.9; transform: translateY(-20px) scale(1); }
            100% { opacity: 0; transform: translateY(-140px) scale(0.3); }
        }

        /* Confetti burst */
        .burst-confetti {
            position: absolute; inset: 0; pointer-events: none; overflow: hidden;
        }
        .confetti {
            position: absolute; width: 8px; height: 8px; border-radius: 2px;
            opacity: 0;
        }
        .confetti.burst {
            animation: confettiFall 2.5s ease-out forwards;
        }
        @keyframes confettiFall {
            0% { opacity: 1; transform: translate(0, 0) rotate(0deg) scale(1); }
            100% { opacity: 0; transform: translate(var(--tx), var(--ty)) rotate(720deg) scale(0.2); }
        }

        /* Floating rings */
        .floating-ring {
            position: absolute;             border: 1px solid rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.06);
            border-radius: 50%; pointer-events: none;
            animation: ringFloat 6s ease-in-out infinite;
        }
        @keyframes ringFloat {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 1; }
        }

        /* Section title */
        .section-title { text-align: center; font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 800; color: #0f1119; margin-bottom: 12px; letter-spacing: -0.02em; }
        .section-sub { text-align: center; color: #8893ac; font-size: 1rem; max-width: 480px; margin: 0 auto 50px; line-height: 1.6; }

        .how-section { padding: 100px 24px 80px; background: #fff; position: relative; z-index: 1; }
        .steps { max-width: 1000px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
        .step {
            padding: 36px 24px; border-radius: 20px; text-align: center;
            background: #faf9f7; border: 1px solid #eceef2;
            transition: all 0.5s cubic-bezier(0.4,0,0.2,1); position: relative; overflow: hidden;
            opacity: 0; transform: translateY(30px);
        }
        .step.visible { opacity: 1; transform: translateY(0); }
        .step:hover { transform: translateY(-8px); box-shadow: 0 30px 80px rgba(0,0,0,0.06); border-color: var(--site-primary); }
        .step .num {
            width: 44px; height: 44px; border-radius: 14px;
            background: linear-gradient(135deg, var(--site-primary), var(--site-secondary)); color: white;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 1.1rem; margin: 0 auto 18px;
        }
        .step h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: 10px; color: #0f1119; }
        .step p { color: #8893ac; font-size: 0.85rem; line-height: 1.7; }
        .step .step-bg { position: absolute; right: -15px; bottom: -15px; font-size: 4.5rem; opacity: 0.04; pointer-events: none; transition: all 0.5s; }
        .step:hover .step-bg { opacity: 0.08; transform: scale(1.1) rotate(-5deg); }

        .features-section { padding: 80px 24px; background: #faf9f7; position: relative; z-index: 1; }
        .features-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 16px; }
        .feature-card {
            padding: 24px; border-radius: 18px; display: flex; gap: 16px; align-items: flex-start;
            background: #fff; border: 1px solid #eceef2; transition: all 0.4s ease;
            opacity: 0; transform: translateY(20px);
        }
        .feature-card.visible { opacity: 1; transform: translateY(0); }
        .feature-card:hover { border-color: var(--site-primary); transform: translateY(-4px); box-shadow: 0 16px 48px rgba(0,0,0,0.04); }
        .feature-card .ficon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;
            transition: transform 0.3s;
        }
        .feature-card:hover .ficon { transform: scale(1.1) rotate(-5deg); }
        .feature-card .ftext h4 { font-size: 0.9rem; font-weight: 700; color: #0f1119; margin-bottom: 4px; }
        .feature-card .ftext p { font-size: 0.8rem; color: #8893ac; line-height: 1.5; }

        .contact-section {
            padding: 100px 24px; background: #fff; position: relative; z-index: 1;
            overflow: hidden;
        }
        .contact-section::before {
            content: ''; position: absolute; top: -50%; right: -20%; width: 400px; height: 400px;
            background: radial-gradient(circle, rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.03), transparent 70%);
            border-radius: 50%;
        }
        .contact-section::after {
            content: ''; position: absolute; bottom: -30%; left: -10%; width: 300px; height: 300px;
            background: radial-gradient(circle, rgba({{ $sr }}, {{ $sg }}, {{ $sb }}, 0.03), transparent 70%);
            border-radius: 50%;
        }
        .contact-wrap { max-width: 500px; margin: 0 auto; position: relative; }
        .contact-form {
            background: linear-gradient(160deg, #faf9f7, #fff);
            border-radius: 24px; padding: 44px 40px;
            border: 1px solid #eceef2;
            box-shadow: 0 20px 60px rgba(0,0,0,0.03), 0 4px 16px rgba(0,0,0,0.02);
            transition: box-shadow 0.4s, transform 0.4s;
            position: relative;
        }
        .contact-form::before {
            content: ''; position: absolute; inset: -1px; border-radius: 24px;
            background: linear-gradient(135deg, rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.15), transparent 40%, rgba({{ $sr }}, {{ $sg }}, {{ $sb }}, 0.10));
            z-index: -1;
        }
        .contact-form:hover { box-shadow: 0 30px 80px rgba(0,0,0,0.05); transform: translateY(-2px); }
        .contact-form .form-header {
            text-align: center; margin-bottom: 32px;
        }
        .contact-form .form-header .icon {
            width: 56px; height: 56px; border-radius: 16px;
            background: linear-gradient(135deg, #fdf8ed, #fce7ea);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px; font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.08);
        }
        .contact-form .form-header h3 { font-size: 1.15rem; font-weight: 800; color: #0f1119; margin-bottom: 4px; }
        .contact-form .form-header p { font-size: 0.85rem; color: #8893ac; }
        .contact-form .field-group { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .contact-form .field {
            position: relative; margin-bottom: 14px;
        }
        .contact-form .field.full { grid-column: 1 / -1; }
        .contact-form .field .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            font-size: 1rem; opacity: 0.4; pointer-events: none; transition: opacity 0.3s;
        }
        .contact-form .field textarea ~ .input-icon { top: 18px; transform: none; }
        .contact-form .field:focus-within .input-icon { opacity: 0.7; }
        .contact-form label {
            display: block; font-size: 0.8rem; font-weight: 600; color: #464e62;
            margin-bottom: 5px; letter-spacing: 0.3px;
        }
        .contact-form input, .contact-form textarea {
            width: 100%; padding: 12px 16px 12px 40px; border: 1.5px solid #e8eaef;
            border-radius: 12px; font-size: 0.9rem; transition: all 0.25s;
            outline: none; background: #fff; color: #0f1119;
        }
        .contact-form textarea { padding-left: 40px; resize: vertical; min-height: 100px; }
        .contact-form input::placeholder, .contact-form textarea::placeholder { color: #c5c9d4; }
        .contact-form input:focus, .contact-form textarea:focus {
            border-color: var(--site-primary); box-shadow: 0 0 0 4px rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.08);
            background: #fffdf7;
        }
        .contact-form button {
            width: 100%; padding: 15px; border: none; border-radius: 14px;
            font-size: 0.95rem; font-weight: 700; cursor: pointer; margin-top: 4px;
            background: linear-gradient(135deg, var(--site-primary), var(--site-secondary)); color: white;
            transition: all 0.3s; box-shadow: 0 8px 24px rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.20);
            position: relative; overflow: hidden; display: flex; align-items: center;
            justify-content: center; gap: 8px; letter-spacing: 0.3px;
        }
        .contact-form button::before {
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.08), transparent);
            transform: rotate(45deg) translateX(-100%); transition: transform 0.6s;
        }
        .contact-form button:hover::before { transform: rotate(45deg) translateX(100%); }
        .contact-form button:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.30); }
        .contact-form button:active { transform: translateY(0); }
        .contact-form .success-state {
            text-align: center; padding: 40px 20px; display: none;
        }
        .contact-form .success-state .check {
            width: 64px; height: 64px; border-radius: 50%;
            background: linear-gradient(135deg, var(--site-primary), var(--site-secondary));
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px; font-size: 1.8rem; color: white;
            box-shadow: 0 8px 24px rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.20);
        }
        .contact-form .success-state h4 { font-size: 1.1rem; font-weight: 800; color: #0f1119; margin-bottom: 6px; }
        .contact-form .success-state p { font-size: 0.85rem; color: #8893ac; line-height: 1.6; }

        footer { padding: 36px 24px; text-align: center; color: #b1b8c9; font-size: 0.8rem; background: #fff; border-top: 1px solid #eceef2; position: relative; z-index: 1; }

        @media (max-width: 768px) {
            .env-3d { width: 260px; height: 195px; }
            .env-label { font-size: 0.7rem; top: -70px; }
            .env-3d .letter { padding: 20px; }
            .env-3d .letter .fig { width: 48px; height: 48px; font-size: 1.5rem; }
            .env-3d .letter .couple { gap: 16px; }
            .env-3d.open .letter { top: -60%; }
            .env-3d .letter .heart-icon { font-size: 1.5rem; }
            .steps { grid-template-columns: 1fr; }
            .features-grid { grid-template-columns: 1fr; }
            .contact-form { padding: 24px; }
            #navbar { padding: 12px 16px; }
        }
    </style>
</head>
<body>
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-7 py-3.5 bg-white/75 backdrop-blur-2xl border-b border-black/[0.04] transition-all duration-300">
        <a href="/" class="flex items-center gap-2.5 font-extrabold text-base text-night-900 no-underline shrink-0">
            <span class="w-[34px] h-[34px] rounded-[10px] flex items-center justify-center text-white text-sm font-bold" style="background:linear-gradient(135deg,var(--site-primary),var(--site-secondary))">s</span>
            senin 💝 davetiyen
        </a>

        <button id="hamburgerBtn" class="md:hidden flex flex-col gap-1 bg-transparent border-none cursor-pointer z-[200] p-2 rounded-md" aria-label="Menü">
            <span class="block w-5 h-0.5 bg-night-900 rounded-sm transition-all duration-300"></span>
            <span class="block w-5 h-0.5 bg-night-900 rounded-sm transition-all duration-300"></span>
            <span class="block w-5 h-0.5 bg-night-900 rounded-sm transition-all duration-300"></span>
        </button>

        <div class="hidden md:flex items-center gap-0.5">
            <a href="#how" class="px-3.5 py-2 text-sm font-medium text-night-500 no-underline rounded-lg transition-all hover:bg-black/5 hover:text-gold-500">Nasıl Çalışır?</a>
            <a href="#features" class="px-3.5 py-2 text-sm font-medium text-night-500 no-underline rounded-lg transition-all hover:bg-black/5 hover:text-gold-500">Özellikler</a>
            <a href="#pricing" class="px-3.5 py-2 text-sm font-medium text-night-500 no-underline rounded-lg transition-all hover:bg-black/5 hover:text-gold-500">Fiyatlandırma</a>
            <a href="#faq" class="px-3.5 py-2 text-sm font-medium text-night-500 no-underline rounded-lg transition-all hover:bg-black/5 hover:text-gold-500">SSS</a>
            <a href="#contact" class="px-3.5 py-2 text-sm font-medium text-night-500 no-underline rounded-lg transition-all hover:bg-black/5 hover:text-gold-500">İletişim</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="ml-1.5 px-5 py-2 text-sm font-semibold no-underline rounded-lg text-white transition-all hover:opacity-90 hover:-translate-y-0.5" style="background:linear-gradient(135deg,var(--site-primary),var(--site-secondary))">Panel</a>
                @else
                    <a href="{{ route('login') }}" class="ml-1.5 px-5 py-2 text-sm font-semibold no-underline rounded-lg text-white transition-all hover:opacity-90 hover:-translate-y-0.5" style="background:linear-gradient(135deg,var(--site-primary),var(--site-secondary))">Giriş Yap</a>
                @endauth
            @endif
        </div>

        <div id="mobileMenu" class="mobile-menu fixed inset-0 bg-white/95 backdrop-blur-xl z-[199] flex flex-col items-center justify-center gap-1 p-8 overflow-y-auto">
            <div class="flex flex-col items-center gap-1 w-full max-w-xs py-8">
                <a href="#how" class="w-full text-center py-4 px-4 rounded-xl text-lg font-semibold text-night-500 no-underline transition-all hover:bg-black/5 hover:text-gold-500">Nasıl Çalışır?</a>
                <a href="#features" class="w-full text-center py-4 px-4 rounded-xl text-lg font-semibold text-night-500 no-underline transition-all hover:bg-black/5 hover:text-gold-500">Özellikler</a>
                <a href="#pricing" class="w-full text-center py-4 px-4 rounded-xl text-lg font-semibold text-night-500 no-underline transition-all hover:bg-black/5 hover:text-gold-500">Fiyatlandırma</a>
                <a href="#faq" class="w-full text-center py-4 px-4 rounded-xl text-lg font-semibold text-night-500 no-underline transition-all hover:bg-black/5 hover:text-gold-500">SSS</a>
                <a href="#contact" class="w-full text-center py-4 px-4 rounded-xl text-lg font-semibold text-night-500 no-underline transition-all hover:bg-black/5 hover:text-gold-500">İletişim</a>
                <div class="mt-4 w-full">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="block text-center py-4 px-4 rounded-xl text-lg font-bold no-underline text-white transition-all hover:opacity-90" style="background:linear-gradient(135deg,var(--site-primary),var(--site-secondary))">Panel</a>
                        @else
                            <a href="{{ route('login') }}" class="block text-center py-4 px-4 rounded-xl text-lg font-bold no-underline text-white transition-all hover:opacity-90" style="background:linear-gradient(135deg,var(--site-primary),var(--site-secondary))">Giriş Yap</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <script>
        (function() {
            var hamburger = document.getElementById('hamburgerBtn');
            var menu = document.getElementById('mobileMenu');
            if (!hamburger || !menu) return;

            function toggleMenu() {
                var isOpen = menu.classList.toggle('open');
                hamburger.classList.toggle('open', isOpen);
                document.body.style.overflow = isOpen ? 'hidden' : '';
            }

            hamburger.addEventListener('click', toggleMenu);

            menu.querySelectorAll('a').forEach(function(link) {
                link.addEventListener('click', function() {
                    menu.classList.remove('open');
                    hamburger.classList.remove('open');
                    document.body.style.overflow = '';
                });
            });
        })();
    </script>

    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-floating" id="heroOrbs">
            <div class="orb" style="width:300px;height:300px;top:10%;left:5%;background:var(--site-primary);animation-delay:0s;"></div>
            <div class="orb" style="width:250px;height:250px;bottom:15%;right:10%;background:var(--site-secondary);animation-delay:-3s;"></div>
            <div class="orb" style="width:200px;height:200px;top:40%;left:60%;background:#6366f1;animation-delay:-5s;"></div>
        </div>
        <div class="hero-badge"><span class="dot"></span> Yeni Nesil Davetiye</div>
        <h1>Özel Günlerin İçin<br><span class="highlight">Dijital Davetiye</span></h1>
        <p>QR kodlu, müzikli, fotoğraflı modern davetiyelerle sevdiklerini büyüle. Paylaşması kolay, etkisi büyük.</p>
        <div class="btns">
            <a href="#contact" class="primary">Şimdi Başla</a>
            <a href="#how" class="secondary">Nasıl Çalışır?</a>
        </div>
        <div class="hero-scroll" id="heroScroll" onclick="document.getElementById('envSection').scrollIntoView({behavior:'smooth'})">
            <div class="mouse"></div>
            <span>Kaydır</span>
        </div>
    </section>

    <div class="reklam-slider">
        <div class="reklam-track">
            <div class="reklam-slide">
                <div class="reklam-img" style="background-image:url('https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=200&h=120&fit=crop')"></div>
                <div class="reklam-text">Özel davetiyeni hemen oluştur, sevdiklerinle paylaş!</div>
            </div>
            <div class="reklam-slide">
                <div class="reklam-img" style="background-image:url('https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=200&h=120&fit=crop')"></div>
                <div class="reklam-text">Müzik ve video desteği ile davetiyene hayat ver!</div>
            </div>
            <div class="reklam-slide">
                <div class="reklam-img" style="background-image:url('https://images.unsplash.com/photo-1519741497674-611481863552?w=200&h=120&fit=crop')"></div>
                <div class="reklam-text">Premium pakette sınırsız davetiye, sınırsız özellik!</div>
            </div>
        </div>
        <div class="reklam-dots">
            <span></span><span></span><span></span>
        </div>
    </div>

    <style>
        .reklam-slider {
            background: linear-gradient(135deg, var(--site-primary), var(--site-secondary));
            padding: 18px 24px;
            overflow: hidden;
            position: relative;
        }
        .reklam-track {
            display: flex;
            animation: reklamScroll 9s ease-in-out infinite;
            max-width: 750px;
            margin: 0 auto;
        }
        .reklam-slide {
            min-width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            color: white;
        }
        .reklam-img {
            width: 120px; height: 70px;
            border-radius: 12px;
            background-size: cover;
            background-position: center;
            flex-shrink: 0;
            border: 2px solid rgba(255,255,255,0.15);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .reklam-text { font-size: 0.92rem; font-weight: 600; line-height: 1.5; }
        .reklam-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }
        .reklam-dots span {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            animation: reklamDot 9s ease-in-out infinite;
        }
        .reklam-dots span:nth-child(2) { animation-delay: 3s; }
        .reklam-dots span:nth-child(3) { animation-delay: 6s; }
        @keyframes reklamScroll {
            0%, 28% { transform: translateX(0); }
            33.33%, 61% { transform: translateX(-100%); }
            66.66%, 94% { transform: translateX(-200%); }
            100% { transform: translateX(0); }
        }
        @keyframes reklamDot {
            0%, 28% { background: rgba(255,255,255,0.9); }
            33.33%, 100% { background: rgba(255,255,255,0.3); }
        }
        @media (max-width: 640px) {
            .reklam-img { width: 80px; height: 50px; }
            .reklam-text { font-size: 0.8rem; }
            .reklam-slide { gap: 12px; }
        }
    </style>

    <div class="env-sticky" id="envSticky" style="background:linear-gradient(180deg,#faf9f7 0%,#fff 30%,#fdf8ed 70%,#faf9f7 100%);overflow-x:hidden;">
        <div class="env-particles" id="particles"></div>
        <div class="burst-confetti" id="confettiContainer"></div>
        <div class="env-scene" id="envScene">
            <div class="env-label" id="envLabel">
                <span class="arrow">↓</span> Zarfı Açmak İçin Kaydır <span class="arrow">↓</span>
            </div>
            <div class="env-3d" id="env3d">
                <div class="card-body"></div>
                <div class="card-flap"></div>
                <div class="seal">♥</div>
                <div class="letter">
                    <div class="couple">
                        <div class="fig groom">👨</div>
                        <div class="heart-icon">💖</div>
                        <div class="fig bride">👩</div>
                    </div>
                    <div class="title">senin 💝 davetiyen</div>
                    <div class="sub">Özel Gününüz Kutlu Olsun</div>
                </div>
                <div class="env-shadow"></div>
            </div>
            <div class="env-glow"></div>
            <div class="env-progress" id="envProgress">
                <span class="pct" id="envPct">%0</span>
                <div class="bar"><div class="fill" id="envFill"></div></div>
            </div>
        </div>
    </div>

    <div class="env-section" id="envSection">
        <div class="how-section" id="how">
            <div class="section-title animate-reveal">Nasıl Çalışır?</div>
            <div class="section-sub animate-reveal">Birkaç adımda davetiyeni oluştur, QR kodla paylaşmaya başla</div>
            <div class="steps">
                <div class="step animate-step">
                    <div class="num">1</div>
                    <h3>Bize Ulaş</h3>
                    <p>Formdan mesaj gönder, sana özel hesabını oluşturalım</p>
                    <div class="step-bg">📞</div>
                </div>
                <div class="step animate-step" style="transition-delay:0.1s">
                    <div class="num">2</div>
                    <h3>Davetiyeni Tasarla</h3>
                    <p>Renk, fotoğraf, müzik ve yazılarınla kişiselleştir</p>
                    <div class="step-bg">🎨</div>
                </div>
                <div class="step animate-step" style="transition-delay:0.2s">
                    <div class="num">3</div>
                    <h3>QR Kodla Paylaş</h3>
                    <p>WhatsApp, Instagram veya SMS ile davetlilere ulaştır</p>
                    <div class="step-bg">📱</div>
                </div>
                <div class="step animate-step" style="transition-delay:0.3s">
                    <div class="num">4</div>
                    <h3>Takip Et</h3>
                    <p>Kim katılıyor, kim katılmıyor panelden canlı izle</p>
                    <div class="step-bg">📊</div>
                </div>
            </div>
        </div>

        <div class="features-section" id="features">
            <div class="section-title animate-reveal">Tüm Özellikler</div>
            <div class="section-sub animate-reveal">İhtiyacın olan her şey bu platformda</div>
            <div class="features-grid">
                <div class="feature-card animate-feature"><div class="ficon" style="background:#fdf8ed">📱</div><div class="ftext"><h4>QR Kod</h4><p>Her davetiye için otomatik QR kod, PNG/SVG indir</p></div></div>
                <div class="feature-card animate-feature" style="transition-delay:0.05s"><div class="ficon" style="background:#fdf2f4">🎵</div><div class="ftext"><h4>Müzik Desteği</h4><p>YouTube embed ya da MP3 ile arka plan müziği</p></div></div>
                <div class="feature-card animate-feature" style="transition-delay:0.1s"><div class="ficon" style="background:#fdf8ed">🖼️</div><div class="ftext"><h4>Fotoğraf Galerisi</h4><p>Özel anılarını galeri şeklinde paylaş</p></div></div>
                <div class="feature-card animate-feature" style="transition-delay:0.15s"><div class="ficon" style="background:#fdf2f4">🎨</div><div class="ftext"><h4>Tema & Renk</h4><p>Tamamen özelleştirilebilir tasarım</p></div></div>
                <div class="feature-card animate-feature" style="transition-delay:0.2s"><div class="ficon" style="background:#fdf8ed">⏱️</div><div class="ftext"><h4>Geri Sayım</h4><p>Etkinlik tarihine otomatik sayaç</p></div></div>
                <div class="feature-card animate-feature" style="transition-delay:0.25s"><div class="ficon" style="background:#fdf2f4">📍</div><div class="ftext"><h4>Konum</h4><p>Harita entegrasyonu ile adres göster</p></div></div>
                <div class="feature-card animate-feature" style="transition-delay:0.3s"><div class="ficon" style="background:#fdf8ed">💬</div><div class="ftext"><h4>RSVP Sistemi</h4><p>Katılım takibi, anlık bildirim</p></div></div>
                <div class="feature-card animate-feature" style="transition-delay:0.35s"><div class="ficon" style="background:#fdf2f4">🎬</div><div class="ftext"><h4>Video Desteği</h4><p>YouTube videoları ile zenginleştir</p></div></div>
            </div>
        </div>

        @php $plans = \App\Models\Plan::active()->get(); @endphp
        @if ($plans->count())
        <style>
            .pricing-section { padding: 80px 24px; background: linear-gradient(180deg, #faf9f7 0%, #fff 50%, #faf9f7 100%); position: relative; z-index: 1; }
            .pricing-grid { max-width: 1000px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
            .pricing-card { background: #fff; border-radius: 20px; border: 1px solid #eceef2; padding: 32px 28px; text-align: center; transition: all 0.4s; opacity: 0; transform: translateY(20px); position: relative; overflow: hidden; }
            .pricing-card.visible { opacity: 1; transform: translateY(0); }
            .pricing-card:hover { transform: translateY(-6px); box-shadow: 0 30px 80px rgba(0,0,0,0.06); border-color: var(--site-primary); }
            .pricing-card.featured { border-color: var(--site-primary); box-shadow: 0 0 0 1px var(--site-primary), 0 20px 60px rgba(0,0,0,0.04); }
            .pricing-card .badge { position: absolute; top: 16px; right: 16px; padding: 4px 12px; border-radius: 100px; font-size: 0.7rem; font-weight: 700; background: linear-gradient(135deg, var(--site-primary), var(--site-secondary)); color: #fff; }
            .pricing-card h3 { font-size: 1.1rem; font-weight: 800; color: #0f1119; margin-bottom: 4px; }
            .pricing-card .desc { font-size: 0.8rem; color: #8893ac; margin-bottom: 20px; }
            .pricing-card .p-price { font-size: 2.2rem; font-weight: 900; color: #0f1119; letter-spacing: -0.03em; margin-bottom: 4px; }
            .pricing-card .p-price .cur { font-size: 0.85rem; font-weight: 600; color: #8893ac; }
            .pricing-card .p-period { font-size: 0.8rem; color: #b1b8c9; margin-bottom: 20px; }
            .pricing-card .p-features { list-style: none; padding: 0; margin: 0 0 24px; text-align: left; }
            .pricing-card .p-features li { padding: 6px 0; font-size: 0.85rem; color: #464e62; display: flex; align-items: center; gap: 8px; }
            .pricing-card .p-features li .check { color: #10b981; font-weight: 700; }
            .pricing-card .p-features li .cross { color: #ef4444; font-weight: 700; }
            .pricing-card .p-btn { display: inline-block; width: 100%; padding: 14px; border-radius: 14px; font-size: 0.9rem; font-weight: 700; text-decoration: none; background: linear-gradient(135deg, var(--site-primary), var(--site-secondary)); color: #fff; transition: all 0.3s; box-sizing: border-box; }
            .pricing-card .p-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba({{ $pr }}, {{ $pg }}, {{ $pb }}, 0.25); }
            .pricing-card .p-btn-outline { background: transparent; color: #0f1119; border: 1.5px solid #eceef2; }
            .pricing-card .p-btn-outline:hover { border-color: var(--site-primary); background: rgba(212,166,30,0.04); box-shadow: none; }
            .pricing-toggle { display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 40px; }
            .pricing-toggle span { font-size: 0.85rem; font-weight: 600; color: #8893ac; }
            .pricing-toggle span.active { color: #0f1119; }
            .toggle-switch { width: 48px; height: 26px; border-radius: 13px; background: #d5d9e2; cursor: pointer; position: relative; transition: background 0.3s; }
            .toggle-switch.active { background: var(--site-primary); }
            .toggle-switch::after { content: ''; position: absolute; top: 3px; left: 3px; width: 20px; height: 20px; border-radius: 50%; background: #fff; transition: transform 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
            .toggle-switch.active::after { transform: translateX(22px); }
            @media (max-width: 768px) { .pricing-grid { grid-template-columns: 1fr; } }
        </style>
        <div class="pricing-section" id="pricing">
            <div class="section-title animate-reveal">Plan ve Fiyatlandırma</div>
            <div class="section-sub animate-reveal">İhtiyacına uygun planı seç, hemen başla</div>

            <div class="pricing-toggle">
                <span class="active" id="toggleMonthlyLabel">Aylık</span>
                <div class="toggle-switch" id="pricingToggle" onclick="togglePricing()"></div>
                <span id="toggleYearlyLabel">Yıllık</span>
            </div>

            <div class="pricing-grid">
                @foreach ($plans as $plan)
                <div class="pricing-card animate-feature {{ $plan->name === 'Standart' ? 'featured' : '' }}">
                    @if ($plan->name === 'Standart')<div class="badge">Popüler</div>@endif
                    <h3>{{ $plan->name }}</h3>
                    <p class="desc">{{ $plan->description }}</p>
                    <div class="p-price"><span class="monthly-price">{{ number_format($plan->monthly_price, 2) }}</span><span class="yearly-price" style="display:none">{{ number_format($plan->yearly_price, 2) }}</span><span class="cur"> TL</span></div>
                    <div class="p-period"><span class="monthly-period">/ ay</span><span class="yearly-period" style="display:none">/ yıl</span></div>
                    <ul class="p-features">
                        <li><span class="check">✓</span> {{ $plan->max_invitations == -1 ? 'Sınırsız davetiye' : 'En fazla '.$plan->max_invitations.' davetiye' }}</li>
                        <li><span class="check">✓</span> Davetiye başına {{ $plan->max_images_per_invitation == -1 ? 'sınırsız' : $plan->max_images_per_invitation }} fotoğraf</li>
                        <li><span class="{{ $plan->music_feature ? 'check' : 'cross' }}">{{ $plan->music_feature ? '✓' : '✗' }}</span> Müzik desteği</li>
                        <li><span class="{{ $plan->video_feature ? 'check' : 'cross' }}">{{ $plan->video_feature ? '✓' : '✗' }}</span> Video desteği</li>
                        <li><span class="{{ $plan->rsvp_feature ? 'check' : 'cross' }}">{{ $plan->rsvp_feature ? '✓' : '✗' }}</span> RSVP katılım takibi</li>
                        <li><span class="{{ $plan->qr_download ? 'check' : 'cross' }}">{{ $plan->qr_download ? '✓' : '✗' }}</span> QR kod indirme</li>
                    </ul>
                    @auth
                        <a href="{{ route('payment.checkout', $plan) }}" class="p-btn {{ $plan->monthly_price == 0 ? 'p-btn-outline' : '' }}">Satın Al</a>
                    @else
                        <a href="{{ route('register', ['purchase' => 1]) }}" class="p-btn p-btn-outline">Satın Al</a>
                    @endauth
                </div>
                @endforeach
            </div>
        </div>
        <script>
            function togglePricing() {
                var el = document.getElementById('pricingToggle');
                var isYearly = el.classList.toggle('active');
                document.getElementById('toggleMonthlyLabel').classList.toggle('active', !isYearly);
                document.getElementById('toggleYearlyLabel').classList.toggle('active', isYearly);
                document.querySelectorAll('.monthly-price, .monthly-period').forEach(function(e) { e.style.display = isYearly ? 'none' : ''; });
                document.querySelectorAll('.yearly-price, .yearly-period').forEach(function(e) { e.style.display = isYearly ? '' : 'none'; });
            }
        </script>
        @endif

        @if ($reviews->count())
        <style>
            .reviews-section { padding: 80px 24px; background: #fff; position: relative; z-index: 1; }
            .reviews-grid { max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 16px; }
            .review-card { background: #faf9f7; border-radius: 18px; border: 1px solid #eceef2; padding: 24px; transition: all 0.3s; opacity: 0; transform: translateY(20px); }
            .review-card.visible { opacity: 1; transform: translateY(0); }
            .review-card:hover { border-color: var(--site-primary); box-shadow: 0 8px 32px rgba(0,0,0,0.04); transform: translateY(-2px); }
            .review-card .review-header { display: flex; align-items: center; gap: 14px; margin-bottom: 12px; }
            .review-card .review-avatar { width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, var(--site-primary), var(--site-secondary)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem; flex-shrink: 0; }
            .review-card .review-name { font-weight: 700; font-size: 0.9rem; color: #0f1119; }
            .review-card .review-date { font-size: 0.75rem; color: #b1b8c9; }
            .review-card .review-stars { display: flex; gap: 3px; margin-left: auto; }
            .review-card .review-stars span { font-size: 1rem; }
            .review-card .review-content { font-size: 0.9rem; color: #464e62; line-height: 1.7; }
        </style>
        <div class="reviews-section" id="reviews">
            <div class="section-title animate-reveal">Kullanıcı Yorumları</div>
            <div class="section-sub animate-reveal">senin 💝 davetiyen kullanıcılarının deneyimleri</div>
            <div class="reviews-grid">
                @foreach ($reviews as $review)
                    <div class="review-card animate-feature">
                        <div class="review-header">
                            <div class="review-avatar">{{ substr($review->user->name, 0, 1) }}</div>
                            <div>
                                <div class="review-name">{{ $review->user->name }}</div>
                                <div class="review-date">{{ $review->created_at->format('d M Y') }}</div>
                            </div>
                            <div class="review-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span style="color: {{ $i <= $review->rating ? 'var(--site-primary)' : '#d5d9e2' }}">★</span>
                                @endfor
                            </div>
                        </div>
                        <div class="review-content">{{ $review->content }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="faq-section" id="faq">
            <div class="section-title animate-reveal">Sık Sorulan Sorular</div>
            <div class="section-sub animate-reveal">Merak ettiğin her şeyin cevabı burada</div>

            <div class="faq-grid">
                <details class="faq-item" id="faq1">
                    <summary class="faq-q">QR davetiye nedir?</summary>
                    <div class="faq-a">QR davetiye, özel günleriniz için hazırladığınız dijital davetiyenin QR kod ile paylaşılmasıdır. Davetlileriniz kodu okutarak davetiyenize anında ulaşabilir.</div>
                </details>
                <details class="faq-item" id="faq2">
                    <summary class="faq-q">Davetiyemi nasıl paylaşabilirim?</summary>
                    <div class="faq-a">Davetiyeniz hazır olduktan sonra WhatsApp, Telegram, e-posta gibi herhangi bir platformdan linkini paylaşabilir veya QR kodunu bastırıp fiziksel olarak dağıtabilirsiniz.</div>
                </details>
                <details class="faq-item" id="faq3">
                    <summary class="faq-q">Hangi ödeme yöntemlerini kabul ediyorsunuz?</summary>
                    <div class="faq-a">Kredi kartı ve banka kartı ile ödeme yapabilirsiniz. Tüm ödemeler 256-bit SSL ile güvence altındadır.</div>
                </details>
                <details class="faq-item" id="faq4">
                    <summary class="faq-q">Aboneliğimi iptal edebilir miyim?</summary>
                    <div class="faq-a">Evet, dilediğiniz zaman aboneliğinizi iptal edebilirsiniz. İptal sonrası mevcut davetiyeleriniz yayında kalmaya devam eder ancak yeni davetiye oluşturamazsınız.</div>
                </details>
                <details class="faq-item" id="faq5">
                    <summary class="faq-q">Kaç davetiye oluşturabilirim?</summary>
                    <div class="faq-a">Planınıza göre değişir. Temel pakette 1, Standart pakette 5 adet davetiye oluşturabilirsiniz. Premium pakette ise sınırsız davetiye hakkınız bulunur.</div>
                </details>
                <details class="faq-item" id="faq6">
                    <summary class="faq-q">Müzik ve video ekleyebilir miyim?</summary>
                    <div class="faq-a">Standart pakette müzik, Premium pakette hem müzik hem video desteği bulunur. Planınızı yükselterek bu özellikleri aktif edebilirsiniz.</div>
                </details>
            </div>
        </div>

        <style>
            .faq-section { max-width: 720px; margin: 0 auto; padding: 80px 24px; }
            .faq-grid { display: flex; flex-direction: column; gap: 10px; margin-top: 40px; }
            .faq-item { display: block; background: #fff; border-radius: 16px; border: 1px solid #eceef2; transition: all 0.3s; }
            .faq-item[open] { border-color: var(--site-primary); }
            .faq-item:hover { border-color: var(--site-primary); box-shadow: 0 4px 20px rgba(0,0,0,0.04); }
            .faq-q { display: flex; padding: 18px 22px; font-size: 0.92rem; font-weight: 700; color: #0f1119; align-items: center; justify-content: space-between; user-select: none; cursor: pointer; list-style: none; }
            .faq-q::-webkit-details-marker { display: none; }
            .faq-q::after { content: '+'; font-size: 1.3rem; font-weight: 300; color: #b1b8c9; }
            .faq-item[open] .faq-q::after { content: '−'; }
            .faq-a { display: block; padding: 0 22px 18px; font-size: 0.85rem; color: #8893ac; line-height: 1.6; }
        </style>

        <div class="contact-section" id="contact">
            <div class="section-title animate-reveal">Biz Size Ulaşalım</div>
            <div class="section-sub animate-reveal">Formu doldurun, size özel davetiyenizi birlikte oluşturalım</div>
            <div class="contact-wrap">
                <div class="contact-form" id="contactFormCard">
                    <form id="contactForm">
                        @csrf
                        <div class="form-header">
                            <div class="icon">✉️</div>
                            <h3>Mesaj Gönder</h3>
                            <p>Size en kısa sürede dönüş yapalım</p>
                        </div>
                        <div class="field-group">
                            <div class="field">
                                <label>Ad Soyad</label>
                                <span class="input-icon">👤</span>
                                <input type="text" name="name" required placeholder="Adın ve soyadın">
                            </div>
                            <div class="field">
                                <label>Telefon</label>
                                <span class="input-icon">📞</span>
                                <input type="tel" name="phone" placeholder="0555 555 55 55">
                            </div>
                        </div>
                        <div class="field full">
                            <label>E-posta</label>
                            <span class="input-icon">📧</span>
                            <input type="email" name="email" placeholder="ornek@email.com">
                        </div>
                        <div class="field full">
                            <label>Mesajın</label>
                            <span class="input-icon">💬</span>
                            <textarea name="message" rows="3" required placeholder="Merhaba, dijital davetiye hakkında bilgi almak istiyorum..."></textarea>
                        </div>
                        <button type="submit">
                            <span>Mesajı Gönder</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        </button>
                    </form>
                    <div class="success-state" id="contactSuccess">
                        <div class="check">✓</div>
                        <h4>Mesajın Alındı!</h4>
                        <p>En kısa sürede sana dönüş yapacağız.<br>Teşekkür ederiz 🎉</p>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            &copy; {{ date('Y') }} senin 💝 davetiyen. Tüm hakları saklıdır.
        </footer>
    </div>

    <script>
        var env = document.getElementById('env3d');
        var scene = document.getElementById('envScene');
        var label = document.getElementById('envLabel');
        var progress = document.getElementById('envProgress');
        var pct = document.getElementById('envPct');
        var fill = document.getElementById('envFill');
        var hasOpened = false;
        var particlesEl = document.getElementById('particles');
        var heroScroll = document.getElementById('heroScroll');
        var navbar = document.getElementById('navbar');

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            if (window.scrollY > 40) {
                navbar.classList.add('shadow-sm');
                heroScroll.classList.add('hidden');
            } else {
                navbar.classList.remove('shadow-sm');
                heroScroll.classList.remove('hidden');
            }
        });

        window.addEventListener('scroll', function() {
            if (!scene) return;
            var rect = scene.getBoundingClientRect();
            var winH = window.innerHeight;
            var prog = Math.max(0, Math.min(1, (winH - rect.top) / winH));

            var translateY = prog * 50;
            var scale = 1 - prog * 0.35;
            scene.style.transform = 'translateY(' + translateY + 'px) scale(' + Math.max(scale, 0.4) + ')';
            scene.style.opacity = Math.max(1 - prog * 0.5, 0.15);

            var pctVal = Math.round(prog * 100);
            pct.textContent = '%' + pctVal;
            fill.style.width = Math.min(prog * 100, 100) + '%';
            progress.classList.add('visible');

            if (prog > 0.12) {
                label.classList.add('hidden');
            } else {
                label.classList.remove('hidden');
            }

            // Envelope opening sequence
            if (prog > 0.18 && !hasOpened) {
                hasOpened = true;
                env.style.transition = 'transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1)';
                env.style.transform = 'rotateY(360deg)';
                setTimeout(function() {
                    env.style.transition = '';
                    env.style.transform = '';
                    env.classList.add('open');
                    spawnParticles();
                    spawnConfetti();
                }, 750);
            }

            // Scroll reveal for sections
            var reveals = document.querySelectorAll('.animate-reveal, .animate-step, .animate-feature');
            reveals.forEach(function(el) {
                var r = el.getBoundingClientRect();
                if (r.top < winH - 60) {
                    el.classList.add('visible');
                }
            });

            // Steps reveal
            var steps = document.querySelectorAll('.step');
            steps.forEach(function(s) {
                var r = s.getBoundingClientRect();
                if (r.top < winH - 40) {
                    s.classList.add('visible');
                }
            });

            // Feature cards reveal
            var cards = document.querySelectorAll('.feature-card');
            cards.forEach(function(c) {
                var r = c.getBoundingClientRect();
                if (r.top < winH - 40) {
                    c.classList.add('visible');
                }
            });
        });

        function spawnParticles() {
            var colors = ['{{ $sp }}', '{{ $ss }}', '#f59e0b', '#ec4899', '#6366f1', '#10b981', '#f97316'];
            for (var i = 0; i < 50; i++) {
                var p = document.createElement('div');
                p.className = 'env-particle';
                p.style.left = (10 + Math.random() * 80) + '%';
                p.style.top = (20 + Math.random() * 60) + '%';
                p.style.background = colors[Math.floor(Math.random() * colors.length)];
                p.style.width = p.style.height = (3 + Math.random() * 8) + 'px';
                p.style.animationDelay = (Math.random() * 2) + 's';
                p.style.animationDuration = (2 + Math.random() * 2.5) + 's';
                particlesEl.appendChild(p);
                setTimeout(function() { p.remove(); }, 5000);
            }
        }

        function spawnConfetti() {
            var container = document.getElementById('confettiContainer');
            var colors = ['{{ $sp }}', '{{ $ss }}', '#f59e0b', '#ec4899', '#6366f1', '#10b981', '#f97316', '#54a0ff', '#5f27cd'];
            var rect = container.getBoundingClientRect();
            var cx = rect.width / 2;
            var cy = rect.height / 2;

            for (var i = 0; i < 50; i++) {
                var c = document.createElement('div');
                c.className = 'confetti';
                c.style.background = colors[Math.floor(Math.random() * colors.length)];
                c.style.width = (5 + Math.random() * 8) + 'px';
                c.style.height = (5 + Math.random() * 8) + 'px';
                c.style.left = (cx + (Math.random() - 0.5) * 120) + 'px';
                c.style.top = (cy + (Math.random() - 0.5) * 100) + 'px';
                var angle = -Math.PI / 2 + (Math.random() - 0.5) * Math.PI * 0.8;
                var dist = 80 + Math.random() * 300;
                c.style.setProperty('--tx', Math.cos(angle) * dist + 'px');
                c.style.setProperty('--ty', Math.sin(angle) * dist + 'px');
                c.style.animationDelay = (Math.random() * 0.6) + 's';
                c.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
                container.appendChild(c);
                requestAnimationFrame(function() { c.classList.add('burst'); });
            }
            setTimeout(function() {
                container.querySelectorAll('.confetti').forEach(function(el) { el.remove(); });
            }, 3500);
        }

    </script>
</body>
</html>
