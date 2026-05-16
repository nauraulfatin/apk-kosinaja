<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AduanPenghuniController extends Controller
{
    public function index()
{
    $aduans = \App\Models\Aduan::where('id_user', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();

    return view('penghuni.aduan.index', compact('aduans'));
}

    public function create()
    {
        return view('penghuni.aduan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi_aduan' => 'required',
            'foto_aduan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $foto = null;

        if ($request->hasFile('foto_aduan')) {
            $foto = $request->file('foto_aduan')
                ->store('aduan', 'public');
        }

        Aduan::create([
            'id_user' => Auth::id(),
            'isi_aduan' => $request->isi_aduan,
            'foto_aduan' => $foto,
            'status' => 'baru',
            'tanggal' => now()
        ]);

        return redirect()
            ->route('penghuni.aduan.index')
            ->with('success', 'Aduan berhasil dikirim');
    }
}