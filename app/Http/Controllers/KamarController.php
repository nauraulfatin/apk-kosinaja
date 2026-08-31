<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\KamarKost;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KamarController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | VALIDASI KEPEMILIKAN KAMAR
    |--------------------------------------------------------------------------
    */
    private function owned(
        KamarKost $kamar,
        Request $r
    )
    {
        abort_if(
            $kamar->id_kost !== $r->user()->kost->id,
            403
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LIST KAMAR
    |--------------------------------------------------------------------------
    */
    public function index(Request $r)
    {
        return view('admin.kamar.index', [

            'items' => KamarKost::where(
                'id_kost',
                $r->user()->kost->id
            )->get()

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FORM CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.kamar.form', [

            'item' => new KamarKost

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $r)
    {
        $kost = $r->user()->kost;
        abort_unless($kost, 403, 'Admin belum memiliki data kos.');

        $d = $r->validate(
            [
                'nama_kamar' => ['nullable', 'string', 'max:100'],
                'nomor_kamar' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('kamar_kosts')
                        ->where(fn ($q) => $q->where('id_kost', $kost->id)),
                ],
                'ukuran_kamar' => ['nullable', 'string', 'max:50'],
                'foto_kamar' => ['nullable', 'array', 'max:10'],
                'foto_kamar.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            ],
            [
                'nomor_kamar.unique' => 'Nomor kamar tersebut sudah digunakan pada kos Anda.',
                'foto_kamar.max' => 'Maksimal 10 foto kamar dapat diunggah sekaligus.',
                'foto_kamar.*.mimes' => 'Format foto kamar harus JPG, JPEG, PNG, atau WEBP.',
                'foto_kamar.*.max' => 'Ukuran setiap foto kamar maksimal 10 MB.',
            ]
        );

        $fotoPaths = [];

        try {
            if ($r->hasFile('foto_kamar')) {
                foreach ($r->file('foto_kamar') as $foto) {
                    $fotoPaths[] = $foto->store('kamar', 'public');
                }
            }

            DB::transaction(function () use ($d, $kost, $fotoPaths) {
                KamarKost::create([
                    'id_kost' => $kost->id,
                    'nama_kamar' => $d['nama_kamar'] ?? null,
                    'nomor_kamar' => $d['nomor_kamar'],
                    'ukuran_kamar' => $d['ukuran_kamar'] ?? null,
                    'foto_kamar' => $fotoPaths,
                ]);
            });
        } catch (\Throwable $e) {
            if ($fotoPaths !== []) {
                Storage::disk('public')->delete($fotoPaths);
            }

            Log::error('Gagal menambahkan kamar.', [
                'user_id' => $r->user()->id,
                'kost_id' => $kost->id,
                'exception' => $e,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Kamar gagal ditambahkan. Silakan coba lagi.');
        }

        return redirect()
            ->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(
        Request $r,
        KamarKost $kamar
    )
    {
        $this->owned($kamar, $r);

        return view('admin.kamar.form', [

            'item' => $kamar

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(
        Request $r,
        KamarKost $kamar
    )
    {
        $this->owned($kamar, $r);

        $d = $r->validate(
            [
                'nama_kamar' => ['nullable', 'string', 'max:100'],
                'nomor_kamar' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('kamar_kosts')
                        ->ignore($kamar->id_kamar, 'id_kamar')
                        ->where(fn ($q) => $q->where('id_kost', $r->user()->kost->id)),
                ],
                'ukuran_kamar' => ['nullable', 'string', 'max:50'],
                'foto_kamar' => ['nullable', 'array', 'max:10'],
                'foto_kamar.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
                'deleted_old_images' => ['nullable', 'json'],
            ],
            [
                'nomor_kamar.unique' => 'Nomor kamar tersebut sudah digunakan pada kos Anda.',
                'foto_kamar.max' => 'Maksimal 10 foto kamar dapat diunggah sekaligus.',
                'foto_kamar.*.mimes' => 'Format foto kamar harus JPG, JPEG, PNG, atau WEBP.',
                'foto_kamar.*.max' => 'Ukuran setiap foto kamar maksimal 10 MB.',
            ]
        );

        $oldPhotos = $kamar->foto_kamar ?? [];
        $deletedPhotos = json_decode(
            $d['deleted_old_images'] ?? '[]',
            true
        ) ?? [];

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
            if ($r->hasFile('foto_kamar')) {
                foreach ($r->file('foto_kamar') as $foto) {
                    $newPhotos[] = $foto->store('kamar', 'public');
                }
            }

            DB::transaction(function () use (
                $kamar,
                $d,
                $remainingPhotos,
                $newPhotos
            ) {
                $kamar->update([
                    'nama_kamar' => $d['nama_kamar'] ?? null,
                    'nomor_kamar' => $d['nomor_kamar'],
                    'ukuran_kamar' => $d['ukuran_kamar'] ?? null,
                    'foto_kamar' => array_values([
                        ...$remainingPhotos,
                        ...$newPhotos,
                    ]),
                ]);
            });
        } catch (\Throwable $e) {
            if ($newPhotos !== []) {
                Storage::disk('public')->delete($newPhotos);
            }

            Log::error('Gagal memperbarui kamar.', [
                'user_id' => $r->user()->id,
                'kamar_id' => $kamar->id_kamar,
                'exception' => $e,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Kamar gagal diperbarui. Silakan coba lagi.');
        }

        if ($photosToDelete !== []) {
            Storage::disk('public')->delete($photosToDelete);
        }

        return redirect()
            ->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(
        Request $r,
        KamarKost $kamar
    )
    {
        $this->owned($kamar, $r);

        $masihDitempati = $kamar->riwayatHunian()
            ->where('status', 'aktif')
            ->exists();

        if ($masihDitempati) {
            return back()->with(
                'error',
                'Kamar tidak dapat dihapus karena masih ditempati penghuni aktif.'
            );
        }

        $fotoPaths = $kamar->foto_kamar ?? [];

        try {
            DB::transaction(function () use ($kamar) {
                // Pembayaran ikut terhapus melalui cascade dari tagihan.
                $kamar->tagihans()->delete();

                // Pivot fasilitas dan harga kamar ditangani foreign key cascade.
                $kamar->delete();
            });
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus kamar.', [
                'user_id' => $r->user()->id,
                'kamar_id' => $kamar->id_kamar,
                'exception' => $e,
            ]);

            return back()->with(
                'error',
                'Kamar gagal dihapus. Silakan coba lagi.'
            );
        }

        // File dihapus hanya setelah transaksi database sukses.
        if ($fotoPaths !== []) {
            Storage::disk('public')->delete($fotoPaths);
        }

        return back()->with(
            'success',
            'Kamar dan data terkait berhasil dihapus.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM FASILITAS
    |--------------------------------------------------------------------------
    */
    public function editFasilitas(
        Request $r,
        KamarKost $kamar
    )
    {
        $this->owned($kamar, $r);

        return view(
            'admin.kamar.fasilitas.edit',
            [

                'kamar' => $kamar,

                'fasilitas' => Fasilitas::orderBy(
                    'nama_fasilitas'
                )->get(),

                'selected' => $kamar
                    ->fasilitas()
                    ->pluck(
                        'fasilitas.id_fasilitas'
                    )
                    ->all()

            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE FASILITAS
    |--------------------------------------------------------------------------
    */
    public function updateFasilitas(
        Request $r,
        KamarKost $kamar
    )
    {
        $this->owned($kamar, $r);

        $data = $r->validate([
            'fasilitas' => ['nullable', 'array'],
            'fasilitas.*' => [
                'integer',
                'distinct',
                'exists:fasilitas,id_fasilitas',
            ],
        ]);

        $kamar->fasilitas()->sync(
            $data['fasilitas'] ?? []
        );

        return redirect()
            ->route('admin.kamar.index')
            ->with(
                'success',
                'Fasilitas kamar berhasil disimpan.'
            );
    }
}