<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kost;
use App\Models\KamarKost;
use App\Models\PeriodePenagihan;
use App\Models\HargaKamar;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\RiwayatHunian;
use App\Models\Aduan;
use App\Notifications\AduanBaru;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RiwayatPembayaranAduanTest extends TestCase
{
    use RefreshDatabase;

    private function buatPenghuni(): User
    {
        return User::create([
            'username' => 'penghuni_' . uniqid(),
            'nik' => (string) random_int(1000000000000000, 9999999999999999),
            'nama' => 'Penghuni Pengujian',
            'password' => bcrypt('Password123'),
            'no_hp' => '081234567890',
            'role' => 'penghuni kost',
            'status' => 'aktif',
            'must_change_password' => false,
        ]);
    }

    private function buatDataPembayaran(User $penghuni, string $status): Pembayaran
    {
        $admin = User::create([
            'username' => 'admin_' . uniqid(),
            'nik' => (string) random_int(1000000000000000, 9999999999999999),
            'nama' => 'Admin Pengujian',
            'password' => bcrypt('Password123'),
            'no_hp' => '081234567891',
            'role' => 'admin kost',
            'status' => 'aktif',
            'must_change_password' => false,
        ]);

        $kost = Kost::create([
            'nama_kost' => 'Kost Pengujian',
            'alamat' => 'Jalan Pengujian No. 1',
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

        return Pembayaran::create([
            'id_tagihan' => $tagihan->id_tagihan,
            'nominal_pembayaran' => 500000,
            'tanggal_bayar' => now()->toDateString(),
            'bukti_bayar' => 'bukti-pengujian.jpg',
            'status_validasi' => $status,
        ]);
    }

    /**
     * TC-172
     * Riwayat pembayaran kosong.
     */
    public function test_tc_172_penghuni_dapat_melihat_riwayat_pembayaran_kosong(): void
    {
        $penghuni = $this->buatPenghuni();

        $response = $this->actingAs($penghuni)
            ->get(route('penghuni.riwayat-pembayaran'));

        $response->assertOk(); 
        $response->assertViewIs('penghuni.pembayaran.riwayat');
        $response->assertSee('Belum Ada Transaksi');
        $response->assertSee('Belum ada pembayaran yang tercatat');

        $response->assertViewHas('items', function ($items) {
            return $items->isEmpty();
        });
    }

    /**
     * TC-173
     * Riwayat tidak memuat pembayaran penghuni lain.
     */
    public function test_tc_173_riwayat_hanya_menampilkan_pembayaran_milik_penghuni_login(): void
    {
        $penghuniA = $this->buatPenghuni();
        $penghuniB = $this->buatPenghuni();

        $pembayaranA = $this->buatDataPembayaran(
            $penghuniA,
            'menunggu'
        );

        $this->buatDataPembayaran(
            $penghuniB,
            'diterima'
        );

        $response = $this->actingAs($penghuniA)
            ->get(route('penghuni.riwayat-pembayaran'));

        $response->assertOk();

        $response->assertViewHas('items', function ($items) use ($pembayaranA) {
            return $items->count() === 1
                && $items->first()->id_pembayaran === $pembayaranA->id_pembayaran;
        });
    }

    /**
     * TC-174
     * Status riwayat sesuai hasil verifikasi admin.
     */
    public function test_tc_174_status_riwayat_sesuai_hasil_verifikasi_admin(): void
    {
        $penghuni = $this->buatPenghuni();

        $this->buatDataPembayaran($penghuni, 'diterima');
        $this->buatDataPembayaran($penghuni, 'ditolak');
        $this->buatDataPembayaran($penghuni, 'menunggu');

        $response = $this->actingAs($penghuni)
            ->get(route('penghuni.riwayat-pembayaran'));

        $response->assertOk();

        $response->assertViewHas('items', function ($items) {
            return $items->count() === 3
                && $items->contains('status_validasi', 'diterima')
                && $items->contains('status_validasi', 'ditolak')
                && $items->contains('status_validasi', 'menunggu');
        });

        $response->assertSee('Diterima');
        $response->assertSee('Ditolak');
        $response->assertSee('Menunggu');
    }

    /**
     * TC-175
     * Riwayat pembayaran gagal dimuat ketika tabel pembayaran tidak tersedia.
     *
     * Catatan: controller saat ini belum memiliki penanganan khusus
     * untuk kegagalan database. Karena itu, hasil yang diuji adalah HTTP 500.
     */
    public function test_tc_175_sistem_mengembalikan_error_jika_riwayat_gagal_dimuat(): void
    {
        $penghuni = $this->buatPenghuni();

        Schema::disableForeignKeyConstraints();
        Schema::drop('pembayarans');
        Schema::enableForeignKeyConstraints();

        $response = $this->actingAs($penghuni)
            ->get(route('penghuni.riwayat-pembayaran'));

        $response->assertServerError();
    }

    /**
     * TC-176
     * Mengirim aduan dengan data lengkap.
     */
    public function test_tc_176_penghuni_dapat_mengirim_aduan_dengan_data_lengkap(): void
    {
        Storage::fake('public');
        Notification::fake();

        $penghuni = $this->buatPenghuni();

        $admin = User::create([
            'username' => 'admin_aduan_' . uniqid(),
            'nik' => (string) random_int(1000000000000000, 9999999999999999),
            'nama' => 'Admin Kost Pengujian',
            'password' => bcrypt('Password123'),
            'no_hp' => '081234567892',
            'role' => 'admin kost',
            'status' => 'aktif',
            'must_change_password' => false,
        ]);

        $kost = Kost::create([
            'nama_kost' => 'Kost Aduan Pengujian',
            'alamat' => 'Jalan Pengujian No. 2',
            'id_user' => $admin->id,
        ]);

        RiwayatHunian::create([
            'id_user' => $penghuni->id,
            'id_kost' => $kost->id,
            'id_kamar' => null,
            'tanggal_masuk' => now()->toDateString(),
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($penghuni)
            ->post(route('penghuni.aduan.store'), [
                'isi_aduan' => 'Lampu kamar saya mati dan perlu diperbaiki.',
                'foto_aduan' => UploadedFile::fake()->image('lampu.jpg'),
            ]);

        $response->assertRedirect(route('penghuni.aduan.index'));
        $response->assertSessionHas('success', 'Aduan berhasil dikirim.');

        $this->assertDatabaseHas('aduan', [
            'id_user' => $penghuni->id,
            'kost_id' => $kost->id,
            'isi_aduan' => 'Lampu kamar saya mati dan perlu diperbaiki.',
            'status' => 'baru',
        ]);

        $aduan = Aduan::where('id_user', $penghuni->id)->first();

        $this->assertNotNull($aduan->foto_aduan);
        Storage::disk('public')->assertExists($aduan->foto_aduan);

        Notification::assertSentTo(
            $admin,
            AduanBaru::class
        );
    }
}
