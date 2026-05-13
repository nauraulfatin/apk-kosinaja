<?php
namespace App\Http\Controllers;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
class FasilitasController extends Controller
{
    public function index(){ return view('superadmin.fasilitas.index', ['items'=>Fasilitas::latest()->get()]); }
    public function create(){ return view('superadmin.fasilitas.form', ['item'=>new Fasilitas]); }
    public function store(Request $r){ $d=$r->validate(['nama_fasilitas'=>'required|unique:fasilitas_kosts']); Fasilitas::create($d); return redirect()->route('superadmin.fasilitas.index')->with('success','Fasilitas ditambah.'); }
    public function edit(Fasilitas $fasilita){ return view('superadmin.fasilitas.form', ['item'=>$fasilita]); }
    public function update(Request $r, Fasilitas $fasilita){ $d=$r->validate(['nama_fasilitas'=>'required|unique:fasilitas_kosts,nama_fasilitas,'.$fasilita->id_fasilitas.',id_fasilitas']); $fasilita->update($d); return redirect()->route('superadmin.fasilitas.index')->with('success','Fasilitas diperbarui.'); }
    public function destroy(Fasilitas $fasilita){ $fasilita->delete(); return back()->with('success','Fasilitas dihapus.'); }
}
