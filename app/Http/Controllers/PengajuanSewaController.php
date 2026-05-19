<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSewa;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class PengajuanSewaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SIMPAN PENGAJUAN
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([

            'id_kamar' => 'required',

            'id_harga_kamar' => 'required',

            'tanggal_masuk' => 'required|date',

            'tanggal_keluar' => 'required|date|after:tanggal_masuk'

        ]);

        /*
        |--------------------------------------------------------------------------
        | CEK BENTROK DENGAN TAGIHAN
        |--------------------------------------------------------------------------
        */

        $bentrokTagihan = Tagihan::where(

                'id_kamar',
                $data['id_kamar']

            )

            ->where(function ($query) use ($data) {

                $query

                    ->whereBetween(
                        'tanggal_mulai',
                        [
                            $data['tanggal_masuk'],
                            $data['tanggal_keluar']
                        ]
                    )

                    ->orWhereBetween(
                        'tanggal_selesai',
                        [
                            $data['tanggal_masuk'],
                            $data['tanggal_keluar']
                        ]
                    )

                    ->orWhere(function ($q) use ($data) {

                        $q->where(
                                'tanggal_mulai',
                                '<=',
                                $data['tanggal_masuk']
                            )

                          ->where(
                                'tanggal_selesai',
                                '>=',
                                $data['tanggal_keluar']
                            );

                    });

            })

            ->exists();

        /*
        |--------------------------------------------------------------------------
        | CEK BENTROK DENGAN PENGAJUAN LAIN
        |--------------------------------------------------------------------------
        */

        $bentrokPengajuan = PengajuanSewa::where(

                'id_kamar',
                $data['id_kamar']

            )

            ->where(
                'status',
                'menunggu'
            )

            ->where(function ($query) use ($data) {

                $query

                    ->whereBetween(
                        'tanggal_masuk',
                        [
                            $data['tanggal_masuk'],
                            $data['tanggal_keluar']
                        ]
                    )

                    ->orWhereBetween(
                        'tanggal_keluar',
                        [
                            $data['tanggal_masuk'],
                            $data['tanggal_keluar']
                        ]
                    )

                    ->orWhere(function ($q) use ($data) {

                        $q->where(
                                'tanggal_masuk',
                                '<=',
                                $data['tanggal_masuk']
                            )

                          ->where(
                                'tanggal_keluar',
                                '>=',
                                $data['tanggal_keluar']
                            );

                    });

            })

            ->exists();

        /*
        |--------------------------------------------------------------------------
        | JIKA BENTROK
        |--------------------------------------------------------------------------
        */

        if (
            $bentrokTagihan ||
            $bentrokPengajuan
        ) {

            return back()->withErrors([

                'tanggal_masuk' =>

                    'Kamar sudah dibooking pada tanggal tersebut. Silakan pilih tanggal lain.'

            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN PENGAJUAN
        |--------------------------------------------------------------------------
        */

        PengajuanSewa::create([

            'id_user' => auth()->id(),

            'id_kamar' =>
                $data['id_kamar'],

            'id_harga_kamar' =>
                $data['id_harga_kamar'],

            'tanggal_masuk' =>
                $data['tanggal_masuk'],

            'tanggal_keluar' =>
                $data['tanggal_keluar'],

            'status' => 'menunggu'

        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return back()->with(

            'success',

            'Pengajuan sewa berhasil dikirim.'

        );
    }
}