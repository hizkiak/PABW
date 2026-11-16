<?php
namespace Modules\Peminjaman\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Peminjaman\Models\Peminjaman;
use Modules\Peminjaman\Http\Requests\PeminjamanRequest;
use Inertia\Inertia;
class PeminjamanController extends Controller
{
 public function index(){return Inertia::render('Peminjaman/index');}
 public function list(){return response()->json(Peminjaman::with('user:id,name')->latest()->paginate(10));}
 public function store(PeminjamanRequest $r){$data=$r->safe()->except('bukti');if($r->hasFile('bukti'))$data['bukti_path']=$r->file('bukti')->store('bukti-peminjaman','public');$data['user_id']=$r->user()->id;$item=Peminjaman::create($data);return response()->json(['message'=>'Peminjaman berhasil ditambahkan.','data'=>$item],201);}
 public function update(PeminjamanRequest $r,Peminjaman $peminjaman){$data=$r->safe()->except('bukti');if($r->hasFile('bukti')){if($peminjaman->bukti_path)Storage::disk('public')->delete($peminjaman->bukti_path);$data['bukti_path']=$r->file('bukti')->store('bukti-peminjaman','public');}$peminjaman->update($data);return response()->json(['message'=>'Peminjaman berhasil diperbarui.','data'=>$peminjaman]);}
 public function destroy(Peminjaman $peminjaman){if($peminjaman->bukti_path)Storage::disk('public')->delete($peminjaman->bukti_path);$peminjaman->delete();return response()->json(['message'=>'Peminjaman berhasil dihapus.']);}
}
