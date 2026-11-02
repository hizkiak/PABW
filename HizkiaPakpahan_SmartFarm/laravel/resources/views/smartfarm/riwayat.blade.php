@extends('layouts.main')
@section('title', 'Riwayat Monitoring SmartFarm')
@section('content')
    <h1>Riwayat Monitoring</h1>
    <p class="muted">Daftar data kondisi lahan yang sudah dicatat pada sistem SmartFarm.</p>

    @if (session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <div class="card table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Tanaman</th>
                    <th>Kelembapan Tanah</th>
                    <th>Suhu Udara</th>
                    <th>Kelembapan Udara</th>
                    <th>Status</th>
                    <th>Rekomendasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $item->lokasi }}</td>
                        <td>{{ $item->nama_tanaman }}</td>
                        <td>{{ $item->kelembapan_tanah }}%</td>
                        <td>{{ $item->suhu_udara }}&deg;C</td>
                        <td>{{ $item->kelembapan_udara }}%</td>
                        <td><span class="badge {{ strtolower($item->kategori) }}">{{ $item->kategori }}</span></td>
                        <td>{{ $item->rekomendasi }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">Belum ada data monitoring.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <p>
        <a class="button" href="{{ route('smartfarm.form') }}">Tambah Data</a>
    </p>
@endsection
