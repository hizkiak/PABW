@extends('layouts.main')
@section('title', 'Dashboard SmartFarm Monitoring')
@section('content')
    <section class="hero">
        <div>
            <h1>SmartFarm Monitoring Tasikmalaya</h1>
            <p>Sistem monitoring pertanian cerdas untuk mencatat kondisi lahan, membaca kelembapan tanah, suhu udara, dan kelembapan udara secara teratur.</p>
            <a class="button" href="{{ route('smartfarm.form') }}">Input Kondisi Lahan</a>
            <a class="button secondary" href="{{ route('smartfarm.riwayat') }}">Lihat Riwayat</a>
        </div>
        <div class="hero-visual" aria-label="Ilustrasi lahan monitoring SmartFarm">
            <strong>Status Lahan</strong>
            <div class="field-row">
                <span class="crop-line"></span>
                <span class="crop-line"></span>
                <span class="crop-line"></span>
                <span class="crop-line"></span>
            </div>
            <p class="muted">Data sensor membantu menentukan rekomendasi penyiraman.</p>
        </div>
    </section>

    <section class="grid three">
        <article class="card">
            <span class="muted">Total Data</span>
            <p class="metric">{{ $totalData }}</p>
        </article>
        <article class="card">
            <span class="muted">Rata-rata Kelembapan Tanah</span>
            <p class="metric">{{ $rataKelembapanTanah }}%</p>
        </article>
        <article class="card">
            <span class="muted">Rata-rata Suhu Udara</span>
            <p class="metric">{{ $rataSuhuUdara }}&deg;C</p>
        </article>
    </section>

    <h2 class="section-title">Monitoring Terbaru</h2>
    <div class="card table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Lokasi</th>
                    <th>Tanaman</th>
                    <th>Kelembapan Tanah</th>
                    <th>Suhu</th>
                    <th>Status</th>
                    <th>Rekomendasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $item->lokasi }}</td>
                        <td>{{ $item->nama_tanaman }}</td>
                        <td>{{ $item->kelembapan_tanah }}%</td>
                        <td>{{ $item->suhu_udara }}&deg;C</td>
                        <td><span class="badge {{ strtolower($item->kategori) }}">{{ $item->kategori }}</span></td>
                        <td>{{ $item->rekomendasi }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada data monitoring.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
