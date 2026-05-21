<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //show login
    public function showLogin()
    { return view('auth.login'); }

    //login
    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
            'username' =>'required',
            'password' =>'required',
            ],

            [
            'username.required' =>'Username wajib diisi.',
            'password.required' =>'Password wajib diisi.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | ATTEMPT LOGIN
        |--------------------------------------------------------------------------
        */

        if ( !Auth::attempt($credentials) )
        {
            return back()
                ->withErrors([
                    'username' =>'Username atau password salah.',
                ])
                ->onlyInput('username');
        }

        /*
        |--------------------------------------------------------------------------
        | REGENERATE SESSION
        |--------------------------------------------------------------------------
        */

        $request
            ->session()
            ->regenerate();
        $user =
            $request->user();

        /*
        |--------------------------------------------------------------------------
        | FORCE CHANGE PASSWORD
        |--------------------------------------------------------------------------
        */

        if (
            $user->must_change_password
        )
        {
            return redirect()
                ->route( 'password.force' );
        }

        /*
        |--------------------------------------------------------------------------
        | REDIRECT BY ROLE
        |--------------------------------------------------------------------------
        */

        return match($user->role)
        {
            'super admin'=> redirect()->route( 'superadmin.dashboard'),
            'admin kost' => redirect()->route('admin.dashboard' ),
            'penghuni kost' => $user->riwayatHunian()
            ->where('status', 'aktif')
            ->exists()
        ? redirect()->route('home')
        : redirect()->route(
            'home'
        ),
            default
                => redirect('/'),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout( Request $request )
    {
        Auth::logout();
        $request
            ->session()
            ->invalidate();

        $request
            ->session()
            ->regenerateToken();

        return redirect()
            ->route('login');
    }

   //show force password

    public function showForceChangePassword()
    {return view( 'auth.force-password' );}

    //force change password

    public function forceChangePassword(Request $request)
    {
        $data = $request->validate(
            [
                'password' => ['required','min:8','confirmed',],
            ],

            [
                'password.required' => 'Password wajib diisi.',
                'password.min' =>'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
            ]

        );

        //update password
        $request->user()->update([

                'password' =>
                    Hash::make(
                        $data['password']
                    ),

                'must_change_password' => false,
        ]);


        //redirect
        return redirect()
            ->route(
                $request->user()->role ===
                'super admin'
                    ? 'superadmin.dashboard'
                    : 'login'
            )

            ->with(
                'success', 'Password berhasil diganti.'
            );
    }


            //show register penghuni
            public function showRegisterPenghuni()
            {
                return view('auth.register-penghuni' );
            }

             //register penghuni
             public function registerPenghuni(Request $request)
            {
                $data = $request->validate([
                    'nama' => 'required|string|max:255',
                    'nik' => 'required|string|max:16|unique:users,nik',
                    'username' => 'required|string|max:255|unique:users,username',
                    'no_hp' => 'required|string|max:20',
                    'password' => 'required|confirmed|min:8',
                ]);

    \App\Models\User::create([
        'nama' => $data['nama'],
        'nik' => $data['nik'],
        'username' => $data['username'],
        'no_hp' => $data['no_hp'],
        'password' => bcrypt( $data['password']
        ),
        'role' => 'penghuni kost',
        'status' => 'aktif',
        'must_change_password' => false,
    ]);

    return redirect()
        ->route('login')
        ->with(
            'success',
            'Registrasi berhasil. Silakan login.'
        );
}

//show register admin

public function showRegisterAdmin()
{
    return view(
        'auth.register-admin-kost'
    );
}

//register admin

public function registerAdmin(
    Request $request
)
{
    $data = $request->validate([
        //data akun
        'nama' => 'required|string|max:255',
        'nik' => 'required|string|max:16|unique:users,nik',
        'username' => 'required|string|max:255|unique:users,username',
        'no_hp' => 'required|string|max:20',
        'password' => 'required|confirmed|min:8',

        //data kos
        'nama_kost' => 'required|string|max:255',
        'alamat' =>'required|string',
    ]);

    //create user

    $user = \App\Models\User::create([
        'nama' => $data['nama'],
        'nik' => $data['nik'],
        'username' => $data['username'],
        'no_hp' => $data['no_hp'],
        'password' => bcrypt(
            $data['password']
        ),
        'role' => 'admin kost',

        //menunggu aprroval
        'status' => 'pending',
        'must_change_password' => false,
    ]);

    /*
    |--------------------------------------------------------------------------
    | CREATE KOST
    |--------------------------------------------------------------------------
    */

    \App\Models\Kost::create([

        'nama_kost' => $data['nama_kost'],
        'alamat' => $data['alamat'],
        'id_user' => $user->id,
    ]);

    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('login')
        ->with(
            'success',
            'Registrasi admin berhasil. Tunggu persetujuan super admin.'
        );
}
}