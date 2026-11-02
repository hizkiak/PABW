<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Laporan Banjir</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            color: #17324d;
            background: #f4f8fb;
        }

        .page {
            width: min(960px, calc(100% - 32px));
            margin: 0 auto;
            padding: 40px 0;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
        }

        .brand {
            font-size: 20px;
            font-weight: 700;
        }

        .nav-link {
            color: #0f6ea8;
            font-weight: 700;
            text-decoration: none;
        }

        .panel {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            overflow: hidden;
            border: 1px solid #d7e5ef;
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 0 18px 45px rgba(23, 50, 77, 0.08);
        }

        .intro {
            padding: 32px;
            color: #ffffff;
            background: linear-gradient(135deg, #0f6ea8, #239b82);
        }

        .intro h1 {
            margin: 0 0 12px;
            font-size: 32px;
            line-height: 1.15;
        }

        .intro p {
            margin: 0;
            line-height: 1.7;
        }

        form {
            padding: 32px;
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
        }

        input,
        textarea {
            width: 100%;
            border: 1px solid #c9d8e3;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 15px;
            color: #17324d;
            background: #ffffff;
        }

        textarea {
            min-height: 110px;
        }

        input:focus,
        textarea:focus {
            border-color: #0f6ea8;
            outline: 3px solid rgba(15, 110, 168, 0.15);
        }

        .error {
            margin-top: 6px;
            color: #b42318;
            font-size: 14px;
        }

        .submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            border: 0;
            border-radius: 8px;
            padding: 13px 18px;
            color: #ffffff;
            font-weight: 700;
            background: #0f6ea8;
            cursor: pointer;
        }

        .submit:hover {
            background: #0b5c8d;
        }

        @media (max-width: 760px) {
            .panel {
                grid-template-columns: 1fr;
            }

            .intro,
            form {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <nav class="topbar">
            <div class="brand">Pantau Banjir</div>
            <a class="nav-link" href="{{ route('banjir.form') }}">Form Laporan</a>
        </nav>

        <section class="panel">
            <div class="intro">
                <h1>Laporan Genangan Air</h1>
                <p>Masukkan data kondisi banjir di lokasi Anda. Sistem akan menampilkan kategori status dan rekomendasi awal berdasarkan tinggi air.</p>
            </div>

            <form action="{{ route('banjir.store') }}" method="POST">
                @csrf

                <div class="field">
                    <label for="nama_pelapor">Nama Pelapor</label>
                    <input type="text" name="nama_pelapor" id="nama_pelapor" value="{{ old('nama_pelapor') }}" required>
                    @error('nama_pelapor')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required>
                    @error('lokasi')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="tanggal">Tanggal Kejadian</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" required>
                    @error('tanggal')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="tinggi_air">Tinggi Air (cm)</label>
                    <input type="number" name="tinggi_air" id="tinggi_air" value="{{ old('tinggi_air') }}" min="0" max="1000" required>
                    @error('tinggi_air')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" placeholder="Contoh: arus deras, akses jalan tertutup, atau warga membutuhkan bantuan">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button class="submit" type="submit">Kirim Laporan</button>
            </form>
        </section>
    </main>
</body>
</html>
