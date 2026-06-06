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
        .features { list-style: none; padding: 0; margin: 20px 0; }
        .features li { padding: 8px 0; font-size: 0.85rem; color: #464e62; display: flex; align-items: center; gap: 10px; }
        .features li .check { color: #10b981; font-weight: 700; }
        .features li .cross { color: #ef4444; font-weight: 700; }
        .btn-pay { width: 100%; padding: 16px; border: none; border-radius: 14px; font-size: 1rem; font-weight: 700; cursor: pointer; background: linear-gradient(135deg, #d4a61e, #e05278); color: #fff; transition: all 0.3s; box-shadow: 0 8px 24px rgba(212,166,30,0.25); }
        .btn-pay:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(212,166,30,0.35); }
        .btn-pay:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .secure-badge { text-align: center; margin-top: 16px; font-size: 0.75rem; color: #b1b8c9; display: flex; align-items: center; justify-content: center; gap: 6px; }
        .saving { color: #8893ac; font-size: 0.85rem; text-align: center; margin-top: 8px; }
    </style>

    <div class="checkout-container">
        <div class="plan-card">
            <h2>{{ $plan->name }} Plan</h2>
            <p class="desc">{{ $plan->description }}</p>

            <div class="interval-toggle">
                <button class="interval-btn {{ $interval ?? 'active' }}" data-interval="monthly" onclick="setPlanInterval('monthly')">Aylık</button>
                <button class="interval-btn" data-interval="yearly" onclick="setPlanInterval('yearly')">Yıllık</button>
            </div>

            <div id="yearlySaving" class="saving" style="display:none">🎉 Yıllık pakette %16 tasarruf edin!</div>

            <div class="price-display">
                <span id="priceDisplay">{{ number_format($plan->monthly_price, 2) }}</span>
                <span class="cur">TL</span>
                <span id="periodDisplay" style="font-size:0.9rem;color:#8893ac;font-weight:400">/ ay</span>
            </div>

            <ul class="features">
                <li><span class="check">✓</span> Maksimum {{ $plan->max_invitations == -1 ? 'sınırsız' : $plan->max_invitations }} davetiye</li>
                <li><span class="check">✓</span> Davetiye başına {{ $plan->max_images_per_invitation == -1 ? 'sınırsız' : $plan->max_images_per_invitation }} fotoğraf</li>
                <li><span class="{{ $plan->music_feature ? 'check' : 'cross' }}">{{ $plan->music_feature ? '✓' : '✗' }}</span> Müzik desteği</li>
                <li><span class="{{ $plan->video_feature ? 'check' : 'cross' }}">{{ $plan->video_feature ? '✓' : '✗' }}</span> Video desteği</li>
                <li><span class="{{ $plan->rsvp_feature ? 'check' : 'cross' }}">{{ $plan->rsvp_feature ? '✓' : '✗' }}</span> RSVP katılım takibi</li>
                <li><span class="{{ $plan->qr_download ? 'check' : 'cross' }}">{{ $plan->qr_download ? '✓' : '✗' }}</span> QR kod indirme</li>
            </ul>

            <form id="paymentForm" method="GET" action="{{ route('payment.pay', ['plan' => $plan->id, 'interval' => 'monthly']) }}">
                <button type="submit" class="btn-pay" id="payBtn">
                    <span class="label">Iyzico ile Öde</span>
                    <span class="spinner" style="display:none;width:18px;height:18px;border:2.5px solid rgba(255,255,255,0.3);border-top-color:#fff;border-radius:50%;animation:spin 0.7s linear infinite;"></span>
                </button>
            </form>
            <div class="secure-badge">🔒 Iyzico ile güvenli ödeme</div>
            <div style="text-align:center;margin-top:8px;font-size:0.72rem;color:#b1b8c9">Kart bilgileriniz sunucumuza ulaşmaz</div>
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
        var payUrl = @json(route('payment.pay', ['plan' => $plan->id, 'interval' => '__INTERVAL__']));

        function setPlanInterval(type) {
            document.querySelectorAll('.interval-btn').forEach(function(b) {
                b.classList.toggle('active', b.dataset.interval === type);
            });

            document.getElementById('paymentForm').action = payUrl.replace('__INTERVAL__', type);

            var price = type === 'yearly' ? yearlyPrice : monthlyPrice;
            document.getElementById('priceDisplay').textContent = Number(price).toFixed(2);
            document.getElementById('periodDisplay').textContent = type === 'yearly' ? '/ yıl' : '/ ay';
            document.getElementById('yearlySaving').style.display = type === 'yearly' ? 'block' : 'none';
        }

        document.getElementById('paymentForm').addEventListener('submit', function() {
            var btn = document.getElementById('payBtn');
            btn.disabled = true;
            btn.querySelector('.label').textContent = 'Yönlendiriliyor...';
            btn.querySelector('.spinner').style.display = 'inline-block';
        });

        setPlanInterval('monthly');
    </script>
</x-app-layout>
