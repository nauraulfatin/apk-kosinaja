PRIORITAS #4 - KONSISTENSI ROUTE PROFIL

File yang diubah:
- routes/web.php
- app/Http/Controllers/ProfilPenghuniController.php
- resources/views/layouts/penghuni.blade.php
- resources/views/layouts/public.blade.php

Perbaikan:
1. Menghapus duplikasi /admin/profil di luar middleware role admin kost.
2. Menghapus route /profil global yang tidak dilindungi auth/role.
3. Profil penghuni hanya tersedia pada /penghuni/profil di grup auth + force.password + role:penghuni kost.
4. Route name penghuni menjadi penghuni.profil.index.
5. Menghapus route mati yang menunjuk method yang tidak tersedia: updateProfil, hubungkan, dan PengajuanPenghuniController@store.
6. /hubungkan-kode tetap memakai URL lama, tetapi dibatasi role penghuni kost.
7. ProfilPenghuniController menggunakan view profil.index yang tersedia.

Setelah replace:
php artisan optimize:clear
php -l routes\web.php
php -l app\Http\Controllers\ProfilPenghuniController.php
php artisan route:list | Select-String "profil|hubungkan-kode"
