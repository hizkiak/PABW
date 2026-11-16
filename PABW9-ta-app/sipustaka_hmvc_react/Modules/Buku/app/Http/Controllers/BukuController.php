<?php
namespace Modules\Buku\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Buku\Models\Buku;
use Modules\Buku\Http\Requests\BukuRequest;
class BukuController extends Controller
{
 public function index(Request $r){$buku=Buku::query()->when($r->search,fn($q,$s)=>$q->where(fn($w)=>$w->where('judul','like',"%$s%")->orWhere('penulis','like',"%$s%")))->orderBy('judul')->paginate(8)->withQueryString();return Inertia::render('Buku/index',['buku'=>$buku,'filters'=>$r->only('search'),'canManage'=>$r->user()->role==='admin']);}
 public function store(BukuRequest $r){Buku::create($r->validated());return back()->with('success','Buku berhasil ditambahkan.');}
 public function update(BukuRequest $r,Buku $buku){$buku->update($r->validated());return back()->with('success','Buku berhasil diperbarui.');}
 public function destroy(Buku $buku){$buku->delete();return back()->with('success','Buku berhasil dihapus.');}
}
