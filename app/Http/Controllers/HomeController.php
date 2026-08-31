<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\KamarKost;

class HomeController extends Controller
{
    /**
     * Daftar fasilitas populer untuk tampilan katalog.
     *
     * Daftar ini bersifat statis dan tidak mengambil data
     * dari tabel fasilitas di database.
     */
    private function getFasilitasPopuler(): array
    {
        return [
            'WiFi',
            'AC',
            'Kulkas',
            'CCTV',
            'Ruang Tamu',
            'TV',
            'Kipas Angin',
            'Area Parkir',
        ];
    }

    /**
     * BERANDA
     */
    public function index()
    {
        $kostTerbaru = Kost::with([
                'kamars.hargaKamars',
                'fasilitas',
                'user',
            ])
            ->latest()
            ->take(6)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Fasilitas Populer
        |--------------------------------------------------------------------------
        |
        | Hanya digunakan untuk tampilan.
        | Tidak bergantung pada isi database.
        |
        */
        $fasilitasPopuler = $this->getFasilitasPopuler();

        return view(
            'katalog.home',
            compact(
                'kostTerbaru',
                'fasilitasPopuler'
            )
        );
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
            'user',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Pencarian Nama Kos
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $query->where(
                'nama_kost',
                'like',
                '%' . $request->search . '%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Fasilitas
        |--------------------------------------------------------------------------
        |
        | Daftar fasilitas pada halaman bersifat statis.
        | Database hanya digunakan ketika pengguna menekan fasilitas
        | untuk mencari kos yang memiliki fasilitas tersebut.
        |
        */
        if ($request->filled('fasilitas')) {
            $fasilitas = $request->fasilitas;

            $query->where(function ($q) use ($fasilitas) {
                /*
                 * Fasilitas yang dimiliki oleh kos.
                 */
                $q->whereHas('fasilitas', function ($query) use ($fasilitas) {
                    $query->where(
                        'nama_fasilitas',
                        $fasilitas
                    );
                });

                /*
                 * Atau fasilitas yang terdapat pada kamar.
                 */
                $q->orWhereHas(
                    'kamars.fasilitas',
                    function ($query) use ($fasilitas) {
                        $query->where(
                            'nama_fasilitas',
                            $fasilitas
                        );
                    }
                );
            });
        }

        $kost = $query
            ->latest()
            ->paginate(9)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Kos Terbaru
        |--------------------------------------------------------------------------
        */
        $kostTerbaru = Kost::with([
                'kamars.hargaKamars',
                'fasilitas',
                'user',
            ])
            ->latest()
            ->take(6)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Fasilitas Populer
        |--------------------------------------------------------------------------
        |
        | Selalu tersedia meskipun database fasilitas kosong.
        |
        */
        $fasilitasPopuler = $this->getFasilitasPopuler();

        return view(
            'katalog.home',
            compact(
                'kost',
                'kostTerbaru',
                'fasilitasPopuler'
            )
        );
    }

    /**
     * DETAIL KOST
     */
    public function detailKost($id)
    {
        $kost = Kost::with([
                'kamars.fasilitas',
                'kamars.hargaKamars.periode',
                'fasilitas',
                'aturanKos',
                'user',
            ])
            ->findOrFail($id);

        return view(
            'katalog.detail-kost',
            compact('kost')
        );
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
                'kost.user',
            ])
            ->findOrFail($id);

        $kos = $kamar->kost;
        $kamars = $kos->kamars;

        return view(
            'katalog.detail-kamar',
            compact(
                'kamar',
                'kos',
                'kamars'
            )
        );
    }
}