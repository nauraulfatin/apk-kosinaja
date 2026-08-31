<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Kost;
use App\Models\RiwayatHunian;
use App\Models\Pembayaran;
use App\Models\Aduan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminKostController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CATATAN TANGGUNG JAWAB CONTROLLER
    |--------------------------------------------------------------------------
    |
    | Registrasi Admin Kos ditangani sepenuhnya oleh AuthController.
    | Controller ini hanya menangani fitur Admin Kos setelah login.
    |
    */

    //dashboard admin
    public function dashboard(Request $request)
    {
        $kost = $request->user()->kost;

        /*
        |--------------------------------------------------------------------------
        | PASTIKAN ADMIN MEMILIKI KOS
        |--------------------------------------------------------------------------
        |
        | Secara alur normal setiap Admin Kos sudah mempunyai record kos sejak
        | registrasi. Pengecekan ini mencegah error null apabila data tidak utuh.
        |
        */
        abort_unless(
            $kost,
            403,
            'Admin belum memiliki data kos.'
        );

        /*
        |--------------------------------------------------------------------------
        | TOTAL KAMAR
        |--------------------------------------------------------------------------
        */
        $totalKamar = $kost
            ->kamars()
            ->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL PENGHUNI AKTIF
        |--------------------------------------------------------------------------
        |
        | Sumber kebenaran penghuni adalah riwayat_hunians, bukan keberadaan
        | tagihan. Dengan begitu penghuni aktif tetap terhitung meskipun belum
        | mempunyai tagihan, dan penghuni lama yang masih mempunyai riwayat
        | tagihan tidak ikut dihitung.
        |
        */
        $totalPenghuni = RiwayatHunian::where(
                'id_kost',
                $kost->id
            )
            ->where(
                'status',
                'aktif'
            )
            ->distinct()
            ->count('id_user');

        /*
        |--------------------------------------------------------------------------
        | PEMBAYARAN MENUNGGU VERIFIKASI
        |--------------------------------------------------------------------------
        */
        $pendingPembayaran = Pembayaran::where(
                'status_validasi',
                'menunggu'
            )
            ->whereHas(
                'tagihan.kamar',
                function ($query) use ($kost) {
                    $query->where(
                        'id_kost',
                        $kost->id
                    );
                }
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | PEMBAYARAN TERBARU
        |--------------------------------------------------------------------------
        */
        $pembayaranTerbaru = Pembayaran::with([
                'tagihan.user',
                'tagihan.kamar',
                'tagihan.hargaKamar',
            ])
            ->where(
                'status_validasi',
                'menunggu'
            )
            ->whereHas(
                'tagihan.kamar',
                function ($query) use ($kost) {
                    $query->where(
                        'id_kost',
                        $kost->id
                    );
                }
            )
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | ADUAN TERBARU
        |--------------------------------------------------------------------------
        */
        $aduanTerbaru = Aduan::with('user')
            ->where(
                'kost_id',
                $kost->id
            )
            ->orderBy(
                'tanggal',
                'desc'
            )
            ->take(3)
            ->get();

        return view(
            'admin.dashboard',
            [
                'kost' => $kost,
                'totalKamar' => $totalKamar,
                'totalPenghuni' => $totalPenghuni,
                'pendingPembayaran' => $pendingPembayaran,
                'pembayaranTerbaru' => $pembayaranTerbaru,
                'aduanTerbaru' => $aduanTerbaru,
            ]
        );
    }

    //infomrasi kost

    public function index(Request $request)
    {
        return view('admin.kost.index', [
            'kost' => $request->user()->kost
        ]);
    }

   //form edit kos

    public function editKost(Request $request)
    {
        return view('admin.kost.kost-edit', [
            'kost' => $request->user()->kost,
            //fasilitas
            'fasilitas' => Fasilitas::all(),
        ]);
    }

    //update kost
    public function updateKost(Request $request)
    {
        $kost = $request->user()->kost;

        abort_unless(
            $kost,
            403,
            'Admin belum memiliki data kos.'
        );

        $data = $request->validate(
            [
                'nama_kost' => ['required', 'string', 'max:150'],
                'no_hp' => ['required', 'string', 'regex:/^08[0-9]{8,13}$/'],
                'alamat' => ['required', 'string', 'max:1000'],
                'deskripsi' => ['nullable', 'string', 'max:5000'],
                'fasilitas' => ['nullable', 'array'],
                'fasilitas.*' => ['integer', 'distinct', 'exists:fasilitas,id_fasilitas'],
                'foto_kost' => ['nullable', 'array', 'max:10'],
                'foto_kost.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
                'lokasi' => ['nullable', 'string', 'max:2000'],
                'deleted_old_images' => ['nullable', 'json'],
            ],
            [
                'no_hp.regex' => 'Nomor WhatsApp harus diawali 08 dan berisi 10–15 digit.',
                'foto_kost.max' => 'Maksimal 10 foto dapat diunggah sekaligus.',
                'foto_kost.*.image' => 'Setiap file foto kos harus berupa gambar yang valid.',
                'foto_kost.*.mimes' => 'Format foto kos harus JPG, JPEG, PNG, atau WEBP.',
                'foto_kost.*.max' => 'Ukuran setiap foto kos maksimal 10 MB.',
            ]
        );

        $oldPhotos = $kost->foto_kost ?? [];
        $deletedPhotos = json_decode(
            $data['deleted_old_images'] ?? '[]',
            true
        ) ?? [];

        // User hanya boleh meminta penghapusan foto yang memang dimiliki kosnya.
        $photosToDelete = array_values(
            array_intersect($oldPhotos, $deletedPhotos)
        );

        $remainingPhotos = array_values(
            array_filter(
                $oldPhotos,
                fn ($foto) => !in_array($foto, $photosToDelete, true)
            )
        );

        $newPhotos = [];

        try {
            if ($request->hasFile('foto_kost')) {
                foreach ($request->file('foto_kost') as $foto) {
                    $newPhotos[] = $foto->store('kost', 'public');
                }
            }

            DB::transaction(function () use (
                $request,
                $kost,
                $data,
                $remainingPhotos,
                $newPhotos
            ) {
                $kost->update([
                    'nama_kost' => $data['nama_kost'],
                    'alamat' => $data['alamat'],
                    'deskripsi' => $data['deskripsi'] ?? null,
                    'lokasi' => $data['lokasi'] ?? null,
                    'foto_kost' => array_values([
                        ...$remainingPhotos,
                        ...$newPhotos,
                    ]),
                ]);

                $request->user()->update([
                    'no_hp' => $data['no_hp'],
                ]);

                $kost->fasilitas()->sync(
                    $data['fasilitas'] ?? []
                );
            });
        } catch (\Throwable $e) {
            // Jika database gagal, jangan tinggalkan file baru tanpa record.
            if ($newPhotos !== []) {
                Storage::disk('public')->delete($newPhotos);
            }

            Log::error('Gagal memperbarui informasi kos.', [
                'user_id' => $request->user()->id,
                'kost_id' => $kost->id,
                'exception' => $e,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Informasi kos gagal diperbarui. Silakan coba lagi.');
        }

        // File lama baru dihapus setelah transaksi database benar-benar sukses.
        if ($photosToDelete !== []) {
            Storage::disk('public')->delete($photosToDelete);
        }

        return redirect()
            ->route('admin.kost.index')
            ->with('success', 'Informasi kost berhasil diperbarui.');
    }
 //refresh kode undangan

public function refreshKode(Request $request)
{
    $kost = $request->user()->kost;
    do {
        $kode = strtoupper( Str::random(8) );
    } while (
        Kost::where(
            'kode_undangan', $kode
        )->exists()
    );

    $kost->update([
        'kode_undangan' => $kode
    ]);

    return back()->with(
        'success',
        'Kode undangan berhasil diperbarui.'
    );
}
}