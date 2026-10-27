
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
    | CEK KEPEMILIKAN KAMAR
    |--------------------------------------------------------------------------
    */

    private function owned(KamarKost $kamar, Request $r)
    {
        abort_if(
            !$r->user()->kost ||
            $kamar->id_kost !== $r->user()->kost->id,
            403,
            'Anda tidak memiliki akses ke kamar ini.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DAFTAR KAMAR
    |--------------------------------------------------------------------------
    */

    public function index(Request $r)
    {
        $kost = $r->user()->kost;

        abort_unless(
            $kost,
            403,
            'Admin belum memiliki data kos.'
        );

        $items = KamarKost::where('id_kost', $kost->id)
            ->with('riwayatHunian')
            ->orderBy('nomor_kamar')
            ->get();

        return view(
            'admin.kamar.index',
            compact('items')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH KAMAR
    |--------------------------------------------------------------------------
    */

    public function create(Request $r)
    {
        abort_unless(
            $r->user()->kost,
            403,
            'Admin belum memiliki data kos.'
        );

        return view('admin.kamar.form', [
            'item' => new KamarKost(),

            'fasilitas' => Fasilitas::orderBy(
                'nama_fasilitas'
            )->get(),

            'selected' => [],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN KAMAR BARU
    |--------------------------------------------------------------------------
    */

    public function store(Request $r)
    {
        $kost = $r->user()->kost;

        abort_unless(
            $kost,
            403,
            'Admin belum memiliki data kos.'
        );

        $kostId = $kost->id;

        $d = $r->validate([
            'nama_kamar' => [
                'required',
                'string',
                'max:100',
            ],

            'nomor_kamar' => [
                'required',
                'string',
                'max:5',
                Rule::unique('kamar_kosts', 'nomor_kamar')
                    ->where('id_kost', $kostId),
            ],

            'ukuran_kamar' => [
                'nullable',
                'string',
                'max:100',
            ],

            'foto_kamar' => [
                'nullable',
                'array',
            ],

            'foto_kamar.*' => [
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120',
            ],

            'fasilitas' => [
                'nullable',
                'array',
            ],

            'fasilitas.*' => [
                'integer',
                'distinct',
                'exists:fasilitas,id_fasilitas',
            ],
        ], [
            // NAMA KAMAR
            'nama_kamar.required' => 'Nama kamar wajib diisi.',
            'nama_kamar.string' =>  'Nama kamar harus berupa teks.',
            'nama_kamar.max' =>'Nama kamar maksimal 100 karakter.',
            // NOMOR KAMAR
            'nomor_kamar.required' =>'Nomor kamar wajib diisi.',
            'nomor_kamar.string' =>'Nomor kamar harus berupa teks.',
            'nomor_kamar.max' =>'Nomor kamar maksimal 5 karakter.',
            'nomor_kamar.unique' =>'Nomor kamar tersebut sudah digunakan pada kos Anda.',
            // UKURAN KAMAR
            'ukuran_kamar.string' =>'Ukuran kamar harus berupa teks.',
            'ukuran_kamar.max' =>'Ukuran kamar maksimal 100 karakter.',
            // FOTO KAMAR
            'foto_kamar.array' =>'Format unggahan foto kamar tidak valid.',
            'foto_kamar.*.image' =>'Setiap file foto kamar harus berupa gambar yang valid.',
            'foto_kamar.*.mimes' => 'Format foto kamar harus JPG, JPEG, atau PNG',
            'foto_kamar.*.max' =>'Ukuran setiap foto kamar maksimal 5 MB.',

            // FASILITAS
            'fasilitas.array' =>'Format pilihan fasilitas tidak valid.',
            'fasilitas.*.integer' =>'Pilihan fasilitas tidak valid.',
            'fasilitas.*.distinct' =>'Fasilitas yang sama tidak boleh dipilih berulang.',
            'fasilitas.*.exists' =>'Fasilitas yang dipilih tidak tersedia.',
        ]);

        $fotoPaths = [];

        try {
            // Simpan semua foto kamar yang diunggah.
            if ($r->hasFile('foto_kamar')) {
                foreach ($r->file('foto_kamar') as $foto) {
                    $fotoPaths[] = $foto->store(
                        'kamar',
                        'public'
                    );
                }
            }

            DB::transaction(function () use (
                $kostId,
                $d,
                $fotoPaths,
                &$kamar
            ) {
                $kamar = KamarKost::create([
                    'id_kost' => $kostId,
                    'nama_kamar' => $d['nama_kamar'],
                    'nomor_kamar' => $d['nomor_kamar'],
                    'ukuran_kamar' => $d['ukuran_kamar'] ?? null,
                    'foto_kamar' => $fotoPaths,
                ]);

                $kamar->fasilitas()->sync(
                    $d['fasilitas'] ?? []
                );
            });
        } catch (\Throwable $e) {
            if ($fotoPaths !== []) {
                Storage::disk('public')->delete($fotoPaths);
            }

            Log::error('Gagal menambahkan kamar.', [
                'user_id' => $r->user()->id,
                'kost_id' => $kostId,
                'exception' => $e,
            ]);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Kamar gagal ditambahkan. Silakan coba kembali.'
                );
        }

        return redirect()
            ->route('admin.kamar.index')
            ->with(
                'success',
                'Kamar berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT KAMAR
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | PERBARUI KAMAR
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $r,
        KamarKost $kamar
    ) {
        $this->owned($kamar, $r);

        $d = $r->validate([
            'nama_kamar' => [
                'required',
                'string',
                'max:100',
            ],

            'nomor_kamar' => [
                'required',
                'string',
                'max:5',
                Rule::unique('kamar_kosts', 'nomor_kamar')
                    ->where('id_kost', $kamar->id_kost)
                    ->ignore(
                        $kamar->id_kamar,
                        'id_kamar'
                    ),
            ],

            'ukuran_kamar' => [ 'nullable', 'string',  'max:100', ],
            'foto_kamar' => [ 'nullable', 'array', ],
            'foto_kamar.*' => [ 'image', 'mimes:jpg,jpeg,png,webp','max:5120',],
            'fasilitas' => ['nullable', 'array', ],
            'fasilitas.*' => [ 'integer', 'distinct', 'exists:fasilitas,id_fasilitas',],
        ], [
            // NAMA KAMAR
            'nama_kamar.required' => 'Nama kamar wajib diisi.',
            'nama_kamar.string' => 'Nama kamar harus berupa teks.',
            'nama_kamar.max' =>  'Nama kamar maksimal 100 karakter.',

            // NOMOR KAMAR
            'nomor_kamar.required' =>'Nomor kamar wajib diisi.',
            'nomor_kamar.string' =>'Nomor kamar harus berupa teks.',
            'nomor_kamar.max' =>'Nomor kamar maksimal 5 karakter.',
            'nomor_kamar.unique' => 'Nomor kamar tersebut sudah digunakan pada kos Anda.',

            // UKURAN KAMAR
            'ukuran_kamar.string' =>'Ukuran kamar harus berupa teks.',
            'ukuran_kamar.max' =>'Ukuran kamar maksimal 100 karakter.',
            // FOTO KAMAR
            'foto_kamar.array' => 'Format unggahan foto kamar tidak valid.',
            'foto_kamar.*.image' => 'Setiap file foto kamar harus berupa gambar yang valid.',
            'foto_kamar.*.mimes' => 'Format foto kamar harus JPG, JPEG, atau PNG.',
            'foto_kamar.*.max' => 'Ukuran setiap foto kamar maksimal 5 MB.',
        ]);

        $fotoLama = $kamar->foto_kamar ?? [];
        $fotoBaru = [];

        try {
            // Tambahkan foto baru tanpa menghapus foto lama.
            if ($r->hasFile('foto_kamar')) {
                foreach ($r->file('foto_kamar') as $foto) {
                    $fotoBaru[] = $foto->store(
                        'kamar',
                        'public'
                    );
                }
            }

            DB::transaction(function () use (
                $kamar,
                $d,
                $fotoLama,
                $fotoBaru
            ) {
                $kamar->update([
                    'nama_kamar' => $d['nama_kamar'],
                    'nomor_kamar' => $d['nomor_kamar'],
                    'ukuran_kamar' => $d['ukuran_kamar'] ?? null,
                    'foto_kamar' => array_values([
                        ...$fotoLama,
                        ...$fotoBaru,
                    ]),
                ]);

                $kamar->fasilitas()->sync(
                    $d['fasilitas'] ?? []
                );
            });
        } catch (\Throwable $e) {
            if ($fotoBaru !== []) {
                Storage::disk('public')->delete($fotoBaru);
            }

            Log::error('Gagal memperbarui kamar.', [
                'user_id' => $r->user()->id,
                'kamar_id' => $kamar->id_kamar,
                'exception' => $e,
            ]);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Kamar gagal diperbarui. Silakan coba kembali.'
                );
        }

        return redirect()
            ->route('admin.kamar.index')
            ->with(
                'success',
                'Kamar berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS KAMAR
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Request $r,
        KamarKost $kamar
    ) {
        $this->owned($kamar, $r);

        $fotoPaths = $kamar->foto_kamar ?? [];

        DB::transaction(function () use ($kamar) {
            $kamar->fasilitas()->detach();
            $kamar->delete();
        });

        foreach ($fotoPaths as $foto) {
            if ($foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        return redirect()
            ->route('admin.kamar.index')
            ->with(
                'success',
                'Kamar berhasil dihapus.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT FASILITAS LAMA
    |--------------------------------------------------------------------------
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

    /*
    |--------------------------------------------------------------------------
    | PERBARUI FASILITAS KAMAR
    |--------------------------------------------------------------------------
    */

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
                'distinct',
                'exists:fasilitas,id_fasilitas',
            ],
        ], [
            'fasilitas.array' =>
                'Format pilihan fasilitas tidak valid.',

            'fasilitas.*.integer' =>
                'Pilihan fasilitas tidak valid.',

            'fasilitas.*.distinct' =>
                'Fasilitas yang sama tidak boleh dipilih berulang.',

            'fasilitas.*.exists' =>
                'Fasilitas yang dipilih tidak tersedia.',
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
