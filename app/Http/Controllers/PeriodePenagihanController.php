<?php
namespace App\Http\Controllers;

use App\Models\PeriodePenagihan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PeriodePenagihanController extends Controller
{
    public function index()
    {
        return view('admin.periode.index', [
            'items' => PeriodePenagihan::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.periode.form', [
            'item' => new PeriodePenagihan(['jumlah_interval' => 1, 'satuan_interval' => 'bulan']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        PeriodePenagihan::create($data);

        return redirect()->route('admin.periode.index')->with('success', 'Periode ditambah.');
    }

    public function edit(PeriodePenagihan $periode)
    {
        return view('admin.periode.form', ['item' => $periode]);
    }

    public function update(Request $request, PeriodePenagihan $periode)
    {
        $data = $this->validatedData($request, $periode);
        $periode->update($data);

        return redirect()->route('admin.periode.index')->with('success', 'Periode diperbarui.');
    }

    public function destroy(PeriodePenagihan $periode)
    {
        $periode->delete();
        return back()->with('success', 'Periode dihapus.');
    }

    private function validatedData(Request $request, ?PeriodePenagihan $periode = null): array
    {
        $ignoreId = $periode?->id_penagihan;

        return $request->validate([
            'periode_penagihan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('periode_penagihans', 'periode_penagihan')->ignore($ignoreId, 'id_penagihan'),
            ],
            'jumlah_interval' => ['required', 'integer', 'min:1', 'max:120'],
            'satuan_interval' => ['required', Rule::in(['hari', 'minggu', 'bulan', 'tahun'])],
        ]);
    }
}
