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

            if ($request->hasFile('foto_kost')) {

                foreach ($request->file('foto_kost') as $file) {

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
        return view('admin.dashboard', [

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

public function index(Request $request)
{
    return view('admin.kost.index', [

        'kost' => $request->user()->kost

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

            'nama_kost' => 'required',

            'alamat' => 'required',

            'deskripsi' => 'nullable',
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
        | UPLOAD MULTIPLE FOTO
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto_kost')) {

            $fotos = [];

            foreach ($request->file('foto_kost') as $file) {

                $fotos[] = $file->store(
                    'kost',
                    'public'
                );

            }

            $data['foto_kost'] = $fotos;
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA
        |--------------------------------------------------------------------------
        */

        $kost->update($data);
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