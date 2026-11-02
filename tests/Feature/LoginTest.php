<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    //HELPER DATA DUMMY LOGIN, Membuat akun aktif untuk pengujian.

    private function buatAkunLogin(
        string $username,
        string $password,
        string $role,
        string $nik
    ): User {
        return User::create([
            'nama' => 'Pengguna' . $username,
            'nik' => $nik,
            'username' => $username,
            'no_hp' => '081234567891',
            'password' => Hash::make($password),
            'role' => $role,
            'status' => 'aktif',
            'must_change_password' => false,
        ]);
    }

    //TC-047-LOGIN SUPERADMIN
    public function test_tc_047_login_superadmin_valid(): void
    {
        // ARRANGE: Buat akun Super Admin aktif
        $user = $this->buatAkunLogin(
            'superadmin',
            'orbitgacor',
            'super admin',
            '1234567891011121'
        );

        // ACT: Login menggunakan akun Super Admin
        $response = $this->post(
            route('login.post'),
            [
                'username' => 'superadmin',
                'password' => 'orbitgacor',
            ]
        );

        // ASSERT: Login berhasil
        $response->assertRedirect(route('home'));
        $response->assertSessionHasNoErrors();

        // Pastikan pengguna terautentikasi
        $this->assertAuthenticatedAs($user);

        // Pastikan role sesuai
        $this->assertEquals('super admin', $user->role);
    }

    //TC-048-LOGIN ADMIN KOS
    public function test_tc_048_login_admin_kos_valid(): void
    {
        // ARRANGE: Buat akun Admin Kos aktif
        $user = $this->buatAkunLogin(
            'nauranaww',
            'Naura123',
            'admin kost',
            '3201234567890123'
        );

        // ACT: Login menggunakan akun Admin Kos
        $response = $this->post(
            route('login.post'),
            [
                'username' => 'nauranaww',
                'password' => 'Naura123',
            ]
        );

        // ASSERT: Login berhasil
        $response->assertRedirect(route('home'));
        $response->assertSessionHasNoErrors();

        // Pastikan pengguna terautentikasi
        $this->assertAuthenticatedAs($user);

        // Pastikan role dan status sesuai
        $this->assertEquals('admin kost', $user->role);
        $this->assertEquals('aktif', $user->status);
    }

    //TC-049-LOGIN PENGHUNI KOS
    public function test_tc_049_login_penghuni_kos_valid(): void
    {
        // ARRANGE: Buat akun Penghuni Kos aktif
        $user = $this->buatAkunLogin(
            'sapirapir',
            'Sapir123',
            'penghuni kost',
            '3627919308390030'
        );

        // ACT: Login menggunakan akun Penghuni Kos
        $response = $this->post(
            route('login.post'),
            [
                'username' => 'sapirapir',
                'password' => 'Sapir123',
            ]
        );

        // ASSERT: Login berhasil
        $response->assertRedirect(route('home'));
        $response->assertSessionHasNoErrors();

        // Pastikan pengguna terautentikasi
        $this->assertAuthenticatedAs($user);

        // Pastikan role sesuai
        $this->assertEquals('penghuni kost', $user->role);
    }

    //TC-050-LOGIN DENGAN PASSWORD SALAH
    public function test_tc_050_login_password_salah(): void
    {
        // ARRANGE: Buat akun yang sudah terdaftar
        $this->buatAkunLogin(
            'nauranaww',
            'Naura123',
            'admin kost',
            '3201234567890123'
        );

        // ACT: Login menggunakan password salah
        $response = $this->post(
            route('login.post'),
            [
                'username' => 'nauranaww',
                'password' => 'Naura234',
            ]
        );

        // ASSERT: Sistem menolak login
        $response->assertSessionHasErrors([
            'username' => 'Username atau password salah.',
        ]);

        // Pengguna tidak boleh terautentikasi
        $this->assertGuest();

        // Akun yang sudah ada tetap tersimpan
        $this->assertDatabaseCount('users', 1);
    }

    //TC-051-LOGIN DENGAN USERNAME SALAH
    public function test_tc_051_login_username_salah(): void
    {
        // ARRANGE: Buat akun yang sudah terdaftar
        $this->buatAkunLogin(
            'nauranaww',
            'Naura123',
            'admin kost',
            '3201234567890123'
        );

        // ACT: Login menggunakan username tidak terdaftar
        $response = $this->post(
            route('login.post'),
            [
                'username' => 'nauraja',
                'password' => 'Naura123',
            ]
        );

        // ASSERT: Sistem menolak login
        $response->assertSessionHasErrors([
            'username' => 'Username atau password salah.',
        ]);

        // Pengguna tidak boleh terautentikasi
        $this->assertGuest();

        // Akun awal tetap ada
        $this->assertDatabaseHas('users', [
            'username' => 'nauranaww',
            'role' => 'admin kost',
        ]);

        // Tidak ada akun baru yang dibuat
        $this->assertDatabaseCount('users', 1);
    }

    
    //TC-052-LOGIN DENGAN USERNAME DAN PASSWORD SALAH
    public function test_tc_052_username_dan_password_salah(): void
    {
        // ARRANGE: Buat akun yang terdaftar
        $this->buatAkunLogin(
            'nauranaww',
            'Naura123',
            'admin kost',
            '3201234567890123'
        );

        // ACT: Login dengan username dan password salah
        $response = $this->post(
            route('login.post'),
            [
                'username' => 'nauraja',
                'password' => 'Naura127',
            ]
        );

        // ASSERT: Sistem menolak login
        $response->assertSessionHasErrors([
            'username' => 'Username atau password salah.',
        ]);

        // Pengguna tetap belum login
        $this->assertGuest();

        // Tidak ada akun baru yang dibuat
        $this->assertDatabaseCount('users', 1);
    }

    //TC-053-LOGIN DENGAN USERNAME DAN PASSWORD KOSONG
    public function test_tc_053_username_dan_password_kosong(): void
    {
        // ARRANGE: Kedua field dikosongkan
        $data = [
            'username' => '',
            'password' => '',
        ];

        // ACT: Kirim request login
        $response = $this->post(
            route('login.post'),
            $data
        );

        // ASSERT: Kedua field wajib diisi
        $response->assertSessionHasErrors([
            'username' => 'Username wajib diisi.',
            'password' => 'Password wajib diisi.',
        ]);

        // Pengguna tidak boleh terautentikasi
        $this->assertGuest();

        // Tidak ada akun yang dibuat
        $this->assertDatabaseCount('users', 0);
    }

    //TC-054-LOGIN DENGAN PASSWORD KOSONG
    public function test_tc_054_password_kosong(): void
    {
        // ARRANGE: Buat akun valid
        $this->buatAkunLogin(
            'nauranaww',
            'Naura123',
            'admin kost',
            '3201234567890123'
        );

        // ACT: Login dengan password kosong
        $response = $this->post(
            route('login.post'),
            [
                'username' => 'nauranaww',
                'password' => '',
            ]
        );

        // ASSERT: Password wajib diisi
        $response->assertSessionHasErrors([
            'password' => 'Password wajib diisi.',
        ]);

        // Pengguna tetap belum login
        $this->assertGuest();

        // Akun awal tetap tersimpan
        $this->assertDatabaseCount('users', 1);
    }

    //TC-055-LOGIN DENGAN USERNAME KOSONG
    public function test_tc_055_username_kosong(): void
    {
        // ARRANGE: Buat akun valid
        $this->buatAkunLogin(
            'nauranaww',
            'Naura123',
            'admin kost',
            '3201234567890123'
        );

        // ACT: Login dengan username kosong
        $response = $this->post(
            route('login.post'),
            [
                'username' => '',
                'password' => 'Naura123',
            ]
        );

        // ASSERT: Username wajib diisi
        $response->assertSessionHasErrors([
            'username' => 'Username wajib diisi.',
        ]);

        // Pengguna tetap belum login
        $this->assertGuest();

        // Akun awal tetap tersimpan
        $this->assertDatabaseCount('users', 1);
    }

    //TC-056-LOGIN DENGAN AKUN ADMIN KOS YANG BELUM DISETUJUI SUPERADMIN
    public function test_tc_056_login_admin_kos_belum_disetujui(): void
    {
        // ARRANGE: Buat akun Admin Kos
        $user = $this->buatAkunLogin(
            'nadya_ulfatin',
            'Nadya123',
            'admin kost',
            '3201234567890156'
        );

        // Status akun belum disetujui
        $user->update([ 'status' => 'pending', ]);

        // ACT: Coba login dengan kredensial valid
        $response = $this->post(
            route('login.post'),
            [
                'username' => 'nadya_ulfatin', 'password' => 'Nadya123',
            ]
        );

        // ASSERT: Sistem menampilkan HTTP 403
        $response->assertForbidden();

        // ASSERT: Pesan sesuai kebutuhan
        $response->assertSee('Akun admin kost anda belum divalidasi Super Admin.' );

        // ASSERT: Akun tidak berhasil login
        $this->assertGuest();

        // ASSERT: Status akun tetap pending
        $this->assertDatabaseHas('users', ['username' => 'nadya_ulfatin','status' => 'pending',]);
    }

    //TC-057-LOGIN DENGAN AKUN ADMIN KOS YANG DITOLAK SUPERADMIN
    public function test_tc_057_login_admin_kos_ditolak(): void
    {
        // ARRANGE: Buat akun Admin Kos
        $user = $this->buatAkunLogin(
            'shavira',
            'Pinga123',
            'admin kost',
            '3201234567890157'
        );

        // Ubah status akun menjadi ditolak
        $user->update(['status' => 'ditolak', ]);

        // Pastikan status akun tersimpan
        $this->assertDatabaseHas('users', [
            'username' => 'shavira',
            'role' => 'admin kost',
            'status' => 'ditolak',
        ]);

        // ACT: Login menggunakan akun yang ditolak
        $response = $this->post(
            route('login.post'),
            [
                'username' => 'shavira', 'password' => 'Pinga123',
            ]
        );

        // ASSERT: Sistem menampilkan HTTP 403
        $response->assertForbidden();

        // ASSERT: Pesan sesuai ketentuan test case
        $response->assertSee('Pengajuan anda ditolak oleh Super Admin.' );

        // ASSERT: Pengguna tidak berhasil login
        $this->assertGuest();

        // ASSERT: Status akun tetap ditolak
        $this->assertDatabaseHas('users', ['username' => 'shavira','status' => 'ditolak',]);
    }


}
