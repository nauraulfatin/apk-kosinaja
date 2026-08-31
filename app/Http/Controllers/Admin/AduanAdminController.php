<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AduanAdminController extends Controller
{
    public function index()
    {
        $kost = Auth::user()->kost;

        $aduan = $kost
            ? Aduan::with('user')
                ->where('kost_id', $kost->id)
                ->latest('id_aduan')
                ->get()
                ->each(function (Aduan $item) {
                    // Kompatibel dengan Blade lama yang membaca $item->nama.
                    $item->setAttribute('nama', $item->user?->nama ?? '-');
                })
            : collect();

        return view('admin.aduan.index', compact('aduan'));
    }

    public function show($id)
    {
        $aduan = $this->aduanMilikAdmin($id);

        // View lama menggunakan properti nama langsung.
        $aduan->nama = $aduan->user?->nama ?? '-';

        return view('admin.aduan.show', compact('aduan'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(
            [
                'tanggapan_admin' => ['required', 'string', 'min:3', 'max:3000'],
                'status' => [
                    'required',
                    Rule::in(['baru', 'diproses', 'selesai']),
                ],
            ],
            [
                'tanggapan_admin.min' => 'Tanggapan admin minimal 3 karakter.',
                'tanggapan_admin.max' => 'Tanggapan admin maksimal 3000 karakter.',
                'status.in' => 'Status aduan tidak valid.',
            ]
        );

        $aduan = $this->aduanMilikAdmin($id);

        try {
            $aduan->update([
                'tanggapan_admin' => $data['tanggapan_admin'],
                'status' => $data['status'],
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal memperbarui aduan.', [
                'admin_id' => Auth::id(),
                'aduan_id' => $aduan->id_aduan,
                'exception' => $e,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Tanggapan gagal disimpan. Silakan coba lagi.');
        }

        return redirect()
            ->route('admin.aduan.index')
            ->with('success', 'Aduan berhasil ditanggapi.');
    }

    private function aduanMilikAdmin($id): Aduan
    {
        $kost = Auth::user()->kost;
        abort_unless($kost, 404);

        return Aduan::with('user')
            ->where('kost_id', $kost->id)
            ->findOrFail($id);
    }
}
