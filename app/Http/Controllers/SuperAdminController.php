<?php
namespace App\Http\Controllers;
use App\Models\User;
class SuperAdminController extends Controller
{
    public function dashboard() { return view('superadmin.dashboard', ['pendingAdmins'=>User::with('kost')->where('role','admin kost')->where('status','pending')->get(), 'admins'=>User::with('kost')->where('role','admin kost')->latest()->get()]); }
    public function validasiAdmin(User $user) { abort_if($user->role !== 'admin kost', 404); $user->update(['status'=>'aktif']); return back()->with('success','Admin kost divalidasi.'); }
    public function tolakAdmin(User $user) { abort_if($user->role !== 'admin kost', 404); $user->update(['status'=>'ditolak']); return back()->with('success','Admin kost ditolak.'); }
}
