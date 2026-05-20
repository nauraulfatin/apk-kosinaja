<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RiwayatHunian;
use App\Models\KamarKost;
use App\Models\HargaKamar;
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
        $kost = auth()->user()->kost;

        $items = RiwayatHunian::with([

                'user',
                'kost'

            ])
            ->where(

                'status',

                'menunggu'

            )
            ->where(

                'id_kost',

                $kost->id

            )
            ->latest()
            ->get();

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
        | KAMAR
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

            'admin.pengajuan.show',

            compact(

                'riwayatHunian',
                'kamars',
                'hargaKamars'

            )

        );
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE / ANTRIAN
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

            'id_harga_kamar' =>

                'required|exists:harga_kamars,id_harga_kamar',

            'jatuh_tempo_hari' =>

                'required|integer|min:1|max:31',

            'status' =>

                'required|in:aktif,antrian',

        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE RIWAYAT
        |--------------------------------------------------------------------------
        */

        $riwayatHunian->update([

            'id_kost' =>

                auth()->user()
                    ->kost
                    ->id,

            'id_kamar' =>

                $data['id_kamar'],

            'tanggal_masuk' =>

                $data['tanggal_masuk'],

            'tanggal_keluar' =>

                $data['tanggal_keluar'],

            'status' =>

                $data['status'],

        ]);

        /*
        |--------------------------------------------------------------------------
        | JIKA ANTRIAN
        |--------------------------------------------------------------------------
        */

        if ($data['status'] === 'antrian')
        {
            return redirect()
                ->route('admin.pengajuan.index')
                ->with(

                    'success',

                    'Penghuni berhasil dimasukkan ke daftar antrian.'

                );
        }

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

                    $hargaKamar
                        ->id_harga_kamar,

                'tanggal_mulai' =>

                    $row[0],

                'tanggal_selesai' =>

                    $row[1],

                /*
                |--------------------------------------------------------------------------
                | JATUH TEMPO
                |--------------------------------------------------------------------------
                */

                'tanggal_jatuh_tempo' =>

                    Carbon::parse(

                        $row[0]

                    )->addDays(

                        (int)
                        $data['jatuh_tempo_hari']

                    ),

                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                */

                'status' =>

                    'pending',

            ]);
        }

        return redirect()
            ->route('admin.pengajuan.index')
            ->with(

                'success',

                'Penghuni berhasil diapprove.'

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

        while ($current < $finish)
        {
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
            | BATASI TANGGAL KELUAR
            |--------------------------------------------------------------------------
            */

            if ($periodEnd > $finish)
            {
                $periodEnd = $finish->copy();
            }

            /*
            |--------------------------------------------------------------------------
            | SIMPAN
            |--------------------------------------------------------------------------
            */

            $rows[] = [

                $current->toDateString(),

                $periodEnd->toDateString()

            ];

            /*
            |--------------------------------------------------------------------------
            | NEXT
            |--------------------------------------------------------------------------
            */

            $current = $periodEnd
                ->copy()
                ->addDay();
        }

        return $rows;
    }
}