<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\RiwayatHunian;
use App\Models\Kost;
use App\Models\KamarKost;

class ProfilPenghuniController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN PROFIL
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = Auth::user();

        $riwayat = RiwayatHunian::with('kamar.kost')
            ->where('id_user', $user->id)
            ->latest()
            ->first();

        return view(
            'penghuni.profil',
            compact(
                'user',
                'riwayat'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SUBMIT KODE UNDANGAN
    |--------------------------------------------------------------------------
    */

    public function submitKode(Request $request)
    {
        $request->validate([

            'kode_undangan' => 'required'

        ]);

        $kost = Kost::where(

            'kode_undangan',

            $request->kode_undangan

        )->first();

        /*
        |--------------------------------------------------------------------------
        | KODE TIDAK DITEMUKAN
        |--------------------------------------------------------------------------
        */

        if (!$kost) {

            return back()->with(

                'error',

                'Kode undangan tidak ditemukan'

            );
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL KAMAR PERTAMA
        |--------------------------------------------------------------------------
        */

        $kamar = KamarKost::where(

            'id_kost',

            $kost->id

        )->first();

        /*
        |--------------------------------------------------------------------------
        | SIMPAN RIWAYAT HUNIAN
        |--------------------------------------------------------------------------
        */

        RiwayatHunian::create([

            'id_user' => Auth::id(),

            'id_kamar' => $kamar?->id_kamar,

            'tanggal_masuk' => now(),

            'status' => 'menunggu'

        ]);

        return back()->with(

            'success',

            'Kode berhasil dikirim'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        return view(
            'penghuni.dashboard'
        );
    }
}