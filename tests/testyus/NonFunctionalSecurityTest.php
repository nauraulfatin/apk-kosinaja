<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class NonFunctionalSecurityTest extends TestCase
{
    use RefreshDatabase;

    private function buatUser(string $role = 'super admin'): User
    {
        return User::create([
            'nama' => 'User Pengujian',
            'nik' => (string) random_int(1000000000000000, 9999999999999999),
            'username' => 'user_' . uniqid(),
            'no_hp' => '081234567890',
            'password' => Hash::make('Password123'),
            'role' => $role,
            'status' => 'aktif',
            'must_change_password' => false,
        ]);
    }

    // NF1-01: Login dengan data yang benar.
    public function test_nf1_01_login_berhasil_dengan_kredensial_valid(): void
    {
        $user = $this->buatUser();

        $response = $this->post(route('login.post'), [
            'username' => $user->username,
            'password' => 'Password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    // NF1-02: Login dengan data yang salah ditolak.
    public function test_nf1_02_login_ditolak_dengan_password_salah(): void
    {
        $user = $this->buatUser();

        $response = $this->post(route('login.post'), [
            'username' => $user->username,
            'password' => 'PasswordSalah',
        ]);

        $response->assertSessionHasErrors([
            'username' => 'Username atau password salah.',
        ]);

        $this->assertGuest();
    }

    // NF2-01: Password saat registrasi tersimpan dalam bentuk hash.
    public function test_nf2_01_password_registrasi_tidak_disimpan_sebagai_plain_text(): void
    {
        $password = 'Password123';

        $response = $this->post(route('register.penghuni.store'), [
            'nama' => 'Penghuni Pengujian',
            'nik' => '3201234567890123',
            'username' => 'penghuni_nf201',
            'no_hp' => '081234567890',
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertRedirect(route('login'));

        $user = User::where('username', 'penghuni_nf201')->firstOrFail();

        $this->assertNotEquals($password, $user->password);
        $this->assertTrue(Hash::check($password, $user->password));
    }

    // NF2-02: Password setelah diganti tetap tersimpan dalam bentuk hash.
    public function test_nf2_02_password_setelah_perubahan_tetap_di_hash(): void
    {
        $user = $this->buatUser();
        $user->update(['must_change_password' => true]);

        $response = $this->actingAs($user)->post(
            route('password.force.store'),
            [
                'password' => 'PasswordBaru123',
                'password_confirmation' => 'PasswordBaru123',
            ]
        );

        $response->assertRedirect();

        $user->refresh();

        $this->assertNotEquals('PasswordBaru123', $user->password);
        $this->assertTrue(Hash::check('PasswordBaru123', $user->password));
        $this->assertFalse($user->must_change_password);
    }
}