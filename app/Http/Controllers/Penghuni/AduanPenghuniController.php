<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use App\Models\RiwayatHunian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AduanPenghuniController extends Controller
{
    public function index()
    {
        $aduans = Aduan::where('id_user', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('penghuni.aduan.index', compact('aduans'));
    }

    public function create()
    {
        return view('penghuni.aduan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'isi_aduan' => ['required', 'string', 'min:10', 'max:2000'],
                'foto_aduan' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:10240',
                ],
            ],
            [
                'isi_aduan.min' => 'Isi aduan minimal 10 karakter.',
                'isi_aduan.max' => 'Isi aduan maksimal 2000 karakter.',
                'foto_aduan.mimes' => 'Format foto aduan harus JPG, JPEG, PNG, atau WEBP.',
                'foto_aduan.max' => 'Ukuran foto aduan maksimal 10 MB.',
            ]
        );

        $user = Auth::user();

        // Cari kos terlebih dahulu sebelum mengunggah file agar tidak muncul orphan file.
        $riwayat = RiwayatHunian::where('id_user', $user->id)
            ->whereIn('status', ['aktif', 'antrian'])
            ->latest('id_riwayat_hunian')
            ->first();

        if (!$riwayat || !$riwayat->id_kost) {
            return back()
                ->withInput()
                ->withErrors([
                    'aduan' => 'Kamu belum terdaftar di kos manapun. Hubungi admin.',
                ]);
        }

        $fotoPath = null;

        try {
            if ($request->hasFile('foto_aduan')) {
                $fotoPath = $request->file('foto_aduan')
                    ->store('aduan', 'public');
            }

            DB::transaction(function () use ($data, $user, $riwayat, $fotoPath) {
                Aduan::create([
                    'id_user' => $user->id,
                    'kost_id' => $riwayat->id_kost,
                    'isi_aduan' => $data['isi_aduan'],
                    'foto_aduan' => $fotoPath,
                    'status' => 'baru',
                    'tanggal' => now()->toDateString(),
                ]);
            });
        } catch (\Throwable $e) {
            if ($fotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }

            Log::error('Gagal menyimpan aduan penghuni.', [
                'user_id' => $user->id,
                'kost_id' => $riwayat->id_kost,
                'exception' => $e,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Aduan gagal dikirim. Silakan coba lagi.');
        }

        return redirect()
            ->route('penghuni.aduan.index')
            ->with('success', 'Aduan berhasil dikirim.');
    }
}
