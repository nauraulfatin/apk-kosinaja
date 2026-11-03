<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class NonFunctionalRoleAccessTest extends TestCase
{
    use RefreshDatabase;

    private function buatUser(string $role): User
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

    // NF4-01: Admin kos dapat mengakses halaman pengelolaan kos.
    public function test_nf4_01_admin_kost_dapat_mengakses_halaman_admin(): void
    {
        $admin = $this->buatUser('admin kost');

        $response = $this->actingAs($admin)
            ->get(route('admin.aturan.index'));

        $response->assertOk();
    }

    // NF4-02: Penghuni tidak dapat mengakses halaman admin.
    public function test_nf4_02_penghuni_ditolak_mengakses_halaman_admin(): void
    {
        $penghuni = $this->buatUser('penghuni kost');

        $response = $this->actingAs($penghuni)
            ->get(route('admin.dashboard'));

        $response->assertForbidden();
    }
}