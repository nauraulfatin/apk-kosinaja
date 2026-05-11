<?php
namespace App\Http\Controllers;
use App\Models\Kost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminKostController extends Controller
{
    public function create() { return view('auth.register-admin-kost'); }
    public function store(Request $request)
    {
        $data = $request->validate([
            'username'=>'required|unique:users', 'nik'=>'required|unique:users', 'nama'=>'required', 'password'=>'required|min:8|confirmed', 'no_hp'=>'required',
            'nama_kost'=>'required', 'alamat'=>'required', 'deskripsi'=>'nullable', 'foto_kost'=>'nullable|image|max:2048'
        ]);
        DB::transaction(function() use ($request, $data) {
            $user = User::create(['username'=>$data['username'], 'nik'=>$data['nik'], 'nama'=>$data['nama'], 'password'=>Hash::make($data['password']), 'no_hp'=>$data['no_hp'], 'role'=>'admin kost', 'status'=>'pending']);
            $foto = $request->file('foto_kost')?->store('kost', 'public');
            Kost::create(['nama_kost'=>$data['nama_kost'], 'alamat'=>$data['alamat'], 'deskripsi'=>$data['deskripsi'] ?? null, 'foto_kost'=>$foto, 'id_user'=>$user->id]);
        });
        return redirect()->route('login')->with('success','Pendaftaran berhasil. Tunggu validasi super admin.');
    }
    public function dashboard(Request $request) { return view('admin.dashboard', ['kost'=>$request->user()->kost]); }
    public function editKost(Request $request) { return view('admin.kost-edit', ['kost'=>$request->user()->kost]); }
    public function updateKost(Request $request)
    {
        $data = $request->validate(['nama_kost'=>'required', 'alamat'=>'required', 'deskripsi'=>'nullable', 'foto_kost'=>'nullable|image|max:2048']);
        $kost = $request->user()->kost;
        if ($request->hasFile('foto_kost')) $data['foto_kost'] = $request->file('foto_kost')->store('kost','public');
        $kost->update($data);
        return back()->with('success','Data kost diperbarui.');
    }
}
