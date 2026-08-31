<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //show login

    public function showLogin()
    {return view('auth.login'); }

    //login

    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ],
            [
                'username.required' => 'Username wajib diisi.',
                'password.required' => 'Password wajib diisi.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | RATE LIMIT LOGIN
        |--------------------------------------------------------------------------
        |
        | Maksimal 5 percobaan login gagal dalam 60 detik untuk kombinasi
        | username + alamat IP yang sama. Ini memperlambat brute-force tanpa
        | mengunci akun secara permanen.
        |
        */
        $throttleKey = $this->loginThrottleKey(
            $credentials['username'],
            $request->ip()
        );

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withErrors([
                    'username' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
                ])
                ->onlyInput('username');
        }

        /*
        |--------------------------------------------------------------------------
        | AUTHENTICATION
        |--------------------------------------------------------------------------
        */
        if (!Auth::attempt($credentials)) {
            RateLimiter::hit($throttleKey, 60);

            return back()
                ->withErrors([
                    // Pesan dibuat generik agar tidak membocorkan apakah
                    // username tertentu terdaftar atau tidak.
                    'username' => 'Username atau password salah.',
                ])
                ->onlyInput('username');
        }

        // Login berhasil: hapus hit gagal untuk kombinasi ini.
        RateLimiter::clear($throttleKey);

        // Regenerate session untuk mencegah session fixation.
        $request
            ->session()
            ->regenerate();

        $user = $request->user();

       //force change password

        if ($user->must_change_password)
        {
            return redirect() ->route('password.force');
        }

       //redirect by role
        return match ($user->role)
        {
            'super admin' => redirect()->route('home'),
            'admin kost' => $user->status === 'aktif'
    ? redirect()->route('home')
    : redirect()->route('admin.profil.index'),
            'penghuni kost' => $user->riwayatHunian()
            ->where('status', 'aktif')
            ->exists()
        ? redirect()->route('home')
        : redirect()->route('home'),
            default
                => redirect('/'),
        };
    }

    //logout

    public function logout(Request $request)
    {
        Auth::logout();
        $request
            ->session()
            ->invalidate();
        $request
            ->session()
            ->regenerateToken();
        return redirect()
            ->route('home');
    }

    //show force password

    public function showForceChangePassword()
    { return view('auth.force-password');}

    //force change password

    public function forceChangePassword(Request $request)
    {
        $data = $request->validate(
            [
                'password' => ['required','min:8', 'confirmed', ],
            ],
            [
                'password.required' => 'Password wajib diisi.',
                'password.min' =>'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
            ]

        );

        //update password

        $request->user()->update([
            'password' => Hash::make( $data['password'] ),
            'must_change_password' => false,
        ]);

        //redirect
        return redirect()
            ->route(
                $request->user()->role === 'super admin'
                    ? 'superadmin.dashboard'
                    : 'login'
            )

            ->with(
                'success', 'Password berhasil diganti.'
            );
    }

    //show register penghuni

    public function showRegisterPenghuni()
    { return view('auth.register-penghuni');}

   //register penghuni
    public function registerPenghuni(Request $request)
    {
        $data = $request->validate(
            [

                'nama' =>'required|string|max:100',
                'nik' => ['required', 'digits:16', 'regex:/^[0-9]+$/', 'unique:users,nik' ],
                'username' => [ 'required', 'string','min:3','max:30', 'regex:/^[a-zA-Z0-9._]+$/', 'unique:users,username' ],
                'no_hp' => ['required', 'digits_between:10,13' ],
                'password' => [ 'required', 'confirmed','min:8','regex:/[A-Z]/', 'regex:/[a-z]/','regex:/[0-9]/' ],
            ],

            [

                //error message nama
                'nama.required' =>'Nama wajib diisi.',
                'nama.max' => 'Nama maksimal 100 karakter.',

                //nik
                'nik.required' =>'NIK wajib diisi.',
                'nik.digits' => 'NIK harus 16 digit.',
                'nik.regex' => 'NIK hanya boleh angka.',
                'nik.unique' => 'NIK sudah digunakan.',

                //useername
                'username.required' =>'Username wajib diisi.',
                'username.min' => 'Username minimal 3 karakter.',
                'username.max' =>'Username maksimal 30 karakter.',
                'username.regex' =>'Username hanya boleh huruf, angka, titik, dan underscore.',
                'username.unique' =>'Username sudah digunakan.',

                //no hp
                'no_hp.required' => 'Nomor HP wajib diisi.',
                'no_hp.digits_between' =>'Nomor HP harus 10 sampai 13 digit.',

                //password
                'password.required' =>'Password wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min' =>'Password minimal 8 karakter.',
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
            ]

        );

       //create user

        \App\Models\User::create([
            'nama' => $data['nama'],
            'nik' => $data['nik'],
            'username' => $data['username'],
            'no_hp' => $data['no_hp'],
            'password' => bcrypt( $data['password']),
            'role' => 'penghuni kost', 'status' => 'aktif',
            'must_change_password' => false,
        ]);

        //redirect

        return redirect()
            ->route('login')
            ->with(
                'success', 'Registrasi berhasil. Silakan login.'
            );
    }

    //show register admin
    public function showRegisterAdmin()
    {
        return view('auth.register-admin-kost');
    }

    //register admin
    public function registerAdmin(Request $request)
    {
        $data = $request->validate(
            [
                // Data akun admin
                'nama' => 'required|string|max:100',
                'nik' => [
                    'required',
                    'digits:16',
                    'regex:/^[0-9]+$/',
                    'unique:users,nik',
                ],
                'username' => [
                    'required',
                    'string',
                    'min:3',
                    'max:30',
                    'regex:/^[a-zA-Z0-9._]+$/',
                    'unique:users,username',
                ],
                'no_hp' => [
                    'required',
                    'digits_between:10,13',
                ],
                'password' => [
                    'required',
                    'confirmed',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                ],

                // Data minimum kos saat registrasi
                'nama_kost' => 'required|string|max:255',
                'alamat' => 'required|string|max:2000',
            ],
            [
                'nama.required' => 'Nama wajib diisi.',
                'nama.max' => 'Nama maksimal 100 karakter.',

                'nik.required' => 'NIK wajib diisi.',
                'nik.digits' => 'NIK harus 16 digit.',
                'nik.regex' => 'NIK hanya boleh angka.',
                'nik.unique' => 'NIK sudah digunakan.',

                'username.required' => 'Username wajib diisi.',
                'username.min' => 'Username minimal 3 karakter.',
                'username.max' => 'Username maksimal 30 karakter.',
                'username.regex' => 'Username hanya boleh huruf, angka, titik, dan underscore.',
                'username.unique' => 'Username sudah digunakan.',

                'no_hp.required' => 'Nomor HP wajib diisi.',
                'no_hp.digits_between' => 'Nomor HP harus 10 sampai 13 digit.',

                'password.required' => 'Password wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',

                'nama_kost.required' => 'Nama kos wajib diisi.',
                'nama_kost.max' => 'Nama kos maksimal 255 karakter.',
                'alamat.required' => 'Alamat kos wajib diisi.',
                'alamat.max' => 'Alamat kos terlalu panjang.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | REGISTRASI DALAM SATU TRANSAKSI
        |--------------------------------------------------------------------------
        |
        | Pada tahap registrasi hanya dibuat identitas admin dan data minimum kos.
        | Foto, deskripsi, lokasi, fasilitas, dan data detail lainnya diisi oleh
        | Admin Kos setelah akun disetujui Super Admin.
        |
        */
        DB::transaction(function () use ($data) {
            $user = User::create([
                'nama' => $data['nama'],
                'nik' => $data['nik'],
                'username' => $data['username'],
                'no_hp' => $data['no_hp'],
                'password' => Hash::make($data['password']),
                'role' => 'admin kost',
                'status' => 'pending',
                'must_change_password' => false,
            ]);

            Kost::create([
                'id_user' => $user->id,
                'nama_kost' => $data['nama_kost'],
                'alamat' => $data['alamat'],

                // Data berikut sengaja belum diisi saat registrasi.
                'deskripsi' => null,
                'foto_kost' => null,
                'lokasi' => null,
            ]);
        });

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Registrasi Admin Kos berhasil. Silakan tunggu persetujuan Super Admin.'
            );
    }
    /*
    |--------------------------------------------------------------------------
    | LOGIN THROTTLE KEY
    |--------------------------------------------------------------------------
    */
    private function loginThrottleKey(string $username, ?string $ip): string
    {
        $normalizedUsername = Str::lower(trim($username));

        return 'login:' . sha1(
            $normalizedUsername . '|' . ($ip ?? 'unknown')
        );
    }

}