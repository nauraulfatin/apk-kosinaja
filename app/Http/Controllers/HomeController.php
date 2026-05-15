<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\KamarKost;
use App\Models\HargaKamar;
use App\Models\Fasilitas;

class HomeController extends Controller
{
    /**
     * BERANDA
     */
    public function index()
    {
        $kostTerbaru = Kost::with([
                            'kamars.hargaKamars',
                            'fasilitas',
                            'user'
                        ])
                        ->latest()
                        ->take(6)
                        ->get();

        return view('katalog.home', compact('kostTerbaru'));
    }

    /**
     * TENTANG
     */
    public function tentang()
    {
        return view('katalog.tentang');
    }

    /**
     * HUBUNGI
     */
    public function hubungi()
    {
        return view('katalog.hubungi');
    }

    /**
     * KATALOG
     */
    public function katalog(Request $request)
    {
        $query = Kost::with([
            'kamars.fasilitas',
            'kamars.hargaKamars',
            'fasilitas',
            'user'
        ]);

        if ($request->filled('search')) {
            $query->where('nama_kost', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('fasilitas')) {
            $query->whereHas('fasilitas', function ($q) use ($request) {
                $q->where('nama_fasilitas', $request->fasilitas);
            });
        }

        $kost = $query->latest()->paginate(9);

        return view('katalog.katalog', compact('kost'));
    }

    /**
     * DETAIL KOST
     */
    public function detailKost($id)
    {
        $kost = Kost::with([
                    'kamars.fasilitas',
                    'kamars.hargaKamars',
                    'fasilitas',
                    'user'
                ])->findOrFail($id);

        return view('katalog.detail-kost', compact('kost'));
    }

    /**
     * DETAIL KAMAR
     */
    public function detailKamar($id)
    {
        $kamar = KamarKost::with([
                    'fasilitas',
                    'hargaKamars',
                    'kost.fasilitas',
                    'kost.kamars.fasilitas',
                    'kost.kamars.hargaKamars',
                    'kost.user'
                ])->findOrFail($id);

        return view('katalog.detail-kamar', compact('kamar'));
    }
}