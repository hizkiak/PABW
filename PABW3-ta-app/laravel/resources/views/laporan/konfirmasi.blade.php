@extends('layouts.app')

@section('title', 'Konfirmasi Laporan')

@section('content')
    <h2>Konfirmasi Pelaporan</h2>

    {{-- Penggunaan Blade Component Alert --}}
    <x-alert type="success" message="Laporan banjir berhasil dikirim dan disimulasikan!" />

    <div class="card">
        <h3>Detail Laporan Terkirim:</h3>
        <p><strong>Nama Pelapor:</strong> {{ $data['nama'] }}</p>
        <p><strong>Lokasi Kejadian:</strong> {{ $data['lokasi'] }}</p>
        <p><strong>Tinggi Genangan:</strong> {{ $data['tinggi'] }} cm</p>
        
        <p>
            <strong>Status Ditetapkan:</strong>
            @if($data['tinggi'] < 30)
                <span class="badge badge-waspada">Waspada</span>
            @elseif($data['tinggi'] >= 30 && $data['tinggi'] <= 70)
                <span class="badge badge-siaga">Siaga</span>
            @else
                <span class="badge badge-awas">Awas</span>
            @endif
        </p>
        
        <br>
        <a href="{{ route('laporan.index') }}"><button type="button">Lihat Semua Laporan</button></a>
    </div>
@endsection