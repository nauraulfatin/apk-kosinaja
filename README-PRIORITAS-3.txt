KOSINAJA - PRIORITAS #3
Konsistensi Status Tagihan & Pembayaran

FILE YANG DIUBAH:
1. app/Models/Tagihan.php
2. app/Http/Controllers/TagihanController.php
3. resources/views/penghuni/dashboard.blade.php
4. resources/views/penghuni/pembayaran/index.blade.php
5. resources/views/admin/dashboard.blade.php

PATCH INI TIDAK MENYENTUH:
- app/Http/Controllers/Admin/PengajuanPenghuniController.php (Prioritas #1)
- app/Http/Controllers/PenghuniController.php (Prioritas #1)
- app/Http/Controllers/KamarController.php (Prioritas #2)
- app/Models/KamarKost.php (Prioritas #2)
- migration status kamar Prioritas #2
- HomeController / fasilitas populer

KONSEP STATUS SETELAH PERBAIKAN:
A. tagihans.status = status finansial saja:
   - pending
   - telat
   - lunas

B. pembayarans.status_validasi = status proses verifikasi pembayaran:
   - menunggu
   - diterima
   - ditolak

C. Tagihan->status_label = status untuk tampilan UI:
   - lunas
   - menunggu_verifikasi
   - ditolak
   - telat
   - pending

Tidak ada migration baru pada Prioritas #3.

SETELAH COPY/REPLACE:
php artisan optimize:clear
php -l app\Models\Tagihan.php
php -l app\Http\Controllers\TagihanController.php

TEST:
1. Tagihan baru -> Pending
2. Lewat jatuh tempo -> Telat
3. Upload bukti -> Menunggu Verifikasi
4. Admin tolak -> Ditolak
5. Upload ulang -> Menunggu Verifikasi
6. Admin terima cicilan belum penuh -> Pending/Telat sesuai jatuh tempo
7. Total cicilan diterima >= tagihan -> Lunas
8. Saat masih Menunggu Verifikasi, user tidak boleh upload pembayaran kedua
