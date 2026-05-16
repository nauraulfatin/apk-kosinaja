<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use Illuminate\Http\Request;

class AduanAdminController extends Controller
{
    public function index()
    {
        $aduan = Aduan::with('user')
            ->latest()
            ->get();

        return view('admin.aduan.index', compact('aduan'));
    }

    public function show($id)
    {
        $aduan = Aduan::with('user')
            ->findOrFail($id);

        return view('admin.aduan.show', compact('aduan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggapan_admin' => 'required',
            'status' => 'required'
        ]);

        $aduan = Aduan::findOrFail($id);

        $aduan->update([
            'tanggapan_admin' => $request->tanggapan_admin,
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.aduan.index')
            ->with('success', 'Aduan berhasil ditanggapi');
    }
}