PRIORITAS #7 - KONSISTENSI DASHBOARD ADMIN

File yang diubah:
- app/Http/Controllers/AdminKostController.php

Perubahan utama:
- Total penghuni dihitung dari riwayat_hunians.status = aktif.
- Tidak lagi dihitung dari user yang mempunyai tagihan.
- Data tetap dibatasi pada kos milik Admin yang sedang login.
- Ditambahkan pengecekan apabila record kos Admin tidak tersedia.

Setelah replace:
1. php artisan optimize:clear
2. php -l app\Http\Controllers\AdminKostController.php
3. Tidak perlu migrate.
