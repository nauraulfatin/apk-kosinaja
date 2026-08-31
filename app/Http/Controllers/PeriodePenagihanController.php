<?php

namespace App\Http\Controllers;

use App\Models\PeriodePenagihan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PeriodePenagihanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX MASTER PERIODE
    |--------------------------------------------------------------------------
    |
    | Periode penagihan adalah master data global. Hanya Super Admin yang
    | dapat mengelolanya. Admin Kos cukup memilih periode yang tersedia saat
    | mengatur harga kamar.
    |
    */
    public function index()
    {
        $items = PeriodePenagihan::withCount('hargaKamars')
            ->orderBy('id_penagihan')
            ->get();

        return view('superadmin.periode.index', compact('items'));
    }

    public function create()
    {
        return view('superadmin.periode.form', [
            'item' => new PeriodePenagihan([
                'jumlah_interval' => 1,
                'satuan_interval' => 'bulan',
            ]),
            'sedangDigunakan' => false,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        PeriodePenagihan::create($data);

        return redirect()
            ->route('superadmin.periode.index')
            ->with('success', 'Periode penagihan berhasil ditambahkan.');
    }

    public function edit(PeriodePenagihan $periode)
    {
        $sedangDigunakan = $periode->hargaKamars()->exists();

        return view('superadmin.periode.form', [
            'item' => $periode,
            'sedangDigunakan' => $sedangDigunakan,
        ]);
    }

    public function update(Request $request, PeriodePenagihan $periode)
    {
        $sedangDigunakan = $periode->hargaKamars()->exists();

        /*
        |--------------------------------------------------------------------------
        | LINDUNGI INTERVAL YANG SUDAH DIPAKAI
        |--------------------------------------------------------------------------
        |
        | Jika periode sudah dipakai pada harga kamar, jumlah/satuan interval
        | tidak boleh diubah karena perubahan tersebut akan berdampak ke seluruh
        | kos yang menggunakan master periode ini. Nama/label masih boleh diubah.
        |
        */
        $data = $this->validatedData(
            $request,
            $periode,
            lockInterval: $sedangDigunakan
        );

        $periode->update($data);

        return redirect()
            ->route('superadmin.periode.index')
            ->with(
                'success',
                $sedangDigunakan
                    ? 'Nama periode berhasil diperbarui. Interval tetap dikunci karena periode sedang digunakan.'
                    : 'Periode penagihan berhasil diperbarui.'
            );
    }

    public function destroy(PeriodePenagihan $periode)
    {
        /*
        |--------------------------------------------------------------------------
        | JANGAN HAPUS MASTER YANG MASIH DIGUNAKAN
        |--------------------------------------------------------------------------
        */
        if ($periode->hargaKamars()->exists()) {
            return back()->with(
                'error',
                'Periode tidak dapat dihapus karena masih digunakan pada harga kamar.'
            );
        }

        $periode->delete();

        return back()->with(
            'success',
            'Periode penagihan berhasil dihapus.'
        );
    }

    private function validatedData(
        Request $request,
        ?PeriodePenagihan $periode = null,
        bool $lockInterval = false
    ): array {
        $ignoreId = $periode?->id_penagihan;

        $rules = [
            'periode_penagihan' => [
                'required',
                'string',
                'max:100',
                Rule::unique(
                    'periode_penagihans',
                    'periode_penagihan'
                )->ignore($ignoreId, 'id_penagihan'),
            ],
        ];

        if (!$lockInterval) {
            $rules['jumlah_interval'] = [
                'required',
                'integer',
                'min:1',
                'max:120',
            ];

            $rules['satuan_interval'] = [
                'required',
                Rule::in([
                    'hari',
                    'minggu',
                    'bulan',
                    'tahun',
                ]),
            ];
        }

        return $request->validate($rules, [
            'periode_penagihan.required' => 'Nama periode wajib diisi.',
            'periode_penagihan.unique' => 'Nama periode tersebut sudah tersedia.',
            'periode_penagihan.max' => 'Nama periode maksimal 100 karakter.',
            'jumlah_interval.required' => 'Jumlah interval wajib diisi.',
            'jumlah_interval.integer' => 'Jumlah interval harus berupa angka bulat.',
            'jumlah_interval.min' => 'Jumlah interval minimal 1.',
            'jumlah_interval.max' => 'Jumlah interval maksimal 120.',
            'satuan_interval.required' => 'Satuan interval wajib dipilih.',
            'satuan_interval.in' => 'Satuan interval tidak valid.',
        ]);
    }
}
