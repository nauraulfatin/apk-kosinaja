PRIORITAS #2 - KONSISTENSI STATUS KAMAR

File yang berubah:
1. app/Models/KamarKost.php
2. app/Http/Controllers/KamarController.php
3. database/migrations/2026_08_30_000002_drop_legacy_status_from_kamar_kosts_table.php

Setelah copy:
php artisan optimize:clear
php artisan migrate

Lalu cek:
php -l app/Models/KamarKost.php
php -l app/Http/Controllers/KamarController.php

Status kamar sekarang berasal dari riwayat_hunians.status:
- ada riwayat status aktif => terisi
- selain itu => kosong

Blade yang masih memakai $kamar->status tetap bekerja karena KamarKost menyediakan accessor status otomatis.
