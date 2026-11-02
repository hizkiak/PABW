@extends('layouts.app')

@section('title', 'Form Pelaporan')

@section('content')
    <h2>Form Lapor Kejadian Banjir</h2>
    <div class="card">
        <form action="{{ route('laporan.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama">Nama Pelapor:</label>
                <input type="text" id="nama" name="nama" required placeholder="Masukkan nama lengkap">
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi Kejadian:</label>
                <input type="text" id="lokasi" name="lokasi" required placeholder="Contoh: Kec. Dayeuhkolot">
            </div>

            <div class="form-group">
                <label for="tinggi">Tinggi Genangan Air (cm):</label>
                <input type="number" id="tinggi" name="tinggi" required placeholder="Contoh: 45">
            </div>

            <button type="submit">Kirim Laporan</button>
        </form>
    </div>
@endsection