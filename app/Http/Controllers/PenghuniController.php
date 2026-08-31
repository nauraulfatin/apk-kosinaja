<?php

namespace App\Http\Controllers;

use App\Models\HargaKamar;
use App\Models\KamarKost;
use App\Models\Kost;
use App\Models\RiwayatHunian;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PenghuniController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function dashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | HUNIAN AKTIF
        |--------------------------------------------------------------------------
        */

        $hunianAktif = RiwayatHunian::with([
                'kamar.kost',
            ])
            ->where(
                'id_user',
                $request->user()->id
            )
            ->where(
                'status',
                'aktif'
            )
            ->latest()
            ->first();

        /*
        |--------------------------------------------------------------------------
        | TAGIHAN
        |--------------------------------------------------------------------------
        */

        $tagihanAktif = Tagihan::with([
                'kamar.kost',
                'hargaKamar.periode',
                'pembayaran',
            ])
            ->where(
                'id_user',
                $request->user()->id
            )
            ->get();

        $tagihanTerbaru = $tagihanAktif
            ->filter(function ($tagihan) {
                return
                    $tagihan->status_label
                    !== 'lunas';
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

        /*
         * Bagian status tagihan akan kita rapikan pada prioritas
         * status tagihan berikutnya.
         *
         * Untuk sekarang dipertahankan agar perubahan tahap ini
         * fokus pada authorization.
         */

        $tagihanPending = $tagihanAktif
            ->whereIn(
                'status',
                [
                    'pending',
                    'telat',
                    'ditolak',
                    'menunggu_verifikasi',
                ]
            )
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

    public function aktif(Request $request)
    {
        $kost = $this->getAdminKost();

        $items = RiwayatHunian::with([
                'user',
                'kamar',
            ])
            ->where(
                'id_kost',
                $kost->id
            )
            ->where(
                'status',
                'aktif'
            )
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

    public function antrian(Request $request)
    {
        $kost = $this->getAdminKost();

        $items = RiwayatHunian::with([
                'user',
                'kamar',
            ])
            ->where(
                'id_kost',
                $kost->id
            )
            ->where(
                'status',
                'antrian'
            )
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

    public function nonaktif(Request $request)
    {
        $kost = $this->getAdminKost();

        $items = RiwayatHunian::with([
                'user',
                'kamar',
            ])
            ->where(
                'id_kost',
                $kost->id
            )
            ->where(
                'status',
                'nonaktif'
            )
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
    ) {
        $kost = $this->getAdminKost();

        /*
        |--------------------------------------------------------------------------
        | CEK OWNERSHIP
        |--------------------------------------------------------------------------
        */

        $this->ensureRiwayatOwnedByKost(
            $riwayatHunian,
            $kost->id,
            ['aktif']
        );

        DB::transaction(
            function () use (
                $riwayatHunian,
                $kost
            ) {
                /*
                |--------------------------------------------------------------------------
                | NONAKTIFKAN
                |--------------------------------------------------------------------------
                */

                $riwayatHunian->update([
                    'status' =>
                        'nonaktif',

                    'tanggal_keluar' =>
                        now(),
                ]);

                /*
                |--------------------------------------------------------------------------
                | HAPUS TAGIHAN YANG BELUM LUNAS
                |--------------------------------------------------------------------------
                |
                | Penting:
                |
                | Hanya tagihan penghuni pada KOS INI.
                |
                | Jangan sampai tagihan penghuni pada kos lain
                | ikut terhapus.
                |
                */

                Tagihan::where(
                        'id_user',
                        $riwayatHunian->id_user
                    )
                    ->where(
                        'status',
                        '!=',
                        'lunas'
                    )
                    ->whereHas(
                        'kamar',
                        function ($query) use ($kost) {
                            $query->where(
                                'id_kost',
                                $kost->id
                            );
                        }
                    )
                    ->delete();
            }
        );

        return back()->with(
            'success',
            'Penghuni berhasil dinonaktifkan dan tagihan yang belum lunas pada kos ini telah dihapus.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM AKTIFKAN PENGHUNI
    |--------------------------------------------------------------------------
    */

    public function formAktifkan(
        RiwayatHunian $riwayatHunian
    ) {
        $kost = $this->getAdminKost();

        /*
        |--------------------------------------------------------------------------
        | CEK OWNERSHIP
        |--------------------------------------------------------------------------
        |
        | Hanya penghuni antrian / nonaktif pada kos admin login
        | yang boleh dibuka.
        |
        */

        $this->ensureRiwayatOwnedByKost(
            $riwayatHunian,
            $kost->id,
            [
                'antrian',
                'nonaktif',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | KAMAR MILIK ADMIN LOGIN
        |--------------------------------------------------------------------------
        */

        $kamars = KamarKost::with([
                'riwayatHunian.user',
            ])
            ->where(
                'id_kost',
                $kost->id
            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | HARGA KAMAR MILIK ADMIN LOGIN
        |--------------------------------------------------------------------------
        */

        $hargaKamars = HargaKamar::with([
                'periode',
                'kamar',
            ])
            ->where(
                'isactive',
                true
            )
            ->whereHas(
                'kamar',
                function ($query) use ($kost) {
                    $query->where(
                        'id_kost',
                        $kost->id
                    );
                }
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
        Request $request,
        RiwayatHunian $riwayatHunian
    ) {
        $kost = $this->getAdminKost();

        /*
        |--------------------------------------------------------------------------
        | CEK OWNERSHIP
        |--------------------------------------------------------------------------
        */

        $this->ensureRiwayatOwnedByKost(
            $riwayatHunian,
            $kost->id,
            [
                'antrian',
                'nonaktif',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([
            'id_kamar' => [
                'required',
                'integer',

                /*
                 * Kamar harus milik kos admin login.
                 */
                Rule::exists(
                    'kamar_kosts',
                    'id_kamar'
                )->where(
                    fn ($query) =>
                    $query->where(
                        'id_kost',
                        $kost->id
                    )
                ),
            ],

            'tanggal_masuk' => [
                'required',
                'date',
            ],

            'tanggal_keluar' => [
                'required',
                'date',
                'after:tanggal_masuk',
            ],

            'id_harga_kamar' => [
                'required',
                'integer',
                'exists:harga_kamars,id_harga_kamar',
            ],

            'jatuh_tempo_hari' => [
                'required',
                'integer',
                'min:1',
                'max:31',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | VALIDASI HARGA KAMAR
        |--------------------------------------------------------------------------
        |
        | Jangan percaya id_harga_kamar dari browser.
        |
        | Pastikan harga:
        | - aktif,
        | - milik kamar yang dipilih,
        | - dan kamar tersebut milik kos admin.
        |
        */

        $hargaKamar = HargaKamar::with(
                'periode'
            )
            ->where(
                'id_harga_kamar',
                $data['id_harga_kamar']
            )
            ->where(
                'id_kamar',
                $data['id_kamar']
            )
            ->where(
                'isactive',
                true
            )
            ->whereHas(
                'kamar',
                function ($query) use ($kost) {
                    $query->where(
                        'id_kost',
                        $kost->id
                    );
                }
            )
            ->first();

        if (!$hargaKamar) {
            throw ValidationException::withMessages([
                'id_harga_kamar' =>
                    'Harga kamar tidak valid atau bukan milik kos Anda.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK BENTROK KAMAR
        |--------------------------------------------------------------------------
        */

        $bentrok = RiwayatHunian::where(
                'id_kamar',
                $data['id_kamar']
            )
            ->where(
                'status',
                'aktif'
            )
            ->where(
                'id_riwayat_hunian',
                '!=',
                $riwayatHunian->id_riwayat_hunian
            )
            ->whereDate(
                'tanggal_masuk',
                '<=',
                $data['tanggal_keluar']
            )
            ->where(
                function ($query) use ($data) {
                    $query
                        ->whereNull(
                            'tanggal_keluar'
                        )
                        ->orWhereDate(
                            'tanggal_keluar',
                            '>=',
                            $data['tanggal_masuk']
                        );
                }
            )
            ->exists();

        if ($bentrok) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Kamar sudah digunakan pada periode tersebut. Silakan pilih kamar atau tanggal lain.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use (
                $data,
                $kost,
                $hargaKamar,
                $riwayatHunian
            ) {
                /*
                |--------------------------------------------------------------------------
                | UPDATE RIWAYAT
                |--------------------------------------------------------------------------
                */

                $riwayatHunian->update([
                    /*
                     * Tetap set id_kost supaya konsisten
                     * dengan admin yang melakukan proses.
                     */

                    'id_kost' =>
                        $kost->id,

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
                | HAPUS TAGIHAN LAMA KOS INI
                |--------------------------------------------------------------------------
                */

                Tagihan::where(
                        'id_user',
                        $riwayatHunian->id_user
                    )
                    ->whereHas(
                        'kamar',
                        function ($query) use ($kost) {
                            $query->where(
                                'id_kost',
                                $kost->id
                            );
                        }
                    )
                    ->delete();

                /*
                |--------------------------------------------------------------------------
                | GENERATE TAGIHAN
                |--------------------------------------------------------------------------
                */

                $periode =
                    $hargaKamar->periode;

                foreach (
                    $this->makeTagihanPeriods(
                        $data['tanggal_masuk'],
                        $data['tanggal_keluar'],
                        $periode->jumlah_interval,
                        $periode->satuan_interval
                    ) as $row
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

                        'tanggal_jatuh_tempo' =>
                            Carbon::parse(
                                $row[0]
                            )->addDays(
                                (int)
                                $data[
                                    'jatuh_tempo_hari'
                                ]
                            ),

                        'status' =>
                            'pending',
                    ]);
                }
            }
        );

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
    | GET KOS ADMIN LOGIN
    |--------------------------------------------------------------------------
    */

    private function getAdminKost(): Kost
    {
        $kost =
            auth()->user()?->kost;

        abort_unless(
            $kost,
            403,
            'Admin belum memiliki data kos.'
        );

        return $kost;
    }

    /*
    |--------------------------------------------------------------------------
    | CEK OWNERSHIP RIWAYAT HUNIAN
    |--------------------------------------------------------------------------
    */

    private function ensureRiwayatOwnedByKost(
        RiwayatHunian $riwayatHunian,
        int $kostId,
        array $allowedStatuses = []
    ): void {
        /*
         * Riwayat harus mempunyai id_kost yang sama
         * dengan kos admin login.
         */

        abort_unless(
            (int) $riwayatHunian->id_kost ===
            (int) $kostId,
            404
        );

        /*
         * Kalau method hanya boleh digunakan pada status tertentu,
         * status juga diverifikasi.
         */

        if (
            !empty($allowedStatuses) &&
            !in_array(
                $riwayatHunian->status,
                $allowedStatuses,
                true
            )
        ) {
            abort(404);
        }
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
        $current = Carbon::parse(
            $start
        )->startOfDay();

        $finish = Carbon::parse(
            $end
        )->startOfDay();

        $rows = [];

        while ($current < $finish) {
            $periodEnd = match (
                $satuanInterval
            ) {
                'hari' =>
                    $current
                        ->copy()
                        ->addDays(
                            $jumlahInterval
                        )
                        ->subDay(),

                'minggu' =>
                    $current
                        ->copy()
                        ->addWeeks(
                            $jumlahInterval
                        )
                        ->subDay(),

                'bulan' =>
                    $current
                        ->copy()
                        ->addMonthsNoOverflow(
                            $jumlahInterval
                        )
                        ->subDay(),

                'tahun' =>
                    $current
                        ->copy()
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
             * Batasi sampai tanggal keluar.
             */

            if ($periodEnd > $finish) {
                $periodEnd =
                    $finish->copy();
            }

            $rows[] = [
                $current->toDateString(),
                $periodEnd->toDateString(),
            ];

            $current =
                $periodEnd
                    ->copy()
                    ->addDay();
        }

        return $rows;
    }
}