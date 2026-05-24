<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AduanAdminController extends Controller
{
    public function index()
    {
        $kost = Auth::user()->kost;

        if (!$kost) {
            return view('admin.aduan.index', ['aduan' => collect()]);
        }

        $aduan = DB::table('aduan')
            ->join('users', 'users.id', '=', 'aduan.id_user')
            ->select(
                'aduan.*',
                'users.nama'
            )
            // Filter berdasarkan kost_id milik admin yang login
            ->where('aduan.kost_id', $kost->id)
            ->latest('aduan.id_aduan')
            ->get();

        return view('admin.aduan.index', compact('aduan'));
    }

    public function show($id)
    {
        $kost = Auth::user()->kost;

        abort_if(!$kost, 404);

        $aduan = DB::table('aduan')
            ->join('users', 'users.id', '=', 'aduan.id_user')
            ->select(
                'aduan.*',
                'users.nama'
            )
            // Pastikan aduan ini milik kost admin yang login
            ->where('aduan.kost_id', $kost->id)
            ->where('aduan.id_aduan', $id)
            ->first();

        abort_if(!$aduan, 404);

        return view('admin.aduan.show', compact('aduan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggapan_admin' => 'required',
            'status' => 'required'
        ]);

        $kost = Auth::user()->kost;

        abort_if(!$kost, 404);

        $cek = DB::table('aduan')
            // Pastikan aduan ini milik kost admin yang login
            ->where('aduan.kost_id', $kost->id)
            ->where('aduan.id_aduan', $id)
            ->exists();

        abort_if(!$cek, 404);

        Aduan::where('id_aduan', $id)->update([
            'tanggapan_admin' => $request->tanggapan_admin,
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.aduan.index')
            ->with('success', 'Aduan berhasil ditanggapi');
    }
}