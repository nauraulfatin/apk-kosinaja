<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kost;
use App\Models\KamarKost;
use App\Models\HargaKamar;
use App\Models\PeriodePenagihan;
use App\Models\RiwayatHunian;
use App\Models\Tagihan;
use App\Notifications\PenghuniDiterima;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class PengajuanPenghuniTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | HELPER MEMBUAT USER
    |--------------------------------------------------------------------------
    */

    private function buatUser(
        string $username,
        string $nama,
        string $nik,
        string $role,
        string $noHp
    ): User {
        return User::create([
            'username' => $username,
            'nik' => $nik,
            'nama' => $nama,
            'password' => bcrypt('password123'),
            'no_hp' => $noHp,
            'role' => $role,
            'status' => 'aktif',
            'must_change_password' => false,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER MEMBUAT KOST
    |--------------------------------------------------------------------------
    */

    private function buatKost(User $admin, string $nama): Kost
    {
        return Kost::create([
            'nama_kost' => $nama,
            'alamat' => 'Jl. Raya Banyuwangi',
            'deskripsi' => 'Kos untuk pengujian',
            'foto_kost' => [],
            'lokasi' => 'https://maps.google.com/',
            'id_user' => $admin->id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER MEMBUAT RIWAYAT PENGAJUAN
    |--------------------------------------------------------------------------
    */

    private function buatRiwayat(
        User $penghuni,
        Kost $kost
    ): RiwayatHunian {
        return RiwayatHunian::create([
            'id_user' => $penghuni->id,
            'id_kost' => $kost->id,
            'id_kamar' => null,
            'tanggal_masuk' => '2026-10-12',
            'tanggal_keluar' => null,
            'status' => 'menunggu',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER DATA PENGAJUAN
    |--------------------------------------------------------------------------
    */

    private function buatDataPengajuan(): array
    {
        $admin = $this->buatUser(
            'admin_pengajuan_test',
            'Admin Kos Jelita',
            '3507010101010001',
            'admin kost',
            '085733553160'
        );

        $kost = $this->buatKost($admin, 'Kos Jelita');

        $kamar = KamarKost::create([
            'id_kost' => $kost->id,
            'nama_kamar' => 'Kamar Jelita',
            'nomor_kamar' => '01',
            'ukuran_kamar' => '3x3 meter',
            'foto_kamar' => [],
        ]);

        $periode = PeriodePenagihan::firstOrCreate(
            [
                'periode_penagihan' => 'Bulanan',
            ],
            [
                'jumlah_interval' => 1,
                'satuan_interval' => 'bulan',
            ]
        );

        $harga = HargaKamar::create([
            'id_kamar' => $kamar->id_kamar,
            'harga' => 1500000,
            'id_periode' => $periode->id_penagihan,
            'isactive' => true,
        ]);

        $penghuni = $this->buatUser(
            'shavira_test',
            'ShaviraNindya',
            '3507010101010002',
            'penghuni kost',
            '085733553161'
        );

        $riwayat = $this->buatRiwayat(
            $penghuni,
            $kost
        );

        return [
            'admin' => $admin,
            'kost' => $kost,
            'kamar' => $kamar,
            'periode' => $periode,
            'harga' => $harga,
            'penghuni' => $penghuni,
            'riwayat' => $riwayat,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | TC-110 MELIHAT DAFTAR PENGAJUAN PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function test_tc_110_admin_dapat_melihat_daftar_pengajuan_penghuni(): void
    {
        $data = $this->buatDataPengajuan();

        // Membuat admin kos lain.
        $adminLain = $this->buatUser(
            'admin_kos_lain',
            'Admin Kos Lain',
            '3507010101010003',
            'admin kost',
            '085733553162'
        );

        $kostLain = $this->buatKost(
            $adminLain,
            'Kos Anggrek'
        );

        // Membuat penghuni yang mengajukan ke kos lain.
        $penghuniLain = $this->buatUser(
            'adhelia_test',
            'AdheliaFebri',
            '3507010101010004',
            'penghuni kost',
            '085733553163'
        );

        $this->buatRiwayat(
            $penghuniLain,
            $kostLain
        );

        // Admin membuka daftar pengajuan miliknya.
        $response = $this->actingAs($data['admin'])
            ->get(route('admin.pengajuan.index'));

        $response->assertOk();

        // Pengajuan dari kos sendiri harus ditampilkan.
        $response->assertSee('ShaviraNindya');
        $response->assertSee('Menunggu');

        // Pengajuan dari kos lain tidak boleh ditampilkan.
        $response->assertDontSee('AdheliaFebri');
    }

    /*
    |--------------------------------------------------------------------------
    | TC-111 MELIHAT DETAIL PENGAJUAN PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function test_tc_111_admin_dapat_melihat_detail_pengajuan_penghuni(): void
    {
        $data = $this->buatDataPengajuan();

        // Membuat kos lain beserta kamar dan harga aktifnya.
        $adminLain = $this->buatUser(
            'admin_lain_detail',
            'Admin Kos Lain',
            '3507010101010005',
            'admin kost',
            '085733553164'
        );

        $kostLain = $this->buatKost(
            $adminLain,
            'Kos Anggrek'
        );

        $kamarLain = KamarKost::create([
            'id_kost' => $kostLain->id,
            'nama_kamar' => 'Kamar Anggrek',
            'nomor_kamar' => '99',
            'ukuran_kamar' => '3x3 meter',
            'foto_kamar' => [],
        ]);

        HargaKamar::create([
            'id_kamar' => $kamarLain->id_kamar,
            'harga' => 9999000,
            'id_periode' => $data['periode']->id_penagihan,
            'isactive' => true,
        ]);

        $response = $this->actingAs($data['admin'])
            ->get(route('admin.pengajuan.show', [
                'riwayatHunian' => $data['riwayat']->id_riwayat_hunian,
            ]));

        $response->assertOk();

        // Memastikan detail penghuni ditampilkan.
        $response->assertSee('ShaviraNindya');

        // Memastikan kamar dan harga aktif milik kos admin tersedia.
        $response->assertSee('01');
        $response->assertSee('Rp 1.500.000');
        $response->assertSee('Bulanan');

        // Harga dari kos lain tidak boleh ikut ditampilkan.
        $response->assertDontSee('Rp 9.999.000');
    }

    /*
    |--------------------------------------------------------------------------
    | TC-112 MENYETUJUI PENGHUNI DENGAN DATA LENGKAP DAN VALID
    |--------------------------------------------------------------------------
    */

    public function test_tc_112_admin_dapat_menyetujui_penghuni_dengan_data_valid(): void
    {
        $data = $this->buatDataPengajuan();

        Notification::fake();

        $response = $this->actingAs($data['admin'])
            ->put(route('admin.pengajuan.approve', [
                'riwayatHunian' => $data['riwayat']->id_riwayat_hunian,
            ]), [
                'id_kamar' => $data['kamar']->id_kamar,
                'tanggal_masuk' => '2026-10-12',
                'tanggal_keluar' => '2026-12-12',
                'id_harga_kamar' => $data['harga']->id_harga_kamar,
                'jatuh_tempo_hari' => 5,
                'status' => 'aktif',
            ]);

        $response->assertRedirect(route('admin.pengajuan.index'));

        $response->assertSessionHas(
            'success',
            'Penghuni berhasil disetujui.'
        );

        // Memastikan status hunian berubah menjadi aktif.
        $data['riwayat']->refresh();

        $this->assertEquals('aktif', $data['riwayat']->status);

        $this->assertEquals(
            $data['kamar']->id_kamar,
            $data['riwayat']->id_kamar
        );

        $this->assertEquals(
            '2026-10-12',
            $data['riwayat']->tanggal_masuk->toDateString()
        );

        $this->assertEquals(
            '2026-12-12',
            $data['riwayat']->tanggal_keluar->toDateString()
        );

        $this->assertDatabaseHas('tagihans', [
    'id_kamar' => $data['kamar']->id_kamar,
    'id_user' => $data['penghuni']->id,
    'id_harga_kamar' => $data['harga']->id_harga_kamar,
    'tanggal_mulai' => '2026-10-12 00:00:00',
    'tanggal_selesai' => '2026-11-11 00:00:00',
    'tanggal_jatuh_tempo' => '2026-10-17 00:00:00',
    'status' => 'pending',
]);

$this->assertDatabaseHas('tagihans', [
    'id_kamar' => $data['kamar']->id_kamar,
    'id_user' => $data['penghuni']->id,
    'id_harga_kamar' => $data['harga']->id_harga_kamar,
    'tanggal_mulai' => '2026-11-12 00:00:00',
    'tanggal_selesai' => '2026-12-11 00:00:00',
    'tanggal_jatuh_tempo' => '2026-11-17 00:00:00',
    'status' => 'pending',
]);

        // Memastikan notifikasi berhasil dikirim kepada penghuni.
        Notification::assertSentTo(
            $data['penghuni'],
            PenghuniDiterima::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TC-113 MENOLAK ANTRIAN TANPA MEMILIH KAMAR
    |--------------------------------------------------------------------------
    */

    public function test_tc_113_admin_tidak_dapat_memasukkan_penghuni_ke_antrian_tanpa_memilih_kamar(): void
    {
        $data = $this->buatDataPengajuan();

        $response = $this->actingAs($data['admin'])
            ->put(route('admin.pengajuan.approve', [
                'riwayatHunian' => $data['riwayat']->id_riwayat_hunian,
            ]), [
                // id_kamar sengaja tidak dikirim.
                'tanggal_masuk' => '2026-12-15',
                'tanggal_keluar' => '2027-03-15',
                'id_harga_kamar' => $data['harga']->id_harga_kamar,
                'jatuh_tempo_hari' => 5,
                'status' => 'antrian',
            ]);

        // Sistem harus menolak karena kamar wajib dipilih.
        $response->assertSessionHasErrors([
            'id_kamar',
        ]);

        // Status pengajuan harus tetap menunggu.
        $data['riwayat']->refresh();

        $this->assertEquals(
            'menunggu',
            $data['riwayat']->status
        );

        // Tidak boleh ada tagihan yang dibuat.
        $this->assertDatabaseCount('tagihans', 0);
    }

    /*
    |--------------------------------------------------------------------------
    | TC-114 TANGGAL KELUAR SEBELUM TANGGAL MASUK
    |--------------------------------------------------------------------------
    */

    public function test_tc_114_admin_tidak_dapat_menyetujui_penghuni_dengan_tanggal_keluar_sebelum_tanggal_masuk(): void
    {
        $data = $this->buatDataPengajuan();

        $response = $this->actingAs($data['admin'])
            ->put(route('admin.pengajuan.approve', [
                'riwayatHunian' => $data['riwayat']->id_riwayat_hunian,
            ]), [
                'id_kamar' => $data['kamar']->id_kamar,
                'tanggal_masuk' => '2027-10-01',
                'tanggal_keluar' => '2026-04-01',
                'id_harga_kamar' => $data['harga']->id_harga_kamar,
                'jatuh_tempo_hari' => 5,
                'status' => 'aktif',
            ]);

        // Sistem harus menolak tanggal keluar yang lebih awal.
        $response->assertSessionHasErrors([
            'tanggal_keluar',
        ]);

        // Status pengajuan tidak boleh berubah.
        $data['riwayat']->refresh();

        $this->assertEquals(
            'menunggu',
            $data['riwayat']->status
        );

        // Tidak boleh ada tagihan yang dibuat.
        $this->assertDatabaseCount('tagihans', 0);
    }

    /*
    |--------------------------------------------------------------------------
    | TC-115 JATUH TEMPO LEBIH DARI 31 HARI
    |--------------------------------------------------------------------------
    */

    public function test_tc_115_admin_tidak_dapat_menyetujui_penghuni_dengan_jatuh_tempo_lebih_dari_31_hari(): void
    {
        $data = $this->buatDataPengajuan();

        $response = $this->actingAs($data['admin'])
            ->put(route('admin.pengajuan.approve', [
                'riwayatHunian' => $data['riwayat']->id_riwayat_hunian,
            ]), [
                'id_kamar' => $data['kamar']->id_kamar,
                'tanggal_masuk' => '2026-10-14',
                'tanggal_keluar' => '2026-12-14',
                'id_harga_kamar' => $data['harga']->id_harga_kamar,
                'jatuh_tempo_hari' => 32,
                'status' => 'aktif',
            ]);

        // Sistem harus menolak jatuh tempo lebih dari 31 hari.
        $response->assertSessionHasErrors([
            'jatuh_tempo_hari',
        ]);

        // Status pengajuan tidak boleh berubah.
        $data['riwayat']->refresh();

        $this->assertEquals(
            'menunggu',
            $data['riwayat']->status
        );

        // Tidak boleh ada tagihan yang dibuat.
        $this->assertDatabaseCount('tagihans', 0);
    }
}