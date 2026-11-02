@extends('layouts.app')

@section('title', 'Daftar Laporan Banjir')

@section('content')
    <h2>Daftar Laporan Kejadian Banjir</h2>

    {{-- Loop menggunakan Partial Card dengan @include --}}
    @forelse($laporanList as $laporan)
        @include('partials.laporan-card', ['laporan' => $laporan])
    @empty
        <x-alert type="error" message="Belum ada laporan masuk saat ini." />
    @endforelse
@endsection