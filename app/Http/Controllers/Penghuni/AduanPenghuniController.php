<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use App\Models\RiwayatHunian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AduanPenghuniController extends Controller
{
    public function index()
    {
        $aduans = Aduan::where('id_user', auth()->id())
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

        $user = Auth::user();

        // Ambil riwayat hunian aktif penghuni → untuk dapat id_kost
        $riwayat = RiwayatHunian::where('id_user', $user->id)
            ->whereIn('status', ['aktif', 'antrian'])
            ->latest()
            ->first();

        if (!$riwayat || !$riwayat->id_kost) {
            return back()->withErrors([
                'aduan' => 'Kamu belum terdaftar di kos manapun. Hubungi admin.'
            ]);
        }

        Aduan::create([
            'id_user'    => $user->id,
            'kost_id'    => $riwayat->id_kost,
            'isi_aduan'  => $request->isi_aduan,
            'foto_aduan' => $foto,
            'status'     => 'baru',
            'tanggal'    => now()
        ]);

        return redirect()
            ->route('penghuni.aduan.index')
            ->with('success', 'Aduan berhasil dikirim');
    }
}