PRIORITAS #10 - VALIDASI FORM & TRANSAKSI DATABASE

File yang diubah:
1. app/Http/Controllers/AdminKostController.php
2. app/Http/Controllers/KamarController.php
3. app/Http/Controllers/Penghuni/AduanPenghuniController.php
4. app/Http/Controllers/Admin/AduanAdminController.php
5. resources/views/admin/kost/kost-edit.blade.php
6. resources/views/admin/kamar/form.blade.php
7. resources/views/admin/aduan/show.blade.php

Fokus perbaikan:
- Validasi input dibuat lebih ketat dan konsisten.
- Upload gambar dibatasi tipe, ukuran, dan jumlah.
- Update kos dilakukan dalam DB transaction.
- Create/update/delete kamar menggunakan DB transaction.
- File baru dihapus kembali jika transaksi database gagal.
- File lama baru dihapus dari storage setelah database sukses.
- Aduan tidak mengunggah foto sebelum memastikan penghuni terhubung ke kos.
- Validasi status aduan dibatasi ke baru/diproses/selesai.
- Error teknis dicatat ke laravel.log dan user mendapat pesan generik.
- Form admin menampilkan validation error / session error.

Tidak ada migration baru.
Setelah copy patch:
php artisan optimize:clear
php -l app/Http/Controllers/AdminKostController.php
php -l app/Http/Controllers/KamarController.php
php -l app/Http/Controllers/Penghuni/AduanPenghuniController.php
php -l app/Http/Controllers/Admin/AduanAdminController.php
