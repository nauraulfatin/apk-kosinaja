<?php

namespace App\Http\Controllers;

use App\Models\AturanKos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AturanKosController extends Controller
{
    public function index()
    {
        $kost = DB::table('kosts')
            ->where('id_user', Auth::user()->id)
            ->first();

        if (!$kost) {
            $aturans = collect();
        } else {
            $aturans = AturanKos::where('kost_id', $kost->id)->get();
        }

        return view('admin.aturan.index', compact('aturans'));
    }

    public function create()
    {
        return view('admin.aturan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi_aturan' => 'required'
        ]);

        $kost = DB::table('kosts')
            ->where('id_user', Auth::user()->id)
            ->first();

        if (!$kost) {
            return back()->with('error', 'Data kost tidak ditemukan');
        }

        AturanKos::create([
            'kost_id' => $kost->id,
            'judul' => 'Aturan Kos',
            'isi' => $request->isi_aturan
        ]);

        return redirect()
            ->route('admin.aturan.index')
            ->with('success', 'Aturan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $aturan = AturanKos::findOrFail($id);

        return view('admin.aturan.edit', compact('aturan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'isi_aturan' => 'required'
        ]);

        $aturan = AturanKos::findOrFail($id);

        $aturan->update([
            'isi' => $request->isi_aturan
        ]);

        return redirect()
            ->route('admin.aturan.index')
            ->with('success', 'Aturan berhasil diupdate');
    }

    public function destroy($id)
    {
        AturanKos::findOrFail($id)->delete();

        return redirect()
            ->route('admin.aturan.index')
            ->with('success', 'Aturan berhasil dihapus');
    }

    public function penghuniIndex()
    {
        $aturans = DB::table('peraturans')->get();

        return view(
            'penghuni.aturan.aturan',
            compact('aturans')
        );
    }
}