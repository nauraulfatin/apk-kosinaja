<?php
namespace Database\Seeders;
use App\Models\PeriodePenagihan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'superadmin'],
            ['nama' => 'superadmin_kosinaja', 'nik' => '0987654321', 'password' => Hash::make('orbitgacor'), 'role' => 'super admin', 'no_hp' => '08123456789', 'status' => 'aktif', 'must_change_password' => true]
        );
        $periodes = [
            ['periode_penagihan' => 'Harian', 'jumlah_interval' => 1, 'satuan_interval' => 'hari'],
            ['periode_penagihan' => 'Mingguan', 'jumlah_interval' => 1, 'satuan_interval' => 'minggu'],
            ['periode_penagihan' => 'Bulanan', 'jumlah_interval' => 1, 'satuan_interval' => 'bulan'],
            ['periode_penagihan' => '3 Bulan', 'jumlah_interval' => 3, 'satuan_interval' => 'bulan'],
            ['periode_penagihan' => 'Semester', 'jumlah_interval' => 6, 'satuan_interval' => 'bulan'],
            ['periode_penagihan' => 'Tahunan', 'jumlah_interval' => 1, 'satuan_interval' => 'tahun'],
        ];

        foreach ($periodes as $periode) {
            PeriodePenagihan::updateOrCreate(
                ['periode_penagihan' => $periode['periode_penagihan']],
                ['jumlah_interval' => $periode['jumlah_interval'], 'satuan_interval' => $periode['satuan_interval']]
            );
        }
    }
}