# KosinAja! 🏠

## 📋 Deskripsi Proyek

Berdasarkan permasalahan yang ditemukan, tim kami merancang sebuah solusi berupa **Sistem Informasi dan Manajemen Kos** yang terintegrasi. Sistem ini dirancang untuk mempermudah pengelolaan data kos, kamar, penghuni, tagihan, pembayaran, serta aduan penghuni secara digital dan terpusat. Dengan sistem ini, proses administrasi menjadi lebih efisien, data tersimpan secara rapi, dan calon penghuni dapat mengakses informasi kos secara mandiri tanpa harus menunggu balasan dari admin secara langsung.

### Keunggulan Solusi

**📇 Pencatatan Penghuni Secara Digital**
Semua data penghuni dicatat langsung melalui sistem KosinAja!. Admin dapat mengakses informasi penghuni kapan saja tanpa harus menggunakan catatan manual. Dengan sistem ini, data tersimpan secara rapi, terstruktur, dan mudah dicari kembali, sehingga memudahkan pemantauan hunian.

**💳 Pencatatan Tagihan dan Pembayaran Lebih Terdokumentasi**
Semua pembayaran yang masuk dicatat secara otomatis. Admin dapat melihat status pembayaran masing-masing penghuni, termasuk yang sudah membayar, belum membayar, atau terlambat. Bukti pembayaran tersimpan di dalam sistem sehingga tidak perlu melakukan pengecekan manual satu per satu, meningkatkan efisiensi dan akurasi administrasi.

**🏘️ Informasi Kos Terstruktur, Lengkap, dan Akurat**
Calon penghuni dapat mengakses informasi kos melalui katalog yang tersedia di sistem. Informasi yang ditampilkan meliputi foto kamar, harga sewa, fasilitas, lokasi, serta ketersediaan kamar. Dengan demikian, calon penghuni dapat memperoleh informasi secara mandiri tanpa harus menunggu balasan langsung dari admin, sehingga proses pencarian kos menjadi lebih cepat dan efisien.

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
- **Frontend:** Blade Template, Tailwind CSS 
- **Autentikasi:** Laravel Breeze 
- **Package Manager:** Composer (PHP), NPM (Frontend Assets)
- **Web Server (lokal):** Laravel Artisan Serve / XAMPP / Laragon



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
   git clone https://github.com/nauraulfatin/apk-kosinaja.git
   cd apk-kosinaja
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

| Role | Username | Password |
|------|----------|----------|
| Super Admin | `superadmin` | `orbitgacor` |
| Admin Kos | `teamorbit` | `Orbit123` |
| Penghuni | `kadek` | `Kadek123` |

> ⚠️ Akun ini hanya untuk keperluan demo/testing. Jangan gunakan kredensial ini di lingkungan production.

---

## 📁 Struktur Folder (Ringkasan)

```
apk-kosinaja/
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

| Nama | NIM |
|------|-----|
| Naura Ulfatin Nadya | 362458302129 |
| Shavira Nindya Putriawan | 362458302050 |
| Rahma Titis Pratiwi | 362458302052 |
| Moh Andy Yusril | 362458302111 |

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan akademik/tugas mata kuliah. Seluruh hak terkait implementasi berada pada tim pengembang.
