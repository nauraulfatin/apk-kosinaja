<?php

namespace App\Http\Controllers;

use App\Models\AturanKos;
use App\Models\RiwayatHunian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AturanKosController extends Controller
{
    public function index()
    {
        $kost = Auth::user()->kost;

        $aturans = $kost
            ? $kost->aturanKos()->latest()->get()
            : collect();

        return view('admin.aturan.index', compact('aturans'));
    }

    public function create()
    {
        abort_if(!Auth::user()->kost, 404);

        return view('admin.aturan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'isi_aturan' => ['required', 'string', 'max:5000'],
        ]);

        $kost = Auth::user()->kost;
        abort_if(!$kost, 404);

        AturanKos::create([
            'kost_id' => $kost->id,
            'judul' => 'Aturan Kos',
            'isi' => $data['isi_aturan'],
        ]);

        return redirect()
            ->route('admin.aturan.index')
            ->with('success', 'Aturan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $aturan = $this->aturanMilikAdmin($id);

        return view('admin.aturan.edit', compact('aturan'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'isi_aturan' => ['required', 'string', 'max:5000'],
        ]);

        $aturan = $this->aturanMilikAdmin($id);
        $aturan->update(['isi' => $data['isi_aturan']]);

        return redirect()
            ->route('admin.aturan.index')
            ->with('success', 'Aturan berhasil diupdate');
    }

    public function destroy($id)
    {
        $aturan = $this->aturanMilikAdmin($id);
        $aturan->delete();

        return redirect()
            ->route('admin.aturan.index')
            ->with('success', 'Aturan berhasil dihapus');
    }

    public function penghuniIndex()
    {
        $riwayat = RiwayatHunian::where('id_user', Auth::id())
            ->whereIn('status', ['aktif', 'antrian'])
            ->latest('id_riwayat_hunian')
            ->first();

        $aturans = $riwayat?->id_kost
            ? AturanKos::where('kost_id', $riwayat->id_kost)->latest()->get()
            : collect();

        return view('penghuni.aturan.aturan', compact('aturans'));
    }

    private function aturanMilikAdmin($id): AturanKos
    {
        $kost = Auth::user()->kost;
        abort_if(!$kost, 404);

        return AturanKos::where('kost_id', $kost->id)->findOrFail($id);
    }
}
