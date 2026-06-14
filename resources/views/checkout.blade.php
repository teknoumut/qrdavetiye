<x-app-layout>
    <style>
        .checkout-container { max-width: 640px; margin: 40px auto; padding: 0 20px; }
        .plan-card { background: #fff; border-radius: 20px; border: 1px solid #eceef2; padding: 32px; box-shadow: 0 4px 24px rgba(0,0,0,0.03); }
        .plan-card h2 { font-size: 1.3rem; font-weight: 800; color: #0f1119; margin-bottom: 4px; }
        .plan-card .desc { color: #8893ac; font-size: 0.9rem; margin-bottom: 20px; }
        .price-display { font-size: 2.5rem; font-weight: 900; color: #0f1119; letter-spacing: -0.03em; }
        .price-display .cur { font-size: 1rem; font-weight: 600; color: #8893ac; }
        .interval-toggle { display: flex; gap: 8px; margin: 20px 0; background: #f5f5f7; border-radius: 12px; padding: 4px; }
        .interval-btn { flex: 1; padding: 12px; border: none; border-radius: 10px; font-weight: 600; font-size: 0.85rem; cursor: pointer; background: transparent; color: #8893ac; transition: all 0.25s; }
        .interval-btn.active { background: #fff; color: #0f1119; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .interval-btn:disabled { opacity: 0.5; cursor: not-allowed; }
        .features { list-style: none; padding: 0; margin: 20px 0; }
        .features li { padding: 8px 0; font-size: 0.85rem; color: #464e62; display: flex; align-items: center; gap: 10px; }
        .features li .check { color: #10b981; font-weight: 700; }
        .features li .cross { color: #ef4444; font-weight: 700; }
        .btn-pay { width: 100%; padding: 16px; border: none; border-radius: 14px; font-size: 1rem; font-weight: 700; cursor: pointer; background: linear-gradient(135deg, #d4a61e, #e05278); color: #fff; transition: all 0.3s; box-shadow: 0 8px 24px rgba(212,166,30,0.25); }
        .btn-pay:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(212,166,30,0.35); }
        .btn-pay:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .btn-switch { width: 100%; padding: 16px; border: none; border-radius: 14px; font-size: 1rem; font-weight: 700; cursor: pointer; background: linear-gradient(135deg, #10b981, #059669); color: #fff; transition: all 0.3s; box-shadow: 0 8px 24px rgba(16,185,129,0.25); }
        .btn-switch:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(16,185,129,0.35); }
        .secure-badge { text-align: center; margin-top: 16px; font-size: 0.75rem; color: #b1b8c9; display: flex; align-items: center; justify-content: center; gap: 6px; }
        .saving { color: #8893ac; font-size: 0.85rem; text-align: center; margin-top: 8px; }
        .info-box { border-radius:12px; padding:16px; margin-bottom:16px; font-size:0.85rem; }
    </style>

    <div class="checkout-container">
        <div class="plan-card">
            <h2>{{ $plan->name }} Plan</h2>
            <p class="desc">{{ $plan->description }}</p>

            @if($switchType === 'interval_switch')
                @php
                    $currentInterval = $upgrade['monthly'] ? 'monthly' : 'yearly';
                @endphp
                <div class="info-box" style="background:#eff6ff;border:1px solid #93c5fd;">
                    <strong style="color:#1e40af">🔄 {{ $currentInterval === 'monthly' ? 'Aylıktan Yıllığa Geçiş' : 'Yıllıktan Aylığa Geçiş' }}</strong>
                    <p style="margin:8px 0 0;color:#1e3a5f;">Mevcut planınızın süresi devam ederken farklı bir periyoda geçiş yapabilirsiniz.</p>
                </div>
            @endif

            <div class="interval-toggle">
                <button class="interval-btn active" data-interval="monthly" onclick="setPlanInterval('monthly')" {{ $switchType === 'interval_switch' && !$upgrade['monthly'] ? 'disabled' : '' }}>{{ __('Aylık') }}</button>
                <button class="interval-btn" data-interval="yearly" onclick="setPlanInterval('yearly')" {{ $switchType === 'interval_switch' && !$upgrade['yearly'] ? 'disabled' : '' }}>{{ __('Yıllık') }}</button>
            </div>

            <div id="yearlySaving" class="saving" style="display:none">🎉 {{ __('Yıllık pakette %16 tasarruf edin!') }}</div>

            <div class="price-display">
                <span id="priceDisplay">{{ number_format($plan->monthly_price, 2) }}</span>
                <span class="cur">TL</span>
                <span id="periodDisplay" style="font-size:0.9rem;color:#8893ac;font-weight:400">/ {{ __('ay') }}</span>
            </div>

            <ul class="features">
                <li><span class="check">✓</span> {{ __('Maksimum :count davetiye', ['count' => $plan->max_invitations == -1 ? __('sınırsız') : $plan->max_invitations]) }}</li>
                <li><span class="check">✓</span> {{ __('Davetiye başına :count fotoğraf', ['count' => $plan->max_images_per_invitation == -1 ? __('sınırsız') : $plan->max_images_per_invitation]) }}</li>
                <li><span class="{{ $plan->music_feature ? 'check' : 'cross' }}">{{ $plan->music_feature ? '✓' : '✗' }}</span> {{ __('Müzik desteği') }}</li>
                <li><span class="{{ $plan->video_feature ? 'check' : 'cross' }}">{{ $plan->video_feature ? '✓' : '✗' }}</span> {{ __('Video desteği') }}</li>
                <li><span class="{{ $plan->cover_video_feature ? 'check' : 'cross' }}">{{ $plan->cover_video_feature ? '✓' : '✗' }}</span> {{ __('Kapak videosu') }}</li>
                <li><span class="{{ $plan->rsvp_feature ? 'check' : 'cross' }}">{{ $plan->rsvp_feature ? '✓' : '✗' }}</span> {{ __('RSVP katılım takibi') }}</li>
                <li><span class="{{ $plan->qr_download ? 'check' : 'cross' }}">{{ $plan->qr_download ? '✓' : '✗' }}</span> {{ __('QR kod indirme') }}</li>
            </ul>

            @if($switchType === 'upgrade')
            <div class="info-box" style="background:#fefce8;border:1px solid #fde68a;">
                <strong style="color:#92400e">📈 {{ $plan->name }} Paketine Yükseltme</strong>
                <div style="margin-top:8px;color:#78350f;">
                    <div style="display:flex;justify-content:space-between;padding:4px 0;"><span>Kalan gün:</span> <strong>{{ $upgrade['monthly']['remaining_days'] ?? $upgrade['yearly']['remaining_days'] }} gün</strong></div>
                    <div style="display:flex;justify-content:space-between;padding:4px 0;"><span>Kalan değer:</span> <strong id="upgradeRemainingValue">{{ number_format($upgrade['monthly']['remaining_value'] ?? 0, 2) }} TL</strong></div>
                    <div style="display:flex;justify-content:space-between;padding:4px 0;"><span>Yeni plan fiyatı (kalan gün):</span> <strong id="upgradeProratedPrice">{{ number_format($upgrade['monthly']['prorated_new_price'] ?? 0, 2) }} TL</strong></div>
                    <div style="border-top:1px dashed #fde68a;margin:6px 0;padding:6px 0;display:flex;justify-content:space-between;font-size:1rem;">
                        <span style="font-weight:700;">Ödenecek fark:</span>
                        <strong style="color:#dc2626;font-size:1.2rem;" id="upgradePrice">{{ number_format($upgrade['monthly']['difference'] ?? 0, 2) }} TL</strong>
                    </div>
                </div>
            </div>

            <div class="info-box" style="background:#f0fdf4;border:1px solid #86efac;">
                <strong style="color:#166534">🏦 Havale/EFT ile Ödeme</strong>
                <p style="margin:8px 0 0;color:#14532d;">Yükseltme işleminiz için banka havalesi ile ödeme yapacaksınız. Ödeme bildiriminiz admin tarafından onaylandığında paketiniz yükseltilecektir.</p>
            </div>

            <form id="paymentForm" method="POST" action="{{ route('payment.eft.upgrade', $plan) }}">
                @csrf
                <input type="hidden" name="difference" id="differenceInput" value="{{ $upgrade['monthly']['difference'] ?? 0 }}">
                <input type="hidden" name="interval" id="intervalInput" value="monthly">
                <button type="submit" class="btn-pay" id="payBtn">
                    <span class="label">Farkı Öde ve Yükselt</span>
                    <span class="spinner" style="display:none;width:18px;height:18px;border:2.5px solid rgba(255,255,255,0.3);border-top-color:#fff;border-radius:50%;animation:spin 0.7s linear infinite;"></span>
                </button>
            </form>

            @elseif($switchType === 'downgrade')
            <div class="info-box" style="background:#fefce8;border:1px solid #fde68a;">
                <strong style="color:#92400e">📉 {{ $plan->name }} Paketine Geçiş</strong>
                <div style="margin-top:8px;color:#78350f;">
                    <div style="display:flex;justify-content:space-between;padding:4px 0;"><span>Kalan gün:</span> <strong>{{ $upgrade['monthly']['remaining_days'] }} gün</strong></div>
                </div>
            </div>

            <div class="info-box" style="background:#f0fdf4;border:1px solid #86efac;">
                <strong style="color:#166534">✅ Ücretsiz Geçiş</strong>
                <p style="margin:8px 0 0;color:#14532d;">Daha düşük fiyatlı bir pakete geçiş yapıyorsunuz. Herhangi bir ödeme yapmanıza gerek yoktur. Mevcut abonelik süreniz aynen devam edecektir.</p>
            </div>

            <form method="POST" action="{{ route('payment.switch', $plan) }}">
                @csrf
                <button type="submit" class="btn-switch">
                    Planı Değiştir
                </button>
            </form>

            @elseif($switchType === 'interval_switch' && ($upgrade['monthly'] || $upgrade['yearly']))
                @php
                    $targetInterval = $upgrade['monthly'] ? 'monthly' : 'yearly';
                    $targetData = $upgrade[$targetInterval];
                @endphp
            <div class="info-box" style="background:#fefce8;border:1px solid #fde68a;">
                <strong style="color:#92400e">🔄 Periyot Değişikliği</strong>
                <div style="margin-top:8px;color:#78350f;">
                    <div style="display:flex;justify-content:space-between;padding:4px 0;"><span>Kalan gün:</span> <strong id="switchRemainingDays">{{ $targetData['remaining_days'] }} gün</strong></div>
                    @if($targetData['difference'] > 0)
                    <div style="display:flex;justify-content:space-between;padding:4px 0;"><span>Ödenecek tutar:</span> <strong style="color:#dc2626;font-size:1.2rem;" id="switchPrice">{{ number_format($targetData['difference'], 2) }} TL</strong></div>
                    @else
                    <div style="display:flex;justify-content:space-between;padding:4px 0;"><span>Ödenecek tutar:</span> <strong style="color:#059669;font-size:1.2rem;" id="switchPrice">0 TL (ücretsiz)</strong></div>
                    @endif
                </div>
            </div>

            @if($targetData['difference'] > 0)
            <form id="paymentForm" method="POST" action="{{ route('payment.eft.upgrade', $plan) }}">
                @csrf
                <input type="hidden" name="difference" id="differenceInput" value="{{ $targetData['difference'] }}">
                <input type="hidden" name="interval" id="intervalInput" value="{{ $targetInterval }}">
                <button type="submit" class="btn-pay" id="payBtn">
                    <span class="label">Öde ve Geçiş Yap</span>
                    <span class="spinner" style="display:none;width:18px;height:18px;border:2.5px solid rgba(255,255,255,0.3);border-top-color:#fff;border-radius:50%;animation:spin 0.7s linear infinite;"></span>
                </button>
            </form>
            @else
            <form id="paymentForm" method="POST" action="{{ route('payment.switch', $plan) }}">
                @csrf
                <button type="submit" class="btn-switch">
                    Periyodu Değiştir
                </button>
            </form>
            @endif

            @else
            <form id="paymentForm" method="GET" action="{{ route('payment.eft.pay', [$plan, 'monthly']) }}">
                <button type="submit" class="btn-pay" id="payBtn">
                    <span class="label">Ödemeyi Tamamla</span>
                    <span class="spinner" style="display:none;width:18px;height:18px;border:2.5px solid rgba(255,255,255,0.3);border-top-color:#fff;border-radius:50%;animation:spin 0.7s linear infinite;"></span>
                </button>
            </form>
            @endif
            <div class="secure-badge">🔒 Güvenli ödeme</div>
        </div>
    </div>

    @push('styles')
    <style>
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
    @endpush

    <script>
        var monthlyPrice = @json($plan->monthly_price);
        var yearlyPrice = @json($plan->yearly_price);
        var switchType = @json($switchType);
        var upgradeMonthly = @json(isset($upgrade['monthly']) ? $upgrade['monthly'] : null);
        var upgradeYearly = @json(isset($upgrade['yearly']) ? $upgrade['yearly'] : null);
        var payUrl = @json(route('payment.eft.pay', [$plan, '__INTERVAL__']));
        var upgradeUrl = @json(route('payment.eft.upgrade', $plan));
        var switchUrl = @json(route('payment.switch', $plan));

        function setPlanInterval(type) {
            document.querySelectorAll('.interval-btn').forEach(function(b) {
                b.classList.toggle('active', b.dataset.interval === type);
            });

            var form = document.getElementById('paymentForm');
            if (!form) return;

            var intervalInput = document.getElementById('intervalInput');
            if (intervalInput) intervalInput.value = type;

            if (switchType === 'upgrade' || switchType === 'interval_switch') {
                var data = type === 'yearly' ? upgradeYearly : upgradeMonthly;
                if (data && data.difference !== undefined) {
                    var priceEl = document.getElementById('upgradePrice') || document.getElementById('switchPrice');
                    if (priceEl) priceEl.textContent = Number(data.difference).toFixed(2) + ' TL';
                    var remValEl = document.getElementById('upgradeRemainingValue');
                    if (remValEl && data.remaining_value !== undefined) remValEl.textContent = Number(data.remaining_value).toFixed(2) + ' TL';
                    var proratedEl = document.getElementById('upgradeProratedPrice');
                    if (proratedEl && data.prorated_new_price !== undefined) proratedEl.textContent = Number(data.prorated_new_price).toFixed(2) + ' TL';
                    var diffInput = document.getElementById('differenceInput');
                    if (diffInput) diffInput.value = data.difference;
                }
                form.action = upgradeUrl;
            } else if (switchType === 'downgrade') {
                form.action = switchUrl;
            } else {
                form.action = payUrl.replace('__INTERVAL__', type);
            }

            var price = type === 'yearly' ? yearlyPrice : monthlyPrice;
            var priceDisplay = document.getElementById('priceDisplay');
            if (priceDisplay) priceDisplay.textContent = Number(price).toFixed(2);
            var periodDisplay = document.getElementById('periodDisplay');
            if (periodDisplay) periodDisplay.textContent = type === 'yearly' ? '/ yıl' : '/ ay';
            var savingEl = document.getElementById('yearlySaving');
            if (savingEl) savingEl.style.display = type === 'yearly' ? 'block' : 'none';
        }

        var form = document.getElementById('paymentForm');
        if (form) {
            form.addEventListener('submit', function() {
                var btn = document.getElementById('payBtn');
                if (!btn) return;
                btn.disabled = true;
                var label = btn.querySelector('.label');
                if (label) label.textContent = 'Yönlendiriliyor...';
                var spinner = btn.querySelector('.spinner');
                if (spinner) spinner.style.display = 'inline-block';
            });
        }

        setPlanInterval('monthly');
    </script>
</x-app-layout>