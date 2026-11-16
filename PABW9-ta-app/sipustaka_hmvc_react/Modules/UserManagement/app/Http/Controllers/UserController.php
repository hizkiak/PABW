<?php
namespace Modules\UserManagement\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Modules\UserManagement\Http\Requests\UserRequest;
class UserController extends Controller
{
 public function index(){return Inertia::render('UserManagement/index',['users'=>User::query()->orderBy('name')->paginate(10)]);}
 public function store(UserRequest $r){$data=$r->validated();$data['password']=Hash::make($data['password']);User::create($data);return back()->with('success','Pengguna berhasil ditambahkan.');}
 public function update(UserRequest $r,User $user){if($user->is(auth()->user()) && $r->role!=='admin')return back()->withErrors(['role'=>'Anda tidak dapat menurunkan role akun sendiri.']);$data=$r->safe()->except('password');if($r->filled('password'))$data['password']=Hash::make($r->password);$user->update($data);return back()->with('success','Pengguna berhasil diperbarui.');}
 public function destroy(User $user){if($user->is(auth()->user()))return back()->withErrors(['user'=>'Anda tidak dapat menghapus akun sendiri.']);$user->delete();return back()->with('success','Pengguna berhasil dihapus.');}
}
