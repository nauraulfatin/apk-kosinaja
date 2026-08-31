<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        $riwayatList = RiwayatHunian::with([

            'kamar.kost.user'

        ])
        ->where('id_user', $user->id)
        ->where('status', 'nonaktif')
        ->latest()
        ->get();

    return view(
        'profil.index',
        compact(
            'user',
            'riwayat',
            'riwayatList'
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
| CEK PERNAH TINGGAL DI KOST INI (nonaktif)
|--------------------------------------------------------------------------
*/

$pernahTinggal = RiwayatHunian::where('id_user', Auth::user()->id)
    ->where('id_kost', $kost->id)
    ->where('status', 'nonaktif')
    ->exists();

if ($pernahTinggal)
{
    return response()->json([

        'success' => false,

        'message' => 'Kamu pernah tinggal di kost ini. Silakan hubungi admin untuk mengaktifkan kembali.'

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

        /*
        |--------------------------------------------------------------------------
        | JANGAN BO CORKAN DETAIL ERROR KE CLIENT
        |--------------------------------------------------------------------------
        |
        | Detail exception bisa berisi nama tabel, query SQL, path server,
        | atau informasi internal lain. Detail tetap dicatat ke log server,
        | sedangkan pengguna hanya menerima pesan generik.
        |
        */
        Log::error('Gagal memproses kode undangan penghuni.', [
            'user_id' => Auth::id(),
            'exception' => $e,
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan pada sistem. Silakan coba lagi.',
        ], 500);

    }
}

}