<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

class PengajuanPenghuniController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $kost = $this->getAdminKost();

        $items = RiwayatHunian::with([
                'user',
                'kost',
            ])
            ->where('id_kost', $kost->id)
            ->where('status', 'menunggu')
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

    public function show(RiwayatHunian $riwayatHunian)
    {
        $kost = $this->getAdminKost();

        /*
        |--------------------------------------------------------------------------
        | CEK OWNERSHIP
        |--------------------------------------------------------------------------
        |
        | Admin hanya boleh membuka pengajuan penghuni yang memang
        | mengajukan ke kos miliknya.
        |
        */

        $this->ensureRiwayatOwnedByKost(
            $riwayatHunian,
            $kost->id,
            ['menunggu']
        );

        /*
        |--------------------------------------------------------------------------
        | KAMAR MILIK KOS ADMIN
        |--------------------------------------------------------------------------
        */

        $kamars = KamarKost::with([
                'riwayatHunian.user',
            ])
            ->where('id_kost', $kost->id)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | HARGA KAMAR MILIK KOS ADMIN
        |--------------------------------------------------------------------------
        |
        | Sebelumnya semua harga kamar dari seluruh kos bisa ikut terambil.
        | Sekarang hanya harga kamar yang kamar-nya dimiliki admin login.
        |
        */

        $hargaKamars = HargaKamar::with([
                'periode',
                'kamar',
            ])
            ->where('isactive', true)
            ->whereHas('kamar', function ($query) use ($kost) {
                $query->where('id_kost', $kost->id);
            })
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
    | APPROVE / MASUKKAN ANTRIAN
    |--------------------------------------------------------------------------
    */

    public function approve(
        Request $request,
        RiwayatHunian $riwayatHunian
    ) {
        $kost = $this->getAdminKost();

        /*
        |--------------------------------------------------------------------------
        | CEK OWNERSHIP PENGAJUAN
        |--------------------------------------------------------------------------
        |
        | Tidak cukup hanya route middleware role.
        | Kita juga harus memastikan object yang sedang diproses
        | memang milik kos admin login.
        |
        */

        $this->ensureRiwayatOwnedByKost(
            $riwayatHunian,
            $kost->id,
            ['menunggu']
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
                 * Kamar harus benar-benar berada pada kos admin login.
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

            'status' => [
                'required',
                Rule::in([
                    'aktif',
                    'antrian',
                ]),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | VALIDASI HARGA KAMAR
        |--------------------------------------------------------------------------
        |
        | Harga harus:
        |
        | 1. Aktif
        | 2. Milik kamar yang dipilih
        | 3. Kamar tersebut milik kos admin login
        |
        | Jadi user tidak bisa memanipulasi id_harga_kamar dari kos lain.
        |
        */

        $hargaKamar = HargaKamar::with('periode')
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
        |
        | Dua hunian aktif tidak boleh mempunyai periode hunian
        | yang saling tumpang tindih pada kamar yang sama.
        |
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

            /*
             * Existing mulai sebelum periode baru selesai.
             */
            ->whereDate(
                'tanggal_masuk',
                '<=',
                $data['tanggal_keluar']
            )

            /*
             * Existing belum keluar,
             * atau keluar setelah periode baru dimulai.
             */
            ->where(function ($query) use ($data) {
                $query
                    ->whereNull('tanggal_keluar')
                    ->orWhereDate(
                        'tanggal_keluar',
                        '>=',
                        $data['tanggal_masuk']
                    );
            })
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

        DB::transaction(function () use (
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
                'id_kost' => $kost->id,

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
            | JIKA MASUK ANTRIAN
            |--------------------------------------------------------------------------
            */

            if ($data['status'] === 'antrian') {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | HAPUS TAGIHAN LAMA DI KOS INI
            |--------------------------------------------------------------------------
            |
            | Sebelumnya:
            |
            | Tagihan::where('id_user', ...)->delete();
            |
            | Itu bisa menghapus tagihan user tersebut dari kos lain.
            |
            | Sekarang tagihan dibatasi hanya untuk kos admin login.
            |
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

            $periode = $hargaKamar->periode;

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
                        $hargaKamar->id_harga_kamar,

                    'tanggal_mulai' =>
                        $row[0],

                    'tanggal_selesai' =>
                        $row[1],

                    'tanggal_jatuh_tempo' =>
                        Carbon::parse(
                            $row[0]
                        )->addDays(
                            (int)
                            $data['jatuh_tempo_hari']
                        ),

                    'status' =>
                        'pending',
                ]);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        if ($data['status'] === 'antrian') {
            return redirect()
                ->route(
                    'admin.pengajuan.index'
                )
                ->with(
                    'success',
                    'Penghuni berhasil dimasukkan ke daftar antrian.'
                );
        }

        return redirect()
            ->route(
                'admin.pengajuan.index'
            )
            ->with(
                'success',
                'Penghuni berhasil disetujui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | GET KOS ADMIN LOGIN
    |--------------------------------------------------------------------------
    */

    private function getAdminKost(): Kost
    {
        $kost = auth()->user()?->kost;

        /*
         * Admin Kos seharusnya mempunyai satu data kos.
         * Kalau tidak ada, request dihentikan.
         */

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
         * Gunakan 404 daripada 403 supaya keberadaan data kos lain
         * tidak dibocorkan kepada pengguna.
         */

        abort_unless(
            (int) $riwayatHunian->id_kost ===
            (int) $kostId,
            404
        );

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
            $periodEnd = match ($satuanInterval) {
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
             * Jangan melewati tanggal keluar.
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