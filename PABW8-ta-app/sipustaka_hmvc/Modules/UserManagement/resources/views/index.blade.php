@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h1 class="h3">Manajemen Pengguna</h1><p class="text-muted mb-0">Kelola akun dan hak akses.</p></div>
    <a class="btn btn-primary" href="{{ route('usermanagement.create') }}">Tambah pengguna</a>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card"><div class="table-responsive"><table class="table table-hover mb-0">
<thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead><tbody>
@forelse($users as $user)<tr><td>{{ $user->name }} @if($user->is(auth()->user()))<span class="badge text-bg-secondary">Anda</span>@endif</td><td>{{ $user->email }}</td><td>{{ $user->role->label() }}</td><td class="d-flex gap-2"><a class="btn btn-sm btn-warning" href="{{ route('usermanagement.edit', $user) }}">Ubah</a>@unless($user->is(auth()->user()))<form method="POST" action="{{ route('usermanagement.destroy', $user) }}" onsubmit="return confirm('Hapus akun ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form>@endunless</td></tr>
@empty<tr><td colspan="4" class="text-center py-4">Belum ada pengguna.</td></tr>@endforelse
</tbody></table></div><div class="card-body">{{ $users->links() }}</div></div>
@endsection
