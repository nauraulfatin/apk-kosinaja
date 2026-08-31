PRIORITAS #9 - CLEANUP ROUTE & DEAD CODE

Perubahan:
1. Menghapus resource route /admin/penghuni yang menunjuk ke method controller yang tidak ada.
2. Menghapus import PengajuanSewaController yang tidak digunakan/tidak ada.
3. Menghapus route /penghuni/pembayaran/create karena view create tidak ada dan pembayaran sudah memakai modal pada index.
4. Memperbaiki path view edit kos menjadi admin.kost.kost-edit.
5. Menghapus method controller yang tidak dipakai: dashboard ProfilAdmin, dashboard ProfilPenghuni, createPembayaran, batalPembayaran.
6. Memperbaiki tombol "Masuk Kost" di dashboard penghuni agar menuju halaman profil/kode undangan.

Opsional setelah patch dan setelah memastikan aplikasi normal:
Remove-Item -Recurse -Force resources\views\admin\periode
Remove-Item -Force resources\views\welcome.blade.php

Folder admin/periode adalah view lama sebelum master periode dipindahkan ke Super Admin.
welcome.blade.php adalah view bawaan Laravel dan tidak digunakan route KosinAja saat ini.
