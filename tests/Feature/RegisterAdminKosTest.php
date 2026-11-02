<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegisterAdminKosTest extends TestCase {
    use RefreshDatabase;

   //data dummy
    private function dataAdminValid(): array
    {
        return [
            'nama' => 'Naura Ulfatin',
            'nik' => '3201234567890123',
            'username' => 'nauranaww',
            'no_hp' => '085733553160',
            'password' => 'Naura123',
            'password_confirmation' => 'Naura123',
            'nama_kost' => 'Kos Jelita',
            'alamat' => 'Jl. Raya Jember No. KM 13, Desa Labanasem, Kecamatan Kabat, Kabupaten Banyuwangi',
        ];
    }

    //TC-001-REGISTER ADMIN KOS DENGAN SEMUA FIELD TERISI DAN DATA VALID
    public function test_tc_001_registrasi_admin_valid(): void
    {
        // ARRANGE: Siapkan data dummy
        Notification::fake();
        $data = $this->dataAdminValid();

        // ACT: Kirim request registrasi
        $response = $this->post(
            route('register.admin.store'), $data );

        // ASSERT: Periksa response
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');
        $response->assertSessionHasNoErrors();

        // Pastikan admin berhasil tersimpan
        $this->assertDatabaseHas('users', [
            'nama' => $data['nama'], 'nik' => $data['nik'], 'username' => $data['username'], 'no_hp' => $data['no_hp'], 'role' => 'admin kost', 'status' => 'pending',
        ]);

        // Ambil akun yang telah dibuat
        $user = User::where('username', $data['username']
        )->firstOrFail();

        // Pastikan data kos berhasil tersimpan
        $this->assertDatabaseHas('kosts', [
            'id_user' => $user->id, 'nama_kost' => $data['nama_kost'],'alamat' => $data['alamat'], ]);

        // Pastikan password tersimpan sebagai hash
        $this->assertTrue(
            Hash::check( $data['password'], $user->password)
        );

        // Pastikan jumlah data sesuai
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('kosts', 1);
    }

    //TC-002-REGISTER ADMIN KOS DENGAN NAMA KOSONG
    public function test_tc_002_nama_admin_kosong(): void
    {
        // ARRANGE: Data valid, nama dikosongkan
        $data = $this->dataAdminValid(); $data['nama'] = '';

        // ACT: Kirim request registrasi
        $response = $this->post(
            route('register.admin.store'), $data
        );

        // ASSERT: Validasi nama wajib diisi
        $response->assertSessionHasErrors([
            'nama' => 'Nama wajib diisi.',
        ]);

        // Registrasi tidak boleh menyimpan data
        $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
    }

    //TC-003-REGISTER ADMIN KOS DENGAN NAMA LEBIH DARI 100 KARAKTER
    public function test_tc_003_nama_lebih_100_karakter(): void
    {
        // ARRANGE: Nama berisi 101 karakter
        $data = $this->dataAdminValid();
        $data['nama'] = str_repeat('A', 101);

        // ACT: Kirim request registrasi
        $response = $this->post(
            route('register.admin.store'), $data );

        // ASSERT: Validasi panjang nama
        $response->assertSessionHasErrors([
            'nama' => 'Nama maksimal 100 karakter.',]);

        // Data tidak boleh tersimpan
        $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
    }

    //TC-004-REGISTER ADMIN KOS DENGAN NIK KOSONG
    public function test_tc_004_nik_admin_kosong(): void
    {
        // ARRANGE: NIK dikosongkan
        $data = $this->dataAdminValid();
        $data['nik'] = '';

        // ACT: Kirim request registrasi
        $response = $this->post(
            route('register.admin.store'), $data );

        // ASSERT: NIK wajib diisi
        $response->assertSessionHasErrors([
            'nik' => 'NIK wajib diisi.', ]);

        // Data tidak boleh tersimpan
        $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
    }

    //TC-005-REGISTER ADMIN KOS DENGAN NIK KURANG DARI 16 DIGIT
    public function test_tc_005_nik_kurang_16_digit(): void
    {
        // ARRANGE: NIK diubah menjadi 15 digit
        $data = $this->dataAdminValid();
        $data['nik'] = substr($data['nik'], 0, 15);

        // ACT: Kirim request registrasi
        $response = $this->post( route('register.admin.store'), $data );

        // ASSERT: Validasi panjang NIK
        $response->assertSessionHasErrors([ 'nik' => 'NIK harus 16 digit.',
        ]);

        // Data tidak boleh tersimpan
        $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
    }

    //TC-006-REGISTER ADMIN KOS DENGAN NIK LEBIH DARI 16 DIGIT
public function test_tc_006_nik_lebih_16_digit(): void
{
    // ARRANGE: Menggunakan data valid
    $data = $this->dataAdminValid();

    // NIK dibuat menjadi 17 digit
    $data['nik'] = '32012345678901237';

    // ACT: Memeriksa halaman registrasi
    $this->get(route('register.admin'))
        ->assertOk()
        ->assertSee('name="nik" maxlength="16"', false);

    // ACT: Mengirim NIK 17 digit langsung ke server
    $response = $this->post(
        route('register.admin.store'), $data );

    // ASSERT: Server menolak NIK lebih dari 16 digit
    $response->assertSessionHasErrors([ 'nik' => 'NIK harus 16 digit.', ]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
}

//TC-007-REGISTER ADMIN KOS DENGAN NIK MENGANDUNG KARAKTER HURUF
public function test_tc_007_nik_mengandung_huruf(): void
{
    // ARRANGE: Data valid dengan NIK mengandung huruf
    $data = $this->dataAdminValid();
    $data['nik'] = '32012O4567A9012E';

    // ACT: Kirim request registrasi
    $response = $this->post( route('register.admin.store'), $data);

    // ASSERT: NIK hanya boleh angka
    $response->assertSessionHasErrors([ 'nik' => 'NIK hanya boleh angka.',]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0);$this->assertDatabaseCount('kosts', 0);
}

//TC-008-REGISTER ADMIN KOS DENGAN NIK YANG SUDAH TERDAFTAR
public function test_tc_008_nik_sudah_terdaftar(): void
{
    // ARRANGE: Data valid
    $data = $this->dataAdminValid();

    // Buat akun yang sudah memakai NIK tersebut
    User::create([
        'nama' => $data['nama'],
        'nik' => $data['nik'],
        'username' => $data['username'],
        'no_hp' => $data['no_hp'],
        'password' => Hash::make($data['password']),
        'role' => 'admin kost',
        'status' => 'pending',
        'must_change_password' => false,
    ]);

    // Registrasi baru dengan NIK sama
    // Username dibedakan agar hanya aturan NIK yang diuji
    $data['username'] = 'nauranaww_baru';

    // ACT: Kirim request registrasi kedua
    $response = $this->post(
        route('register.admin.store'),
        $data
    );

    // ASSERT: NIK sudah digunakan
    $response->assertSessionHasErrors([
        'nik' => 'NIK sudah digunakan.',
    ]);

    // Hanya akun awal yang boleh ada
    $this->assertDatabaseCount('users', 1);

    // Registrasi kedua tidak membuat data kos
    $this->assertDatabaseCount('kosts', 0);

    // Username baru tidak boleh tersimpan
    $this->assertDatabaseMissing('users', ['username' => 'nauranaww_baru',
    ]);
}

//TC-009-REGISTER ADMIN KOS DENGAN USERNAME KOSONG
public function test_tc_009_username_kosong(): void
{
    // ARRANGE: Data valid
    $data = $this->dataAdminValid();

    // Username dikosongkan
    $data['username'] = '';

    // ACT: Kirim request registrasi
    $response = $this->post(
        route('register.admin.store'),$data );

    // ASSERT: Username wajib diisi
    $response->assertSessionHasErrors([ 'username' => 'Username wajib diisi.', ]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
}

//TC-010-REGISTER ADMIN KOS DENGAN USERNAME KURANG DARI 3 KARAKTER
public function test_tc_010_username_kurang_3_karakter(): void
{
    // ARRANGE: Data valid
    $data = $this->dataAdminValid();

    // Username hanya 2 karakter
    $data['username'] = 'ti';

    // ACT: Kirim request registrasi
    $response = $this->post( route('register.admin.store'), $data
    );

    // ASSERT: Username minimal 3 karakter
    $response->assertSessionHasErrors([ 'username' => 'Username minimal 3 karakter.',
    ]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
}

//TC-011-REGISTER ADMIN KOS DENGAN USERNAME LEBIH DARI 30 KARAKTER
public function test_tc_011_username_lebih_30_karakter(): void
{
    // ARRANGE: Data valid dengan username > 30 karakter
    $data = $this->dataAdminValid();
    $data['username'] = 'titispratiwinauraulfatinshaviranindya';

    // ACT: Kirim request registrasi
    $response = $this->post( route('register.admin.store'), $data);

    // ASSERT: Username maksimal 30 karakter
    $response->assertSessionHasErrors([ 'username' => 'Username maksimal 30 karakter.',]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
}

//TC-012-REGISTER ADMIN KOS DENGAN USERNAME TERDAPAT KARAKTER SELAIN HURUF, ANGKA, TITIK DAN _
public function test_tc_012_username_karakter_tidak_valid(): void
{
    // ARRANGE: Data valid dengan username tidak sesuai format
    $data = $this->dataAdminValid();
    $data['username'] = 'titis@pratiwi#';

    // ACT: Kirim request registrasi
    $response = $this->post( route('register.admin.store'), $data);

    // ASSERT: Username hanya boleh karakter tertentu
    $response->assertSessionHasErrors(['username' => 'Username hanya boleh huruf, angka, titik, dan underscore.', ]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0);$this->assertDatabaseCount('kosts', 0);
}

//TC-013-REGISTER ADMIN KOS DENGAN USERNAME YANG SUDAH TERDAFTAR
public function test_tc_013_username_sudah_terdaftar(): void
{
    // ARRANGE: Siapkan data valid
    $data = $this->dataAdminValid();

    // Membuat akun dummy yang sudah terdaftar
    User::create([
        'nama' => $data['nama'],
        'nik' => $data['nik'],
        'username' => $data['username'],
        'no_hp' => $data['no_hp'],
        'password' => Hash::make($data['password']),
        'role' => 'admin kost',
        'status' => 'pending',
        'must_change_password' => false,
    ]);

    // Username tetap sama dengan akun terdaftar
    // NIK dibedakan agar hanya validasi username yang diuji
    $data['nik'] = '3201234567890124';

    // ACT: Kirim request registrasi
    $response = $this->post( route('register.admin.store'), $data);

    // ASSERT: Username sudah digunakan
    $response->assertSessionHasErrors([ 'username' => 'Username sudah digunakan.', ]);

    // Hanya akun awal yang tersimpan
    $this->assertDatabaseCount('users', 1);

    // Tidak ada data kos baru
    $this->assertDatabaseCount('kosts', 0);

    // Pastikan NIK milik registrasi baru tidak tersimpan
    $this->assertDatabaseMissing('users', [ 'nik' => '3201234567890124',
    ]);
}

//TC-014-REGISTER ADMIN KOS DENGAN NO HP KOSONG
public function test_tc_014_nomor_hp_kosong(): void
{
    // ARRANGE: Data valid dengan nomor HP kosong
    $data = $this->dataAdminValid();
    $data['no_hp'] = '';

    // ACT: Kirim request registrasi
    $response = $this->post( route('register.admin.store'), $data);

    // ASSERT: Nomor HP wajib diisi
    $response->assertSessionHasErrors([ 'no_hp' => 'Nomor HP wajib diisi.', ]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
}

//TC-015-REGISTER ADMIN KOS DENGAN NO HP KURANG DARI 10 DIGIT
public function test_tc_015_nomor_hp_kurang_10_digit(): void
{
    // ARRANGE: Data valid dengan nomor HP 9 digit
    $data = $this->dataAdminValid();
    $data['no_hp'] = '085733553';

    // ACT: Kirim request registrasi
    $response = $this->post( route('register.admin.store'), $data);

    // ASSERT: Nomor HP harus 10-13 digit
    $response->assertSessionHasErrors([
        'no_hp' => 'Nomor HP harus 10 sampai 13 digit.', ]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
}

//TC-016-REGISTER ADMIN KOS DENGAN NO HP LEBIH DARI 13 DIGIT
public function test_tc_016_nomor_hp_lebih_13_digit(): void
{
    // ARRANGE: Menggunakan data valid
    $data = $this->dataAdminValid();
    // Nomor HP diubah menjadi 14 digit
    $data['no_hp'] = '08573355416098';

    // ACT: Kirim request registrasi
    $response = $this->post( route('register.admin.store'), $data );

    // ASSERT: Nomor HP harus 10-13 digit
    $response->assertSessionHasErrors([ 'no_hp' => 'Nomor HP harus 10 sampai 13 digit.', ]);

    // Registrasi tidak boleh menyimpan data
    $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
}

//TC-017-REGISTER ADMIN KOS DENGAN PASSWORD KOSONG
public function test_tc_017_password_kosong(): void
{
    // ARRANGE: Menggunakan data valid
    $data = $this->dataAdminValid();
    // Password dan konfirmasi dikosongkan
    $data['password'] = '';
    $data['password_confirmation'] = '';

    // ACT: Kirim request registrasi
    $response = $this->post(route('register.admin.store'), $data);

    // ASSERT: Password wajib diisi
    $response->assertSessionHasErrors(['password' => 'Password wajib diisi.',]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0);$this->assertDatabaseCount('kosts', 0);
}

//TC-018-REGISTER ADMIN KOS DENGAN PASSWORD KURANG DARI 8 KARAKTER
public function test_tc_018_password_kurang_8_karakter(): void
{
    // ARRANGE: Menggunakan data valid
    $data = $this->dataAdminValid();

    // Password hanya 6 karakter
    $data['password'] = 'ti3tiS';
    $data['password_confirmation'] = 'ti3tiS';

    // ACT: Kirim request registrasi
    $response = $this->post( route('register.admin.store'),$data);

    // ASSERT: Password minimal 8 karakter
    $response->assertSessionHasErrors([ 'password' => 'Password minimal 8 karakter.',]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
}
//TC-019-REGISTER ADMIN KOS DENGAN PASSWORD HANYA MENGANDUNG HURUF BESAR DAN ANGKA
public function test_tc_019_password_tanpa_huruf_kecil(): void
{
    // ARRANGE: Menggunakan data valid
    $data = $this->dataAdminValid();
    // Password hanya huruf kapital dan angka
    $data['password'] = 'TITIS123';
    $data['password_confirmation'] = 'TITIS123';

    // ACT: Kirim request registrasi
    $response = $this->post( route('register.admin.store'), $data);

    // ASSERT: Password harus memiliki huruf kecil
    $response->assertSessionHasErrors(['password' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
}
//TC-020-REGISTER ADMIN KOS DENGAN PASSWORD TERDAPAT KARAKTER SELAIN HURUF BESAR, HURUF KECIL, DAN ANGKA
public function test_tc_020_password_karakter_khusus(): void
{
    // ARRANGE: Menggunakan data valid
    $data = $this->dataAdminValid();
    // Password mengandung karakter # dan @
    $data['password'] = 'Titis#123@';
    $data['password_confirmation'] = 'Titis#123@';

    // ACT: Kirim request registrasi
    $response = $this->post( route('register.admin.store'), $data );

    // ASSERT: Password seharusnya ditolak
    $response->assertSessionHasErrors(['password']);

    // Registrasi tidak boleh menyimpan data
    $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
}

//TC-021-REGISTER ADMIN KOS DENGAN PASSWORD DAN KONFIRMASI PASSWORD TIDAK COCOK/BERBEDA
public function test_tc_021_konfirmasi_password_tidak_cocok(): void
{
    // ARRANGE: Data valid dengan konfirmasi berbeda
    $data = $this->dataAdminValid();
    $data['password_confirmation'] = 'Naura125';

    // ACT: Kirim request registrasi
    $response = $this->post(route('register.admin.store'), $data);

    // ASSERT: Konfirmasi password tidak cocok
    $response->assertSessionHasErrors(['password' => 'Konfirmasi password tidak cocok.', ]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0);$this->assertDatabaseCount('kosts', 0);
}

//TC-022-REGISTER ADMIN KOS DENGAN NAMA KOS KOSONG
public function test_tc_022_nama_kos_kosong(): void
{
    // ARRANGE: Data valid dengan nama kos kosong
    $data = $this->dataAdminValid();
    $data['nama_kost'] = '';

    // ACT: Kirim request registrasi
    $response = $this->post( route('register.admin.store'), $data);

    // ASSERT: Nama kos wajib diisi
    $response->assertSessionHasErrors(['nama_kost' => 'Nama kos wajib diisi.',]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0);$this->assertDatabaseCount('kosts', 0);
}

//TC-023-REGISTER ADMIN KOS DENGAN NAMA KOS LEBIH DARI 100 KARAKTER
public function test_tc_023_nama_kos_lebih_100_karakter(): void
{
    // ARRANGE: Nama kos sebanyak 101 karakter
    $data = $this->dataAdminValid();
    $data['nama_kost'] = str_repeat('K', 101);

    // ACT: Kirim request registrasi
    $response = $this->post(route('register.admin.store'), $data);

    // ASSERT: Nama kos maksimal 100 karakter
    $response->assertSessionHasErrors(['nama_kost' => 'Nama kos maksimal 100 karakter.',]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
}

//TC-024-REGISTER ADMIN KOS DENGAN ALAMAT KOS KOSONG
public function test_tc_024_alamat_kos_kosong(): void
{
    // ARRANGE: Data valid dengan alamat kosong
    $data = $this->dataAdminValid();
    $data['alamat'] = '';

    // ACT: Kirim request registrasi
    $response = $this->post(route('register.admin.store'), $data);

    // ASSERT: Alamat kos wajib diisi
    $response->assertSessionHasErrors([ 'alamat' => 'Alamat kos wajib diisi.',
    ]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
}

//TC-025-REGISTRASI ADMIN KOS DENGAN ALAMAT KOS LEBIH DARI 300 KARAKTER
public function test_tc_025_alamat_kos_lebih_300_karakter(): void
{
    // ARRANGE: Alamat sebanyak 301 karakter
    $data = $this->dataAdminValid();
    $data['alamat'] = str_repeat('A', 301);

    // ACT: Kirim request registrasi
    $response = $this->post( route('register.admin.store'),$data);

    // ASSERT: Alamat kos terlalu panjang
    $response->assertSessionHasErrors(['alamat' => 'Alamat kos terlalu panjang.',]);

    // Data tidak boleh tersimpan
    $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
}
}
