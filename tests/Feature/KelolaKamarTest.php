<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kost;
use App\Models\Fasilitas;
use App\Models\KamarKost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class KelolaKamarTest extends TestCase //menampung pengujian data kamar
{
    use RefreshDatabase; //bisa digunakan di data lain

    protected function setUp(): void //kondisi awal sebelum test dijalankan 
    {
        parent::setUp();

        Storage::fake('public');
    }

    private function buatDataKamar(): array // data dummy untuk pengujian kamar
    {
        $admin = User::create([ //tabel baru
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
            'alamat' => 'Jl. Raya Jember No. KM 13',
            'deskripsi' => 'Kos nyaman',
            'foto_kost' => [],
            'lokasi' => 'https://maps.google.com/',
            'id_user' => $admin->id,
        ]);

        $fasilitas = collect([
            'Spring Bed',
            'Lemari',
            'AC',
        ])->map(function ($nama) { //memproses setiap fasilitas satu persatu scr otomatis tanpa
            return Fasilitas::create([
                'nama_fasilitas' => $nama,
            ]);
        });

        return compact('admin', 'kost', 'fasilitas'); //menggabungkan jadi 1 jadi kalo memanggil gapelru satu"
    }

    private function fotoPngValid(): UploadedFile
    {
        $isiPng = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/f+QAAAAASUVORK5CYII='
        );

        return UploadedFile::fake()->createWithContent( // nama dan isi yg sudah ditemukan
            'foto-kamar.png', //hasil
            $isiPng
        );
    }

    private function dataKamar($fasilitas, array $tambahan = []): array
    {
        return array_merge([ // data kamar diubah sesuai kebutuhan (digabungkan)
            'nama_kamar' => 'Kamar Jelita',
            'nomor_kamar' => '01',
            'ukuran_kamar' => '3x3 meter',
            'fasilitas' => $fasilitas->pluck('id_fasilitas')->toArray(),
            'foto_kamar' => [
                $this->fotoPngValid(), //dlm bentuk array
            ],
        ], $tambahan);
    }

    // TC-079: Menambahkan kamar dengan data valid
    public function test_tc_079_admin_dapat_menambahkan_kamar_dengan_data_valid(): void
    {
        $data = $this->buatDataKamar();

        $response = $this->actingAs($data['admin'])
            ->post( 
                route('admin.kamar.store'),
                $this->dataKamar($data['fasilitas']) //menyiapkan data yg akan dikirim 
            );

        $response->assertRedirect(route('admin.kamar.index')); //penambahan kamar berhasil  
        $response->assertSessionHas( //pesan berhasil
            'success',
            'Kamar berhasil ditambahkan.'
        ); //jadi tidak hanya back ke halman admin tpi juga ngasih info beerhasil

        $this->assertDatabaseHas('kamar_kosts', [ //apakah benar data tersimpan di DB
            'id_kost' => $data['kost']->id, //ambil id otomatis dari data kost yg dibuat diawal
            'nama_kamar' => 'Kamar Jelita',
            'nomor_kamar' => '01',
            'ukuran_kamar' => '3x3 meter',
        ]);

        $kamar = KamarKost::where( //mengambil data kamar yg sdh tersimpan
            'id_kost',
            $data['kost']->id
        )->firstOrFail(); // mencari data pertama yg ditemukan kemudian disimpan dlm var kamar

        $this->assertNotEmpty($kamar->foto_kamar); //memeriksa apakah foto kamar tidak kosogn

        $this->assertTrue(
            Storage::disk('public')->exists($kamar->foto_kamar[0]) //apakah foto benar" tersimpan di storage
        );

        $this->assertEqualsCanonicalizing( //memeriksah apakah fasilitas sdh terhubung
            $data['fasilitas']->pluck('id_fasilitas')->toArray(),
            $kamar->fasilitas()->pluck('fasilitas.id_fasilitas')->toArray() //mengambol id yg sdh terhubung di kamar dengan relasi model
        );
    }

    // TC-080: Menambahkan kamar tanpa mengisi nama kamar
    public function test_tc_080_admin_tidak_dapat_menambahkan_kamar_tanpa_nama(): void
    {
        $data = $this->buatDataKamar();

        $response = $this->actingAs($data['admin'])
            ->post(
                route('admin.kamar.store'),
                $this->dataKamar($data['fasilitas'], [
                    'nama_kamar' => '',
                ])
            );

        $response->assertSessionHasErrors(['nama_kamar']);

        $this->assertDatabaseCount('kamar_kosts', 0);
    }

    // TC-081: Nama kamar lebih dari 100 karakter
    public function test_tc_081_admin_tidak_dapat_mengisi_nama_kamar_lebih_dari_100_karakter(): void
    {
        $data = $this->buatDataKamar();

        $response = $this->actingAs($data['admin'])
            ->post(
                route('admin.kamar.store'),
                $this->dataKamar($data['fasilitas'], [
                    'nama_kamar' => str_repeat('A', 101),
                ])
            );

        $response->assertSessionHasErrors(['nama_kamar']);

        $this->assertDatabaseCount('kamar_kosts', 0);
    }

    // TC-082: Nomor kamar tidak diisi
public function test_tc_082_admin_tidak_dapat_menambahkan_kamar_tanpa_nomor(): void
{
    $data = $this->buatDataKamar();

    $response = $this->actingAs($data['admin'])
        ->post(
            route('admin.kamar.store'),
            $this->dataKamar($data['fasilitas'], [
                'nomor_kamar' => '',
            ])
        );

    $response->assertSessionHasErrors(['nomor_kamar']);

    $this->assertDatabaseCount('kamar_kosts', 0);
}


// TC-083: Nomor kamar lebih dari 5 karakter
public function test_tc_083_admin_tidak_dapat_mengisi_nomor_kamar_lebih_dari_5_karakter(): void
{
    $data = $this->buatDataKamar();

    $response = $this->actingAs($data['admin'])
        ->post(
            route('admin.kamar.store'),
            $this->dataKamar($data['fasilitas'], [
                'nomor_kamar' => 'A01234',
            ])
        );

    $response->assertSessionHasErrors(['nomor_kamar']);

    $this->assertDatabaseCount('kamar_kosts', 0);
}


// TC-084: Nomor kamar sudah digunakan
public function test_tc_084_admin_tidak_dapat_menggunakan_nomor_kamar_yang_sudah_digunakan(): void
{
    $data = $this->buatDataKamar();

    // Membuat kamar lama dengan nomor 01
    KamarKost::create([
        'id_kost' => $data['kost']->id,
        'nama_kamar' => 'Kamar Lama',
        'nomor_kamar' => '01',
        'ukuran_kamar' => '3x3 meter',
        'foto_kamar' => [],
    ]);

    // Mencoba menambahkan kamar dengan nomor yang sama
    $response = $this->actingAs($data['admin'])
        ->post(
            route('admin.kamar.store'),
            $this->dataKamar($data['fasilitas'], [
                'nama_kamar' => 'Kamar Mawar',
                'nomor_kamar' => '01',
            ])
        );

    $response->assertSessionHasErrors(['nomor_kamar']);

    // Kamar baru tidak boleh tersimpan
    $this->assertDatabaseCount('kamar_kosts', 1);
}


// TC-085: Ukuran kamar lebih dari 100 karakter
public function test_tc_085_admin_tidak_dapat_mengisi_ukuran_kamar_lebih_dari_100_karakter(): void
{
    $data = $this->buatDataKamar();

    $response = $this->actingAs($data['admin'])
        ->post(
            route('admin.kamar.store'),
            $this->dataKamar($data['fasilitas'], [
                'nama_kamar' => 'Kamar Mawar',
                'nomor_kamar' => '02',
                'ukuran_kamar' => str_repeat('A', 101),
            ])
        );

    $response->assertSessionHasErrors(['ukuran_kamar']);

    $this->assertDatabaseCount('kamar_kosts', 0);
}

// ======================================================
// TC-086: MENAMBAHKAN KAMAR DENGAN FOTO JPG <5MB
// ======================================================
public function test_tc_086_admin_dapat_menambahkan_kamar_dengan_foto_jpg_kurang_dari_5_mb(): void
{
    Storage::fake('public');

    $data = $this->buatDataKamar();

    $payload = $this->dataKamar($data['fasilitas']);
    $payload['foto_kamar'] = [
        UploadedFile::fake()->createWithContent(
            'foto.jpg',
            $this->isiJpgValidUntukTc()
        ),
    ];

    $response = $this->actingAs($data['admin'])
        ->post(route('admin.kamar.store'), $payload);

    $response->assertRedirect(route('admin.kamar.index'));
    $response->assertSessionHas('success', 'Kamar berhasil ditambahkan.');

    $this->assertDatabaseCount('kamar_kosts', 1);

    $kamar = KamarKost::first();

    $this->assertNotEmpty($kamar->foto_kamar);

    $this->assertTrue(
        Storage::disk('public')->exists($kamar->foto_kamar[0]),
        'File foto JPG tidak ditemukan di storage public.'
    );
}


// ======================================================
// TC-087: MENAMBAHKAN KAMAR DENGAN FOTO JPEG <5MB
// ======================================================
public function test_tc_087_admin_dapat_menambahkan_kamar_dengan_foto_jpeg_kurang_dari_5_mb(): void
{
    Storage::fake('public');

    $data = $this->buatDataKamar();

    $payload = $this->dataKamar($data['fasilitas']);
    $payload['foto_kamar'] = [
        UploadedFile::fake()->createWithContent(
            'foto.jpeg',
            $this->isiJpgValidUntukTc()
        ),
    ];

    $response = $this->actingAs($data['admin'])
        ->post(route('admin.kamar.store'), $payload);

    $response->assertRedirect(route('admin.kamar.index'));
    $response->assertSessionHas('success', 'Kamar berhasil ditambahkan.');

    $this->assertDatabaseCount('kamar_kosts', 1);

    $kamar = KamarKost::first();

    $this->assertNotEmpty($kamar->foto_kamar);

    $this->assertTrue(
        Storage::disk('public')->exists($kamar->foto_kamar[0]),
        'File foto JPEG tidak ditemukan di storage public.'
    );
}


// ======================================================
// TC-088: MENAMBAHKAN KAMAR DENGAN FOTO PNG <5MB
// ======================================================
public function test_tc_088_admin_dapat_menambahkan_kamar_dengan_foto_png_kurang_dari_5_mb(): void
{
    Storage::fake('public');

    $data = $this->buatDataKamar();

    $payload = $this->dataKamar($data['fasilitas']);
    $payload['foto_kamar'] = [
        UploadedFile::fake()->createWithContent(
            'foto.png',
            $this->isiPngValidUntukTc()
        ),
    ];

    $response = $this->actingAs($data['admin'])
        ->post(route('admin.kamar.store'), $payload);

    $response->assertRedirect(route('admin.kamar.index'));
    $response->assertSessionHas('success', 'Kamar berhasil ditambahkan.');

    $this->assertDatabaseCount('kamar_kosts', 1);

    $kamar = KamarKost::first();

    $this->assertNotEmpty($kamar->foto_kamar);

    $this->assertTrue(
        Storage::disk('public')->exists($kamar->foto_kamar[0]),
        'File foto PNG tidak ditemukan di storage public.'
    );
}


// ======================================================
// TC-089: MENAMBAHKAN KAMAR DENGAN FORMAT FOTO TIDAK VALID
// ======================================================
public function test_tc_089_admin_tidak_dapat_mengunggah_foto_dengan_format_tidak_valid(): void
{
    $data = $this->buatDataKamar();

    $payload = $this->dataKamar($data['fasilitas']);
    $payload['foto_kamar'] = [
        UploadedFile::fake()->createWithContent(
            'dokumen.pdf',
            "%PDF-1.4\nDokumen PDF untuk pengujian."
        ),
    ];

    $response = $this->actingAs($data['admin'])
        ->post(route('admin.kamar.store'), $payload);

    $response->assertSessionHasErrors(['foto_kamar.0']);

    $this->assertDatabaseCount('kamar_kosts', 0);
}


// ======================================================
// TC-090: MENAMBAHKAN KAMAR DENGAN UKURAN FOTO >5MB
// ======================================================
public function test_tc_090_admin_tidak_dapat_mengunggah_foto_kamar_lebih_dari_5_mb(): void
{
    $data = $this->buatDataKamar();

    $isiJpg = $this->isiJpgValidUntukTc();

    // Membuat ukuran file lebih dari 5 MB
    $isiFotoBesar = $isiJpg . str_repeat(
        'A',
        (5 * 1024 * 1024) + 1024
    );

    $payload = $this->dataKamar($data['fasilitas']);
    $payload['foto_kamar'] = [
        UploadedFile::fake()->createWithContent(
            'foto.jpg',
            $isiFotoBesar
        ),
    ];

    $response = $this->actingAs($data['admin'])
        ->post(route('admin.kamar.store'), $payload);

    $response->assertSessionHasErrors(['foto_kamar.0']);

    $this->assertDatabaseCount('kamar_kosts', 0);
}


// ======================================================
// HELPER: ISI FILE JPG VALID
// ======================================================
private function isiJpgValidUntukTc(): string
{
    return base64_decode(
        '/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAABAAEDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD3+iiigD//2Q==',
        true
    );
}


// ======================================================
// HELPER: ISI FILE PNG VALID
// ======================================================
private function isiPngValidUntukTc(): string
{
    return base64_decode(
        'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADElEQVR4nGP4//8/AAX+Av4N70a4AAAAAElFTkSuQmCC',
        true
    );
}

public function test_tc_107_admin_dapat_menghapus_data_kamar(): void
{
    Storage::fake('public');

    $data = $this->buatDataKamar();

    Storage::disk('public')->put(
        'kamar/foto-hapus.jpg',
        'Foto kamar untuk pengujian'
    );

    $kamar = KamarKost::create([
        'id_kost' => $data['kost']->id,
        'nama_kamar' => 'Kamar Mawar',
        'nomor_kamar' => 'A01',
        'ukuran_kamar' => '3x3 meter',
        'foto_kamar' => ['kamar/foto-hapus.jpg'],
    ]);

    $fasilitasIds = $data['fasilitas']
        ->pluck('id_fasilitas')
        ->take(2)
        ->all();

    $kamar->fasilitas()->attach($fasilitasIds);

    $response = $this->actingAs($data['admin'])
        ->delete(route('admin.kamar.destroy', [
            'kamar' => $kamar->id_kamar,
        ]));

    $response->assertRedirect(route('admin.kamar.index'));

    $response->assertSessionHas(
        'success',
        'Kamar berhasil dihapus.'
    );

    $this->assertDatabaseMissing('kamar_kosts', [
        'id_kamar' => $kamar->id_kamar,
    ]);

    $this->assertDatabaseMissing('fasilitas_kamars', [
        'id_kamar' => $kamar->id_kamar,
    ]);

    $this->assertFalse(
    Storage::disk('public')->exists('kamar/foto-hapus.jpg'),
    'File foto kamar masih ada setelah kamar dihapus.'
);
}


public function test_tc_108_admin_dapat_mengubah_fasilitas_kamar(): void
{
    $data = $this->buatDataKamar();

    $kamar = KamarKost::create([
        'id_kost' => $data['kost']->id,
        'nama_kamar' => 'Kamar Jelita',
        'nomor_kamar' => 'A02',
        'ukuran_kamar' => '3x3 meter',
        'foto_kamar' => [],
    ]);

    $springBed = $data['fasilitas']->firstWhere(
        'nama_fasilitas',
        'Spring Bed'
    );

    $lemari = $data['fasilitas']->firstWhere(
        'nama_fasilitas',
        'Lemari'
    );

    $ac = $data['fasilitas']->firstWhere(
        'nama_fasilitas',
        'AC'
    );

    $kamar->fasilitas()->attach([
        $springBed->id_fasilitas,
        $lemari->id_fasilitas,
        $ac->id_fasilitas,
    ]);

    $meja = Fasilitas::create([
        'nama_fasilitas' => 'Meja',
    ]);

    $response = $this->actingAs($data['admin'])
        ->put(route('admin.kamar.fasilitas.update', [
            'kamar' => $kamar->id_kamar,
        ]), [
            'fasilitas' => [
                $springBed->id_fasilitas,
                $meja->id_fasilitas,
                $lemari->id_fasilitas,
                $ac->id_fasilitas,
            ],
        ]);

    $response->assertRedirect(route('admin.kamar.index'));

    $response->assertSessionHas(
        'success',
        'Fasilitas kamar berhasil diperbarui.'
    );

    $this->assertDatabaseCount('fasilitas_kamars', 4);

    $this->assertDatabaseHas('fasilitas_kamars', [
        'id_kamar' => $kamar->id_kamar,
        'id_fasilitas' => $springBed->id_fasilitas,
    ]);

    $this->assertDatabaseHas('fasilitas_kamars', [
        'id_kamar' => $kamar->id_kamar,
        'id_fasilitas' => $meja->id_fasilitas,
    ]);

    $this->assertDatabaseHas('fasilitas_kamars', [
        'id_kamar' => $kamar->id_kamar,
        'id_fasilitas' => $lemari->id_fasilitas,
    ]);

    $this->assertDatabaseHas('fasilitas_kamars', [
        'id_kamar' => $kamar->id_kamar,
        'id_fasilitas' => $ac->id_fasilitas,
    ]);
}


public function test_tc_109_admin_dapat_menghapus_seluruh_fasilitas_kamar(): void
{
    $data = $this->buatDataKamar();

    $kamar = KamarKost::create([
        'id_kost' => $data['kost']->id,
        'nama_kamar' => 'Kamar Jelita',
        'nomor_kamar' => 'A01',
        'ukuran_kamar' => '3x3 meter',
        'foto_kamar' => [],
    ]);

    $springBed = $data['fasilitas']->firstWhere(
        'nama_fasilitas',
        'Spring Bed'
    );

    $lemari = $data['fasilitas']->firstWhere(
        'nama_fasilitas',
        'Lemari'
    );

    $meja = Fasilitas::create([
        'nama_fasilitas' => 'Meja',
    ]);

    $kamar->fasilitas()->attach([
        $springBed->id_fasilitas,
        $meja->id_fasilitas,
        $lemari->id_fasilitas,
    ]);

    $response = $this->actingAs($data['admin'])
        ->put(route('admin.kamar.fasilitas.update', [
            'kamar' => $kamar->id_kamar,
        ]), []);

    $response->assertRedirect(route('admin.kamar.index'));

    $response->assertSessionHas(
        'success',
        'Fasilitas kamar berhasil diperbarui.'
    );

    $this->assertDatabaseMissing('fasilitas_kamars', [
        'id_kamar' => $kamar->id_kamar,
    ]);

    $this->assertDatabaseCount('fasilitas_kamars', 0);
}
}