<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Kost;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminKostController extends Controller
{
   //form register admin kos

    public function create()
    { return view('auth.register-admin-kost');}

   //simpan register admin kos

    public function store(Request $request)
    {
        $data = $request->validate([
            //data user
            'username' => 'required|unique:users',
            'nik' => 'required|unique:users',
            'nama' => 'required',
            'password' => 'required|min:8|confirmed',
            'no_hp' => 'required',
            'g-recaptcha-response' => 'required|captcha',

           //data kost
            'nama_kost' => 'required',
            'alamat' => 'required',
            //opsional
            'deskripsi' => 'nullable',

            //multiple foto
            'foto_kost' => 'nullable|array',
            'foto_kost.*' => 'image|max:2048',

            //gmaps
            'lokasi' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $data) {

            //create user
            $user = User::create([
                'username' => $data['username'],
                'nik' => $data['nik'],
                'nama' => $data['nama'],
                'password' => Hash::make($data['password']),
                'no_hp' => $data['no_hp'],
                'role' => 'admin kost',
                'status' => 'pending',
            ]);

            //multiple foto kost
            $fotos = [];
            if ($request->hasFile('foto_kost'))
            {
                foreach ($request->file('foto_kost') as $file)
                {
                    $fotos[] = $file->store( 'kost','public'
                    );
                }
            }

           //create kost

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
    ->route('admin-kost.register')
    ->with(
        'register_success',
        true
    );
    }

    //dashboard admin
    public function dashboard(Request $request)
{
    $kost = $request->user()->kost;

    ///totalkamar
    $totalKamar =
        $kost
            ?->kamars()
            ->count() ?? 0;

    //totalpenghuni
    $totalPenghuni = User::whereHas( 'tagihans.kamar',
        function($q) use ($kost){
            $q->where(
                'id_kost',
                $kost->id
            );
        }

    )
    ->where(
        'role', 'penghuni kost'
    )
    ->distinct()
    ->count();

//pembayaran pending
$pendingPembayaran = Pembayaran::where(
        'status_validasi', 'menunggu'
    )
    ->whereHas(
        'tagihan.kamar',
        function($q) use ($kost){
            $q->where(
                'id_kost', $kost->id
            );
        }
    )
    ->count();

    //pembayaran terbaru
 $pembayaranTerbaru = Pembayaran::with([
        'tagihan.user', 'tagihan.kamar', 'tagihan.hargaKamar',
    ])
    ->where(
        'status_validasi', 'menunggu'

    )
    ->whereHas(
        'tagihan.kamar',
        function($q) use ($kost){
            $q->where(
                'id_kost',
                $kost->id
            );

        }

    )
    ->latest()
    ->take(5)
    ->get();

    //aduan terbaru
    $aduanTerbaru = [];
    return view('admin.dashboard', [
        'kost' => $kost,
        'totalKamar' => $totalKamar,
        'totalPenghuni' => $totalPenghuni,
        'pendingPembayaran' => $pendingPembayaran,
        'pembayaranTerbaru' => $pembayaranTerbaru,
        'aduanTerbaru' => $aduanTerbaru,
    ]);
}
    //infomrasi kost

    public function index(Request $request)
    {
        return view('admin.kost.index', [
            'kost' => $request->user()->kost
        ]);
    }

   //form edit kos

    public function editKost(Request $request)
    {
        return view('admin.kost-edit', [
            'kost' => $request->user()->kost,
            //fasilitas
            'fasilitas' => Fasilitas::all(),
        ]);
    }

    //update kost
    public function updateKost(Request $request)
    {
        $data = $request->validate([

           //data kos
            'nama_kost' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'nullable',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'exists:fasilitas,id_fasilitas',
            'foto_kost' => 'nullable|array',
            'foto_kost.*' => 'image|max:2048',
            'lokasi' => 'nullable|string',

        ]);

        $kost = $request->user()->kost;

        //foto lama
        $oldPhotos = $kost->foto_kost ?? [];

        //foto yang dihapus
        $deletedPhotos = json_decode(
            $request->deleted_old_images,
            true
        ) ?? [];

       //filter ofot lama
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
//upload foto bau
        if ($request->hasFile('foto_kost'))
        {
            foreach ($request->file('foto_kost') as $foto)
            {
                $oldPhotos[] =
                    $foto->store('kost', 'public');
            }
        }

       //save foto
        $data['foto_kost'] = $oldPhotos;

        //update data kos
        $kost->update($data);

       //update no hp
        $request->user()->update([
            'no_hp' => $request->no_hp
        ]);

        //syncfasilitas
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
 //refresh kode undangan

public function refreshKode(Request $request)
{
    $kost = $request->user()->kost;
    do {
        $kode = strtoupper( Str::random(8) );
    } while (
        Kost::where(
            'kode_undangan', $kode
        )->exists()
    );

    $kost->update([
        'kode_undangan' => $kode
    ]);

    return back()->with(
        'success',
        'Kode undangan berhasil diperbarui.'
    );
}
}