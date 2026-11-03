<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kost;
use App\Models\KamarKost;
use App\Models\Fasilitas;
use App\Models\HargaKamar;
use App\Models\PeriodePenagihan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DetailKatalogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Membuat data dummy yang digunakan
     * untuk pengujian detail kos dan kamar.
     */
    private function buatDataDetail()
    {
        // Membuat pemilik kos
        $pemilik = User::create([
            'username' => 'pemilik_jelita',
            'nik' => '3507010101010001',
            'nama' => 'Pemilik Kos Jelita',
            'password' => bcrypt('password123'),
            'no_hp' => '085733553160',
            'role' => 'admin kost',
            'status' => 'aktif',
        ]);

        // Membuat data kos
        $kost = Kost::create([
            'nama_kost' => 'Kos Jelita',
            'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
            'deskripsi' => 'Kos Khusus Putri Nyaman dan Dekat Kampus',
            'foto_kost' => ['foto-kos.jpg'],
            'lokasi' => 'https://maps.google.com/',
            'id_user' => $pemilik->id,
        ]);

        // Membuat fasilitas kos dan kamar
        $fasilitasKos = Fasilitas::create([
            'nama_fasilitas' => 'Tempat Parkir',
        ]);

        $fasilitasKamar = Fasilitas::create([
            'nama_fasilitas' => 'Spring Bed',
        ]);

        // Menghubungkan fasilitas dengan kos
        $kost->fasilitas()->attach($fasilitasKos->id_fasilitas);

        // Membuat kamar
        $kamar = KamarKost::create([
            'id_kost' => $kost->id,
            'nama_kamar' => 'Kamar Jelita',
            'nomor_kamar' => '01',
            'ukuran_kamar' => '3x3 meter',
            'foto_kamar' => ['foto-kamar.jpg'],
        ]);

        // Menghubungkan fasilitas dengan kamar
        $kamar->fasilitas()->attach($fasilitasKamar->id_fasilitas);

        // Membuat periode pembayaran
        $periode = PeriodePenagihan::create([
            'periode_penagihan' => 'Bulanan',
            'jumlah_interval' => 1,
            'satuan_interval' => 'bulan',
        ]);

        // Membuat harga kamar
        HargaKamar::create([
            'id_kamar' => $kamar->id_kamar,
            'harga' => 1500000,
            'isactive' => true,
            'id_periode' => $periode->id_penagihan,
        ]);

        return [
            'kost' => $kost,
            'kamar' => $kamar,
        ];
    }

    /**
     * TC-059
     * Melihat Detail Informasi Kos.
     */
    public function test_pengunjung_dapat_melihat_detail_informasi_kos()
    {
        $data = $this->buatDataDetail();

        $response = $this->get(
            route('detailKost', $data['kost']->id)
        );

        $response->assertStatus(200);

        $response->assertSee('Kos Jelita');
        $response->assertSee('Jl. Raya Jember No. KM 13, Banyuwangi');
        $response->assertSee('Kos Khusus Putri Nyaman dan Dekat Kampus');
        $response->assertSee('Tempat Parkir');
        $response->assertSee('Kamar Jelita');
        $response->assertSee('Pemilik Kos Jelita');
    }

    /**
     * TC-060
     * Melihat Detail Kamar.
     */
    public function test_pengunjung_dapat_melihat_detail_kamar()
    {
        $data = $this->buatDataDetail();

        $response = $this->get(
            route('detailKamar', $data['kamar']->id_kamar)
        );

        $response->assertStatus(200);

        $response->assertSee('Kamar Jelita');
        $response->assertSee('Kos Jelita');
        $response->assertSee('Spring Bed');
        $response->assertSee('Rp 1.500.000');
        $response->assertSee('Tersedia');
    }
}