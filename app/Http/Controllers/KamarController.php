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
    private function owned(KamarKost $kamar, Request $r)
    {
        abort_if(
            $kamar->id_kost !== $r->user()->kost->id,
            403
        );
    }

    public function index(Request $r)
    {
        $kostId = $r->user()->kost->id;

        $items = KamarKost::where('id_kost', $kostId)
            ->with('riwayatHunian')
            ->orderBy('nomor_kamar')
            ->get();

        return view('admin.kamar.index', compact('items'));
    }

    public function create(Request $r)
    {
        return view('admin.kamar.form', [
            'item' => new KamarKost(),
            'fasilitas' => Fasilitas::orderBy('nama_fasilitas')->get(),
            'selected' => [],
        ]);
    }

    public function store(Request $r)
    {
        $kostId = $r->user()->kost->id;

        $d = $r->validate([
            'nama_kamar' => [
                'required',
                'string',
                'max:255',
            ],

            'nomor_kamar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kamar_kosts', 'nomor_kamar')
                    ->where('id_kost', $kostId),
            ],

            'ukuran_kamar' => [
                'nullable',
                'string',
                'max:255',
            ],

            'foto_kamar' => [
                'nullable',
                'array',
            ],

            'foto_kamar.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'fasilitas' => [
                'nullable',
                'array',
            ],

            'fasilitas.*' => [
                'integer',
                'exists:fasilitas,id_fasilitas',
            ],
        ]);

        $fotoPaths = [];

        if ($r->hasFile('foto_kamar')) {
            foreach ($r->file('foto_kamar') as $foto) {
                $fotoPaths[] = $foto->store(
                    'kamar',
                    'public'
                );
            }
        }

        $kamar = KamarKost::create([
            'id_kost' => $kostId,
            'nama_kamar' => $d['nama_kamar'],
            'nomor_kamar' => $d['nomor_kamar'],
            'ukuran_kamar' => $d['ukuran_kamar'] ?? null,
            'foto_kamar' => $fotoPaths,
        ]);

        // Simpan fasilitas kamar
        $kamar->fasilitas()->sync(
            $d['fasilitas'] ?? []
        );

        return redirect()
            ->route('admin.kamar.index')
            ->with(
                'success',
                'Kamar berhasil ditambahkan.'
            );
    }

    public function edit(Request $r, KamarKost $kamar)
    {
        $this->owned($kamar, $r);

        return view('admin.kamar.form', [
            'item' => $kamar,

            'fasilitas' => Fasilitas::orderBy(
                'nama_fasilitas'
            )->get(),

            'selected' => $kamar
                ->fasilitas()
                ->pluck('fasilitas.id_fasilitas')
                ->all(),
        ]);
    }

    public function update(
        Request $r,
        KamarKost $kamar
    ) {
        $this->owned($kamar, $r);

        $d = $r->validate([
            'nama_kamar' => [
                'required',
                'string',
                'max:255',
            ],

            'nomor_kamar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kamar_kosts', 'nomor_kamar')
                    ->where(
                        'id_kost',
                        $kamar->id_kost
                    )
                    ->ignore(
                        $kamar->id_kamar,
                        'id_kamar'
                    ),
            ],

            'ukuran_kamar' => [
                'nullable',
                'string',
                'max:255',
            ],

            'foto_kamar' => [
                'nullable',
                'array',
            ],

            'foto_kamar.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'fasilitas' => [
                'nullable',
                'array',
            ],

            'fasilitas.*' => [
                'integer',
                'exists:fasilitas,id_fasilitas',
            ],
        ]);

        $fotoPaths = $kamar->foto_kamar ?? [];

        if ($r->hasFile('foto_kamar')) {

            foreach ($r->file('foto_kamar') as $foto) {

                $fotoPaths[] = $foto->store(
                    'kamar',
                    'public'
                );
            }
        }

        $kamar->update([
            'nama_kamar' => $d['nama_kamar'],
            'nomor_kamar' => $d['nomor_kamar'],
            'ukuran_kamar' => $d['ukuran_kamar'] ?? null,
            'foto_kamar' => $fotoPaths,
        ]);

        // Update fasilitas kamar
        $kamar->fasilitas()->sync(
            $d['fasilitas'] ?? []
        );

        return redirect()
            ->route('admin.kamar.index')
            ->with(
                'success',
                'Kamar berhasil diperbarui.'
            );
    }

    public function destroy(
        Request $r,
        KamarKost $kamar
    ) {
        $this->owned($kamar, $r);

        $fotoPaths = $kamar->foto_kamar ?? [];

        foreach ($fotoPaths as $foto) {
            if ($foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        $kamar->fasilitas()->detach();

        $kamar->delete();

        return redirect()
            ->route('admin.kamar.index')
            ->with(
                'success',
                'Kamar berhasil dihapus.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Fasilitas Lama
    |--------------------------------------------------------------------------
    |
    | Method ini tetap dipertahankan supaya route lama tidak rusak.
    | Tombol fasilitas di halaman daftar kamar sudah tidak digunakan.
    |
    */

    public function editFasilitas(
        Request $r,
        KamarKost $kamar
    ) {
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
                    ->all(),
            ]
        );
    }

    public function updateFasilitas(
        Request $r,
        KamarKost $kamar
    ) {
        $this->owned($kamar, $r);

        $d = $r->validate([
            'fasilitas' => [
                'nullable',
                'array',
            ],

            'fasilitas.*' => [
                'integer',
                'exists:fasilitas,id_fasilitas',
            ],
        ]);

        $kamar->fasilitas()->sync(
            $d['fasilitas'] ?? []
        );

        return redirect()
            ->route('admin.kamar.index')
            ->with(
                'success',
                'Fasilitas kamar berhasil diperbarui.'
            );
    }
}