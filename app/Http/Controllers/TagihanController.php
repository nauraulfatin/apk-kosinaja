<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
                'pembayaran',
            ])
            ->where('id_user', $r->user()->id)
            ->latest()
            ->get();

        // Sinkronkan status finansial pending/telat/lunas.
        $tagihanAktif->each(
            fn (Tagihan $tagihan) => $tagihan->syncFinancialStatus()
        );

        return view(
            'penghuni.pembayaran.index',
            compact('tagihanAktif')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function storePembayaran(Request $r)
    {
        $data = $r->validate([
            'id_tagihan' => 'required|exists:tagihans,id_tagihan',
            'nominal_pembayaran' => 'required|numeric|min:1000',
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $tagihan = Tagihan::with([
                'hargaKamar',
                'pembayaran',
            ])
            ->findOrFail($data['id_tagihan']);

        /*
        |--------------------------------------------------------------------------
        | CEK KEPEMILIKAN
        |--------------------------------------------------------------------------
        */

        abort_if(
            (int) $tagihan->id_user !== (int) $r->user()->id,
            403
        );

        $tagihan->syncFinancialStatus();

        /*
        |--------------------------------------------------------------------------
        | CEGAH PEMBAYARAN GANDA SAAT MASIH DIVERIFIKASI
        |--------------------------------------------------------------------------
        */

        if ($tagihan->status_label === 'menunggu_verifikasi') {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Masih ada pembayaran yang menunggu verifikasi admin.'
                );
        }

        if ($tagihan->status_label === 'lunas' || $tagihan->sisa_tagihan <= 0) {
            return back()->with(
                'error',
                'Tagihan ini sudah lunas.'
            );
        }

        if ((float) $data['nominal_pembayaran'] > $tagihan->sisa_tagihan) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Nominal melebihi sisa tagihan.'
                );
        }

        $path = $r->file('bukti_bayar')
            ->store('bukti-bayar', 'public');

        try {
            DB::transaction(function () use ($data, $tagihan, $path) {
                Pembayaran::create([
                    'id_tagihan' => $tagihan->id_tagihan,
                    'nominal_pembayaran' => $data['nominal_pembayaran'],
                    'tanggal_bayar' => now(),
                    'bukti_bayar' => $path,
                    'status_validasi' => 'menunggu',
                ]);

                // Status finansial tetap pending/telat.
                // Status UI otomatis menjadi menunggu_verifikasi
                // dari pembayaran terakhir.
                $tagihan->syncFinancialStatus();
            });
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($path);
            throw $e;
        }

        return redirect()
            ->route('penghuni.pembayaran.index')
            ->with(
                'success',
                'Bukti pembayaran berhasil dikirim.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN INDEX
    |--------------------------------------------------------------------------
    */

    public function adminIndex(Request $r)
    {
        $kostId = $r->user()->kost->id;

        $all = Tagihan::with([
                'user',
                'kamar',
                'hargaKamar.periode',
                'pembayaran',
            ])
            ->whereHas('kamar', function ($query) use ($kostId) {
                $query->where('id_kost', $kostId);
            })
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SINKRONKAN STATUS FINANSIAL
        |--------------------------------------------------------------------------
        */

        $all->each(
            fn (Tagihan $tagihan) => $tagihan->syncFinancialStatus()
        );

        /*
        |--------------------------------------------------------------------------
        | FILTER BERDASARKAN STATUS LABEL
        |--------------------------------------------------------------------------
        |
        | Jangan query DB dengan status = menunggu_verifikasi / ditolak,
        | karena dua status tersebut adalah status validasi pembayaran,
        | bukan status finansial pada tabel tagihans.
        |
        */

        $filtered = $all;

        if ($r->filter === 'menunggu') {
            $filtered = $all->filter(
                fn (Tagihan $tagihan) =>
                    $tagihan->status_label === 'menunggu_verifikasi'
            );
        } elseif ($r->filter === 'lunas') {
            $filtered = $all->filter(
                fn (Tagihan $tagihan) =>
                    $tagihan->status_label === 'lunas'
            );
        } elseif ($r->filter === 'telat') {
            $filtered = $all->filter(
                fn (Tagihan $tagihan) =>
                    $tagihan->status_label === 'telat'
            );
        } elseif ($r->filter === 'ditolak') {
            $filtered = $all->filter(
                fn (Tagihan $tagihan) =>
                    $tagihan->status_label === 'ditolak'
            );
        } elseif ($r->filter === 'tagihan') {
            $filtered = $all->filter(
                fn (Tagihan $tagihan) =>
                    $tagihan->status_label === 'pending'
            );
        }

        $items = $filtered->groupBy('id_user');

        $totalMenunggu = $all->filter(
            fn (Tagihan $tagihan) =>
                $tagihan->status_label === 'menunggu_verifikasi'
        )->count();

        $totalLunas = $all->filter(
            fn (Tagihan $tagihan) =>
                $tagihan->status_label === 'lunas'
        )->count();

        $totalTelat = $all->filter(
            fn (Tagihan $tagihan) =>
                $tagihan->status_label === 'telat'
        )->count();

        return view(
            'admin.tagihan.index',
            compact(
                'items',
                'totalMenunggu',
                'totalLunas',
                'totalTelat'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT PEMBAYARAN ADMIN
    |--------------------------------------------------------------------------
    */

    public function riwayat(Request $r)
    {
        $kostId = $r->user()->kost->id;

        $bulanTahun = $r->get('bulan', now()->format('Y-m'));

        if (str_contains($bulanTahun, '-')) {
            [$tahun, $bulan] = explode('-', $bulanTahun);
        } else {
            $bulan = $bulanTahun;
            $tahun = now()->year;
        }

        $riwayat = Pembayaran::with([
                'tagihan.user',
                'tagihan.kamar.kost',
            ])
            ->whereHas('tagihan.kamar', function ($query) use ($kostId) {
                $query->where('id_kost', $kostId);
            })
            ->whereMonth('tanggal_bayar', $bulan)
            ->whereYear('tanggal_bayar', $tahun)
            ->where('status_validasi', 'diterima')
            ->latest('tanggal_bayar')
            ->get();

        $totalNominalRiwayat = $riwayat
            ->sum('nominal_pembayaran');

        return view(
            'admin.tagihan.riwayat',
            compact(
                'riwayat',
                'totalNominalRiwayat',
                'bulanTahun'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL TAGIHAN PER PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function detail(Request $r, $userId)
    {
        $kostId = $r->user()->kost->id;

        $items = Tagihan::with([
                'user',
                'kamar',
                'hargaKamar.periode',
                'pembayaran',
            ])
            ->where('id_user', $userId)
            ->whereHas('kamar', function ($query) use ($kostId) {
                $query->where('id_kost', $kostId);
            })
            ->latest()
            ->get();

        abort_if($items->isEmpty(), 404);

        $items->each(
            fn (Tagihan $tagihan) => $tagihan->syncFinancialStatus()
        );

        $user = $items->first()->user;

        return view(
            'admin.tagihan.detail',
            compact('items', 'user')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TERIMA PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function validasiBukti(
        Request $r,
        Pembayaran $pembayaran
    ) {
        $tagihan = $pembayaran->tagihan;

        abort_if(!$tagihan, 404);

        abort_if(
            !$tagihan->kamar ||
            (int) $tagihan->kamar->id_kost !== (int) $r->user()->kost->id,
            403
        );

        if ($pembayaran->status_validasi !== 'menunggu') {
            return back()->with(
                'error',
                'Pembayaran ini sudah pernah diproses.'
            );
        }

        DB::transaction(function () use ($r, $pembayaran, $tagihan) {
            $pembayaran->update([
                'status_validasi' => 'diterima',
            ]);

            $tagihan->update([
                'validated_by' => $r->user()->id,
                'validated_at' => now(),
            ]);

            // Jika cicilan yang diterima sudah menutup seluruh nominal,
            // status finansial otomatis menjadi lunas.
            $tagihan->load('pembayaran', 'hargaKamar');
            $tagihan->syncFinancialStatus();
        });

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
        Pembayaran $pembayaran
    ) {
        $tagihan = $pembayaran->tagihan;

        abort_if(!$tagihan, 404);

        abort_if(
            !$tagihan->kamar ||
            (int) $tagihan->kamar->id_kost !== (int) $r->user()->kost->id,
            403
        );

        if ($pembayaran->status_validasi !== 'menunggu') {
            return back()->with(
                'error',
                'Pembayaran ini sudah pernah diproses.'
            );
        }

        DB::transaction(function () use ($r, $pembayaran, $tagihan) {
            $pembayaran->update([
                'status_validasi' => 'ditolak',
            ]);

            $tagihan->update([
                'validated_by' => $r->user()->id,
                'validated_at' => now(),
            ]);

            $tagihan->load('pembayaran', 'hargaKamar');
            $tagihan->syncFinancialStatus();
        });

        return back()->with(
            'success',
            'Pembayaran ditolak.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT PEMBAYARAN PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function riwayatPembayaran(Request $r)
    {
        $items = Pembayaran::with([
                'tagihan.kamar',
                'tagihan.hargaKamar.periode',
            ])
            ->whereHas('tagihan', function ($query) use ($r) {
                $query->where(
                    'id_user',
                    $r->user()->id
                );
            })
            ->latest()
            ->get();

        return view(
            'penghuni.pembayaran.riwayat',
            compact('items')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
    |--------------------------------------------------------------------------
    */

    public function exportPdf(Request $r)
    {
        $bulanInput = $r->get('bulan', now()->format('Y-m'));

        if (str_contains($bulanInput, '-')) {
            [$tahun, $bulan] = explode('-', $bulanInput);
        } else {
            $bulan = $bulanInput;
            $tahun = now()->year;
        }

        $kostId = $r->user()->kost->id;

        $pembayaran = Pembayaran::with([
                'tagihan.user',
                'tagihan.kamar.kost',
            ])
            ->whereHas('tagihan.kamar', function ($query) use ($kostId) {
                $query->where('id_kost', $kostId);
            })
            ->whereMonth('tanggal_bayar', $bulan)
            ->whereYear('tanggal_bayar', $tahun)
            ->where('status_validasi', 'diterima')
            ->latest('tanggal_bayar')
            ->get();

        $totalNominal = $pembayaran
            ->sum('nominal_pembayaran');

        $pdf = Pdf::loadView(
                'admin.tagihan.pdf',
                compact(
                    'pembayaran',
                    'totalNominal',
                    'bulanInput'
                )
            )
            ->setPaper('a4', 'landscape');

        return $pdf->download(
            'laporan-pembayaran-' . $bulanInput . '.pdf'
        );
    }
}
