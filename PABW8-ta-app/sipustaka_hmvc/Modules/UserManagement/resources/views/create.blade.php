@extends('layouts.app')
@section('title', 'Tambah Pengguna')
@section('content')<h1 class="h3 mb-4">Tambah Pengguna</h1><form method="POST" action="{{ route('usermanagement.store') }}">@csrf @include('usermanagement::partials.form', ['user' => null])</form>@endsection
