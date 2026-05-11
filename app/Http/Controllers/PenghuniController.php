<?php

namespace App\Http\Controllers;

use App\Models\HargaKamar;
use App\Models\KamarKost;
use App\Models\Tagihan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenghuniController extends Controller
{
    public function dashboard(Request $r)
    {
        return view('penghuni.dashboard');
    }

    public function index(Request $r)
    {
        $kostId = $r->user()->kost->id;

        $items = User::where('role', 'penghuni kost')
            ->whereHas('tagihans.kamar', fn($q) => $q->where('id_kost', $kostId))
            ->distinct()
            ->get();

        return view('admin.penghuni.index', compact('items'));
    }

    public function create(Request $r)
    {
        $kamars = KamarKost::where('id_kost', $r->user()->kost->id)
            ->where('status', 'kosong')
            ->with([
                'hargaKamars' => fn($q) =>
                    $q->where('isactive', true)
                      ->with('periode')
            ])
            ->get();

        return view('admin.penghuni.form', [
            'item' => new User,
            'kamars' => $kamars
        ]);
    }

    public function store(Request $r)
    {
        $d = $r->validate([
            'username' => 'required|unique:users',
            'nik' => 'required|unique:users',
            'nama' => 'required',
            'password' => 'required|min:8|confirmed',
            'no_hp' => 'required',
            'id_kamar' => 'required|exists:kamar_kosts,id_kamar',
            'id_harga_kamar' => 'required|exists:harga_kamars,id_harga_kamar',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai'
        ]);

        $kamar = KamarKost::findOrFail($d['id_kamar']);

        abort_if(
            $kamar->id_kost !== $r->user()->kost->id ||
            $kamar->status !== 'kosong',
            403
        );

        $harga = HargaKamar::with('periode')
            ->findOrFail($d['id_harga_kamar']);

        abort_if(
            $harga->id_kamar !== $kamar->id_kamar ||
            !$harga->isactive,
            403
        );

        DB::transaction(function () use ($d, $kamar, $harga) {

            $user = User::create([
                'username' => $d['username'],
                'nik' => $d['nik'],
                'nama' => $d['nama'],
                'password' => Hash::make($d['password']),
                'no_hp' => $d['no_hp'],
                'role' => 'penghuni kost',
                'status' => 'aktif'
            ]);

            foreach (
                $this->makeTagihanPeriods(
                    $d['tanggal_mulai'],
                    $d['tanggal_selesai'],
                    $harga->periode->jumlah_interval,
                    $harga->periode->satuan_interval
                ) as $row
            ) {

                Tagihan::create([
                    'id_kamar' => $kamar->id_kamar,
                    'id_user' => $user->id,
                    'id_harga_kamar' => $harga->id_harga_kamar,
                    'tanggal_mulai' => $row[0],
                    'tanggal_selesai' => $row[1],
                    'tanggal_jatuh_tempo' => $row[1],
                    'status' => 'pending',
                ]);
            }

            $kamar->update([
                'status' => 'terisi'
            ]);
        });

        return redirect()
            ->route('admin.penghuni.index')
            ->with('success', 'Penghuni dan tagihan berhasil dibuat.');
    }

    public function edit(User $penghuni)
    {
        return view('admin.penghuni.edit', [
            'item' => $penghuni
        ]);
    }

    public function update(Request $r, User $penghuni)
    {
        abort_if($penghuni->role !== 'penghuni kost', 404);

        $d = $r->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'password' => 'nullable|min:8|confirmed'
        ]);

        if (!empty($d['password'])) {
            $d['password'] = Hash::make($d['password']);
        } else {
            unset($d['password']);
        }

        $penghuni->update($d);

        return redirect()
            ->route('admin.penghuni.index')
            ->with('success', 'Penghuni diperbarui.');
    }

    public function destroy(User $penghuni)
    {
        abort_if($penghuni->role !== 'penghuni kost', 404);

        DB::transaction(function () use ($penghuni) {

            /*
            |--------------------------------------------------------------------------
            | AMBIL ID KAMAR
            |--------------------------------------------------------------------------
            */

            $idKamar = Tagihan::where('id_user', $penghuni->id)
                ->value('id_kamar');

            /*
            |--------------------------------------------------------------------------
            | AMBIL ID TAGIHAN
            |--------------------------------------------------------------------------
            */

            $tagihanIds = Tagihan::where('id_user', $penghuni->id)
                ->pluck('id_tagihan');

            /*
            |--------------------------------------------------------------------------
            | HAPUS PEMBAYARAN
            |--------------------------------------------------------------------------
            */

            DB::table('pembayarans')
                ->whereIn('id_tagihan', $tagihanIds)
                ->delete();

            /*
            |--------------------------------------------------------------------------
            | HAPUS TAGIHAN
            |--------------------------------------------------------------------------
            */

            Tagihan::where('id_user', $penghuni->id)
                ->delete();

            /*
            |--------------------------------------------------------------------------
            | KOSONGKAN KAMAR
            |--------------------------------------------------------------------------
            */

            if ($idKamar) {

                KamarKost::where('id_kamar', $idKamar)
                    ->update([
                        'status' => 'kosong'
                    ]);

            }

            /*
            |--------------------------------------------------------------------------
            | HAPUS PENGHUNI
            |--------------------------------------------------------------------------
            */

            $penghuni->delete();

        });

        return back()->with(
            'success',
            'Penghuni berhasil dihapus.'
        );
    }

    private function makeTagihanPeriods(
        string $start,
        string $end,
        int $jumlahInterval,
        string $satuanInterval
    ): array {

        $current = Carbon::parse($start)->startOfDay();

        $finish = Carbon::parse($end)->startOfDay();

        $rows = [];

        while ($current <= $finish) {

            $periodEnd = match ($satuanInterval) {

                'hari' =>
                    $current->copy()
                        ->addDays($jumlahInterval)
                        ->subDay(),

                'minggu' =>
                    $current->copy()
                        ->addWeeks($jumlahInterval)
                        ->subDay(),

                'bulan' =>
                    $current->copy()
                        ->addMonthsNoOverflow($jumlahInterval)
                        ->subDay(),

                'tahun' =>
                    $current->copy()
                        ->addYears($jumlahInterval)
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

            $current = $periodEnd->copy()->addDay();
        }

        return $rows;
    }
}