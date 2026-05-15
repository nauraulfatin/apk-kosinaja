<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PENGHUNI - HALAMAN PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function penghuniIndex(Request $r)
    {
        $tagihanAktif = Tagihan::with([

            'kamar',
            'hargaKamar.periode',
            'pembayaran'

        ])
        ->where('id_user', $r->user()->id)
        ->latest()
        ->get();

        return view(

            'penghuni.pembayaran.index',

            compact('tagihanAktif')

        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function createPembayaran(
        Request $r
    )
    {
        $tagihans = Tagihan::with([

            'kamar',
            'hargaKamar.periode'

        ])
        ->where('id_user', $r->user()->id)
        ->where('status', 'pending')
        ->get();

        return view(

            'penghuni.pembayaran.create',

            compact('tagihans')

        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function storePembayaran(
        Request $r
    )
    {
        $d = $r->validate([

            'id_tagihan' =>

                'required|exists:tagihans,id_tagihan',

            'bukti_bayar' =>

                'required|image|mimes:jpg,jpeg,png|max:4096',

        ]);

        /*
        |--------------------------------------------------------------------------
        | TAGIHAN
        |--------------------------------------------------------------------------
        */

        $tagihan = Tagihan::findOrFail(

            $d['id_tagihan']

        );

        /*
        |--------------------------------------------------------------------------
        | VALIDASI KEPEMILIKAN
        |--------------------------------------------------------------------------
        */

        abort_if(

            $tagihan->id_user !== $r->user()->id,

            403

        );

        /*
        |--------------------------------------------------------------------------
        | UPLOAD BUKTI
        |--------------------------------------------------------------------------
        */

        $path = $r->file('bukti_bayar')
            ->store(
                'bukti-bayar',
                'public'
            );

        /*
        |--------------------------------------------------------------------------
        | CREATE / UPDATE PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        Pembayaran::updateOrCreate(

            [
                'id_tagihan' =>
                    $tagihan->id_tagihan,
            ],

            [
                'nominal_pembayaran' =>

                    $tagihan
                        ->hargaKamar
                        ->harga,

                'tanggal_bayar' => now(),

                'bukti_bayar' => $path,
            ]

        );

        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS TAGIHAN
        |--------------------------------------------------------------------------
        */

        $tagihan->update([

            'status_bukti' => 'menunggu',

        ]);

        return redirect()
            ->route(
                'penghuni.pembayaran.index'
            )
            ->with(
                'success',
                'Bukti pembayaran berhasil dikirim.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN KOST
    |--------------------------------------------------------------------------
    */

    public function adminIndex(Request $r)
    {
        $kostId = $r->user()->kost->id;

        $items = Tagihan::with([

            'user',
            'kamar',
            'hargaKamar.periode',
            'pembayaran',

        ])
        ->whereHas('kamar', function ($q)
        use ($kostId) {

            $q->where(
                'id_kost',
                $kostId
            );

        })
        ->latest()
        ->get();

        return view(

            'admin.tagihan.index',

            compact('items')

        );
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function validasiBukti(
        Request $r,
        Tagihan $tagihan
    )
    {
        abort_if(

            $tagihan->kamar->id_kost
            !== $r->user()->kost->id,

            403

        );

        $tagihan->update([

            'status' => 'lunas',

            'status_bukti' => 'diterima',

            'validated_by' => $r->user()->id,

            'validated_at' => now(),

        ]);

        return back()->with(

            'success',

            'Pembayaran berhasil divalidasi.'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | TOLAK PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function tolakBukti(
        Request $r,
        Tagihan $tagihan
    )
    {
        abort_if(

            $tagihan->kamar->id_kost
            !== $r->user()->kost->id,

            403

        );

        $tagihan->update([

            'status' => 'pending',

            'status_bukti' => 'ditolak',

            'validated_by' => $r->user()->id,

            'validated_at' => now(),

        ]);

        return back()->with(

            'success',

            'Bukti pembayaran ditolak.'

        );
    }
}