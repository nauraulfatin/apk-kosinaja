<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kost;
use App\Models\Fasilitas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class InformasiKosTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Membuat admin kos, data kos, dan fasilitas dummy.
     */
    private function buatDataKos()
    {
        $admin = User::create([
            'username' => 'admin_jelita',
            'nik' => '3507010101010001',
            'nama' => 'Admin Kos Jelita',
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

        $fasilitas = collect([
            'Tempat Parkir',
            'Musholla',
            'Dapur Bersama',
            'Kulkas',
            'Ruang Tamu',
        ])->map(function ($nama) {
            return Fasilitas::create([
                'nama_fasilitas' => $nama,
            ]);
        });

        $kost->fasilitas()->attach(
            $fasilitas->pluck('id_fasilitas')->toArray()
        );

        return [
            'admin' => $admin,
            'kost' => $kost,
            'fasilitas' => $fasilitas,
        ];
    }

    /**
     * TC-061
     * Melihat Informasi Kos.
     */
    public function test_admin_dapat_melihat_informasi_kos()
    {
        $data = $this->buatDataKos();

        $response = $this->actingAs($data['admin'])
            ->get(route('admin.kost.index'));

        $response->assertStatus(200);
        $response->assertSee('Kos Jelita');
        $response->assertSee('Jl. Raya Jember No. KM 13, Banyuwangi');
        $response->assertSee('Kos Khusus Putri Nyaman');
    }

    /**
     * TC-062
     * Mengedit Informasi Kos dengan Seluruh Data Valid.
     */
    public function test_admin_dapat_mengedit_informasi_kos_dengan_data_valid()
    {
        $data = $this->buatDataKos();

        $response = $this->actingAs($data['admin'])
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '085733553160',
                'alamat' => 'Jl. Raya Jember No. KM 13, Desa Labanasem, Kecamatan Kabat, Kabupaten Banyuwangi',
                'deskripsi' => 'Kos Khusus Putri Nyaman, 2 Lantai, Dekat dengan Kampus Politeknik Negeri Banyuwangi',
                'lokasi' => 'https://maps.google.com/',
                'fasilitas' => $data['fasilitas']->pluck('id_fasilitas')->toArray(),
            ]);

        $response->assertRedirect(route('admin.kost.index'));
        $response->assertSessionHas(
            'success',
            'Informasi kost berhasil diperbarui.'
        );

        $this->assertDatabaseHas('kosts', [
            'id' => $data['kost']->id,
            'nama_kost' => 'Kos Jelita',
            'alamat' => 'Jl. Raya Jember No. KM 13, Desa Labanasem, Kecamatan Kabat, Kabupaten Banyuwangi',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $data['admin']->id,
            'no_hp' => '085733553160',
        ]);
    }

    /**
     * TC-063
     * Mengedit Informasi Kos tanpa Mengisi Nama Kos.
     */
    public function test_admin_tidak_dapat_mengedit_kos_tanpa_nama_kos()
    {
        $data = $this->buatDataKos();

        $response = $this->actingAs($data['admin'])
            ->from(route('admin.kost.edit'))
            ->put(route('admin.kost.update'), [
                'nama_kost' => '',
                'no_hp' => '085733553160',
                'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
                'deskripsi' => 'Kos Khusus Putri Nyaman',
            ]);

        $response->assertSessionHasErrors('nama_kost');

        $this->assertDatabaseHas('kosts', [
            'id' => $data['kost']->id,
            'nama_kost' => 'Kos Jelita',
        ]);
    }

    /**
     * TC-064
     * Mengedit Informasi Kos dengan Nama Kos lebih dari 100 Karakter.
     */
    public function test_admin_tidak_dapat_mengedit_kos_dengan_nama_lebih_dari_100_karakter()
    {
        $data = $this->buatDataKos();

        $response = $this->actingAs($data['admin'])
            ->from(route('admin.kost.edit'))
            ->put(route('admin.kost.update'), [
                'nama_kost' => str_repeat('A', 101),
                'no_hp' => '085733553160',
                'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
                'deskripsi' => 'Kos Khusus Putri Nyaman',
            ]);

        $response->assertSessionHasErrors('nama_kost');

        $this->assertDatabaseHas('kosts', [
            'id' => $data['kost']->id,
            'nama_kost' => 'Kos Jelita',
        ]);
    }

    /**
     * TC-065
     * Mengedit Informasi Kos dengan Menghapus Nomor WhatsApp.
     */
    public function test_admin_tidak_dapat_mengedit_kos_tanpa_nomor_whatsapp()
    {
        $data = $this->buatDataKos();

        $response = $this->actingAs($data['admin'])
            ->from(route('admin.kost.edit'))
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '',
                'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
                'deskripsi' => 'Kos Khusus Putri Nyaman',
            ]);

        $response->assertSessionHasErrors('no_hp');

        $this->assertDatabaseHas('users', [
            'id' => $data['admin']->id,
            'no_hp' => '085733553160',
        ]);
    }
    
    /**
     * TC-066
     * Mengedit Informasi Kos dengan Nomor WhatsApp kurang dari 10 digit.
     */
    public function test_admin_tidak_dapat_mengedit_kos_dengan_nomor_whatsapp_kurang_dari_10_digit()
    {
        $data = $this->buatDataKos();

        $response = $this->actingAs($data['admin'])
            ->from(route('admin.kost.edit'))
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '085733553',
                'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
                'deskripsi' => 'Kos Khusus Putri Nyaman',
            ]);

        $response->assertSessionHasErrors('no_hp');

        $this->assertDatabaseHas('users', [
            'id' => $data['admin']->id,
            'no_hp' => '085733553160',
        ]);
    }

    /**
     * TC-067
     * Mengedit Informasi Kos dengan Nomor WhatsApp lebih dari 13 digit.
     */
    public function test_admin_tidak_dapat_mengedit_kos_dengan_nomor_whatsapp_lebih_dari_13_digit()
    {
        $data = $this->buatDataKos();

        $response = $this->actingAs($data['admin'])
            ->from(route('admin.kost.edit'))
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '08573355316098',
                'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
                'deskripsi' => 'Kos Khusus Putri Nyaman',
            ]);

        $response->assertSessionHasErrors('no_hp');

        $this->assertDatabaseHas('users', [
            'id' => $data['admin']->id,
            'no_hp' => '085733553160',
        ]);
    }

    /**
     * TC-068
     * Mengedit Informasi Kos dengan Menghapus Alamat Kos.
     */
    public function test_admin_tidak_dapat_mengedit_kos_tanpa_alamat()
    {
        $data = $this->buatDataKos();

        $response = $this->actingAs($data['admin'])
            ->from(route('admin.kost.edit'))
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '085733553160',
                'alamat' => '',
                'deskripsi' => 'Kos Khusus Putri Nyaman',
            ]);

        $response->assertSessionHasErrors('alamat');

        $this->assertDatabaseHas('kosts', [
            'id' => $data['kost']->id,
            'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
        ]);
    }

    /**
     * TC-069
     * Mengedit Informasi Kos dengan Alamat lebih dari 300 karakter.
     */
    public function test_admin_tidak_dapat_mengedit_kos_dengan_alamat_lebih_dari_300_karakter()
    {
        $data = $this->buatDataKos();

        $alamatPanjang = 'Kos Putra Barokah, Jalan Letnan Jenderal Raden Suprapto Gang Haji Umar Nomor 123A, RT 012/RW 009, Blok C Lantai 2, Dusun Karangwuni Barat, Kelurahan Watunggarandu, Kecamatan Lalonggasumeeto, Kabupaten Konawe, Provinsi Sulawesi Tenggara, Kode Pos 93351, Republik Indonesia. (Patokan: Masuk gang sebelah toko bangunan, cat rumah warna pagar hijau)';

        $response = $this->actingAs($data['admin'])
            ->from(route('admin.kost.edit'))
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '085733553160',
                'alamat' => $alamatPanjang,
                'deskripsi' => 'Kos Khusus Putri Nyaman',
            ]);

        $response->assertSessionHasErrors('alamat');

        $this->assertDatabaseHas('kosts', [
            'id' => $data['kost']->id,
            'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
        ]);
    }

    /**
     * TC-070
     * Mengedit Informasi Kos dengan Deskripsi lebih dari 2000 karakter.
     */
    public function test_admin_tidak_dapat_mengedit_kos_dengan_deskripsi_lebih_dari_2000_karakter()
    {
        $data = $this->buatDataKos();

        $deskripsiPanjang = str_repeat('A', 2001);

        $response = $this->actingAs($data['admin'])
            ->from(route('admin.kost.edit'))
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '085733553160',
                'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
                'deskripsi' => $deskripsiPanjang,
            ]);

        $response->assertSessionHasErrors('deskripsi');

        $this->assertDatabaseHas('kosts', [
            'id' => $data['kost']->id,
            'deskripsi' => 'Kos Khusus Putri Nyaman',
        ]);
    }


    /**
     * TC-071
     * Mengunggah foto dengan format tidak valid.
     */
    public function test_admin_tidak_dapat_mengunggah_foto_dengan_format_tidak_valid()
    {
        $data = $this->buatDataKos();

        $fotoAwal = $data['kost']->fresh()->foto_kost;

        $response = $this->actingAs($data['admin'])
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '085733553160',
                'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
                'deskripsi' => 'Kos Khusus Putri Nyaman',
                'lokasi' => 'https://maps.google.com/',
                'fasilitas' => $data['fasilitas']
                    ->pluck('id_fasilitas')
                    ->toArray(),
                'foto_kost' => [
                    UploadedFile::fake()->create(
                        'dokumen.pdf',
                        100,
                        'application/pdf'
                    ),
                ],
            ]);

        $response->assertSessionHasErrors(['foto_kost.0']);

        $this->assertSame(
            $fotoAwal,
            $data['kost']->fresh()->foto_kost
        );

        $this->assertDatabaseHas('kosts', [
            'id' => $data['kost']->id,
            'nama_kost' => 'Kos Jelita',
        ]);
    }

    /**
     * TC-072
     * Mengunggah lebih dari 10 foto.
     */
    public function test_admin_tidak_dapat_mengunggah_lebih_dari_10_foto()
    {
        $data = $this->buatDataKos();

        $fotoAwal = $data['kost']->fresh()->foto_kost;

        $daftarFoto = [];

        for ($i = 1; $i <= 11; $i++) {
            $daftarFoto[] = UploadedFile::fake()->image(
                'foto-' . $i . '.jpg'
            );
        }

        $response = $this->actingAs($data['admin'])
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '085733553160',
                'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
                'deskripsi' => 'Kos Khusus Putri Nyaman',
                'lokasi' => 'https://maps.google.com/',
                'fasilitas' => $data['fasilitas']
                    ->pluck('id_fasilitas')
                    ->toArray(),
                'foto_kost' => $daftarFoto,
            ]);

        $response->assertSessionHasErrors(['foto_kost']);

        $this->assertSame(
            $fotoAwal,
            $data['kost']->fresh()->foto_kost
        );

        $this->assertDatabaseHas('kosts', [
            'id' => $data['kost']->id,
            'nama_kost' => 'Kos Jelita',
        ]);
    }

    /**
     * TC-073
     * Mengunggah foto dengan ukuran lebih dari 10 MB.
     */
    public function test_admin_tidak_dapat_mengunggah_foto_lebih_dari_10_mb()
    {
        $data = $this->buatDataKos();

        $fotoAwal = $data['kost']->fresh()->foto_kost;

        $fotoBesar = UploadedFile::fake()
            ->image('foto-besar.jpg')
            ->size(10241);

        $response = $this->actingAs($data['admin'])
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '085733553160',
                'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
                'deskripsi' => 'Kos Khusus Putri Nyaman',
                'lokasi' => 'https://maps.google.com/',
                'fasilitas' => $data['fasilitas']
                    ->pluck('id_fasilitas')
                    ->toArray(),
                'foto_kost' => [$fotoBesar],
            ]);

        $response->assertSessionHasErrors(['foto_kost.0']);

        $this->assertSame(
            $fotoAwal,
            $data['kost']->fresh()->foto_kost
        );

        $this->assertDatabaseHas('kosts', [
            'id' => $data['kost']->id,
            'nama_kost' => 'Kos Jelita',
        ]);
    }

    /**
     * TC-074
     * Menghapus foto kos yang sudah tersimpan.
     */
    public function test_admin_dapat_menghapus_foto_kos()
    {
        Storage::fake('public');

        $data = $this->buatDataKos();

        $fotoDihapus = 'kost/foto-lama.jpg';
        $fotoDipertahankan = 'kost/foto-tetap.jpg';

        Storage::disk('public')->put($fotoDihapus, 'isi foto lama');
        Storage::disk('public')->put($fotoDipertahankan, 'isi foto tetap');

        $data['kost']->update([
            'foto_kost' => [
                $fotoDihapus,
                $fotoDipertahankan,
            ],
        ]);

        $response = $this->actingAs($data['admin'])
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '085733553160',
                'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
                'deskripsi' => 'Kos Khusus Putri Nyaman',
                'lokasi' => 'https://maps.google.com/',
                'fasilitas' => $data['fasilitas']
                    ->pluck('id_fasilitas')
                    ->toArray(),
                'deleted_old_images' => json_encode([
                    $fotoDihapus,
                ]),
            ]);

        $response->assertRedirect(route('admin.kost.index'));

        $response->assertSessionHas(
            'success',
            'Informasi kost berhasil diperbarui.'
        );

       $this->assertSame(
    [$fotoDipertahankan],
    $data['kost']->fresh()->foto_kost
);

$this->assertFalse(
    Storage::disk('public')->exists($fotoDihapus)
);

$this->assertTrue(
    Storage::disk('public')->exists($fotoDipertahankan)
);
    }

    /**
     * TC-075
     * Menambahkan foto JPG ke informasi kos.
     */
    public function test_admin_dapat_menambahkan_foto_jpg()
    {
        Storage::fake('public');

        $data = $this->buatDataKos();

        $fotoLama = 'kost/foto-lama.jpg';

        Storage::disk('public')->put($fotoLama, 'isi foto lama');

        $data['kost']->update([
            'foto_kost' => [$fotoLama],
        ]);

        $fotoBaru = UploadedFile::fake()
            ->image('foto-baru.jpg');

        $response = $this->actingAs($data['admin'])
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '085733553160',
                'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
                'deskripsi' => 'Kos Khusus Putri Nyaman',
                'lokasi' => 'https://maps.google.com/',
                'fasilitas' => $data['fasilitas']
                    ->pluck('id_fasilitas')
                    ->toArray(),
                'foto_kost' => [$fotoBaru],
            ]);

        $response->assertRedirect(route('admin.kost.index'));

        $response->assertSessionHas(
            'success',
            'Informasi kost berhasil diperbarui.'
        );

       $fotoTersimpan = $data['kost']->fresh()->foto_kost;

$this->assertCount(2, $fotoTersimpan);
$this->assertContains($fotoLama, $fotoTersimpan);

$this->assertTrue(
    Storage::disk('public')->exists($fotoLama)
);

$this->assertTrue(
    Storage::disk('public')->exists($fotoTersimpan[1])
);
    }


    /**
     * TC-076
     * Menambahkan foto JPEG ke informasi kos.
     */
    public function test_admin_dapat_menambahkan_foto_jpeg()
    {
        Storage::fake('public');

        $data = $this->buatDataKos();

        $fotoBaru = UploadedFile::fake()
            ->image('foto-baru.jpeg');

        $response = $this->actingAs($data['admin'])
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '085733553160',
                'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
                'deskripsi' => 'Kos Khusus Putri Nyaman',
                'lokasi' => 'https://maps.google.com/',
                'fasilitas' => $data['fasilitas']
                    ->pluck('id_fasilitas')
                    ->toArray(),
                'foto_kost' => [$fotoBaru],
            ]);

        $response->assertRedirect(route('admin.kost.index'));

        $response->assertSessionHas(
            'success',
            'Informasi kost berhasil diperbarui.'
        );

        $fotoTersimpan = $data['kost']->fresh()->foto_kost;

        $this->assertCount(1, $fotoTersimpan);

        $this->assertTrue(
            Storage::disk('public')->exists($fotoTersimpan[0])
        );

        $halamanInformasi = $this->actingAs($data['admin'])
            ->get(route('admin.kost.index'));

        $halamanInformasi->assertStatus(200);
        $halamanInformasi->assertSee($fotoTersimpan[0]);
    }

    /**
     * TC-077
     * Menambahkan foto PNG ke informasi kos.
     */
    public function test_admin_dapat_menambahkan_foto_png()
    {
        Storage::fake('public');

        $data = $this->buatDataKos();

        $fotoBaru = UploadedFile::fake()
            ->image('foto-baru.png');

        $response = $this->actingAs($data['admin'])
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '085733553160',
                'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
                'deskripsi' => 'Kos Khusus Putri Nyaman',
                'lokasi' => 'https://maps.google.com/',
                'fasilitas' => $data['fasilitas']
                    ->pluck('id_fasilitas')
                    ->toArray(),
                'foto_kost' => [$fotoBaru],
            ]);

        $response->assertRedirect(route('admin.kost.index'));

        $response->assertSessionHas(
            'success',
            'Informasi kost berhasil diperbarui.'
        );

        $fotoTersimpan = $data['kost']->fresh()->foto_kost;

        $this->assertCount(1, $fotoTersimpan);

        $this->assertTrue(
            Storage::disk('public')->exists($fotoTersimpan[0])
        );

        $halamanInformasi = $this->actingAs($data['admin'])
            ->get(route('admin.kost.index'));

        $halamanInformasi->assertStatus(200);
        $halamanInformasi->assertSee($fotoTersimpan[0]);
    }

    /**
     * TC-078
     * Menghapus fasilitas Ruang Tamu dan Musholla.
     */
    public function test_admin_dapat_menghapus_fasilitas_kos()
    {
        $data = $this->buatDataKos();

        $namaFasilitasDihapus = [
            'Ruang Tamu',
            'Musholla',
        ];

        $fasilitasDihapus = $data['fasilitas']
            ->whereIn('nama_fasilitas', $namaFasilitasDihapus);

        $fasilitasDipertahankan = $data['fasilitas']
            ->whereNotIn('nama_fasilitas', $namaFasilitasDihapus);

        $response = $this->actingAs($data['admin'])
            ->put(route('admin.kost.update'), [
                'nama_kost' => 'Kos Jelita',
                'no_hp' => '085733553160',
                'alamat' => 'Jl. Raya Jember No. KM 13, Banyuwangi',
                'deskripsi' => 'Kos Khusus Putri Nyaman',
                'lokasi' => 'https://maps.google.com/',
                'fasilitas' => $fasilitasDipertahankan
                    ->pluck('id_fasilitas')
                    ->toArray(),
            ]);

        $response->assertRedirect(route('admin.kost.index'));

        $response->assertSessionHas(
            'success',
            'Informasi kost berhasil diperbarui.'
        );

        // Memastikan fasilitas yang dihapus sudah tidak ada.
        foreach ($fasilitasDihapus as $fasilitas) {
            $this->assertDatabaseMissing('fasilitas_kost', [
                'id_kost' => $data['kost']->id,
                'id_fasilitas' => $fasilitas->id_fasilitas,
            ]);
        }

        // Memastikan fasilitas lainnya tetap tersimpan.
        foreach ($fasilitasDipertahankan as $fasilitas) {
            $this->assertDatabaseHas('fasilitas_kost', [
                'id_kost' => $data['kost']->id,
                'id_fasilitas' => $fasilitas->id_fasilitas,
            ]);
        }
    }

}