<?php
namespace App\Http\Controllers;
use App\Models\HargaKamar;
use App\Models\KamarKost;
use App\Models\PeriodePenagihan;
use Illuminate\Http\Request;
class HargaKamarController extends Controller
{
    private function owned(KamarKost $kamar, Request $r){ abort_if($kamar->id_kost !== $r->user()->kost->id, 403); }
    public function index(Request $r, KamarKost $kamar){ $this->owned($kamar,$r); return view('admin.kamar.harga.index',['kamar'=>$kamar,'items'=>$kamar->hargaKamars()->with('periode')->get()]); }
    public function create(Request $r, KamarKost $kamar){ $this->owned($kamar,$r); return view('admin.kamar.harga.form',['kamar'=>$kamar,'item'=>new HargaKamar,'periodes'=>PeriodePenagihan::all()]); }
    public function store(Request $r, KamarKost $kamar){ $this->owned($kamar,$r); $d=$r->validate(['harga'=>'required|numeric|min:0','id_periode'=>'required|exists:periode_penagihans,id_penagihan','isactive'=>'nullable|boolean']); $d['id_kamar']=$kamar->id_kamar; $d['isactive']=$r->boolean('isactive'); HargaKamar::create($d); return redirect()->route('admin.kamar.harga.index',$kamar)->with('success','Harga ditambah.'); }
    public function edit(Request $r, KamarKost $kamar, HargaKamar $harga){ $this->owned($kamar,$r); abort_if($harga->id_kamar!==$kamar->id_kamar,403); return view('admin.kamar.harga.form',['kamar'=>$kamar,'item'=>$harga,'periodes'=>PeriodePenagihan::all()]); }
    public function update(Request $r, KamarKost $kamar, HargaKamar $harga){ $this->owned($kamar,$r); abort_if($harga->id_kamar!==$kamar->id_kamar,403); $d=$r->validate(['harga'=>'required|numeric|min:0','id_periode'=>'required|exists:periode_penagihans,id_penagihan','isactive'=>'nullable|boolean']); $d['isactive']=$r->boolean('isactive'); $harga->update($d); return redirect()->route('admin.kamar.harga.index',$kamar)->with('success','Harga diperbarui.'); }
    public function destroy(Request $r, KamarKost $kamar, HargaKamar $harga){ $this->owned($kamar,$r); abort_if($harga->id_kamar!==$kamar->id_kamar,403); $harga->delete(); return back()->with('success','Harga dihapus.'); }
}
