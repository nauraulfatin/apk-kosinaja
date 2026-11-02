<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RekomendasiKosTest extends TestCase
{
    use RefreshDatabase;

    //TC-058-MELIHAT REKOMENDASI KOS
    public function test_tc_058_melihat_rekomendasi_kos(): void
    {
        // ARRANGE: Buat Admin Kos yang sudah aktif
        $adminAktif = User::create([
            'nama' => 'Naura Ulfatin',
            'nik' => '3201234567890158',
            'username' => 'naura_kos',
            'no_hp' => '085733553160',
            'password' => Hash::make('Naura123'),
            'role' => 'admin kost',
            'status' => 'aktif',
            'must_change_password' => false,
        ]);

        // Buat data kos yang tersedia
        $kosAktif = Kost::create([
            'id_user' => $adminAktif->id,
            'nama_kost' => 'Kos Jelita',
            'alamat' => 'Jl. Raya Jember No. 13, Banyuwangi',
            'deskripsi' => 'Kos nyaman dekat kampus.',
        ]);

        // Buat Admin Kos yang masih pending
        $adminPending = User::create([
            'nama' => 'Shavira Nindya',
            'nik' => '3201234567890159',
            'username' => 'shavira_kos',
            'no_hp' => '081234567891',
            'password' => Hash::make('Sapir123'),
            'role' => 'admin kost',
            'status' => 'pending',
            'must_change_password' => false,
        ]);

        // Buat kos milik admin yang belum disetujui
        $kosPending = Kost::create([
            'id_user' => $adminPending->id,
            'nama_kost' => 'Kos Belum Disetujui',
            'alamat' => 'Jl. Melati No. 20, Banyuwangi',
            'deskripsi' => 'Kos dengan status admin pending.',
        ]);

        // ACT: Pengguna mengakses halaman beranda
        $response = $this->get(route('home'));

        // ASSERT: Halaman beranda berhasil diakses
        $response->assertOk();

        // ASSERT: View yang ditampilkan sesuai
        $response->assertViewIs('katalog.home');

        // ASSERT: Bagian rekomendasi kos muncul
        $response->assertSee('Rekomendasi Kos');

        // ASSERT: Nama dan alamat kos aktif ditampilkan
        $response->assertSee($kosAktif->nama_kost);
        $response->assertSee($kosAktif->alamat);

        // ASSERT: Tombol menuju detail kos tersedia
        $response->assertSee('Lihat Detail');

        // ASSERT: Kos milik admin pending tidak ditampilkan
        $response->assertDontSee($kosPending->nama_kost);

        // ASSERT: Data rekomendasi yang dikirim controller benar
        $response->assertViewHas(
            'kostTerbaru',
            function ($daftarKos) use ($kosAktif, $kosPending) {
                return $daftarKos->contains('id', $kosAktif->id)
                    && !$daftarKos->contains('id', $kosPending->id);
            }
        );

        // ASSERT: Kedua data dummy tersimpan
        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseCount('kosts', 2);
    }
}
