<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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
        ->where(
            'id_user',
            $r->user()->id
        )
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

    public function createPembayaran(Request $r)
    {
        $tagihans = Tagihan::with([

                'kamar',
                'hargaKamar.periode'

            ])
            ->where('id_user', $r->user()->id)
            ->whereIn('status', [

                'pending',
                'telat',
                'ditolak'

            ])
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

    public function storePembayaran(Request $r)
    {
        $d = $r->validate([

            'id_tagihan' =>

                'required|exists:tagihans,id_tagihan',

            'nominal_pembayaran' =>

                'required|numeric|min:1000',

            'bukti_bayar' =>

                'required|image|mimes:jpg,jpeg,png|max:4096',

        ]);

        /*
        |--------------------------------------------------------------------------
        | TAGIHAN
        |--------------------------------------------------------------------------
        */

        $tagihan = Tagihan::with([

                'hargaKamar',
                'pembayaran'

            ])
            ->findOrFail(

                $d['id_tagihan']

            );

        /*
|--------------------------------------------------------------------------
| VALIDASI KEPEMILIKAN
|--------------------------------------------------------------------------
*/

abort_if(

    (int)$tagihan->id_user !== (int)$r->user()->id,

    403

);

/*
|--------------------------------------------------------------------------
| TOTAL SUDAH DIBAYAR
|--------------------------------------------------------------------------
*/

$totalDibayar =

    $tagihan
        ->pembayaran()
        ->where(
            'status_validasi',
            'diterima'
        )
        ->sum(

            'nominal_pembayaran'

        );

        /*
        |--------------------------------------------------------------------------
        | TOTAL TAGIHAN
        |--------------------------------------------------------------------------
        */

        $totalTagihan =

            $tagihan
                ->hargaKamar
                ?->harga ?? 0;

        /*
        |--------------------------------------------------------------------------
        | SISA
        |--------------------------------------------------------------------------
        */

        $sisa =

            $totalTagihan - $totalDibayar;

        /*
        |--------------------------------------------------------------------------
        | VALIDASI NOMINAL
        |--------------------------------------------------------------------------
        */

        if (

            $d['nominal_pembayaran'] > $sisa

        ) {

            return back()->with(

                'error',

                'Nominal melebihi sisa tagihan.'

            );
        }

        /*
        |--------------------------------------------------------------------------
        | UPLOAD
        |--------------------------------------------------------------------------
        */

        $path = $r->file('bukti_bayar')
            ->store(
                'bukti-bayar',
                'public'
            );

        /*
        |--------------------------------------------------------------------------
        | CREATE PEMBAYARAN BARU
        |--------------------------------------------------------------------------
        */

        Pembayaran::create([

            'id_tagihan' =>$tagihan->id_tagihan,
            'nominal_pembayaran' =>$d['nominal_pembayaran'],
            'tanggal_bayar' =>now(),
            'bukti_bayar' =>$path,
            'status_validasi'    => 'menunggu',

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
    | ADMIN INDEX
    |--------------------------------------------------------------------------
    */

    public function adminIndex(Request $r)
    {
        $kostId = $r->user()->kost->id;

        /*
        |--------------------------------------------------------------------------
        | AUTO TELAT
        |--------------------------------------------------------------------------
        */

        Tagihan::whereIn('status', [

                'pending',
                'ditolak',
                'menunggu_verifikasi'

            ])
            ->whereDate(

                'tanggal_jatuh_tempo',

                '<',

                now()

            )
            ->update([

                'status' => 'telat'

            ]);

        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = Tagihan::with([

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

            });

        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        if($r->filter === 'menunggu')
        {
            $query->where(
                'status',
                'menunggu_verifikasi'
            );
        }

        elseif($r->filter === 'lunas')
        {
            $query->where(
                'status',
                'lunas'
            );
        }

        elseif($r->filter === 'telat')
        {
            $query->where(
                'status',
                'telat'
            );
        }

        elseif($r->filter === 'tagihan')
        {
            $query->where(
                'status',
                'pending'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ITEMS
        |--------------------------------------------------------------------------
        */

        $items = $query
            ->latest()
            ->get()
            ->groupBy('id_user');

        /*
        |--------------------------------------------------------------------------
        | ALL
        |--------------------------------------------------------------------------
        */

        $all = Tagihan::whereHas(

                'kamar',

                function ($q)
                use ($kostId) {

                    $q->where(
                        'id_kost',
                        $kostId
                    );

                }

            )->get();

       $totalMenunggu =

    $all
        ->filter(function($t){

            return
                $t->status_label
                === 'menunggu_verifikasi';

        })
        ->count();

$totalLunas =

    $all
        ->filter(function($t){

            return
                $t->status_label
                === 'lunas';

        })
        ->count();

$totalTelat =

    $all
        ->filter(function($t){

            return
                $t->status_label
                === 'telat';

        })
        ->count();

        /*
|--------------------------------------------------------------------------
| RIWAYAT
|--------------------------------------------------------------------------
*/

$bulan = $r->get('bulan', now()->format('Y-m'));
[$tahun, $bln] = explode('-', $bulan);

$riwayat = Pembayaran::with(['tagihan.user', 'tagihan.kamar.kost'])
    ->whereMonth('tanggal_bayar', $bln)
    ->whereYear('tanggal_bayar', $tahun)
    ->where('status_validasi', 'diterima')
    ->latest('tanggal_bayar')
    ->get();

$totalNominalRiwayat = $riwayat->sum('nominal_pembayaran');



        return view(
    'admin.tagihan.index',
    compact(
        'items',
        'totalMenunggu',
        'totalLunas',
        'totalTelat',
        'riwayat',           // tambah
        'totalNominalRiwayat', // tambah
        'bulan',             // tambah
    )
);
    }
    
    /*
    |--------------------------------------------------------------------------
    | DETAIL
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
            ->whereHas('kamar', function ($q)
            use ($kostId) {

                $q->where(
                    'id_kost',
                    $kostId
                );

            })
            ->latest()
            ->get();

        abort_if(
            $items->isEmpty(),
            404
        );

        $user =
            $items->first()->user;

        return view(

            'admin.tagihan.detail',

            compact(

                'items',
                'user'

            )

        );
    }

   /*
|--------------------------------------------------------------------------
| VALIDASI PEMBAYARAN
|--------------------------------------------------------------------------
*/

public function validasiBukti(
    Request $r,
    Pembayaran $pembayaran
)
{
   $tagihan = $pembayaran->tagihan;

abort_if(

    !$tagihan,

    404

);

// ✅ BENAR
abort_if(
    !$tagihan->kamar ||
    $tagihan->kamar->id_kost != $r->user()->kost->id,  // ganti id_kost → id
    403
);

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    $pembayaran->update([

        'status_validasi' => 'diterima'

    ]);

    /*
    |--------------------------------------------------------------------------
    | TOTAL CICILAN DITERIMA
    |--------------------------------------------------------------------------
    */

    $totalPembayaran =

        $tagihan
            ->pembayaran()
            ->where(
                'status_validasi',
                'diterima'
            )
            ->sum(
                'nominal_pembayaran'
            );

    /*
    |--------------------------------------------------------------------------
    | TOTAL TAGIHAN
    |--------------------------------------------------------------------------
    */

    $totalTagihan =

        $tagihan
            ->hargaKamar
            ?->harga ?? 0;

    /*
    |--------------------------------------------------------------------------
    | STATUS TAGIHAN
    |--------------------------------------------------------------------------
    */

    $tagihan->update([

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
        Pembayaran $pembayaran
    )
    {
        $tagihan = $pembayaran->tagihan;

       // Cek apakah ini sudah benar
abort_if(
    $tagihan->kamar->id_kost !== $r->user()->kost->id,  // pastikan ->id bukan ->id_kost
    403
);

        $pembayaran->update(['status_validasi' => 'ditolak']);

        $tagihan->update([

    'validated_by' => $r->user()->id,
    'validated_at' => now(),

]);

        return back()->with(
            'success',
            'Pembayaran ditolak.'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | BATAL PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function batalPembayaran(
        Pembayaran $pembayaran
    )
    {
        if (

            $pembayaran->status_validasi
            !== 'menunggu'

        ) {

            return back()->with(

                'error',

                'Pembayaran tidak dapat dibatalkan.'

            );
        }

        if ($pembayaran->bukti_bayar) {

            Storage::disk('public')->delete(

                $pembayaran->bukti_bayar

            );
        }

        $pembayaran->delete();

        return back()->with(

            'success',

            'Pembayaran berhasil dibatalkan.'

        );
    }

    /*
|--------------------------------------------------------------------------
| RIWAYAT PEMBAYARAN
|--------------------------------------------------------------------------
*/

public function riwayatPembayaran(Request $r)
{
    $items = Pembayaran::with([

            'tagihan.kamar',
            'tagihan.hargaKamar.periode',

        ])
        ->whereHas('tagihan', function ($q)
        use ($r) {

            $q->where(
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

public function riwayat(Request $r)
{
    $kostId = $r->user()->kost->id;

    $bulan = $r->get('bulan', now()->format('Y-m'));
    [$tahun, $bln] = explode('-', $bulan);

    $riwayat = Pembayaran::with(['tagihan.user', 'tagihan.kamar.kost'])
        ->whereHas('tagihan.kamar', function ($q) use ($kostId) {
            $q->where('id_kost', $kostId);
        })
        ->whereMonth('tanggal_bayar', $bln)
        ->whereYear('tanggal_bayar', $tahun)
        ->where('status_validasi', 'diterima')
        ->latest('tanggal_bayar')
        ->get();

    $totalNominalRiwayat = $riwayat->sum('nominal_pembayaran');

    return view('admin.tagihan.riwayat', compact(
        'riwayat',
        'totalNominalRiwayat',
        'bulan',
    ));
}
// ── EXPORT PDF ───────────────────────────────────────────────
public function exportPdf(Request $r)
{
    $bulan = $r->get('bulan', now()->format('Y-m'));

    [$tahun, $bln] = explode('-', $bulan);

    $pembayaran = Pembayaran::with([
            'tagihan.user',
            'tagihan.kamar.kost',
        ])
        ->whereMonth('tanggal_bayar', $bln)
        ->whereYear('tanggal_bayar', $tahun)
        ->where('status_validasi', 'diterima')
        ->latest('tanggal_bayar')
        ->get();

    $totalNominal = $pembayaran->sum('nominal_pembayaran');

    $pdf = Pdf::loadView('admin.tagihan.pdf', compact(
            'pembayaran',
            'totalNominal',
            'bulan',
        ))
        ->setPaper('a4', 'landscape');

    return $pdf->download('laporan-pembayaran-' . $bulan . '.pdf');
}

}