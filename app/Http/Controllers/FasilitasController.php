<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view(

            'superadmin.fasilitas.index',

            [
                'items' =>
                    Fasilitas::latest()->get()
            ]

        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(

            'superadmin.fasilitas.form',

            [
                'item' =>
                    new Fasilitas
            ]

        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $r)
    {
        $d = $r->validate([

            'nama_fasilitas' =>

                'required|unique:fasilitas,nama_fasilitas',

        ]);

        Fasilitas::create($d);

        return redirect()
            ->route(
                'superadmin.fasilitas.index'
            )
            ->with(
                'success',
                'Fasilitas berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(
        Fasilitas $fasilita
    )
    {
        return view(

            'superadmin.fasilitas.form',

            [
                'item' => $fasilita
            ]

        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $r,
        Fasilitas $fasilita
    )
    {
        $d = $r->validate([

            'nama_fasilitas' =>

                'required|unique:fasilitas,nama_fasilitas,' .

                $fasilita->id_fasilitas .

                ',id_fasilitas',

        ]);

        $fasilita->update($d);

        return redirect()
            ->route(
                'superadmin.fasilitas.index'
            )
            ->with(
                'success',
                'Fasilitas berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Fasilitas $fasilita
    )
    {
        $fasilita->delete();

        return back()->with(

            'success',

            'Fasilitas berhasil dihapus.'

        );
    }
}