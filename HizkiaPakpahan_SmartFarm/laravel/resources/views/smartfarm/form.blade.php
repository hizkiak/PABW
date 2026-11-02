@extends('layouts.main')
@section('title', 'Input Monitoring SmartFarm')
@section('content')
    <div class="card">
        <h1>Input Data Monitoring</h1>
        <p class="muted">Masukkan hasil pembacaan sensor untuk mendapatkan status kelembapan tanah dan rekomendasi perawatan.</p>

        <form action="{{ route('smartfarm.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div>
                    <label for="lokasi">Lokasi</label>
                    <select id="lokasi" name="lokasi" required>
                        <option value="">Pilih lokasi</option>
                        <option value="Singaparna" @selected(old('lokasi') === 'Singaparna')>Singaparna</option>
                        <option value="Ciawi" @selected(old('lokasi') === 'Ciawi')>Ciawi</option>
                        <option value="Manonjaya" @selected(old('lokasi') === 'Manonjaya')>Manonjaya</option>
                    </select>
                    @error('lokasi')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="nama_tanaman">Nama Tanaman</label>
                    <input id="nama_tanaman" type="text" name="nama_tanaman" value="{{ old('nama_tanaman') }}" placeholder="Contoh: Cabai" required>
                    @error('nama_tanaman')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="kelembapan_tanah">Kelembapan Tanah (%)</label>
                    <input id="kelembapan_tanah" type="number" name="kelembapan_tanah" min="0" max="100" value="{{ old('kelembapan_tanah') }}" required>
                    @error('kelembapan_tanah')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="suhu_udara">Suhu Udara (&deg;C)</label>
                    <input id="suhu_udara" type="number" name="suhu_udara" min="0" max="60" value="{{ old('suhu_udara') }}" required>
                    @error('suhu_udara')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="kelembapan_udara">Kelembapan Udara (%)</label>
                    <input id="kelembapan_udara" type="number" name="kelembapan_udara" min="0" max="100" value="{{ old('kelembapan_udara') }}" required>
                    @error('kelembapan_udara')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button class="button" type="submit">Simpan Monitoring</button>
                <a class="button secondary" href="{{ route('smartfarm.riwayat') }}">Batal</a>
            </div>
        </form>
    </div>
@endsection
