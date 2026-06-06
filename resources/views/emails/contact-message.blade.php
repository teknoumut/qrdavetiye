<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family:sans-serif;padding:24px;background:#f5f5f5;">
    <div style="max-width:600px;margin:auto;background:#fff;border-radius:12px;padding:32px;">
        <h2 style="margin:0 0 4px;color:#1a1a2e;">Yeni İletişim Mesajı</h2>
        <p style="color:#666;margin:0 0 24px;">{{ $msg->created_at->format('d.m.Y H:i') }}</p>

        <table style="width:100%;border-collapse:collapse;">
            <tr><td style="padding:8px 0;color:#888;width:80px;">Ad Soyad</td><td style="padding:8px 0;font-weight:600;">{{ $msg->name }}</td></tr>
            @if($msg->phone)<tr><td style="padding:8px 0;color:#888;">Telefon</td><td style="padding:8px 0;">{{ $msg->phone }}</td></tr>@endif
            @if($msg->email)<tr><td style="padding:8px 0;color:#888;">E-posta</td><td style="padding:8px 0;">{{ $msg->email }}</td></tr>@endif
        </table>

        <div style="margin-top:20px;padding:16px;background:#fafafa;border-radius:8px;border-left:3px solid #6366f1;">
            <p style="margin:0;line-height:1.6;white-space:pre-wrap;">{{ $msg->message }}</p>
        </div>

        <p style="margin-top:24px;font-size:12px;color:#aaa;">
            <a href="{{ route('admin.contact-messages.show', $msg) }}" style="color:#6366f1;">Admin panelinden görüntüle</a>
        </p>
    </div>
</body>
</html>
