<?php
namespace App\Http\Controllers;
use App\Models\FasilitasKost;
use App\Models\KamarKost;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    private function owned(KamarKost $kamar, Request $r){ abort_if($kamar->id_kost !== $r->user()->kost->id, 403); }
    public function index(Request $r){ return view('admin.kamar.index', ['items'=>KamarKost::where('id_kost',$r->user()->kost->id)->get()]); }
    public function create(){ return view('admin.kamar.form', ['item'=>new KamarKost]); }
    public function store(Request $r){ $d=$r->validate(['nama_kamar'=>'required','nomor_kamar'=>'required','ukuran_kamar'=>'nullable','foto_kamar'=>'nullable|image|max:2048','status'=>'required|in:kosong,terisi']); if($r->hasFile('foto_kamar')) $d['foto_kamar']=$r->file('foto_kamar')->store('kamar','public'); $d['id_kost']=$r->user()->kost->id; KamarKost::create($d); return redirect()->route('admin.kamar.index')->with('success','Kamar ditambah.'); }
    public function edit(Request $r, KamarKost $kamar){ $this->owned($kamar,$r); return view('admin.kamar.form', ['item'=>$kamar]); }
    public function update(Request $r, KamarKost $kamar){ $this->owned($kamar,$r); $d=$r->validate(['nama_kamar'=>'required','nomor_kamar'=>'required','ukuran_kamar'=>'nullable','foto_kamar'=>'nullable|image|max:2048','status'=>'required|in:kosong,terisi']); if($r->hasFile('foto_kamar')) $d['foto_kamar']=$r->file('foto_kamar')->store('kamar','public'); $kamar->update($d); return redirect()->route('admin.kamar.index')->with('success','Kamar diperbarui.'); }
    public function destroy(Request $r, KamarKost $kamar){ $this->owned($kamar,$r); $kamar->delete(); return back()->with('success','Kamar dihapus.'); }
    public function editFasilitas(Request $r, KamarKost $kamar){ $this->owned($kamar,$r); return view('admin.kamar.fasilitas.edit', ['kamar'=>$kamar, 'fasilitas'=>FasilitasKost::orderBy('nama_fasilitas')->get(), 'selected'=>$kamar->fasilitas()->pluck('fasilitas_kosts.id_fasilitas')->all()]); }
    public function updateFasilitas(Request $r, KamarKost $kamar){ $this->owned($kamar,$r); $kamar->fasilitas()->sync($r->input('fasilitas', [])); return redirect()->route('admin.kamar.index')->with('success','Fasilitas kamar disimpan.'); }
}
