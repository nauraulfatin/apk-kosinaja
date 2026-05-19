<?php

namespace App\Http\Controllers;

use App\Models\HargaKamar;
use App\Models\KamarKost;
use App\Models\RiwayatHunian;
use App\Models\Tagihan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        | TAGIHAN TERBARU
        |--------------------------------------------------------------------------
        */

        $tagihan = Tagihan::with([

            'kamar.kost',

            'hargaKamar.periode',

            'pembayarans'

        ])
        ->where('id_user', $r->user()->id)
        ->latest('tanggal_mulai')
        ->first();

        /*
        |--------------------------------------------------------------------------
        | TOTAL TAGIHAN
        |--------------------------------------------------------------------------
        */

        $jumlahTagihan = Tagihan::where(

            'id_user',
            $r->user()->id

        )->count();

        /*
        |--------------------------------------------------------------------------
        | TAGIHAN BELUM LUNAS
        |--------------------------------------------------------------------------
        */

        $tagihanPending = Tagihan::where(

            'id_user',
            $r->user()->id

        )
        ->where('status', 'pending')
        ->count();

        return view('penghuni.dashboard', [

            'tagihan' => $tagihan,

            'jumlahTagihan' => $jumlahTagihan,

            'tagihanPending' => $tagihanPending,

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DATA PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function index(Request $r)
    {
        $kostId = $r->user()->kost->id;

        $items = User::where(
                'role',
                'penghuni'
            )
            ->whereHas(
                'riwayatHunian.kamar',
                fn($q) =>
                    $q->where(
                        'id_kost',
                        $kostId
                    )
            )
            ->with([
                'riwayatHunian.kamar'
            ])
            ->distinct()
            ->get();

        return view(
            'admin.penghuni.index',
            compact('items')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function create(Request $r)
    {
        /*
        |--------------------------------------------------------------------------
        | USER PENGHUNI
        |--------------------------------------------------------------------------
        */

        $users = User::where(
                'role',
                'penghuni'
            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | KAMAR
        |--------------------------------------------------------------------------
        */

        $kamars = KamarKost::where(
                'id_kost',
                $r->user()->kost->id
            )
            ->with([

                'hargaKamars' => fn($q) =>

                    $q->where(
                        'isactive',
                        true
                    )->with('periode')

            ])
            ->get();

        return view(
            'admin.penghuni.form',
            [

                'item' => new RiwayatHunian,

                'users' => $users,

                'kamars' => $kamars

            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function store(Request $r)
    {
        $d = $r->validate([

            'id_user' =>
                'required|exists:users,id',

            'id_kamar' =>
                'required|exists:kamar_kosts,id_kamar',

            'id_harga_kamar' =>
                'required|exists:harga_kamars,id_harga_kamar',

            'tanggal_mulai' =>
                'required|date',

            'tanggal_selesai' =>
                'required|date|after_or_equal:tanggal_mulai',

            'tanggal_jatuh_tempo' =>
                'required|date'

        ]);

        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        $user = User::findOrFail(
            $d['id_user']
        );

        /*
        |--------------------------------------------------------------------------
        | KAMAR
        |--------------------------------------------------------------------------
        */

        $kamar = KamarKost::findOrFail(
            $d['id_kamar']
        );

        /*
        |--------------------------------------------------------------------------
        | VALIDASI KOST
        |--------------------------------------------------------------------------
        */

        abort_if(

            $kamar->id_kost !==
            $r->user()->kost->id,

            403

        );

        /*
        |--------------------------------------------------------------------------
        | HARGA KAMAR
        |--------------------------------------------------------------------------
        */

        $harga = HargaKamar::with(
                'periode'
            )
            ->findOrFail(
                $d['id_harga_kamar']
            );

        abort_if(

            $harga->id_kamar !==
            $kamar->id_kamar ||

            !$harga->isactive,

            403

        );

        DB::transaction(function () use (

            $d,

            $user,

            $kamar,

            $harga

        ) {

            /*
            |--------------------------------------------------------------------------
            | RIWAYAT HUNIAN
            |--------------------------------------------------------------------------
            */

            RiwayatHunian::create([

                'id_user' =>
                    $user->id,

                'id_kamar' =>
                    $kamar->id_kamar,

                'tanggal_masuk' =>
                    $d['tanggal_mulai'],

                'tanggal_keluar' =>
                    $d['tanggal_selesai'],

                'status' =>
                    'aktif'

            ]);

            /*
            |--------------------------------------------------------------------------
            | GENERATE TAGIHAN
            |--------------------------------------------------------------------------
            */

            foreach (

                $this->makeTagihanPeriods(

                    $d['tanggal_mulai'],

                    $d['tanggal_selesai'],

                    $harga->periode
                        ->jumlah_interval,

                    $harga->periode
                        ->satuan_interval

                )

                as $row

            ) {

                Tagihan::create([

                    'id_kamar' =>
                        $kamar->id_kamar,

                    'id_user' =>
                        $user->id,

                    'id_harga_kamar' =>
                        $harga->id_harga_kamar,

                    'tanggal_mulai' =>
                        $row[0],

                    'tanggal_selesai' =>
                        $row[1],

                    'tanggal_jatuh_tempo' =>
                        $d['tanggal_jatuh_tempo'],

                    'status' =>
                        'pending',

                ]);
            }

        });

        return redirect()
            ->route('admin.penghuni.index')
            ->with(

                'success',

                'Penghuni berhasil ditambahkan.'

            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function edit(User $penghuni)
    {
        abort_if(
            $penghuni->role !== 'penghuni',
            404
        );

        return view(
            'admin.penghuni.edit',
            [
                'item' => $penghuni
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $r,
        User $penghuni
    ) {

        abort_if(
            $penghuni->role !== 'penghuni',
            404
        );

        $d = $r->validate([

            'nama' => 'required',

            'no_hp' => 'required',

        ]);

        $penghuni->update($d);

        return redirect()
            ->route(
                'admin.penghuni.index'
            )
            ->with(
                'success',
                'Penghuni berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | NONAKTIFKAN PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function destroy(User $penghuni)
    {
        abort_if(
            $penghuni->role !== 'penghuni',
            404
        );

        /*
        |--------------------------------------------------------------------------
        | NONAKTIFKAN RIWAYAT HUNIAN
        |--------------------------------------------------------------------------
        */

        RiwayatHunian::where(

            'id_user',
            $penghuni->id

        )->update([

            'status' => 'nonaktif'

        ]);

        return back()->with(

            'success',

            'Penghuni berhasil dinonaktifkan.'

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

        while ($current <= $finish) {

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

            if ($periodEnd > $finish) {

                $periodEnd = $finish->copy();

            }

            $rows[] = [

                $current->toDateString(),

                $periodEnd->toDateString()

            ];

            $current = $periodEnd
                ->copy()
                ->addDay();
        }

        return $rows;
    }
}