<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }
    public function login(Request $request)
    {
        $credentials = $request->validate(['username'=>'required', 'password'=>'required']);
        if (!Auth::attempt($credentials)) return back()->withErrors(['username'=>'Username atau password salah.'])->onlyInput('username');
        $request->session()->regenerate();
        $user = $request->user();
        if ($user->must_change_password) return redirect()->route('password.force');
        return match($user->role) {
            'super admin' => redirect()->route('superadmin.dashboard'),
            'admin kost' => redirect()->route('admin.dashboard'),
            'penghuni kost' => redirect()->route('penghuni.dashboard'),
            default => redirect('/'),
        };
    }
    public function logout(Request $request) { Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect()->route('login'); }
    public function showForceChangePassword() { return view('auth.force-password'); }
    public function forceChangePassword(Request $request)
    {
        $data = $request->validate(['password'=>'required|min:8|confirmed']);
        $request->user()->update(['password'=>Hash::make($data['password']), 'must_change_password'=>false]);
        return redirect()->route($request->user()->role === 'super admin' ? 'superadmin.dashboard' : 'login')->with('success','Password berhasil diganti.');
    }
}
