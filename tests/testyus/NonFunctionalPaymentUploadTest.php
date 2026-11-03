<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kost;
use App\Models\KamarKost;
use App\Models\PeriodePenagihan;
use App\Models\HargaKamar;
use App\Models\Tagihan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NonFunctionalPaymentUploadTest extends TestCase
{
    use RefreshDatabase;

    private function buatTagihan(): array
    {
        $penghuni = User::create([
            'nama' => 'Penghuni Pengujian',
            'nik' => (string) random_int(1000000000000000, 9999999999999999),
            'username' => 'penghuni_' . uniqid(),
            'no_hp' => '081234567890',
            'password' => Hash::make('Password123'),
            'role' => 'penghuni kost',
            'status' => 'aktif',
            'must_change_password' => false,
        ]);

        $admin = User::create([
            'nama' => 'Admin Pengujian',
            'nik' => (string) random_int(1000000000000000, 9999999999999999),
            'username' => 'admin_' . uniqid(),
            'no_hp' => '081234567891',
            'password' => Hash::make('Password123'),
            'role' => 'admin kost',
            'status' => 'aktif',
            'must_change_password' => false,
        ]);

        $kost = Kost::create([
            'nama_kost' => 'Kost Pengujian',
            'alamat' => 'Jalan Pengujian',
            'id_user' => $admin->id,
        ]);

        $kamar = KamarKost::create([
            'id_kost' => $kost->id,
            'nama_kamar' => 'Kamar A',
            'nomor_kamar' => 'A-' . uniqid(),
            'ukuran_kamar' => '3x3',
        ]);

        $periode = PeriodePenagihan::create([
            'periode_penagihan' => 'Bulanan ' . uniqid(),
            'jumlah_interval' => 1,
            'satuan_interval' => 'bulan',
        ]);

        $harga = HargaKamar::create([
            'id_kamar' => $kamar->id_kamar,
            'harga' => 1000000,
            'isactive' => true,
            'id_periode' => $periode->id_penagihan,
        ]);

        $tagihan = Tagihan::create([
            'id_kamar' => $kamar->id_kamar,
            'id_user' => $penghuni->id,
            'id_harga_kamar' => $harga->id_harga_kamar,
            'tanggal_mulai' => now()->startOfMonth()->toDateString(),
            'tanggal_selesai' => now()->endOfMonth()->toDateString(),
            'tanggal_jatuh_tempo' => now()->addDays(7)->toDateString(),
            'status' => 'pending',
        ]);

        return [$penghuni, $tagihan];
    }

    // NF5-01: Upload bukti pembayaran berukuran 5 MB diterima.
    public function test_nf5_01_sistem_menerima_bukti_pembayaran_berukuran_5_mb(): void
    {
        Storage::fake('public');

        [$penghuni, $tagihan] = $this->buatTagihan();

        $response = $this->actingAs($penghuni)->post(
            route('penghuni.pembayaran.store'),
            [
                'id_tagihan' => $tagihan->id_tagihan,
                'nominal_pembayaran' => 500000,
                'bukti_bayar' => UploadedFile::fake()
                    ->image('bukti.jpg')
                    ->size(5120),
            ]
        );

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('pembayarans', [
            'id_tagihan' => $tagihan->id_tagihan,
            'nominal_pembayaran' => 500000,
            'status_validasi' => 'menunggu',
        ]);

        $pembayaran = \App\Models\Pembayaran::where(
            'id_tagihan',
            $tagihan->id_tagihan
        )->firstOrFail();

        Storage::disk('public')->assertExists($pembayaran->bukti_bayar);
    }

    // NF5-02: Upload bukti pembayaran lebih dari 10 MB ditolak.
    public function test_nf5_02_sistem_menolak_bukti_pembayaran_di_atas_10_mb(): void
    {
        Storage::fake('public');

        [$penghuni, $tagihan] = $this->buatTagihan();

        $response = $this->actingAs($penghuni)->post(
            route('penghuni.pembayaran.store'),
            [
                'id_tagihan' => $tagihan->id_tagihan,
                'nominal_pembayaran' => 500000,
                'bukti_bayar' => UploadedFile::fake()
                    ->image('bukti-besar.jpg')
                    ->size(10241),
            ]
        );

        $response->assertSessionHasErrors('bukti_bayar');

        $this->assertDatabaseMissing('pembayarans', [
            'id_tagihan' => $tagihan->id_tagihan,
        ]);
    }
}