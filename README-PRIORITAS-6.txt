KOSINAJA - PRIORITAS #6
MASTER PERIODE PENAGIHAN GLOBAL

Perubahan utama:
1. CRUD periode dipindahkan dari Admin Kos ke Super Admin.
2. Admin Kos tetap dapat memilih periode saat mengatur harga kamar.
3. Periode yang sudah digunakan tidak dapat dihapus.
4. Interval periode yang sudah digunakan dikunci agar tidak mengubah perilaku tagihan seluruh kos.
5. Nama/label periode masih dapat diperbarui oleh Super Admin.
6. Menu "Periode Penagihan" ditambahkan ke sidebar Super Admin.

Tidak ada migration baru.

Setelah copy/replace:
  php artisan optimize:clear
  php -l app\Http\Controllers\PeriodePenagihanController.php
  php -l app\Models\PeriodePenagihan.php
  php -l routes\web.php
  php artisan route:list --path=periode

Target route:
  /super-admin/periode ...

Tidak boleh lagi ada:
  /admin/periode ...
