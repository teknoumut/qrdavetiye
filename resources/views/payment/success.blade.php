<x-app-layout>
    <style>
        .result-container { max-width: 520px; margin: 60px auto; padding: 0 20px; text-align: center; }
        .result-card { background: #fff; border-radius: 20px; border: 1px solid #eceef2; padding: 48px 32px 32px; box-shadow: 0 4px 24px rgba(0,0,0,0.03); }
        .check-icon { width: 72px; height: 72px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 2rem; color: #fff; box-shadow: 0 8px 24px rgba(16,185,129,0.2); }
        .result-card h2 { font-size: 1.4rem; font-weight: 800; color: #0f1119; margin-bottom: 8px; }
        .result-card p { color: #8893ac; font-size: 0.9rem; line-height: 1.6; margin-bottom: 24px; }
        .btn-primary { display: inline-block; padding: 14px 36px; border-radius: 14px; font-size: 0.95rem; font-weight: 700; text-decoration: none; background: linear-gradient(135deg, #d4a61e, #e05278); color: #fff; transition: all 0.3s; box-shadow: 0 8px 24px rgba(212,166,30,0.25); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(212,166,30,0.35); }
        .btn-ghost { display: inline-block; padding: 14px 36px; border-radius: 14px; font-size: 0.9rem; font-weight: 600; text-decoration: none; color: #464e62; border: 1.5px solid #e8eaef; transition: all 0.3s; margin-top: 12px; }
        .btn-ghost:hover { border-color: #d4a61e; color: #d4a61e; }

        .invoice-box { margin-top: 24px; padding: 24px; border: 1px solid #eceef2; border-radius: 14px; text-align: left; background: #fafbfc; }
        .invoice-box .row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 0.85rem; }
        .invoice-box .row .label { color: #8893ac; }
        .invoice-box .row .val { color: #0f1119; font-weight: 600; }
        .invoice-box .divider { height: 1px; background: #eceef2; margin: 10px 0; }
        .invoice-box .total { font-size: 1rem; font-weight: 800; color: #0f1119; }

        @@media print {
            body { background: #fff !important; }
            .btn-primary, .btn-ghost { display: none !important; }
            .result-card { box-shadow: none !important; border: 1px solid #ddd !important; }
            .invoice-box { border: 1px solid #ddd !important; }
        }
    </style>
    <div class="result-container">
        <div class="result-card">
            <div class="check-icon">✓</div>
            <h2>Ödeme Başarılı!</h2>
            <p><strong>{{ $plan->name }}</strong> planına başarıyla kaydoldunuz. Davetiyelerinizi hemen oluşturmaya başlayabilirsiniz.</p>

            @if ($invoice)
            <div class="invoice-box" id="invoice">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
                    <strong style="font-size:1rem;color:#0f1119">FATURA</strong>
                    <span style="font-size:0.75rem;color:#8893ac">#{{ $invoice->invoice_no }}</span>
                </div>
                <div class="row">
                    <span class="label">Plan</span>
                    <span class="val">{{ $plan->name }}</span>
                </div>
                <div class="row">
                    <span class="label">Dönem</span>
                    <span class="val">{{ $invoice->interval === 'yearly' ? 'Yıllık' : 'Aylık' }}</span>
                </div>
                <div class="row">
                    <span class="label">Tarih</span>
                    <span class="val">{{ $invoice->created_at->format('d.m.Y H:i') }}</span>
                </div>
                <div class="divider"></div>
                <div class="row">
                    <span class="label">Müşteri</span>
                    <span class="val">{{ auth()->user()->name }}</span>
                </div>
                <div class="row">
                    <span class="label">E-posta</span>
                    <span class="val">{{ auth()->user()->email }}</span>
                </div>
                <div class="divider"></div>
                <div class="row total">
                    <span>Tutar</span>
                    <span>{{ number_format($invoice->amount, 2) }} TL</span>
                </div>
                <div class="row">
                    <span class="label">KDV (20%)</span>
                    <span class="val">{{ number_format($invoice->amount * 0.20, 2) }} TL</span>
                </div>
                <div class="row">
                    <span class="label">KDV Dahil</span>
                    <span class="val" style="font-size:1.1rem;font-weight:900">{{ number_format($invoice->amount * 1.20, 2) }} TL</span>
                </div>
            </div>
            @endif

            <a href="{{ route('dashboard') }}" class="btn-primary">Paneli Aç</a>
            <br>
            <a href="#" onclick="window.print();return false" class="btn-ghost">🖨 Faturayı Yazdır</a>
        </div>
    </div>
</x-app-layout>