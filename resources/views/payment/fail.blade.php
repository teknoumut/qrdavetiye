<x-app-layout>
    <style>
        .result-container { max-width: 480px; margin: 60px auto; padding: 0 20px; text-align: center; }
        .result-card { background: #fff; border-radius: 20px; border: 1px solid #eceef2; padding: 48px 32px; box-shadow: 0 4px 24px rgba(0,0,0,0.03); }
        .fail-icon { width: 72px; height: 72px; border-radius: 50%; background: linear-gradient(135deg, #ef4444, #dc2626); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 2rem; color: #fff; box-shadow: 0 8px 24px rgba(239,68,68,0.2); }
        .result-card h2 { font-size: 1.4rem; font-weight: 800; color: #0f1119; margin-bottom: 8px; }
        .result-card p { color: #8893ac; font-size: 0.9rem; line-height: 1.6; margin-bottom: 24px; }
        .btn-retry { display: inline-block; padding: 14px 36px; border-radius: 14px; font-size: 0.95rem; font-weight: 700; text-decoration: none; background: linear-gradient(135deg, #d4a61e, #e05278); color: #fff; transition: all 0.3s; box-shadow: 0 8px 24px rgba(212,166,30,0.25); }
        .btn-retry:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(212,166,30,0.35); }
    </style>
    <div class="result-container">
        <div class="result-card">
            <div class="fail-icon">✕</div>
            <h2>{{ __('Ödeme Başarısız') }}</h2>
            <p>{{ session('error') ?: __('Ödeme işlemi tamamlanamadı. Lütfen tekrar deneyin veya farklı bir ödeme yöntemi kullanın.') }}</p>
            <a href="{{ route('payment.checkout', $plan) }}" class="btn-retry">{{ __('Tekrar Dene') }}</a>
        </div>
    </div>
</x-app-layout>
