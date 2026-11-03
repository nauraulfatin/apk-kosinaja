<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kost;
use App\Models\KamarKost;
use App\Models\HargaKamar;
use App\Models\PeriodePenagihan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HargaKamarTest extends TestCase
{
    use RefreshDatabase;

    // ======================================================
    // HELPER: MEMBUAT DATA ADMIN, KOS, KAMAR, DAN PERIODE
    // ======================================================
    private function buatDataHargaKamar(): array
    {
        $admin = User::create([
            'username' => 'admin_harga_test',
            'nik' => '3507010101010001',
            'nama' => 'Admin Harga Test',
            'password' => bcrypt('password123'),
            'no_hp' => '085733553160',
            'role' => 'admin kost',
            'status' => 'aktif',
            'must_change_password' => false,
        ]);

        $kost = Kost::create([
            'nama_kost' => 'Kos Jelita',
            'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
            'deskripsi' => 'Kos Khusus Putri Nyaman',
            'foto_kost' => [],
            'lokasi' => 'https://maps.google.com/',
            'id_user' => $admin->id,
        ]);

        $kamar = KamarKost::create([
            'id_kost' => $kost->id,
            'nama_kamar' => 'Kamar Jelita',
            'nomor_kamar' => '01',
            'ukuran_kamar' => '3x3 meter',
            'foto_kamar' => [],
        ]);

        // Membuat data periode pembayaran
        $periodeHarian = PeriodePenagihan::firstOrCreate(
            ['periode_penagihan' => 'Harian'],
            ['jumlah_interval' => 1, 'satuan_interval' => 'hari']
        );

        $periodeMingguan = PeriodePenagihan::firstOrCreate(
            ['periode_penagihan' => 'Mingguan'],
            ['jumlah_interval' => 1, 'satuan_interval' => 'minggu']
        );

        $periodeBulanan = PeriodePenagihan::firstOrCreate(
            ['periode_penagihan' => 'Bulanan'],
            ['jumlah_interval' => 1, 'satuan_interval' => 'bulan']
        );

        $periodeTigaBulan = PeriodePenagihan::firstOrCreate(
            ['periode_penagihan' => '3 Bulan'],
            ['jumlah_interval' => 3, 'satuan_interval' => 'bulan']
        );

        $periodeEnamBulan = PeriodePenagihan::firstOrCreate(
            ['periode_penagihan' => 'Semester'],
            ['jumlah_interval' => 6, 'satuan_interval' => 'bulan']
        );

        return [
            'admin' => $admin,
            'kost' => $kost,
            'kamar' => $kamar,
            'periode_harian' => $periodeHarian,
            'periode_mingguan' => $periodeMingguan,
            'periode_bulanan' => $periodeBulanan,
            'periode_tiga_bulan' => $periodeTigaBulan,
            'periode_enam_bulan' => $periodeEnamBulan,
        ];
    }


    // ======================================================
    // HELPER: MENAMBAHKAN DAN MEMERIKSA HARGA KAMAR
    // ======================================================
    private function simpanDanPeriksaHarga(
        array $data,
        PeriodePenagihan $periode,
        int $nominal
    ): void {
        $response = $this->actingAs($data['admin'])
            ->post(
                route('admin.kamar.harga.store', [
                    'kamar' => $data['kamar']->id_kamar,
                ]),
                [
                    'harga' => $nominal,
                    'id_periode' => $periode->id_penagihan,
                    'isactive' => 1,
                ]
            );

        // Memeriksa respons penyimpanan
        $response->assertRedirect(
            route('admin.kamar.harga.index', [
                'kamar' => $data['kamar']->id_kamar,
            ])
        );

        $response->assertSessionHas('success', 'Harga ditambah.');

        // Memastikan harga tersimpan di database
        $this->assertDatabaseCount('harga_kamars', 1);

        $harga = HargaKamar::where(
            'id_kamar',
            $data['kamar']->id_kamar
        )->firstOrFail();

        $this->assertEquals($nominal, (float) $harga->harga);
        $this->assertTrue($harga->isactive);
        $this->assertEquals($periode->id_penagihan, $harga->id_periode);

        // Memastikan periode harga tersimpan dengan benar
        $this->assertEquals(
            $periode->periode_penagihan,
            $harga->periode->periode_penagihan
        );

        // Memastikan harga aktif tampil pada detail kamar di katalog
        $katalog = $this->get(
            route('detailKamar', $data['kamar']->id_kamar)
        );

        $katalog->assertOk();

        $katalog->assertSee(
            'Rp ' . number_format($nominal, 0, ',', '.')
        );

        $katalog->assertSee($periode->periode_penagihan);
    }


    // ======================================================
    // TC-091: MENAMBAHKAN HARGA KAMAR PERIODE HARIAN
    // Harga: Rp50.000
    // ======================================================
    public function test_tc_091_admin_dapat_menambahkan_harga_kamar_periode_harian(): void
    {
        $data = $this->buatDataHargaKamar();

        $this->simpanDanPeriksaHarga(
            $data,
            $data['periode_harian'],
            50000
        );
    }


    // ======================================================
    // TC-092: MENAMBAHKAN HARGA KAMAR PERIODE MINGGUAN
    // Harga: Rp300.000
    // ======================================================
    public function test_tc_092_admin_dapat_menambahkan_harga_kamar_periode_mingguan(): void
    {
        $data = $this->buatDataHargaKamar();

        $this->simpanDanPeriksaHarga(
            $data,
            $data['periode_mingguan'],
            300000
        );
    }


    // ======================================================
    // TC-093: MENAMBAHKAN HARGA KAMAR PERIODE BULANAN
    // Harga: Rp1.500.000
    // ======================================================
    public function test_tc_093_admin_dapat_menambahkan_harga_kamar_periode_bulanan(): void
    {
        $data = $this->buatDataHargaKamar();

        $this->simpanDanPeriksaHarga(
            $data,
            $data['periode_bulanan'],
            1500000
        );
    }


    // ======================================================
    // TC-094: MENAMBAHKAN HARGA KAMAR PERIODE 3 BULANAN
    // Harga: Rp4.300.000
    // ======================================================
    public function test_tc_094_admin_dapat_menambahkan_harga_kamar_periode_3_bulanan(): void
    {
        $data = $this->buatDataHargaKamar();

        $this->simpanDanPeriksaHarga(
            $data,
            $data['periode_tiga_bulan'],
            4300000
        );
    }


    // ======================================================
    // TC-095: MENAMBAHKAN HARGA KAMAR PERIODE 6 BULANAN
    // Harga: Rp8.400.000
    // ======================================================
    public function test_tc_095_admin_dapat_menambahkan_harga_kamar_periode_6_bulanan(): void
    {
        $data = $this->buatDataHargaKamar();

        $this->simpanDanPeriksaHarga(
            $data,
            $data['periode_enam_bulan'],
            8400000
        );
    }
    
    // ======================================================
// TC-096: MENAMBAHKAN HARGA KAMAR PERIODE TAHUNAN
// Harga: Rp17.000.000
// ======================================================
public function test_tc_096_admin_dapat_menambahkan_harga_kamar_periode_tahunan(): void
{
    $data = $this->buatDataHargaKamar();

    $periodeTahunan = PeriodePenagihan::firstOrCreate(
        ['periode_penagihan' => 'Tahunan'],
        [
            'jumlah_interval' => 1,
            'satuan_interval' => 'tahun',
        ]
    );

    $this->simpanDanPeriksaHarga(
        $data,
        $periodeTahunan,
        17000000
    );
}


// ======================================================
// TC-097: MENAMBAHKAN HARGA KAMAR DENGAN NOMINAL NEGATIF
// Harga: -500000
// ======================================================
public function test_tc_097_admin_tidak_dapat_menambahkan_harga_kamar_dengan_nominal_negatif(): void
{
    $data = $this->buatDataHargaKamar();

    $response = $this->actingAs($data['admin'])
        ->post(
            route('admin.kamar.harga.store', [
                'kamar' => $data['kamar']->id_kamar,
            ]),
            [
                'harga' => -500000,
                'id_periode' => $data['periode_bulanan']->id_penagihan,
                'isactive' => 1,
            ]
        );

    $response->assertSessionHasErrors(['harga']);

    $this->assertDatabaseCount('harga_kamars', 0);
}


// ======================================================
// TC-098: MENAMBAHKAN HARGA KAMAR DENGAN FORMAT BUKAN ANGKA
// Harga: Tiga ratus ribu
// ======================================================
public function test_tc_098_admin_tidak_dapat_menambahkan_harga_kamar_dengan_format_bukan_angka(): void
{
    $data = $this->buatDataHargaKamar();

    $response = $this->actingAs($data['admin'])
        ->post(
            route('admin.kamar.harga.store', [
                'kamar' => $data['kamar']->id_kamar,
            ]),
            [
                'harga' => 'Tiga ratus ribu',
                'id_periode' => $data['periode_mingguan']->id_penagihan,
                'isactive' => 1,
            ]
        );

    $response->assertSessionHasErrors(['harga']);

    $this->assertDatabaseCount('harga_kamars', 0);
}


// ======================================================
// TC-099: MENAMBAHKAN HARGA KAMAR TANPA MEMILIH PERIODE
// Periode: Tidak dipilih
// ======================================================
public function test_tc_099_admin_tidak_dapat_menambahkan_harga_kamar_tanpa_memilih_periode_pembayaran(): void
{
    $data = $this->buatDataHargaKamar();

    $response = $this->actingAs($data['admin'])
        ->post(
            route('admin.kamar.harga.store', [
                'kamar' => $data['kamar']->id_kamar,
            ]),
            [
                'harga' => 50000,
                'id_periode' => '',
                'isactive' => 1,
            ]
        );

    $response->assertSessionHasErrors(['id_periode']);

    $this->assertDatabaseCount('harga_kamars', 0);
}


// ======================================================
// TC-100: MENAMBAHKAN HARGA KAMAR TANPA MENGISI HARGA
// Harga: Kosong
// ======================================================
public function test_tc_100_admin_tidak_dapat_menambahkan_harga_kamar_tanpa_mengisi_harga(): void
{
    $data = $this->buatDataHargaKamar();

    $response = $this->actingAs($data['admin'])
        ->post(
            route('admin.kamar.harga.store', [
                'kamar' => $data['kamar']->id_kamar,
            ]),
            [
                'harga' => '',
                'id_periode' => $data['periode_tiga_bulan']->id_penagihan,
                'isactive' => 1,
            ]
        );

    $response->assertSessionHasErrors(['harga']);

    $this->assertDatabaseCount('harga_kamars', 0);
}

public function test_tc_101_admin_dapat_menambahkan_harga_kamar_dengan_status_nonaktif(): void
{
    $data = $this->buatDataHargaKamar();

    $response = $this->actingAs($data['admin'])
        ->post(route('admin.kamar.harga.store', [
            'kamar' => $data['kamar']->id_kamar,
        ]), [
            'harga' => 2000000,
            'id_periode' => $data['periode_tiga_bulan']->id_penagihan,
            'isactive' => 0,
        ]);

    $response->assertRedirect(route('admin.kamar.harga.index', [
        'kamar' => $data['kamar']->id_kamar,
    ]));

    $response->assertSessionHas('success', 'Harga ditambah.');

    $this->assertDatabaseHas('harga_kamars', [
        'id_kamar' => $data['kamar']->id_kamar,
        'harga' => 2000000,
        'id_periode' => $data['periode_tiga_bulan']->id_penagihan,
        'isactive' => 0,
    ]);

    $detail = $this->get(route('detailKamar', $data['kamar']->id_kamar));

    $detail->assertOk();
    $detail->assertDontSee('Rp 2.000.000');
}


public function test_tc_102_admin_dapat_mengedit_harga_dan_periode_pembayaran_kamar(): void
{
    $data = $this->buatDataHargaKamar();

    $harga = HargaKamar::create([
        'id_kamar' => $data['kamar']->id_kamar,
        'harga' => 2000000,
        'id_periode' => $data['periode_tiga_bulan']->id_penagihan,
        'isactive' => false,
    ]);

    $response = $this->actingAs($data['admin'])
        ->put(route('admin.kamar.harga.update', [
            'kamar' => $data['kamar']->id_kamar,
            'harga' => $harga->id_harga_kamar,
        ]), [
            'harga' => 650000,
            'id_periode' => $data['periode_bulanan']->id_penagihan,
            'isactive' => 1,
        ]);

    $response->assertRedirect(route('admin.kamar.harga.index', [
        'kamar' => $data['kamar']->id_kamar,
    ]));

    $response->assertSessionHas('success', 'Harga diperbarui.');

    $harga->refresh();

    $this->assertEquals(650000, (float) $harga->harga);
    $this->assertEquals(
        $data['periode_bulanan']->id_penagihan,
        $harga->id_periode
    );
    $this->assertTrue($harga->isactive);

    $detail = $this->get(route('detailKamar', $data['kamar']->id_kamar));

    $detail->assertOk();
    $detail->assertSee('Rp 650.000');
    $detail->assertSee('Bulanan');
}


public function test_tc_103_admin_tidak_dapat_mengedit_harga_kamar_menjadi_nilai_negatif(): void
{
    $data = $this->buatDataHargaKamar();

    $harga = HargaKamar::create([
        'id_kamar' => $data['kamar']->id_kamar,
        'harga' => 30000,
        'id_periode' => $data['periode_harian']->id_penagihan,
        'isactive' => true,
    ]);

    $response = $this->actingAs($data['admin'])
        ->put(route('admin.kamar.harga.update', [
            'kamar' => $data['kamar']->id_kamar,
            'harga' => $harga->id_harga_kamar,
        ]), [
            'harga' => -40000,
            'id_periode' => $data['periode_harian']->id_penagihan,
            'isactive' => 1,
        ]);

    $response->assertSessionHasErrors(['harga']);

    $this->assertDatabaseCount('harga_kamars', 1);

    $harga->refresh();

    $this->assertEquals(30000, (float) $harga->harga);
    $this->assertEquals(
        $data['periode_harian']->id_penagihan,
        $harga->id_periode
    );
}


public function test_tc_104_admin_dapat_mengubah_status_harga_kamar_dari_nonaktif_menjadi_aktif(): void
{
    $data = $this->buatDataHargaKamar();

    $harga = HargaKamar::create([
        'id_kamar' => $data['kamar']->id_kamar,
        'harga' => 650000,
        'id_periode' => $data['periode_bulanan']->id_penagihan,
        'isactive' => false,
    ]);

    $response = $this->actingAs($data['admin'])
        ->put(route('admin.kamar.harga.update', [
            'kamar' => $data['kamar']->id_kamar,
            'harga' => $harga->id_harga_kamar,
        ]), [
            'harga' => 650000,
            'id_periode' => $data['periode_bulanan']->id_penagihan,
            'isactive' => 1,
        ]);

    $response->assertRedirect(route('admin.kamar.harga.index', [
        'kamar' => $data['kamar']->id_kamar,
    ]));

    $response->assertSessionHas('success', 'Harga diperbarui.');

    $harga->refresh();

    $this->assertTrue($harga->isactive);

    $detail = $this->get(route('detailKamar', $data['kamar']->id_kamar));

    $detail->assertOk();
    $detail->assertSee('Rp 650.000');
    $detail->assertSee('Bulanan');
}


public function test_tc_105_admin_dapat_menghapus_harga_kamar(): void
{
    $data = $this->buatDataHargaKamar();

    $harga = HargaKamar::create([
        'id_kamar' => $data['kamar']->id_kamar,
        'harga' => 500000,
        'id_periode' => $data['periode_bulanan']->id_penagihan,
        'isactive' => true,
    ]);

    $response = $this->actingAs($data['admin'])
        ->delete(route('admin.kamar.harga.destroy', [
            'kamar' => $data['kamar']->id_kamar,
            'harga' => $harga->id_harga_kamar,
        ]));

    $response->assertStatus(302);
    $response->assertSessionHas('success', 'Harga dihapus.');

    $this->assertDatabaseMissing('harga_kamars', [
        'id_harga_kamar' => $harga->id_harga_kamar,
    ]);

    $this->assertDatabaseCount('harga_kamars', 0);
}

public function test_tc_106_admin_tidak_dapat_mengakses_harga_kamar_milik_kos_lain(): void
{
    // Membuat Admin Kos A beserta data kos dan kamar miliknya.
    $data = $this->buatDataHargaKamar();

    // Membuat Admin Kos B.
    $adminLain = User::create([
        'username' => 'admin_kos_lain',
        'nik' => '3507010101010002',
        'nama' => 'Admin Kos Lain',
        'password' => bcrypt('password123'),
        'no_hp' => '085733553161',
        'role' => 'admin kost',
        'status' => 'aktif',
        'must_change_password' => false,
    ]);

    // Membuat kos milik Admin Kos B.
    $kostLain = Kost::create([
        'nama_kost' => 'Kos Melati',
        'alamat' => 'Jl. Raya Banyuwangi',
        'deskripsi' => 'Kos milik admin lain',
        'foto_kost' => [],
        'lokasi' => 'https://maps.google.com/',
        'id_user' => $adminLain->id,
    ]);

    // Membuat kamar milik Admin Kos B.
    $kamarLain = KamarKost::create([
        'id_kost' => $kostLain->id,
        'nama_kamar' => 'Kamar Melati',
        'nomor_kamar' => '01',
        'ukuran_kamar' => '3x3 meter',
        'foto_kamar' => [],
    ]);

    // Membuat harga kamar milik Admin Kos B.
    $hargaLain = HargaKamar::create([
        'id_kamar' => $kamarLain->id_kamar,
        'harga' => 500000,
        'id_periode' => $data['periode_bulanan']->id_penagihan,
        'isactive' => true,
    ]);

    // Login sebagai Admin Kos A.
    $adminA = $this->actingAs($data['admin']);

    // Admin A mencoba membuka halaman harga kamar milik Admin B.
    $responseIndex = $adminA->get(
        route('admin.kamar.harga.index', [
            'kamar' => $kamarLain->id_kamar,
        ])
    );

    $responseIndex->assertForbidden();

    // Admin A mencoba membuka form edit harga milik Admin B.
    $responseEdit = $adminA->get(
        route('admin.kamar.harga.edit', [
            'kamar' => $kamarLain->id_kamar,
            'harga' => $hargaLain->id_harga_kamar,
        ])
    );

    $responseEdit->assertForbidden();

    // Admin A mencoba mengubah harga milik Admin B.
    $responseUpdate = $adminA->put(
        route('admin.kamar.harga.update', [
            'kamar' => $kamarLain->id_kamar,
            'harga' => $hargaLain->id_harga_kamar,
        ]),
        [
            'harga' => 650000,
            'id_periode' => $data['periode_bulanan']->id_penagihan,
            'isactive' => 1,
        ]
    );

    $responseUpdate->assertForbidden();

    // Admin A mencoba menghapus harga milik Admin B.
    $responseDelete = $adminA->delete(
        route('admin.kamar.harga.destroy', [
            'kamar' => $kamarLain->id_kamar,
            'harga' => $hargaLain->id_harga_kamar,
        ])
    );

    $responseDelete->assertForbidden();

    // Memastikan harga milik Admin B tetap tersimpan dan tidak berubah.
    $this->assertDatabaseHas('harga_kamars', [
        'id_harga_kamar' => $hargaLain->id_harga_kamar,
        'id_kamar' => $kamarLain->id_kamar,
        'harga' => 500000,
    ]);
}
}