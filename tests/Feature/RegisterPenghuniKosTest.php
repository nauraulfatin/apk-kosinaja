<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterPenghuniKosTest extends TestCase
{
    use RefreshDatabase;

    //data dummy peghuni
    private function dataPenghuniValid(): array
    {
        return [
            'nama' => 'ShaviraNindya',
            'nik' => '3627919308390030',
            'username' => 'sapirapir',
            'no_hp' => '081234567891',
            'password' => 'Sapir123',
            'password_confirmation' => 'Sapir123',
        ];
    }

    //TC-026-REGISTER PENGHUNI KOS DENGAN SEMUA FIELD TERISI DAN DATA VALID
    public function test_tc_026_registrasi_penghuni_valid(): void
    {
        // ARRANGE: Siapkan data dummy valid
        $data = $this->dataPenghuniValid();

        // ACT: Kirim request registrasi penghuni
        $response = $this->post( route('register.penghuni.store'), $data );

        // ASSERT: Periksa respons berhasil
        $response->assertRedirect(route('login'));
        $response->assertSessionHas( 'success','Registrasi berhasil. Silakan login.');
        $response->assertSessionHasNoErrors();

        // Pastikan akun tersimpan di database
        $this->assertDatabaseHas('users', [
            'nama' => $data['nama'],
            'nik' => $data['nik'],
            'username' => $data['username'],
            'no_hp' => $data['no_hp'],
            'role' => 'penghuni kost',
            'status' => 'aktif',
        ]);

        // Ambil user yang baru terdaftar
        $user = User::where('username', $data['username']
        )->firstOrFail();

        // Pastikan password disimpan sebagai hash
        $this->assertTrue(
            Hash::check( $data['password'], $user->password ) );

        // Hanya satu akun yang tersimpan
        $this->assertDatabaseCount('users', 1);

        // Registrasi penghuni tidak membuat data kos
        $this->assertDatabaseCount('kosts', 0);
    }

    //TC-027-REGISTER PENGHUNI KOS DENGAN NAMA KOS
    public function test_tc_027_nama_penghuni_kosong(): void
    {
        // ARRANGE: Nama dikosongkan
        $data = $this->dataPenghuniValid();
        $data['nama'] = '';

        // ACT: Kirim request registrasi
        $response = $this->post( route('register.penghuni.store'), $data );

        // ASSERT: Nama wajib diisi
        $response->assertSessionHasErrors(['nama' => 'Nama wajib diisi.',]);

        // Data tidak boleh tersimpan
        $this->assertDatabaseCount('users', 0);
    }

    //TC-028-REGISTER PENGHUNI KOS DENGAN NAMA LEBIH DARI 100 KARAKTER
    public function test_tc_028_nama_lebih_100_karakter(): void
    {
        // ARRANGE: Nama berisi 101 karakter
        $data = $this->dataPenghuniValid();
        $data['nama'] = str_repeat('A', 101);

        // ACT: Kirim request registrasi
        $response = $this->post( route('register.penghuni.store'), $data );

        // ASSERT: Nama maksimal 100 karakter
        $response->assertSessionHasErrors([ 'nama' => 'Nama maksimal 100 karakter.',]);

        // Data tidak boleh tersimpan
        $this->assertDatabaseCount('users', 0);
    }

    //TC-029-REGISTER PENGUHI KOS DENGAN NIK KOSONG
    public function test_tc_029_nik_penghuni_kosong(): void
    {
        // ARRANGE: NIK dikosongkan
        $data = $this->dataPenghuniValid();
        $data['nik'] = '';

        // ACT: Kirim request registrasi
        $response = $this->post( route('register.penghuni.store'),$data);

        // ASSERT: NIK wajib diisi
        $response->assertSessionHasErrors([ 'nik' => 'NIK wajib diisi.',]);

        // Data tidak boleh tersimpan
        $this->assertDatabaseCount('users', 0);
    }

    //TC-030-REGISTER PENGHUNI KOS DENGAN NIK KURANG DARI 16 DIGIT
    public function test_tc_030_nik_kurang_16_digit(): void
    {
        // ARRANGE: NIK dibuat menjadi 15 digit
        $data = $this->dataPenghuniValid();
        $data['nik'] = substr($data['nik'], 0, 15);

        // ACT: Kirim request registrasi
        $response = $this->post( route('register.penghuni.store'), $data);

        // ASSERT: NIK harus 16 digit
        $response->assertSessionHasErrors(['nik' => 'NIK harus 16 digit.', ]);

        // Data tidak boleh tersimpan
        $this->assertDatabaseCount('users', 0);
    }
    
    //TC-031-REGISTER PENGHUNI KOS DENGAN NIK LEBIH DARI 16 DIGIT
    public function test_tc_031_nik_lebih_16_digit(): void
    {
        // ARRANGE: NIK dibuat menjadi 17 digit
        $data = $this->dataPenghuniValid();
        $data['nik'] = '36279193083900301';

        // ACT: Periksa batas input pada form registrasi
        $this->get(route('register.penghuni'))
            ->assertOk()
            ->assertSee('name="nik"', false)
            ->assertSee('maxlength="16"', false);

        // ACT: Kirim request registrasi dengan NIK 17 digit
        $response = $this->post( route('register.penghuni.store'), $data);

        // ASSERT: NIK harus 16 digit
        $response->assertSessionHasErrors([ 'nik' => 'NIK harus 16 digit.',]);

        $this->assertDatabaseCount('users', 0);
    }

    //TC-032-REGISTER PENGHUNI KOS DENGAN NIK TERDAPAT KARAKTER HURUF
    public function test_tc_032_nik_mengandung_huruf(): void
    {
        // ARRANGE: NIK mengandung karakter huruf
        $data = $this->dataPenghuniValid();
        $data['nik'] = '3H27A19308E9003O';

        // ACT: Kirim request registrasi
        $response = $this->post( route('register.penghuni.store'),$data);

        // ASSERT: NIK hanya boleh angka
        $response->assertSessionHasErrors(['nik' => 'NIK hanya boleh angka.',]);

        $this->assertDatabaseCount('users', 0);
    }

    //TC-033-REGISTER PENGHUNI KOS DENGAN NIK SUDAH DIGUNAKAN
    public function test_tc_033_nik_sudah_terdaftar(): void
    {
        // ARRANGE: Siapkan data valid
        $data = $this->dataPenghuniValid();

        // Buat akun dummy yang sudah menggunakan NIK
        User::create([
            'nama' => $data['nama'],
            'nik' => $data['nik'],
            'username' => $data['username'],
            'no_hp' => $data['no_hp'],
            'password' => Hash::make($data['password']),
            'role' => 'penghuni kost',
            'status' => 'aktif',
            'must_change_password' => false,
        ]);

        // Username dibuat berbeda agar hanya NIK yang diuji
        $data['username'] = 'sapirapir_baru';

        // ACT: Mencoba registrasi dengan NIK yang sama
        $response = $this->post(route('register.penghuni.store'), $data);

        // ASSERT: NIK sudah digunakan
        $response->assertSessionHasErrors([ 'nik' => 'NIK sudah digunakan.',]);

        // Hanya akun dummy awal yang tersimpan
        $this->assertDatabaseCount('users', 1);

        // Akun baru tidak boleh tersimpan
        $this->assertDatabaseMissing('users', [ 'username' => 'sapirapir_baru', ]);
    }

    //TC-034-REGISTER PENGHUNI KOS DENGAN USERNAME KOSONG
    public function test_tc_034_username_kosong(): void
    {
        // ARRANGE: Username dikosongkan
        $data = $this->dataPenghuniValid();
        $data['username'] = '';

        // ACT: Kirim request registrasi
        $response = $this->post(route('register.penghuni.store'), $data );

        // ASSERT: Username wajib diisi
        $response->assertSessionHasErrors(['username' => 'Username wajib diisi.', ]);

        $this->assertDatabaseCount('users', 0);
    }

    //TC-035-REGISTER PENGHUNI KOS DENGAN USERNAME KURANG DARI 3 KARAKTER
    public function test_tc_035_username_kurang_3_karakter(): void
    {
        // ARRANGE: Username hanya 2 karakter
        $data = $this->dataPenghuniValid();
        $data['username'] = 'yu';

        // ACT: Kirim request registrasi
        $response = $this->post( route('register.penghuni.store'),$data);

        // ASSERT: Username minimal 3 karakter
        $response->assertSessionHasErrors([ 'username' => 'Username minimal 3 karakter.',]);

        $this->assertDatabaseCount('users', 0);
    }
    
    //TC-036-REGISTER PENGHUNI KOS DENGAN USERNAME LEBIH DARI 30 KARAKTER
    public function test_tc_036_username_lebih_30_karakter(): void
    {
        // ARRANGE: Username lebih dari 30 karakter
        $data = $this->dataPenghuniValid();
        $data['username'] = 'AndyYusril_RahmaTitisPratiwi_Yes';

        // ACT: Kirim request registrasi
        $response = $this->post( route('register.penghuni.store'),$data);

        // ASSERT: Username maksimal 30 karakter
        $response->assertSessionHasErrors(['username' => 'Username maksimal 30 karakter.',]);

        // Data tidak boleh tersimpan
        $this->assertDatabaseCount('users', 0);
    }

    //TC-037-REGISTER PENGHUNI KOS DENGAN USERNAME TERDAPAT KARAKTER SELAIN HURUF, ANGKA, TITIK, DAN UNDERSCORE
    public function test_tc_037_username_karakter_tidak_valid(): void
    {
        // ARRANGE: Username mengandung karakter @ dan #
        $data = $this->dataPenghuniValid();
        $data['username'] = 'Andy@yus#';

        // ACT: Kirim request registrasi
        $response = $this->post(route('register.penghuni.store'), $data
        );

        // ASSERT: Username hanya boleh karakter tertentu
        $response->assertSessionHasErrors([ 'username' => 'Username hanya boleh huruf, angka, titik, dan underscore.', ]);

        // Data tidak boleh tersimpan
        $this->assertDatabaseCount('users', 0);
    }

    //TC-038-REGISTER PENGHUNI KOS DENGAN USERNAME SUDAH DIGUNAKAN
    public function test_tc_038_username_sudah_terdaftar(): void
    {
        // ARRANGE: Siapkan data valid
        $data = $this->dataPenghuniValid();

        // Buat akun dummy yang sudah terdaftar
        User::create([
            'nama' => $data['nama'],
            'nik' => $data['nik'],
            'username' => $data['username'],
            'no_hp' => $data['no_hp'],
            'password' => Hash::make($data['password']),
            'role' => 'penghuni kost',
            'status' => 'aktif',
            'must_change_password' => false,
        ]);

        // NIK dibedakan agar hanya username yang diuji
        $data['nik'] = '3627919308390031';

        // ACT: Registrasi dengan username yang sama
        $response = $this->post( route('register.penghuni.store'), $data);

        // ASSERT: Username sudah digunakan
        $response->assertSessionHasErrors(['username' => 'Username sudah digunakan.',]);

        // Hanya akun awal yang tersimpan
        $this->assertDatabaseCount('users', 1);

        // Akun baru tidak boleh tersimpan
        $this->assertDatabaseMissing('users', ['nik' => '3627919308390031',]);
    }

    //TC-039-REGISTER PENGHUNI KOS DENGAN NO HP KOSONG
    public function test_tc_039_nomor_hp_kosong(): void
    {
        // ARRANGE: Nomor HP dikosongkan
        $data = $this->dataPenghuniValid();
        $data['no_hp'] = '';

        // ACT: Kirim request registrasi
        $response = $this->post( route('register.penghuni.store'),$data );

        // ASSERT: Nomor HP wajib diisi
        $response->assertSessionHasErrors([ 'no_hp' => 'Nomor HP wajib diisi.',]);

        // Data tidak boleh tersimpan
        $this->assertDatabaseCount('users', 0);
    }

    //TC-040-REGISTRASI PENGHUNI KOS DENGAN NO HP KURANG DARI 10 DIGIT
    public function test_tc_040_nomor_hp_kurang_10_digit(): void
    {
        // ARRANGE: Nomor HP hanya 9 digit
        $data = $this->dataPenghuniValid();
        $data['no_hp'] = '087652655';

        // ACT: Kirim request registrasi
        $response = $this->post(route('register.penghuni.store'),$data);

        // ASSERT: Nomor HP harus 10-13 digit
        $response->assertSessionHasErrors(['no_hp' => 'Nomor HP harus 10 sampai 13 digit.',]);

        // Data tidak boleh tersimpan
        $this->assertDatabaseCount('users', 0);
    }
    
    //TC-041-REGISTER PENGHUNI KOS DENGAN NO HP LEBIH DARI 13 DIGIT
    public function test_tc_041_nomor_hp_lebih_13_digit(): void
    {
        // ARRANGE: Nomor HP berjumlah 14 digit
        $data = $this->dataPenghuniValid();
        $data['no_hp'] = '08765265582839';

        // ACT: Kirim request registrasi
        $response = $this->post( route('register.penghuni.store'),$data);

        // ASSERT: Nomor HP harus 10 sampai 13 digit
        $response->assertSessionHasErrors([ 'no_hp' => 'Nomor HP harus 10 sampai 13 digit.', ]);

        $this->assertDatabaseCount('users', 0);
    }

    //TC-042-REGISTER PENGHUNI KOS DENGAN PASSWORD KOSONG
    public function test_tc_042_password_kosong(): void
    {
        // ARRANGE: Password dikosongkan
        $data = $this->dataPenghuniValid();
        $data['password'] = '';
        $data['password_confirmation'] = '';

        // ACT: Kirim request registrasi
        $response = $this->post( route('register.penghuni.store'),$data);

        // ASSERT: Password wajib diisi
        $response->assertSessionHasErrors([ 'password' => 'Password wajib diisi.',]);

        $this->assertDatabaseCount('users', 0);
    }

    //TC-043-REGISTER PENGHUNI KOS DENGAN  PASSWORD KURANG DARI 8 KARAKTER
    public function test_tc_043_password_kurang_8_karakter(): void
    {
        // ARRANGE: Password hanya 7 karakter
        $data = $this->dataPenghuniValid();
        $data['password'] = 'Yusril1';
        $data['password_confirmation'] = 'Yusril1';

        // ACT: Kirim request registrasi
        $response = $this->post( route('register.penghuni.store'), $data );

        // ASSERT: Password minimal 8 karakter
        $response->assertSessionHasErrors([ 'password' => 'Password minimal 8 karakter.',]);

        $this->assertDatabaseCount('users', 0);
    }

    //TC-044-REGISTER PENGHUNI KOS DENGAN PASSWORD HANYA MENGANDUNG HURUF BESAR DAN HURUF KECIL
    public function test_tc_044_password_tanpa_angka(): void
    {
        // ARRANGE: Password hanya berisi huruf besar dan kecil
        $data = $this->dataPenghuniValid();
        $data['password'] = 'YusrilAja';
        $data['password_confirmation'] = 'YusrilAja';

        // ACT: Kirim request registrasi
        $response = $this->post(route('register.penghuni.store'), $data);

        // ASSERT: Password harus mengandung angka
        $response->assertSessionHasErrors(['password' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',]);

        $this->assertDatabaseCount('users', 0);
    }

    //TC-045-REGISTER PENGHUNI KOS DENGAN PASSWORD MENGANDUNG KARAKTER SELAIN HURUUF BESAR, HURUF KECIL, DAN ANGKA
    public function test_tc_045_password_karakter_khusus(): void
    {
        // ARRANGE: Password mengandung karakter @ dan #
        $data = $this->dataPenghuniValid();
        $data['password'] = 'Yus@Aja12#';
        $data['password_confirmation'] = 'Yus@Aja12#';

        // ACT: Kirim request registrasi
        $response = $this->post( route('register.penghuni.store'),$data );

        // ASSERT: Password dengan karakter khusus ditolak
        $response->assertSessionHasErrors(['password']);

        // Registrasi tidak boleh menyimpan data
        $this->assertDatabaseCount('users', 0);
    }

    //TC-046-REGISTER PENGHUNI KOS DENGAN KONFIRMASI PASSWORD TIDAK COCOK
    public function test_tc_046_konfirmasi_password_tidak_cocok(): void
    {
        // ARRANGE: Gunakan data penghuni yang valid
        $data = $this->dataPenghuniValid();

        // Konfirmasi password dibuat berbeda
        $data['password_confirmation'] = 'Sapir098';

        // ACT: Kirim request registrasi penghuni
        $response = $this->post( route('register.penghuni.store'), $data );

        // ASSERT: Konfirmasi password tidak cocok
        $response->assertSessionHasErrors(['password' => 'Konfirmasi password tidak cocok.',]);

        // Akun tidak boleh tersimpan
        $this->assertDatabaseCount('users', 0); $this->assertDatabaseCount('kosts', 0);
    }



}
