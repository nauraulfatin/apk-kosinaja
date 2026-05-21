<?php

namespace App\Http\Controllers;

use App\Models\HargaKamar;
use App\Models\KamarKost;
use App\Models\RiwayatHunian;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
   /*
|--------------------------------------------------------------------------
| DASHBOARD PENGHUNI
|--------------------------------------------------------------------------
*/

public function dashboard(Request $r)
{
    /*
    |--------------------------------------------------------------------------
    | HUNIAN AKTIF
    |--------------------------------------------------------------------------
    */

    $hunianAktif = RiwayatHunian::with([

            'kamar.kost'

        ])
        ->where(

            'id_user',

            $r->user()->id

        )
        ->where(

            'status',

            'aktif'

        )
        ->latest()
        ->first();

        //tagihan
$tagihanAktif = Tagihan::with([

        'kamar.kost',
        'hargaKamar.periode',
        'pembayaran'

    ])
    ->where(
        'id_user',
        $r->user()->id
    )
    ->get();

$tagihanTerbaru =

    $tagihanAktif

        ->filter(function ($t) {

            return $t->status_label !== 'lunas';

        })

        ->sortBy('tanggal_mulai')

        ->first();


    /*
    |--------------------------------------------------------------------------
    | TOTAL
    |--------------------------------------------------------------------------
    */

    $jumlahTagihan =

        $tagihanAktif->count();

    $tagihanPending =

        $tagihanAktif
            ->whereIn('status', [

                'pending',
                'telat',
                'ditolak',
                'menunggu_verifikasi'

            ])
            ->count();

    return view(

        'penghuni.dashboard',

        [

            'hunianAktif' =>

                $hunianAktif,

            'tagihanAktif' =>

                $tagihanAktif,

            'tagihanTerbaru' =>

                $tagihanTerbaru,

            'jumlahTagihan' =>

                $jumlahTagihan,

            'tagihanPending' =>

                $tagihanPending,

        ]

    );
}

    /*
    |--------------------------------------------------------------------------
    | PENGHUNI AKTIF
    |--------------------------------------------------------------------------
    */

    public function aktif(Request $r)
    {
        $kostId = $r->user()->kost->id;

        $items = RiwayatHunian::with([

                'user',
                'kamar'

            ])
            ->where(

                'status',

                'aktif'

            )
            ->whereHas('kamar', function ($q) use ($kostId) {

                $q->where(

                    'id_kost',

                    $kostId

                );

            })
            ->latest()
            ->get();

        return view(

            'admin.penghuni.aktif',

            compact('items')

        );
    }

    /*
    |--------------------------------------------------------------------------
    | PENGHUNI ANTRIAN
    |--------------------------------------------------------------------------
    */

    public function antrian(Request $r)
    {
        $kostId = $r->user()->kost->id;

        $items = RiwayatHunian::with([

                'user',
                'kamar'

            ])
            ->where(

                'status',

                'antrian'

            )
            ->whereHas('kamar', function ($q) use ($kostId) {

                $q->where(

                    'id_kost',

                    $kostId

                );

            })
            ->latest()
            ->get();

        return view(

            'admin.penghuni.antrian',

            compact('items')

        );
    }

    /*
    |--------------------------------------------------------------------------
    | PENGHUNI NONAKTIF
    |--------------------------------------------------------------------------
    */

    public function nonaktif(Request $r)
    {
        $kostId = $r->user()->kost->id;

        $items = RiwayatHunian::with([

                'user',
                'kamar'

            ])
            ->where(

                'status',

                'nonaktif'

            )
            ->whereHas('kamar', function ($q) use ($kostId) {

                $q->where(

                    'id_kost',

                    $kostId

                );

            })
            ->latest()
            ->get();

        return view(

            'admin.penghuni.nonaktif',

            compact('items')

        );
    }

    /*
    |--------------------------------------------------------------------------
    | NONAKTIFKAN PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function nonaktifkan(
        RiwayatHunian $riwayatHunian
    )
    {
        /*
        |--------------------------------------------------------------------------
        | UPDATE RIWAYAT
        |--------------------------------------------------------------------------
        */

        $riwayatHunian->update([

            'status' => 'nonaktif',

            'tanggal_keluar' => now(),

        ]);

        return back()->with(

            'success',

            'Penghuni berhasil dinonaktifkan.'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM AKTIFKAN
    |--------------------------------------------------------------------------
    */

   public function formAktifkan(
    RiwayatHunian $riwayatHunian
)
{
    /*
    |--------------------------------------------------------------------------
    | SEMUA KAMAR
    |--------------------------------------------------------------------------
    */

    $kamars = KamarKost::with([

            'riwayatHunian.user'

        ])
        ->where(

            'id_kost',

            auth()->user()
                ->kost
                ->id

        )
        ->get();

    /*
    |--------------------------------------------------------------------------
    | HARGA KAMAR
    |--------------------------------------------------------------------------
    */

    $hargaKamars = HargaKamar::with([

            'periode',
            'kamar'

        ])
        ->where(

            'isactive',

            true

        )
        ->get();

    return view(

        'admin.penghuni.aktifkan',

        compact(

            'riwayatHunian',
            'kamars',
            'hargaKamars'

        )

    );
}

    /*
    |--------------------------------------------------------------------------
    | AKTIFKAN PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function aktifkan(
        Request $r,
        RiwayatHunian $riwayatHunian
    )
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $data = $r->validate([

            'id_kamar' =>

                'required|exists:kamar_kosts,id_kamar',

            'tanggal_masuk' =>

                'required|date',

            'tanggal_keluar' =>

                'required|date|after:tanggal_masuk',

            'id_harga_kamar' =>

                'required|exists:harga_kamars,id_harga_kamar',

            'jatuh_tempo_hari' =>

    'required|integer|min:1|max:31',

        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE RIWAYAT
        |--------------------------------------------------------------------------
        */

        $riwayatHunian->update([

            'id_kamar' =>

                $data['id_kamar'],

            'tanggal_masuk' =>

                $data['tanggal_masuk'],

            'tanggal_keluar' =>

                $data['tanggal_keluar'],

            'status' => 'aktif',

        ]);

        /*
        |--------------------------------------------------------------------------
        | HARGA KAMAR
        |--------------------------------------------------------------------------
        */

        $hargaKamar = HargaKamar::with(

                'periode'

            )
            ->findOrFail(

                $data['id_harga_kamar']

            );

            /*
|--------------------------------------------------------------------------
| HAPUS TAGIHAN LAMA
|--------------------------------------------------------------------------
*/

Tagihan::where(

    'id_user',

    $riwayatHunian->id_user

)->delete();

        /*
        |--------------------------------------------------------------------------
        | GENERATE TAGIHAN
        |--------------------------------------------------------------------------
        */

        foreach (

            $this->makeTagihanPeriods(

                $data['tanggal_masuk'],

                $data['tanggal_keluar'],

                $hargaKamar
                    ->periode
                    ->jumlah_interval,

                $hargaKamar
                    ->periode
                    ->satuan_interval

            )

            as $row

        ) {

            Tagihan::create([

                'id_kamar' =>

                    $data['id_kamar'],

                'id_user' =>

                    $riwayatHunian->id_user,

                'id_harga_kamar' =>

                    $hargaKamar->id_harga_kamar,

                'tanggal_mulai' =>

                    $row[0],

                'tanggal_selesai' =>

                    $row[1],

                'tanggal_jatuh_tempo' =>

    Carbon::parse(

        $row[0]

    )->addDays(

       (int) $data['jatuh_tempo_hari']

    ),

                'status' =>

                    'pending',

            ]);
        }

        return redirect()
            ->route(

                'admin.penghuni.aktif'

            )
            ->with(

                'success',

                'Penghuni berhasil diaktifkan.'

            );
    }

   /*
|--------------------------------------------------------------------------
| GENERATE PERIODE TAGIHAN
|--------------------------------------------------------------------------
*/

private function makeTagihanPeriods(
    string $start,
    string $end,
    int $jumlahInterval,
    string $satuanInterval
): array {

    $current = Carbon::parse($start)
        ->startOfDay();

    $finish = Carbon::parse($end)
        ->startOfDay();

    $rows = [];

    /*
    |--------------------------------------------------------------------------
    | LOOP PERIODE
    |--------------------------------------------------------------------------
    */

    while ($current < $finish)
    {
        /*
        |--------------------------------------------------------------------------
        | HITUNG AKHIR PERIODE
        |--------------------------------------------------------------------------
        */

        $periodEnd = match (

            $satuanInterval

        ) {

            'hari' =>

                $current->copy()
                    ->addDays(
                        $jumlahInterval
                    )
                    ->subDay(),

            'minggu' =>

                $current->copy()
                    ->addWeeks(
                        $jumlahInterval
                    )
                    ->subDay(),

            'bulan' =>

                $current->copy()
                    ->addMonthsNoOverflow(
                        $jumlahInterval
                    )
                    ->subDay(),

            'tahun' =>

                $current->copy()
                    ->addYears(
                        $jumlahInterval
                    )
                    ->subDay(),

            default =>

                throw new \InvalidArgumentException(

                    'Satuan periode tidak valid.'

                ),
        };

        /*
        |--------------------------------------------------------------------------
        | JIKA LEWAT TANGGAL KELUAR
        |--------------------------------------------------------------------------
        */

        if ($periodEnd > $finish)
        {
            $periodEnd = $finish->copy();
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN PERIODE
        |--------------------------------------------------------------------------
        */

        $rows[] = [

            $current->toDateString(),

            $periodEnd->toDateString()

        ];

        /*
        |--------------------------------------------------------------------------
        | NEXT PERIODE
        |--------------------------------------------------------------------------
        */

        $current = $periodEnd
            ->copy()
            ->addDay();
    }

    return $rows;
}
}