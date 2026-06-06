<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fatura {{ $invoice->invoice_no }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1a1a2e; }
        .header { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #d4a61e; }
        .header h1 { font-size: 24px; color: #d4a61e; margin: 0; }
        .header p { color: #8893ac; font-size: 11px; margin: 5px 0 0; }
        .info { margin-bottom: 30px; }
        .info table { width: 100%; }
        .info td { vertical-align: top; padding: 5px 10px; }
        .info td:first-child { width: 50%; }
        .info h3 { font-size: 10px; text-transform: uppercase; color: #8893ac; margin: 0 0 5px; letter-spacing: 1px; }
        .info p { margin: 2px 0; font-size: 12px; }
        .details { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .details th { background: #f5f5f7; padding: 10px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #8893ac; }
        .details td { padding: 10px; border-bottom: 1px solid #eceef2; font-size: 12px; }
        .details td:last-child { text-align: right; }
        .total { text-align: right; font-size: 18px; font-weight: bold; padding: 10px 0; border-top: 2px solid #1a1a2e; }
        .footer { text-align: center; color: #b1b8c9; font-size: 10px; margin-top: 40px; padding-top: 20px; border-top: 1px solid #eceef2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <p>Fatura #{{ $invoice->invoice_no }}</p>
        <p>{{ $invoice->created_at->format('d F Y') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td>
                    <h3>Fatura Eden</h3>
                    <p>{{ config('app.name') }}</p>
                </td>
                <td>
                    <h3>Müşteri</h3>
                    <p>{{ $invoice->user->name }}</p>
                    <p>{{ $invoice->user->email }}</p>
                </td>
            </tr>
        </table>
    </div>

    <table class="details">
        <thead>
            <tr>
                <th>Açıklama</th>
                <th>Dönem</th>
                <th>Durum</th>
                <th>Tutar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->plan->name ?? 'Plan' }}</td>
                <td>{{ $invoice->interval === 'yearly' ? 'Yıllık' : 'Aylık' }}</td>
                <td>{{ ucfirst($invoice->status) }}</td>
                <td>{{ number_format($invoice->amount, 2) }} TL</td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        Toplam: {{ number_format($invoice->amount, 2) }} TL
    </div>

    <div class="footer">
        <p>{{ config('app.name') }} - Bu fatura {{ $invoice->created_at->format('d/m/Y') }} tarihinde oluşturulmuştur.</p>
    </div>
</body>
</html>
