<?php
namespace App\Http\Controllers;
use App\Models\FasilitasKost;
use Illuminate\Http\Request;
class FasilitasController extends Controller
{
    public function index(){ return view('superadmin.fasilitas.index', ['items'=>FasilitasKost::latest()->get()]); }
    public function create(){ return view('superadmin.fasilitas.form', ['item'=>new FasilitasKost]); }
    public function store(Request $r){ $d=$r->validate(['nama_fasilitas'=>'required|unique:fasilitas_kosts']); FasilitasKost::create($d); return redirect()->route('superadmin.fasilitas.index')->with('success','Fasilitas ditambah.'); }
    public function edit(FasilitasKost $fasilita){ return view('superadmin.fasilitas.form', ['item'=>$fasilita]); }
    public function update(Request $r, FasilitasKost $fasilita){ $d=$r->validate(['nama_fasilitas'=>'required|unique:fasilitas_kosts,nama_fasilitas,'.$fasilita->id_fasilitas.',id_fasilitas']); $fasilita->update($d); return redirect()->route('superadmin.fasilitas.index')->with('success','Fasilitas diperbarui.'); }
    public function destroy(FasilitasKost $fasilita){ $fasilita->delete(); return back()->with('success','Fasilitas dihapus.'); }
}
