<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\KamarKost;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | VALIDASI KEPEMILIKAN KAMAR
    |--------------------------------------------------------------------------
    */
    private function owned(KamarKost $kamar, Request $r)
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
        $d = $r->validate([

            'nama_kamar'   => 'nullable',

            'nomor_kamar'  => 'required',

            'ukuran_kamar' => 'nullable',

            /*
            |--------------------------------------------------------------------------
            | FOTO MULTIPLE
            |--------------------------------------------------------------------------
            */

            'foto_kamar'   => 'nullable|array',

            'foto_kamar.*' => 'image|max:2048',
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPLOAD MULTIPLE FOTO
        |--------------------------------------------------------------------------
        */

        if ($r->hasFile('foto_kamar'))
        {
            $fotoPaths = [];

            foreach ($r->file('foto_kamar') as $foto)
            {
                $fotoPaths[] =
                    $foto->store('kamar', 'public');
            }

            $d['foto_kamar'] = $fotoPaths;
        }

        /*
        |--------------------------------------------------------------------------
        | ID KOST
        |--------------------------------------------------------------------------
        */

        $d['id_kost'] =
            $r->user()->kost->id;
        
        /*
|--------------------------------------------------------------------------
| DEFAULT STATUS
|--------------------------------------------------------------------------
*/

$d['status'] = 'kosong';

        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        KamarKost::create($d);

        return redirect()
            ->route('admin.kamar.index')
            ->with(
                'success',
                'Kamar berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Request $r, KamarKost $kamar)
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

        $d = $r->validate([

            'nama_kamar'   => 'nullable',

            'nomor_kamar'  => 'required',

            'ukuran_kamar' => 'nullable',

            /*
            |--------------------------------------------------------------------------
            | FOTO MULTIPLE
            |--------------------------------------------------------------------------
            */

            'foto_kamar'   => 'nullable|array',

            'foto_kamar.*' => 'image|max:2048',

        ]);

        /*
        |--------------------------------------------------------------------------
        | UPLOAD MULTIPLE FOTO
        |--------------------------------------------------------------------------
        */

        if ($r->hasFile('foto_kamar'))
        {
            $fotoPaths = [];

            foreach ($r->file('foto_kamar') as $foto)
            {
                $fotoPaths[] =
                    $foto->store('kamar', 'public');
            }

            $d['foto_kamar'] = $fotoPaths;
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $kamar->update($d);

        return redirect()
            ->route('admin.kamar.index')
            ->with(
                'success',
                'Kamar berhasil diperbarui.'
            );
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

    /*
    |--------------------------------------------------------------------------
    | HAPUS RELASI FASILITAS
    |--------------------------------------------------------------------------
    */

    $kamar->fasilitas()->detach();

    /*
    |--------------------------------------------------------------------------
    | HAPUS HARGA KAMAR
    |--------------------------------------------------------------------------
    */

    $kamar->hargaKamars()->delete();

    /*
    |--------------------------------------------------------------------------
    | HAPUS KAMAR
    |--------------------------------------------------------------------------
    */

    $kamar->delete();

    return back()->with(
        'success',
        'Kamar berhasil dihapus.'
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

        $kamar->fasilitas()->sync(

            $r->input('fasilitas', [])

        );

        return redirect()
            ->route('admin.kamar.index')
            ->with(
                'success',
                'Fasilitas kamar berhasil disimpan.'
            );
    }
}