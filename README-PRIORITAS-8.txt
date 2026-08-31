KOSINAJA - PRIORITAS #8 SECURITY POLISHING

File yang diubah:
1. app/Http/Controllers/AuthController.php
   - Rate limiting login: maksimal 5 kegagalan / 60 detik per username + IP.
   - Counter dibersihkan setelah login sukses.
   - Pesan login tetap generik untuk mencegah username enumeration.
   - Session tetap diregenerate setelah login sukses.

2. app/Http/Controllers/ProfilPenghuniController.php
   - Tidak lagi mengirim $e->getMessage() ke browser/client.
   - Detail exception masuk ke storage/logs/laravel.log.
   - Pengguna menerima pesan generik.

Tidak ada migration baru.
Tidak perlu php artisan migrate.

Sesudah replace:
php artisan optimize:clear
php -l app\Http\Controllers\AuthController.php
php -l app\Http\Controllers\ProfilPenghuniController.php

Test rate limiter:
- Masukkan password salah 5 kali dengan username yang sama.
- Percobaan berikutnya harus mendapat pesan tunggu beberapa detik.
- Setelah waktu habis, login dapat dicoba kembali.
- Login sukses akan membersihkan hit gagal.

Catatan production:
Pastikan APP_DEBUG=false pada server produksi.
