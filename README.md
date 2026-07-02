# Sistem Manajemen Kos

## 📋 Deskripsi Proyek

**Sistem Manajemen Kos** adalah aplikasi berbasis web yang dirancang untuk memudahkan pengelolaan rumah kos, mulai dari pencarian kos oleh calon penghuni, pengelolaan data kamar dan penghuni oleh admin kos, hingga proses pembayaran dan pengaduan. Sistem ini melibatkan empat peran pengguna utama, yaitu **Super Admin**, **Admin Kos**, **Penghuni**, dan **Pencari Kos**, yang masing-masing memiliki hak akses berbeda sesuai kebutuhannya.

Aplikasi ini bertujuan untuk mendigitalisasi proses manual pengelolaan kos, seperti pencatatan tagihan, verifikasi pembayaran, dan penanganan aduan, sehingga lebih efisien, transparan, dan mudah diakses oleh semua pihak yang terlibat.

---

## ✨ Fitur-Fitur

### Untuk Pencari Kos
- Melihat katalog kos beserta informasi lengkap (ketersediaan & detail kamar, harga, galeri, kontak pemilik, fasilitas, dan lokasi)
- Register dan login ke sistem
- Melihat aturan kos yang berlaku

### Untuk Admin Kos
- Register dan login ke sistem
- Mengelola informasi kos yang ditampilkan di katalog (nama, alamat, deskripsi, fasilitas, foto, dll)
- Mengelola data kamar (menambah, mengedit, menghapus fasilitas, harga, dan periode pembayaran)
- Mengelola penghuni: menyetujui permintaan bergabung, menentukan kamar, tanggal masuk/keluar, periode pembayaran, jatuh tempo tagihan, serta status aktif/non-aktif
- Memverifikasi bukti pembayaran penghuni (diterima/ditolak)
- Melihat riwayat pembayaran seluruh penghuni
- Melihat dan menanggapi aduan dari penghuni
- Mengelola aturan kos (menambah, mengubah, memperbarui)

### Untuk Penghuni Kos
- Register dan login ke sistem
- Bergabung ke kos menggunakan kode undangan dan menunggu persetujuan admin
- Melihat tagihan, melakukan cicilan, dan mengunggah bukti pembayaran untuk konfirmasi
- Melihat riwayat pembayaran pribadi
- Mengirimkan aduan terkait fasilitas, pelayanan, atau kondisi kos
- Melihat aturan kos yang berlaku

### Untuk Super Admin
- Memverifikasi (menyetujui/menolak) pendaftaran admin kos

### Fitur Sistem Otomatis
- Menghasilkan tagihan otomatis berdasarkan periode pembayaran, tanggal masuk/keluar, dan jatuh tempo yang ditentukan admin

### Kebutuhan Non-Fungsional
- **Autentikasi Pengguna** — sistem menyediakan login dan hak akses berdasarkan role (super admin, admin kos, penghuni, pencari kos)
- **Keamanan Data** — password disimpan dalam bentuk *hashed*
- **Tampilan Responsif** — tampilan menyesuaikan ukuran layar, baik laptop maupun smartphone
- **Batasan Hak Akses** — setiap pengguna hanya dapat mengakses fitur sesuai role yang dimiliki

---

## 🛠️ Tech Stack

- **Backend:** Laravel (PHP)
- **Database:** MySQL
- **Frontend:** Blade Template / Tailwind CSS *(sesuaikan jika menggunakan Vue/React sebagai frontend terpisah)*
- **Autentikasi:** Laravel Breeze / Sanctum *(sesuaikan dengan implementasi)*
- **Package Manager:** Composer (PHP), NPM/Yarn (Frontend Assets)
- **Web Server (lokal):** Laravel Artisan Serve / XAMPP / Laragon

> ⚠️ Sesuaikan bagian tech stack di atas dengan library atau package spesifik yang benar-benar digunakan dalam proyek (misalnya paket upload gambar, library PDF, dsb).

---

## 🚀 Panduan Instalasi

### Prasyarat
Pastikan perangkat sudah memiliki:
- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js & NPM
- Git

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/username/nama-repo.git
   cd nama-repo
   ```

2. **Install dependency PHP**
   ```bash
   composer install
   ```

3. **Install dependency frontend**
   ```bash
   npm install
   ```

4. **Salin file environment**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Konfigurasi database**
   Buka file `.env` dan sesuaikan konfigurasi berikut:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Jalankan migrasi & seeder database**
   ```bash
   php artisan migrate --seed
   ```

8. **Buat symbolic link untuk storage (upload foto/bukti bayar)**
   ```bash
   php artisan storage:link
   ```

9. **Compile asset frontend**
   ```bash
   npm run dev
   ```

10. **Jalankan server lokal**
    ```bash
    php artisan serve
    ```

11. **Akses aplikasi**
    Buka browser dan kunjungi:
    ```
    http://127.0.0.1:8000
    ```

---

## 🔑 Akun Demo

| Role | Email | Password |
|------|-------|----------|
| Super Admin | superadmin@example.com | password |
| Admin Kos | admin@example.com | password |
| Penghuni | penghuni@example.com | password |
| Pencari Kos | pencari@example.com | password |

> Akun di atas hanya contoh. Sesuaikan dengan data hasil `seeder` pada proyek.

---

## 📁 Struktur Folder (Ringkasan)

```
nama-repo/
├── app/
│   ├── Http/Controllers/     # Controller untuk tiap fitur (Kos, Kamar, Penghuni, Pembayaran, Aduan, dll)
│   ├── Models/                # Model Eloquent (User, Kos, Kamar, Penghuni, Tagihan, Pembayaran, Aduan, Aturan)
│   └── ...
├── database/
│   ├── migrations/            # Struktur tabel database
│   └── seeders/                # Data awal/demo
├── resources/
│   ├── views/                  # Tampilan Blade
│   └── js/ css/                # Asset frontend
├── routes/
│   └── web.php                 # Routing aplikasi
├── public/                     # Asset publik (gambar, favicon)
├── .env.example                # Contoh konfigurasi environment
└── README.md
```

---

## 👥 Anggota Kelompok

| Nama | NIM | Peran |
|------|-----|-------|
| _(Nama Anggota 1)_ | _(NIM)_ | _(Frontend/Backend/Fullstack)_ |
| _(Nama Anggota 2)_ | _(NIM)_ | _(Frontend/Backend/Fullstack)_ |
| _(Nama Anggota 3)_ | _(NIM)_ | _(Frontend/Backend/Fullstack)_ |
| _(Nama Anggota 4)_ | _(NIM)_ | _(Frontend/Backend/Fullstack)_ |



---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan akademik/tugas mata kuliah. Seluruh hak terkait implementasi berada pada tim pengembang.
