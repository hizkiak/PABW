@extends('layouts.app')
@section('title', 'Ubah Pengguna')
@section('content')<h1 class="h3 mb-4">Ubah Pengguna</h1><form method="POST" action="{{ route('usermanagement.update', $user) }}">@csrf @method('PUT') @include('usermanagement::partials.form', ['user' => $user])</form>@endsection
