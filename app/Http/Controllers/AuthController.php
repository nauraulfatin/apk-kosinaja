<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW LOGIN
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function login(
        Request $request
    )
    {
        $credentials = $request->validate(

            [

                'username' =>

                    'required',

                'password' =>

                    'required',

            ],

            [

                'username.required' =>

                    'Username wajib diisi.',

                'password.required' =>

                    'Password wajib diisi.',

            ]

        );

        /*
        |--------------------------------------------------------------------------
        | ATTEMPT LOGIN
        |--------------------------------------------------------------------------
        */

        if (
            !Auth::attempt($credentials)
        )
        {
            return back()

                ->withErrors([

                    'username' =>

                        'Username atau password salah.',

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
                ->route(
                    'password.force'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | REDIRECT BY ROLE
        |--------------------------------------------------------------------------
        */

        return match($user->role)
        {
            'super admin'

                => redirect()->route(
                    'superadmin.dashboard'
                ),

            'admin kost'

                => redirect()->route(
                    'admin.dashboard'
                ),

            'penghuni kost'

                => redirect()->route(
                    'penghuni.dashboard'
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

    public function logout(
        Request $request
    )
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

    /*
    |--------------------------------------------------------------------------
    | SHOW FORCE PASSWORD
    |--------------------------------------------------------------------------
    */

    public function showForceChangePassword()
    {
        return view(
            'auth.force-password'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORCE CHANGE PASSWORD
    |--------------------------------------------------------------------------
    */

    public function forceChangePassword(
        Request $request
    )
    {
        $data = $request->validate(

            [

                'password' => [

                    'required',
                    'min:8',
                    'confirmed',

                ],

            ],

            [

                'password.required' =>

                    'Password wajib diisi.',

                'password.min' =>

                    'Password minimal 8 karakter.',

                'password.confirmed' =>

                    'Konfirmasi password tidak cocok.',

            ]

        );

        /*
        |--------------------------------------------------------------------------
        | UPDATE PASSWORD
        |--------------------------------------------------------------------------
        */

        $request
            ->user()
            ->update([

                'password' =>

                    Hash::make(
                        $data['password']
                    ),

                'must_change_password' =>

                    false,

            ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(

                $request->user()->role ===
                'super admin'

                    ? 'superadmin.dashboard'

                    : 'login'

            )

            ->with(

                'success',

                'Password berhasil diganti.'

            );
    }
}