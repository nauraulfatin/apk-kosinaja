<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatHunian;
use App\Models\KamarKost;
use App\Models\PeriodePenagihan;
use App\Models\Tagihan;
use Carbon\Carbon;

class PengajuanPenghuniController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | KOST ADMIN LOGIN
        |--------------------------------------------------------------------------
        */

        $kost = auth()->user()->kost;

        /*
        |--------------------------------------------------------------------------
        | AMBIL PENGAJUAN
        |--------------------------------------------------------------------------
        */

        $items = RiwayatHunian::with([

                'user',
                'kamar'

            ])
            ->where(

                'status',

                'menunggu'

            )
            ->whereHas(

                'kamar',

                function ($q) use ($kost) {

                    $q->where(
                        'id_kost',
                        $kost->id_kost
                    );

                }

            )
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(

            'admin.pengajuan.index',

            compact('items')

        );
    }

    /*
|--------------------------------------------------------------------------
| SHOW
|--------------------------------------------------------------------------
*/

public function show(
    RiwayatHunian $riwayatHunian
)
{
    /*
    |--------------------------------------------------------------------------
    | KAMAR KOST
    |--------------------------------------------------------------------------
    */

    $kamars = KamarKost::where(

            'id_kost',

            auth()->user()
                ->kost
                ->id_kost

        )
        ->get();

    /*
    |--------------------------------------------------------------------------
    | PERIODE
    |--------------------------------------------------------------------------
    */

    $periodes = PeriodePenagihan::all();

    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

    return view(

        'admin.pengajuan.show',

        compact(

            'riwayatHunian',
            'kamars',
            'periodes'

        )

    );
}
/*
|--------------------------------------------------------------------------
| APPROVE
|--------------------------------------------------------------------------
*/

public function approve(
    Request $request,
    RiwayatHunian $riwayatHunian
)
{
    /*
    |--------------------------------------------------------------------------
    | VALIDASI
    |--------------------------------------------------------------------------
    */

    $data = $request->validate([

        'id_kamar' =>

            'required|exists:kamar_kosts,id_kamar',

        'tanggal_masuk' =>

            'required|date',

        'tanggal_keluar' =>

            'required|date|after:tanggal_masuk',

        'id_periode' =>

            'required|exists:periode_penagihans,id_periode',

        'jatuh_tempo' =>

            'required|date',

    ]);

    /*
    |--------------------------------------------------------------------------
    | UPDATE RIWAYAT HUNIAN
    |--------------------------------------------------------------------------
    */

    $riwayatHunian->update([

        'id_kamar' =>

            $data['id_kamar'],

        'tanggal_masuk' =>

            $data['tanggal_masuk'],

        'tanggal_keluar' =>

            $data['tanggal_keluar'],

        'status' =>

            'aktif',

    ]);

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS KAMAR
    |--------------------------------------------------------------------------
    */

    $kamar = KamarKost::findOrFail(
        $data['id_kamar']
    );

    $kamar->update([

        'status' => 'terisi'

    ]);

    /*
    |--------------------------------------------------------------------------
    | AMBIL HARGA KAMAR AKTIF
    |--------------------------------------------------------------------------
    */

    $hargaKamar = HargaKamar::where(

            'id_kamar',

            $data['id_kamar']

        )
        ->where(

            'id_periode',

            $data['id_periode']

        )
        ->first();

    /*
    |--------------------------------------------------------------------------
    | CEK HARGA
    |--------------------------------------------------------------------------
    */

    if (!$hargaKamar)
    {
        return back()->with(

            'error',

            'Harga kamar untuk periode ini belum tersedia.'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE TAGIHAN PERTAMA
    |--------------------------------------------------------------------------
    */

    Tagihan::create([

        'id_kamar' =>

            $data['id_kamar'],

        'id_user' =>

            $riwayatHunian->id_user,

        'id_harga_kamar' =>

            $hargaKamar->id_harga_kamar,

        /*
        |--------------------------------------------------------------------------
        | DURASI
        |--------------------------------------------------------------------------
        */

        'durasi' => 1,

        /*
        |--------------------------------------------------------------------------
        | PERIODE TAGIHAN
        |--------------------------------------------------------------------------
        */

        'tanggal_mulai' =>

            $data['tanggal_masuk'],

        'tanggal_selesai' =>

            Carbon::parse(
                $data['tanggal_masuk']
            )->addMonth(),

        /*
        |--------------------------------------------------------------------------
        | JATUH TEMPO
        |--------------------------------------------------------------------------
        */

        'jatuh_tempo' =>

            $data['jatuh_tempo'],

        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        'status' => 'pending',

    ]);

    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('admin.pengajuan.index')
        ->with(

            'success',

            'Penghuni berhasil diapprove.'

        );
}
}