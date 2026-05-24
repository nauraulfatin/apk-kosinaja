<?php

namespace App\Http\Controllers;

use App\Models\AturanKos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AturanKosController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN - LIST ATURAN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $kost = DB::table('kosts')
            ->where('id_user', Auth::user()->id)
            ->first();

        if (!$kost) {

            $aturans = collect();

        } else {

            $aturans = AturanKos::where(
                'kost_id',
                $kost->id
            )->get();

        }

        return view(
            'admin.aturan.index',
            compact('aturans')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - FORM CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.aturan.create');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'isi_aturan' => 'required'

        ]);

        $kost = DB::table('kosts')
            ->where('id_user', Auth::user()->id)
            ->first();

        if (!$kost) {

            return back()->with(
                'error',
                'Data kost tidak ditemukan'
            );

        }

        AturanKos::create([

            'kost_id' => $kost->id,

            'judul' => 'Aturan Kos',

            'isi' => $request->isi_aturan

        ]);

        return redirect()
            ->route('admin.aturan.index')
            ->with(
                'success',
                'Aturan berhasil ditambahkan'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - FORM EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $aturan = AturanKos::findOrFail($id);

        return view(
            'admin.aturan.edit',
            compact('aturan')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $request->validate([

            'isi_aturan' => 'required'

        ]);

        $aturan = AturanKos::findOrFail($id);

        $aturan->update([

            'isi' => $request->isi_aturan

        ]);

        return redirect()
            ->route('admin.aturan.index')
            ->with(
                'success',
                'Aturan berhasil diupdate'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        AturanKos::findOrFail($id)->delete();

        return redirect()
            ->route('admin.aturan.index')
            ->with(
                'success',
                'Aturan berhasil dihapus'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | PENGHUNI - LIHAT ATURAN
    |--------------------------------------------------------------------------
    */

    public function penghuniIndex()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | AMBIL TAGIHAN PENGHUNI
        |--------------------------------------------------------------------------
        */

        $tagihan = DB::table('tagihans')
            ->where('id_user', $user->id)
            ->latest('id_tagihan')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | JIKA BELUM ADA TAGIHAN
        |--------------------------------------------------------------------------
        */

        if (!$tagihan) {

            $aturans = collect();

        } else {

            /*
            |--------------------------------------------------------------------------
            | AMBIL DATA KAMAR
            |--------------------------------------------------------------------------
            */

            $kamar = DB::table('kamar_kosts')
                ->where('id_kamar', $tagihan->id_kamar)
                ->first();

            /*
            |--------------------------------------------------------------------------
            | JIKA KAMAR TIDAK ADA
            |--------------------------------------------------------------------------
            */

            if (!$kamar) {

                $aturans = collect();

            } else {

                /*
                |--------------------------------------------------------------------------
                | AMBIL ATURAN SESUAI KOST
                |--------------------------------------------------------------------------
                */

                $aturans = DB::table('peraturans')
                    ->where('kost_id', $kamar->id_kost)
                    ->get();

            }

        }

        return view(
            'penghuni.aturan.aturan',
            compact('aturans')
        );
    }
}