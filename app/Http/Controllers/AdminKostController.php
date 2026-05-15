<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Kost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminKostController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM REGISTER ADMIN KOST
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('auth.register-admin-kost');
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN REGISTER ADMIN KOST
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | DATA USER
            |--------------------------------------------------------------------------
            */

            'username' => 'required|unique:users',

            'nik' => 'required|unique:users',

            'nama' => 'required',

            'password' => 'required|min:8|confirmed',

            'no_hp' => 'required',

            /*
            |--------------------------------------------------------------------------
            | DATA KOST
            |--------------------------------------------------------------------------
            */

            'nama_kost' => 'required',

            'alamat' => 'required',

            /*
            |--------------------------------------------------------------------------
            | OPSIONAL
            |--------------------------------------------------------------------------
            */

            'deskripsi' => 'nullable',

            /*
            |--------------------------------------------------------------------------
            | MULTIPLE FOTO
            |--------------------------------------------------------------------------
            */

            'foto_kost' => 'nullable|array',

            'foto_kost.*' => 'image|max:2048',

            /*
            |--------------------------------------------------------------------------
            | GOOGLE MAPS
            |--------------------------------------------------------------------------
            */

            'lokasi' => 'nullable|string',

        ]);

        DB::transaction(function () use ($request, $data) {

            /*
            |--------------------------------------------------------------------------
            | CREATE USER
            |--------------------------------------------------------------------------
            */

            $user = User::create([

                'username' => $data['username'],

                'nik' => $data['nik'],

                'nama' => $data['nama'],

                'password' => Hash::make($data['password']),

                'no_hp' => $data['no_hp'],

                'role' => 'admin kost',

                'status' => 'pending',

            ]);

            /*
            |--------------------------------------------------------------------------
            | MULTIPLE FOTO KOST
            |--------------------------------------------------------------------------
            */

            $fotos = [];

            if ($request->hasFile('foto_kost'))
            {
                foreach ($request->file('foto_kost') as $file)
                {
                    $fotos[] = $file->store(
                        'kost',
                        'public'
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | CREATE KOST
            |--------------------------------------------------------------------------
            */

            Kost::create([

                'nama_kost' => $data['nama_kost'],

                'alamat' => $data['alamat'],

                'deskripsi' => $data['deskripsi'] ?? null,

                'foto_kost' => $fotos,

                'lokasi' => $data['lokasi'] ?? null,

                'id_user' => $user->id,

            ]);

        });

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Pendaftaran berhasil. Tunggu validasi super admin.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */

    public function dashboard(Request $request)
{
    $kost = $request->user()->kost;

    /*
    |--------------------------------------------------------------------------
    | TOTAL KAMAR
    |--------------------------------------------------------------------------
    */

    $totalKamar =
        $kost
            ?->kamars()
            ->count() ?? 0;

    /*
    |--------------------------------------------------------------------------
    | TOTAL PENGHUNI
    |--------------------------------------------------------------------------
    */

    $totalPenghuni = User::whereHas(

        'tagihans.kamar',

        function($q) use ($kost){

            $q->where(
                'id_kost',
                $kost->id
            );

        }

    )
    ->where(
        'role',
        'penghuni kost'
    )
    ->distinct()
    ->count();

    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN PENDING
    |--------------------------------------------------------------------------
    */

    $pendingPembayaran = \App\Models\Tagihan::whereHas(

        'kamar',

        function($q) use ($kost){

            $q->where(
                'id_kost',
                $kost->id
            );

        }

    )
    ->where(
        'status_bukti',
        'menunggu'
    )
    ->count();

    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN TERBARU
    |--------------------------------------------------------------------------
    */

    $pembayaranTerbaru = \App\Models\Tagihan::with([

        'user',
        'pembayaran',

    ])
    ->whereHas('kamar', function($q)
    use ($kost){

        $q->where(
            'id_kost',
            $kost->id
        );

    })
    ->where(
        'status_bukti',
        'menunggu'
    )
    ->latest()
    ->take(5)
    ->get();

    /*
    |--------------------------------------------------------------------------
    | ADUAN TERBARU
    |--------------------------------------------------------------------------
    */

    $aduanTerbaru = [];

    return view('admin.dashboard', [

        'kost' => $kost,

        'totalKamar' =>
            $totalKamar,

        'totalPenghuni' =>
            $totalPenghuni,

        'pendingPembayaran' =>
            $pendingPembayaran,

        'pembayaranTerbaru' =>
            $pembayaranTerbaru,

        'aduanTerbaru' =>
            $aduanTerbaru,

    ]);
}
    /*
    |--------------------------------------------------------------------------
    | HALAMAN INFORMASI KOST
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        return view('admin.kost.index', [

            'kost' => $request->user()->kost

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT KOST
    |--------------------------------------------------------------------------
    */

    public function editKost(Request $request)
    {
        return view('admin.kost-edit', [

            'kost' => $request->user()->kost,

            /*
            |--------------------------------------------------------------------------
            | MASTER FASILITAS
            |--------------------------------------------------------------------------
            */

            'fasilitas' => Fasilitas::all(),

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE KOST
    |--------------------------------------------------------------------------
    */

    public function updateKost(Request $request)
    {
        $data = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | DATA KOST
            |--------------------------------------------------------------------------
            */

            'nama_kost' => 'required',

            'no_hp' => 'required',

            'alamat' => 'required',

            'deskripsi' => 'nullable',

            /*
            |--------------------------------------------------------------------------
            | FASILITAS
            |--------------------------------------------------------------------------
            */

            'fasilitas' => 'nullable|array',

            'fasilitas.*' => 'exists:fasilitas,id_fasilitas',

            /*
            |--------------------------------------------------------------------------
            | MULTIPLE FOTO
            |--------------------------------------------------------------------------
            */

            'foto_kost' => 'nullable|array',

            'foto_kost.*' => 'image|max:2048',

            /*
            |--------------------------------------------------------------------------
            | GOOGLE MAPS
            |--------------------------------------------------------------------------
            */

            'lokasi' => 'nullable|string',

        ]);

        $kost = $request->user()->kost;

        /*
        |--------------------------------------------------------------------------
        | FOTO LAMA
        |--------------------------------------------------------------------------
        */

        $oldPhotos = $kost->foto_kost ?? [];

        /*
        |--------------------------------------------------------------------------
        | FOTO YANG DIHAPUS
        |--------------------------------------------------------------------------
        */

        $deletedPhotos = json_decode(

            $request->deleted_old_images,

            true

        ) ?? [];

        /*
        |--------------------------------------------------------------------------
        | FILTER FOTO LAMA
        |--------------------------------------------------------------------------
        */

        if (count($deletedPhotos))
        {
            $oldPhotos = array_values(

                array_filter(

                    $oldPhotos,

                    fn ($foto) =>
                        !in_array($foto, $deletedPhotos)

                )

            );
        }

        /*
        |--------------------------------------------------------------------------
        | UPLOAD FOTO BARU
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto_kost'))
        {
            foreach ($request->file('foto_kost') as $foto)
            {
                $oldPhotos[] =
                    $foto->store('kost', 'public');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE FOTO
        |--------------------------------------------------------------------------
        */

        $data['foto_kost'] = $oldPhotos;

        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA KOST
        |--------------------------------------------------------------------------
        */

        $kost->update($data);

        /*
        |--------------------------------------------------------------------------
        | UPDATE NO HP USER
        |--------------------------------------------------------------------------
        */

        $request->user()->update([

            'no_hp' => $request->no_hp

        ]);

        /*
        |--------------------------------------------------------------------------
        | SYNC FASILITAS
        |--------------------------------------------------------------------------
        */

        $kost->fasilitas()->sync(

            $request->fasilitas ?? []

        );

        return redirect()
            ->route('admin.kost.index')
            ->with(
                'success',
                'Informasi kost berhasil diperbarui.'
            );
    }
}