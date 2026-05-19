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
    try {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'kode_undangan' => 'required|string'

        ]);

        /*
        |--------------------------------------------------------------------------
        | FORMAT KODE
        |--------------------------------------------------------------------------
        */

        $kode = strtoupper(

            trim(
                $request->kode_undangan
            )

        );

        /*
        |--------------------------------------------------------------------------
        | CEK KOST
        |--------------------------------------------------------------------------
        */

        $kost = Kost::whereRaw(

            'UPPER(TRIM(kode_undangan)) = ?',

            [$kode]

        )->first();

        /*
        |--------------------------------------------------------------------------
        | KODE TIDAK DITEMUKAN
        |--------------------------------------------------------------------------
        */

        if (!$kost)
        {
            return response()->json([

                'success' => false,

                'message' => 'Kode tidak ditemukan.'

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK SUDAH ADA PENGAJUAN
        |--------------------------------------------------------------------------
        */

        $cek = RiwayatHunian::where(

                'id_user',

                Auth::user()->id

            )
            ->whereIn('status', [

                'menunggu',

                'aktif'

            ])
            ->exists();

        if ($cek)
        {
            return response()->json([

                'success' => false,

                'message' => 'Kamu sudah punya pengajuan.'

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN
        |--------------------------------------------------------------------------
        */

        RiwayatHunian::create([

            'id_user' => Auth::user()->id,

            'id_kost' => $kost->id,

            'id_kamar' => null,

            'tanggal_masuk' => now(),

            'tanggal_keluar' => null,

            'status' => 'menunggu'

        ]);

        return response()->json([

            'success' => true

        ]);

    } catch (\Throwable $e) {

        return response()->json([

            'success' => false,

            'message' => $e->getMessage()

        ], 500);

    }
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