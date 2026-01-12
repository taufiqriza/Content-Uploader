# Deployment Guide - Content Uploader

## Production URL
**https://content.alamani.edu.my**

---

## 1. Hostinger Setup

### Database
1. Login ke Hostinger hPanel
2. Buat database MySQL baru
3. Catat: Database Name, Username, Password

### Subdomain
1. Buat subdomain `content.alamani.edu.my`
2. Arahkan ke folder `/public_html/content-uploader/public`
3. Aktifkan SSL (Let's Encrypt)

---

## 2. Upload Files

### Via Git (Recommended)
```bash
cd /home/username/public_html
git clone https://github.com/your-repo/content-uploader.git
cd content-uploader
```

### Via FTP
Upload semua file ke `/public_html/content-uploader/`

---

## 3. Configure Environment

Copy template dari `docs/env-production-template.txt` ke `.env`:
```bash
cp docs/env-production-template.txt .env
```

Update values:
- `APP_KEY` - Generate dengan `php artisan key:generate`
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` - Credentials dari Hostinger
- Social platform credentials (lihat bagian 5)

---

## 4. Install Dependencies

```bash
# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node dependencies & build assets
npm install
npm run build

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Create admin user
php artisan make:filament-user

# Optimize
php artisan optimize
php artisan filament:optimize
```

---

## 5. OAuth Redirect URIs

Daftarkan redirect URI berikut di masing-masing platform:

### YouTube (Google Cloud Console)
```
https://content.alamani.edu.my/auth/youtube/callback
```

### Instagram/Facebook (Meta Developer)
```
https://content.alamani.edu.my/auth/instagram/callback
https://content.alamani.edu.my/auth/facebook/callback
```

### TikTok (TikTok Developer)
```
https://content.alamani.edu.my/auth/tiktok/callback
```

---

## 6. Queue Worker (Cron Job)

Di Hostinger hPanel > Cron Jobs, tambahkan:

```
* * * * * cd /home/username/public_html/content-uploader && php artisan schedule:run >> /dev/null 2>&1
```

Ini akan menjalankan queue worker setiap menit untuk memproses upload.

---

## 7. Storage Link

Pastikan storage link sudah dibuat:
```bash
php artisan storage:link
```

---

## 8. Permissions

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## Access Panel Admin
URL: `https://content.alamani.edu.my/admin`

---

## Troubleshooting

### Error 500
- Check `storage/logs/laravel.log`
- Pastikan `APP_DEBUG=true` sementara untuk melihat error

### Queue tidak jalan
- Pastikan cron job sudah aktif
- Check `jobs` table di database

### OAuth gagal
- Pastikan redirect URI exact match
- Check credentials di `.env`
