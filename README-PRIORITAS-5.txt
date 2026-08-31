KOSINAJA - PRIORITAS #5
SATU ALUR REGISTRASI ADMIN KOS

Tujuan:
- Registrasi awal Admin Kos hanya meminta identitas admin + nama kos + alamat kos.
- Hanya AuthController yang menangani proses registrasi.
- AdminKostController hanya menangani fitur bisnis setelah admin login.
- Data detail kos (foto, deskripsi, lokasi, fasilitas) dilengkapi setelah akun disetujui Super Admin.
- User dan Kost dibuat dalam DB transaction agar tidak ada akun tanpa data kos jika proses gagal.

File yang berubah:
1. app/Http/Controllers/AuthController.php
2. app/Http/Controllers/AdminKostController.php
3. routes/web.php
4. resources/views/auth/register-admin-kost.blade.php

Catatan route:
- GET  /register/admin -> AuthController@showRegisterAdmin
- POST /register/admin -> AuthController@registerAdmin
- GET  /register-admin-kost -> redirect kompatibilitas ke /register/admin
- POST /register-admin-kost sudah dihapus dan tidak lagi menerima request.

Tidak ada migration baru.
Setelah replace:
  php artisan optimize:clear
  php -l app/Http/Controllers/AuthController.php
  php -l app/Http/Controllers/AdminKostController.php
  php -l routes/web.php
  php artisan route:list | Select-String "register"
