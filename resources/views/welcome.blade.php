<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-seo title="Dijital Davetiye Platformu - senin 💝 davetiyen" description="Özel günleriniz için modern ve şık QR kodlu dijital davetiyeler. Müzik, video, fotoğraf galerisi ve RSVP takibi ile sevdiklerinizi büyüleyin." />
    <meta name="keywords" content="dijital davetiye, online davetiye, QR kod davetiye, düğün davetiyesi, nişan davetiyesi, sünnet davetiyesi, doğum günü davetiyesi">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900|playfair-display:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
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
        $prgb = "$pr, $pg, $pb"; $srgb = "$sr, $sg, $sb"; $sdrgb = "$sdr, $sdg, $sdb";
    @endphp
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --site-primary: {{ $sp }};
            --site-primary-dark: {{ $spd }};
            --site-secondary: {{ $ss }};
            --site-secondary-dark: {{ $ssd }};
            --site-primary-rgb: {{ $prgb }};
            --site-secondary-rgb: {{ $srgb }};
            --site-primary-dark-rgb: {{ $sdrgb }};
            --env-pattern: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='{{ $spe }}' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
    @vite(['resources/css/welcome.css', 'resources/js/welcome.js'])
</head>
<body data-site-primary="{{ $sp }}" data-site-secondary="{{ $ss }}">
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-4 md:px-7 py-3 bg-white/75 backdrop-blur-2xl border-b border-black/[0.04] transition-all duration-300">
        <a href="/" class="flex items-center gap-2 font-extrabold text-base text-night-900 no-underline shrink-0">
            <img src="{{ asset('images/logo.svg') }}" alt="senin 💝 davetiyen" class="w-14 h-14 object-contain">
            senin 💝 davetiyen
        </a>

        <div class="hidden md:flex items-center gap-1">
            <a href="#how" class="px-3 py-2 text-sm font-medium text-night-500 no-underline rounded-lg transition-all hover:bg-black/5 hover:text-gold-500">{{ __('Nasıl Çalışır?') }}</a>
            <a href="#features" class="px-3 py-2 text-sm font-medium text-night-500 no-underline rounded-lg transition-all hover:bg-black/5 hover:text-gold-500">{{ __('Özellikler') }}</a>
            <a href="#events" class="px-3 py-2 text-sm font-medium text-night-500 no-underline rounded-lg transition-all hover:bg-black/5 hover:text-gold-500">{{ __('Etkinlikler') }}</a>
            <a href="#pricing" class="px-3 py-2 text-sm font-medium text-night-500 no-underline rounded-lg transition-all hover:bg-black/5 hover:text-gold-500">{{ __('Fiyatlandırma') }}</a>
            <a href="#faq" class="px-3 py-2 text-sm font-medium text-night-500 no-underline rounded-lg transition-all hover:bg-black/5 hover:text-gold-500">{{ __('SSS') }}</a>
            <a href="#contact" class="px-3 py-2 text-sm font-medium text-night-500 no-underline rounded-lg transition-all hover:bg-black/5 hover:text-gold-500">{{ __('İletişim') }}</a>

            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="ml-2 px-5 py-2 text-sm font-semibold no-underline rounded-lg text-white transition-all hover:opacity-90" style="background:linear-gradient(135deg,var(--site-primary),var(--site-secondary))">{{ __('Panel') }}</a>
                @else
                    <a href="{{ route('login') }}" class="ml-2 px-5 py-2 text-sm font-semibold no-underline rounded-lg text-white transition-all hover:opacity-90" style="background:linear-gradient(135deg,var(--site-primary),var(--site-secondary))">{{ __('Giriş Yap') }}</a>
                @endauth
            @endif
        </div>

        <button id="hamburgerBtn" class="md:hidden flex flex-col gap-1 bg-transparent border-none cursor-pointer relative z-50 p-2 rounded-md" aria-label="Menü">
            <span class="block w-5 h-0.5 bg-night-900 rounded-sm transition-all duration-300"></span>
            <span class="block w-5 h-0.5 bg-night-900 rounded-sm transition-all duration-300"></span>
            <span class="block w-5 h-0.5 bg-night-900 rounded-sm transition-all duration-300"></span>
        </button>
    </nav>

    <div id="mobileMenu" class="mobile-menu fixed left-0 right-0 z-40 bg-white/95 backdrop-blur-xl border-b border-black/[0.04] shadow-lg px-4 py-4 flex flex-col gap-1" style="top:0; padding-top:70px;">
        <a href="#how" class="block py-3 px-4 rounded-lg text-base font-medium text-night-500 no-underline transition-colors hover:text-gold-600 hover:bg-gold-50">{{ __('Nasıl Çalışır?') }}</a>
        <a href="#features" class="block py-3 px-4 rounded-lg text-base font-medium text-night-500 no-underline transition-colors hover:text-gold-600 hover:bg-gold-50">{{ __('Özellikler') }}</a>
        <a href="#events" class="block py-3 px-4 rounded-lg text-base font-medium text-night-500 no-underline transition-colors hover:text-gold-600 hover:bg-gold-50">{{ __('Etkinlikler') }}</a>
        <a href="#pricing" class="block py-3 px-4 rounded-lg text-base font-medium text-night-500 no-underline transition-colors hover:text-gold-600 hover:bg-gold-50">{{ __('Fiyatlandırma') }}</a>
        <a href="#faq" class="block py-3 px-4 rounded-lg text-base font-medium text-night-500 no-underline transition-colors hover:text-gold-600 hover:bg-gold-50">{{ __('SSS') }}</a>
        <a href="#contact" class="block py-3 px-4 rounded-lg text-base font-medium text-night-500 no-underline transition-colors hover:text-gold-600 hover:bg-gold-50">{{ __('İletişim') }}</a>

        @if (Route::has('login'))
            @auth
                <a href="{{ route('dashboard') }}" class="block mt-2 py-3 px-4 rounded-lg text-base font-bold no-underline text-white text-center transition-all hover:opacity-90" style="background:linear-gradient(135deg,var(--site-primary),var(--site-secondary))">{{ __('Panel') }}</a>
            @else
                <a href="{{ route('login') }}" class="block mt-2 py-3 px-4 rounded-lg text-base font-bold no-underline text-white text-center transition-all hover:opacity-90" style="background:linear-gradient(135deg,var(--site-primary),var(--site-secondary))">{{ __('Giriş Yap') }}</a>
            @endauth
        @endif
    </div>



    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-floating" id="heroOrbs">
            <div class="orb" style="width:300px;height:300px;top:10%;left:5%;background:var(--site-primary);animation-delay:0s;"></div>
            <div class="orb" style="width:250px;height:250px;bottom:15%;right:10%;background:var(--site-secondary);animation-delay:-3s;"></div>
            <div class="orb" style="width:200px;height:200px;top:40%;left:60%;background:#6366f1;animation-delay:-5s;"></div>
        </div>
        <div class="hero-badge"><span class="dot"></span> {{ __('Yeni Nesil Davetiye') }}</div>
        <h1>{{ __('Özel Günlerin İçin') }}<br><span class="highlight">{{ __('Dijital Davetiye') }}</span></h1>
        <p>{{ __('QR kodlu, müzikli, fotoğraflı modern davetiyelerle sevdiklerini büyüle. Paylaşması kolay, etkisi büyük.') }}</p>
        <div class="btns">
            <a href="#contact" class="primary">{{ __('Şimdi Başla') }}</a>
            <a href="#how" class="secondary">{{ __('Nasıl Çalışır?') }}</a>
        </div>
        <div class="hero-scroll" id="heroScroll" onclick="document.getElementById('envSection').scrollIntoView({behavior:'smooth'})">
            <div class="mouse"></div>
            <span>{{ __('Kaydır') }}</span>
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

    <div class="env-sticky" id="envSticky" style="background:linear-gradient(180deg,#faf9f7 0%,#fff 30%,#fdf8ed 70%,#faf9f7 100%);overflow-x:hidden;">
        <div class="env-particles" id="particles"></div>
        <div class="burst-confetti" id="confettiContainer"></div>
        <div class="env-scene" id="envScene">
            <div class="env-label" id="envLabel">
                <span class="arrow">↓</span> {{ __('Zarfı Açmak İçin Kaydır') }} <span class="arrow">↓</span>
            </div>
            <div class="env-3d" id="env3d">
                <div class="card-body"><div class="gold-shimmer"></div></div>
                <div class="crease"></div>
                <div class="card-flap"><div class="gold-shimmer"></div></div>
                <div class="flap-inner"></div>
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
            <div class="section-title animate-reveal">{{ __('Nasıl Çalışır?') }}</div>
            <div class="section-sub animate-reveal">{{ __('Birkaç adımda davetiyeni oluştur, QR kodla paylaşmaya başla') }}</div>
            <div class="steps">
                <div class="step animate-step">
                    <div class="num">1</div>
                    <h3>{{ __('Bize Ulaş') }}</h3>
                    <p>{{ __('Formdan mesaj gönder, sana özel hesabını oluşturalım') }}</p>
                    <div class="step-bg"><i class="fas fa-phone"></i></div>
                </div>
                <div class="step animate-step" style="transition-delay:0.1s">
                    <div class="num">2</div>
                    <h3>{{ __('Davetiyeni Tasarla') }}</h3>
                    <p>{{ __('Renk, fotoğraf, müzik ve yazılarınla kişiselleştir') }}</p>
                    <div class="step-bg"><i class="fas fa-palette"></i></div>
                </div>
                <div class="step animate-step" style="transition-delay:0.2s">
                    <div class="num">3</div>
                    <h3>{{ __('QR Kodla Paylaş') }}</h3>
                    <p>{{ __('WhatsApp, Instagram veya SMS ile davetlilere ulaştır') }}</p>
                    <div class="step-bg"><i class="fas fa-mobile-alt"></i></div>
                </div>
                <div class="step animate-step" style="transition-delay:0.3s">
                    <div class="num">4</div>
                    <h3>{{ __('Takip Et') }}</h3>
                    <p>{{ __('Kim katılıyor, kim katılmıyor panelden canlı izle') }}</p>
                    <div class="step-bg"><i class="fas fa-chart-bar"></i></div>
                </div>
            </div>
        </div>

        <div class="features-section" id="features">
            <div class="section-title animate-reveal">{{ __('Tüm Özellikler') }}</div>
            <div class="section-sub animate-reveal">{{ __('İhtiyacın olan her şey bu platformda') }}</div>
            <div class="features-grid">
                <div class="feature-card animate-feature"><div class="ficon" style="background:#eff6ff"><i class="fas fa-qrcode" style="color:#3b82f6"></i></div><div class="ftext"><h4>{{ __('QR Kod') }}</h4><p>{{ __('Her davetiye için otomatik QR kod, PNG/SVG indir') }}</p></div></div>
                <div class="feature-card animate-feature" style="transition-delay:0.05s"><div class="ficon" style="background:#fef2f2"><i class="fas fa-music" style="color:#ef4444"></i></div><div class="ftext"><h4>{{ __('Müzik Desteği') }}</h4><p>{{ __('YouTube embed ya da MP3 ile arka plan müziği') }}</p></div></div>
                <div class="feature-card animate-feature" style="transition-delay:0.1s"><div class="ficon" style="background:#f5f3ff"><i class="fas fa-images" style="color:#8b5cf6"></i></div><div class="ftext"><h4>{{ __('Fotoğraf Galerisi') }}</h4><p>{{ __('Özel anılarını galeri şeklinde paylaş') }}</p></div></div>
                <div class="feature-card animate-feature" style="transition-delay:0.15s"><div class="ficon" style="background:#fdf2f8"><i class="fas fa-palette" style="color:#ec4899"></i></div><div class="ftext"><h4>{{ __('Tema & Renk') }}</h4><p>{{ __('Tamamen özelleştirilebilir tasarım') }}</p></div></div>
                <div class="feature-card animate-feature" style="transition-delay:0.2s"><div class="ficon" style="background:#fefce8"><i class="fas fa-clock" style="color:#eab308"></i></div><div class="ftext"><h4>{{ __('Geri Sayım') }}</h4><p>{{ __('Etkinlik tarihine otomatik sayaç') }}</p></div></div>
                <div class="feature-card animate-feature" style="transition-delay:0.25s"><div class="ficon" style="background:#f3f4f6"><i class="fas fa-map-marker-alt" style="color:#111827"></i></div><div class="ftext"><h4>{{ __('Konum') }}</h4><p>{{ __('Harita entegrasyonu ile adres göster') }}</p></div></div>
                <div class="feature-card animate-feature" style="transition-delay:0.3s"><div class="ficon" style="background:#eff6ff"><i class="fas fa-comment-dots" style="color:#3b82f6"></i></div><div class="ftext"><h4>{{ __('RSVP Sistemi') }}</h4><p>{{ __('Katılım takibi, anlık bildirim') }}</p></div></div>
                <div class="feature-card animate-feature" style="transition-delay:0.35s"><div class="ficon" style="background:#fef2f2"><i class="fas fa-video" style="color:#ef4444"></i></div><div class="ftext"><h4>{{ __('Video Desteği') }}</h4><p>{{ __('YouTube videoları ile zenginleştir') }}</p></div></div>
            </div>
        </div>

        <div class="events-section" id="events">
            <div class="section-title animate-reveal">{{ __('Etkinlik Türleri') }}</div>
            <div class="section-sub animate-reveal">{{ __('Her özel gün için özel tasarım') }}</div>
            <div class="events-grid">
                <div class="event-card animate-feature" style="--card-accent:#e05278">
                    <div class="event-icon">💍</div>
                    <h3>{{ __('Düğün') }}</h3>
                    <p>{{ __('Aşk dolu bir düğün davetiyesi ile en mutlu gününü sevdiklerinle paylaş') }}</p>
                </div>
                <div class="event-card animate-feature" style="--card-accent:#8b5cf6;transition-delay:0.05s">
                    <div class="event-icon">💍</div>
                    <h3>{{ __('Nişan') }}</h3>
                    <p>{{ __('Mutluluğa ilk adımı atan çiftler için şık ve romantik nişan davetiyesi') }}</p>
                </div>
                <div class="event-card animate-feature" style="--card-accent:#00b894;transition-delay:0.1s">
                    <div class="event-icon">✂️</div>
                    <h3>{{ __('Sünnet') }}</h3>
                    <p>{{ __('Bu özel günde çocuğun için unutulmaz bir sünnet davetiyesi hazırla') }}</p>
                </div>
                <div class="event-card animate-feature" style="--card-accent:#e84393;transition-delay:0.15s">
                    <div class="event-icon">🎂</div>
                    <h3>{{ __('Doğum Günü') }}</h3>
                    <p>{{ __('Renkli ve eğlenceli doğum günü davetiyesi ile kutlamaya herkesi çağır') }}</p>
                </div>
                <div class="event-card animate-feature" style="--card-accent:#3b82f6;transition-delay:0.2s">
                    <div class="event-icon">🏢</div>
                    <h3>{{ __('Kurumsal') }}</h3>
                    <p>{{ __('Kurumsal etkinlik, açılış ve organizasyonların için profesyonel davetiye') }}</p>
                </div>
                <div class="event-card animate-feature" style="--card-accent:#6c5ce7;transition-delay:0.25s">
                    <div class="event-icon">🎓</div>
                    <h3>{{ __('Mezuniyet') }}</h3>
                    <p>{{ __('Mezuniyet sevincini ailene ve arkadaşlarına özel bir davetiye ile duyur') }}</p>
                </div>
            </div>
        </div>

        @php $plans = \App\Models\Plan::active()->get(); @endphp
        @if ($plans->count())
        <div class="pricing-section" id="pricing">
            <div class="section-title animate-reveal">{{ __('Plan ve Fiyatlandırma') }}</div>
            <div class="section-sub animate-reveal">{{ __('İhtiyacına uygun planı seç, hemen başla') }}</div>

            <div class="pricing-toggle">
                <span class="active" id="toggleMonthlyLabel">{{ __('Aylık') }}</span>
                <div class="toggle-switch" id="pricingToggle" onclick="togglePricing()"></div>
                <span id="toggleYearlyLabel">{{ __('Yıllık') }}</span>
            </div>

            <div class="pricing-grid">
                @foreach ($plans as $plan)
                <div class="pricing-card animate-feature {{ $plan->name === 'Standart' ? 'featured' : '' }}">
                    @if ($plan->name === 'Standart')<div class="badge">{{ __('Popüler') }}</div>@endif
                    <h3>{{ $plan->name }}</h3>
                    <p class="desc">{{ $plan->description }}</p>
                    <div class="p-price"><span class="monthly-price">{{ formatCurrency($plan->monthly_price) }}</span><span class="yearly-price" style="display:none">{{ formatCurrency($plan->yearly_price) }}</span></div>
                    <div class="p-period"><span class="monthly-period">/ {{ __('ay') }}</span><span class="yearly-period" style="display:none">/ {{ __('yıl') }}</span></div>
                    <ul class="p-features">
                        <li><span class="check">✓</span> {{ $plan->max_invitations == -1 ? __('Sınırsız davetiye') : __('En fazla :count davetiye', ['count' => $plan->max_invitations]) }}</li>
                        <li><span class="check">✓</span> {{ __('Davetiye başına') }} {{ $plan->max_images_per_invitation == -1 ? __('sınırsız') : $plan->max_images_per_invitation }} {{ __('fotoğraf') }}</li>
                        <li><span class="{{ $plan->music_feature ? 'check' : 'cross' }}">{{ $plan->music_feature ? '✓' : '✗' }}</span> {{ __('Müzik desteği') }}</li>
                        <li><span class="{{ $plan->video_feature ? 'check' : 'cross' }}">{{ $plan->video_feature ? '✓' : '✗' }}</span> {{ __('Video desteği') }}</li>
                        <li><span class="{{ $plan->cover_video_feature ? 'check' : 'cross' }}">{{ $plan->cover_video_feature ? '✓' : '✗' }}</span> {{ __('Kapak videosu') }}</li>
                        <li><span class="{{ $plan->rsvp_feature ? 'check' : 'cross' }}">{{ $plan->rsvp_feature ? '✓' : '✗' }}</span> {{ __('RSVP katılım takibi') }}</li>
                        <li><span class="{{ $plan->qr_download ? 'check' : 'cross' }}">{{ $plan->qr_download ? '✓' : '✗' }}</span> {{ __('QR kod indirme') }}</li>
                    </ul>
                    @auth
                        <a href="{{ route('payment.eft.checkout', $plan) }}" class="p-btn {{ $plan->monthly_price == 0 ? 'p-btn-outline' : '' }}">{{ __('Satın Al') }}</a>
                    @else
                        <a href="{{ route('register', ['purchase' => 1]) }}" class="p-btn p-btn-outline">{{ __('Satın Al') }}</a>
                    @endauth
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if ($reviews->count())
        <div class="reviews-section" id="reviews">
            <div class="section-title animate-reveal">{{ __('Kullanıcı Yorumları') }}</div>
            <div class="section-sub animate-reveal">{{ __('senin 💝 davetiyen kullanıcılarının deneyimleri') }}</div>
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
            <div class="section-title animate-reveal">{{ __('Sık Sorulan Sorular') }}</div>
            <div class="section-sub animate-reveal">{{ __('Merak ettiğin her şeyin cevabı burada') }}</div>

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
                    <div class="faq-a">EFT/Havale ile ödeme yapabilirsiniz. Ödeme bildiriminiz onaylandıktan sonra aboneliğiniz aktifleşir.</div>
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



        <div class="contact-section" id="contact">
            <div class="section-title animate-reveal">{{ __('Bize Ulaşın') }}</div>
            <div class="section-sub animate-reveal">{{ __('Formu doldurun, size özel davetiyenizi birlikte oluşturalım') }}</div>
            <div class="contact-wrap">
                <div class="contact-form" id="contactFormCard">
                    <form id="contactForm" action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="form-header">
                            <div class="icon"><i class="fas fa-envelope" style="color:#d4a61e"></i></div>
                            <h3>{{ __('Mesaj Gönder') }}</h3>
                            <p>{{ __('Size nasıl yardımcı olabiliriz?') }}</p>
                        </div>
                        <div class="field-group">
                            <div class="field">
                                <label>{{ __('Adınız') }}</label>
                                <span class="input-icon"><i class="fas fa-user" style="color:#3b82f6"></i></span>
                                <input type="text" name="name" required placeholder="{{ __('Adınız') }}">
                            </div>
                            <div class="field">
                                <label>{{ __('Telefon') }}</label>
                                <span class="input-icon"><i class="fas fa-phone" style="color:#ef4444"></i></span>
                                <input type="tel" name="phone" placeholder="0555 555 55 55">
                            </div>
                        </div>
                        <div class="field full">
                            <label>{{ __('E-posta') }}</label>
                            <span class="input-icon"><i class="fas fa-envelope" style="color:#8b5cf6"></i></span>
                            <input type="email" name="email" placeholder="ornek@email.com">
                        </div>
                        <div class="field full">
                            <label>{{ __('Mesajınız') }}</label>
                            <span class="input-icon"><i class="fas fa-comment" style="color:#ec4899"></i></span>
                            <textarea name="message" rows="3" required placeholder="{{ __('Size nasıl yardımcı olabiliriz?') }}"></textarea>
                        </div>
                        <button type="submit">
                            <span>{{ __('Mesaj Gönder') }}</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        </button>
                    </form>
                    <div class="success-state" id="contactSuccess">
                        <div class="check">✓</div>
                        <h4>{{ __('Mesajınız başarıyla gönderildi!') }}</h4>
                        <p>{{ __('En kısa sürede size dönüş yapacağız.') }}<br>🎉</p>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="flex flex-col items-center gap-3">
                <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 text-sm">
                    <a href="{{ route('legal.gizlilik') }}" class="text-night-400 hover:text-gold-500 no-underline transition-colors">{{ __('Gizlilik Politikası') }}</a>
                    <a href="{{ route('legal.kvkk') }}" class="text-night-400 hover:text-gold-500 no-underline transition-colors">KVKK</a>
                    <a href="{{ route('legal.kullanim') }}" class="text-night-400 hover:text-gold-500 no-underline transition-colors">{{ __('Kullanım Koşulları') }}</a>
                    <a href="{{ route('legal.iade') }}" class="text-night-400 hover:text-gold-500 no-underline transition-colors">{{ __('İade Politikası') }}</a>
                    <a href="{{ route('legal.mesafeli') }}" class="text-night-400 hover:text-gold-500 no-underline transition-colors">{{ __('Mesafeli Satış') }}</a>
                </div>
                <div>&copy; {{ date('Y') }} senin 💝 davetiyen. {{ __('Tüm hakları saklıdır.') }}</div>
            </div>
        </footer>
    </div>
</body>
</html>
