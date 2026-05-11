<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function penghuniIndex(Request $r)
    {
        $items = Tagihan::with([
            'kamar',
            'hargaKamar.periode',
            'pembayaran'
        ])
        ->where('id_user', $r->user()->id)
        ->orderBy('tanggal_jatuh_tempo')
        ->get();

        return view(
            'penghuni.tagihan.index',
            compact('items')
        );
    }

    public function uploadBukti(
        Request $r,
        Tagihan $tagihan
    ) {

        abort_if(
            $tagihan->id_user !== $r->user()->id,
            403
        );

        $d = $r->validate([
            'nominal_pembayaran' => [
                'required',
                'numeric',
                'min:1',
            ],

            'bukti_bayar' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:4096',
            ],
        ]);

        $path = $r->file('bukti_bayar')
            ->store('bukti-bayar', 'public');

        Pembayaran::updateOrCreate(
            [
                'id_tagihan' => $tagihan->id_tagihan,
            ],
            [
                'nominal_pembayaran' => $d['nominal_pembayaran'],
                'tanggal_bayar' => now(),
                'bukti_bayar' => $path,
            ]
        );

        $tagihan->update([
            'bukti_bayar' => $path,
            'status_bukti' => 'menunggu',
        ]);

        return back()->with(
            'success',
            'Bukti bayar berhasil diupload dan menunggu validasi admin.'
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
        ->whereHas('kamar', function ($q) use ($kostId) {
            $q->where('id_kost', $kostId);
        })
        ->orderBy('tanggal_jatuh_tempo')
        ->get();

        return view(
            'admin.tagihan.index',
            compact('items')
        );
    }

    public function validasiBukti(
        Request $r,
        Tagihan $tagihan
    ) {

        abort_if(
            $tagihan->kamar->id_kost !== $r->user()->kost->id,
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

    public function tolakBukti(
        Request $r,
        Tagihan $tagihan
    ) {

        abort_if(
            $tagihan->kamar->id_kost !== $r->user()->kost->id,
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