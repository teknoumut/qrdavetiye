# senin 💝 davetiyen

QR kodlu, müzikli, fotoğraflı modern davetiye platformu.

## Özellikler

- QR kodlu dijital davetiyeler
- Müzik ve video desteği
- Fotoğraf galerisi
- RSVP katılım takibi
- Özelleştirilebilir temalar
- Geri sayım sayacı
- Harita entegrasyonu

## Kurulum

```bash
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
```

## Gereksinimler

- PHP 8.1+
- MySQL 5.7+
- Composer 2.x
- Node.js 18+
