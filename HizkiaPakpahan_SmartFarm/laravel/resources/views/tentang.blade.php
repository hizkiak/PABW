@extends('layouts.main')
@section('title', 'Tentang SmartFarm Monitoring')
@section('content')
    <div class="card">
        <h1>Tentang SmartFarm</h1>
        <p>SmartFarm adalah website monitoring pertanian yang membantu mencatat dan mengevaluasi kondisi lahan berdasarkan data sensor sederhana.</p>

        <h2>Parameter Monitoring</h2>
        <ul>
            <li>Lokasi monitoring: Singaparna, Ciawi, dan Manonjaya.</li>
            <li>Kelembapan tanah untuk menentukan status Kering, Normal, atau Basah.</li>
            <li>Suhu udara sebagai indikator kondisi lingkungan tanaman.</li>
            <li>Kelembapan udara untuk melihat kenyamanan mikroklimat lahan.</li>
        </ul>

        <h2>Metode Monitoring</h2>
        <p>Data dimasukkan melalui form, disimpan ke database, lalu ditampilkan pada dashboard dan riwayat. Sistem memberi rekomendasi otomatis berdasarkan nilai kelembapan tanah.</p>
    </div>
@endsection
