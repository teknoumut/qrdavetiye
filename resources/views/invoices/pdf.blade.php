<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fatura {{ $invoice->invoice_no }}</title>
    <style>
        @page { margin: 30px 40px; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; line-height: 1.5; margin: 0; padding: 0; }
        .header-table { width: 100%; margin-bottom: 30px; }
        .header-table td { vertical-align: middle; }
        .header-left { width: 50%; }
        .header-right { width: 50%; text-align: right; }
        .header-right h1 { font-size: 22px; font-weight: 900; color: #0f172a; margin: 0 0 4px; letter-spacing: -0.02em; }
        .header-right .meta { font-size: 10px; color: #64748b; }
        .header-right .meta strong { color: #0f172a; }
        .logo-box { display: inline-block; }
        .logo-box img { width: 60px; height: 60px; vertical-align: middle; }
        .brand-text { display: inline-block; vertical-align: middle; margin-left: 10px; font-size: 20px; font-family: 'Dancing Script', 'DejaVu Sans', cursive; font-weight: 700; }
        .brand-text .t { color: #06b6d4; }
        .brand-text .p { color: #ec4899; }
        hr { border: none; border-top: 2px solid #06b6d4; margin: 0 0 25px; }
        .company-box, .client-box { width: 48%; vertical-align: top; }
        .company-box h3, .client-box h3 { font-size: 9px; text-transform: uppercase; letter-spacing: 1px; color: #64748b; margin: 0 0 8px; }
        .company-box p, .client-box p { margin: 2px 0; font-size: 11px; color: #1e293b; }
        .company-box .label { color: #64748b; font-size: 10px; }
        .details { width: 100%; border-collapse: collapse; margin: 25px 0; border-radius: 8px; overflow: hidden; }
        .details thead { background: linear-gradient(135deg, #06b6d4, #0891b2); }
        .details th { padding: 10px 14px; text-align: left; font-size: 9px; text-transform: uppercase; letter-spacing: 1px; color: #fff; font-weight: 700; }
        .details th:last-child { text-align: right; }
        .details td { padding: 10px 14px; border-bottom: 1px solid #e2e8f0; font-size: 11px; color: #334155; }
        .details td:last-child { text-align: right; font-weight: 700; }
        .details tbody tr:last-child td { border-bottom: none; }
        .details tbody tr:nth-child(even) { background: #f8fafc; }
        .totals { margin-left: auto; width: 280px; }
        .totals table { width: 100%; }
        .totals td { padding: 5px 0; font-size: 12px; }
        .totals .label { color: #64748b; }
        .totals .value { text-align: right; font-weight: 600; }
        .totals .sep td { border-top: 1px solid #e2e8f0; }
        .grand-total td { font-size: 16px; font-weight: 900; color: #0f172a; padding-top: 8px; border-top: 2px solid #0f172a; }
        .grand-total .value { color: #06b6d4; }
        .footer { text-align: center; color: #94a3b8; font-size: 9px; margin-top: 35px; padding-top: 15px; border-top: 1px solid #e2e8f0; }
        .footer p { margin: 2px 0; }
        .badge { display: inline-block; padding: 2px 10px; border-radius: 12px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-paid { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="header-left">
                <div class="logo-box">
                    <img src="data:image/svg+xml;base64,{{ $logoBase64 }}" alt="Logo">
                </div>
                <div class="brand-text">
                    <span class="t">Senin</span> <span class="p">Davetiyen</span>
                </div>
            </td>
            <td class="header-right">
                <h1>FATURA</h1>
                <div class="meta"><strong>Fatura No:</strong> {{ $invoice->invoice_no }}</div>
                <div class="meta"><strong>Düzenlenme:</strong> {{ $invoice->created_at->format('d/m/Y') }}</div>
                <div class="meta" style="margin-top:4px;">
                    <span class="badge badge-paid">{{ ucfirst($invoice->status) }}</span>
                    @if($invoice->is_upgrade)<span style="display:inline-block;padding:2px 8px;border-radius:10px;font-size:8px;font-weight:700;background:#fef3c7;color:#92400e;margin-left:4px;">YÜKSELTME</span>@endif
                </div>
            </td>
        </tr>
    </table>

    <hr>

    <table style="width:100%;margin-bottom:25px;">
        <tr>
            <td class="company-box">
                <h3>Fatura Eden</h3>
                <p style="font-weight:700;font-size:13px;"><span style="color:#06b6d4">Senin</span> <span style="color:#ec4899">Davetiyen</span></p>
                <p>info@senindavetiyen.com.tr</p>
                <p>www.senindavetiyen.com.tr</p>
            </td>
            <td class="client-box">
                <h3>Müşteri</h3>
                <p style="font-weight:700;font-size:13px;">{{ $invoice->user->name }}</p>
                <p>{{ $invoice->user->email }}</p>
            </td>
        </tr>
    </table>

    <table class="details">
        <thead>
            <tr>
                <th style="width:50%;">Açıklama</th>
                <th>Dönem</th>
                <th>Durum</th>
                <th style="text-align:right;">Tutar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->plan->name ?? 'Plan' }} @if($invoice->is_upgrade)<br><span style="font-size:9px;color:#92400e;font-weight:600;">↑ Paket yükseltme</span>@endif</td>
                <td>{{ $invoice->interval === 'yearly' ? 'Yıllık' : 'Aylık' }}</td>
                <td>{{ ucfirst($invoice->status) }}</td>
                <td>{{ formatCurrency($invoice->amount) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td class="label">Ara Toplam</td>
                <td class="value">{{ formatCurrency($invoice->amount) }}</td>
            </tr>
            @if($invoice->tax_rate > 0)
            <tr>
                <td class="label">KDV ({{ number_format($invoice->tax_rate, 0) }}%)</td>
                <td class="value">{{ formatCurrency($invoice->tax_amount) }}</td>
            </tr>
            @endif
            <tr class="sep"><td colspan="2"></td></tr>
            <tr class="grand-total">
                <td class="label">Toplam</td>
                <td class="value">{{ formatCurrency($invoice->amount + $invoice->tax_amount) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p><span style="color:#06b6d4">Senin</span> <span style="color:#ec4899">Davetiyen</span> &bull; www.senindavetiyen.com.tr &bull; info@senindavetiyen.com.tr</p>
        <p>Bu fatura {{ $invoice->created_at->format('d/m/Y') }} tarihinde oluşturulmuştur.</p>
    </div>
</body>
</html>
