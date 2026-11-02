<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Laporan Banjir</title>
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
            width: min(900px, calc(100% - 32px));
            margin: 0 auto;
            padding: 40px 0;
        }

        .result-card {
            overflow: hidden;
            border: 1px solid #d7e5ef;
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 0 18px 45px rgba(23, 50, 77, 0.08);
        }

        .result-header {
            padding: 30px;
            color: #ffffff;
            background: #0f6ea8;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 7px 12px;
            color: #17324d;
            font-size: 13px;
            font-weight: 700;
            background: #d7f4ef;
        }

        h1 {
            margin: 16px 0 8px;
            font-size: 30px;
            line-height: 1.2;
        }

        .subtitle {
            margin: 0;
            line-height: 1.6;
        }

        .result-content {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            padding: 30px;
        }

        .item,
        .recommendation {
            border: 1px solid #d7e5ef;
            border-radius: 8px;
            padding: 16px;
            background: #fbfdff;
        }

        .item span,
        .recommendation span {
            display: block;
            margin-bottom: 8px;
            color: #5a7184;
            font-size: 13px;
            font-weight: 700;
        }

        .item strong,
        .recommendation p {
            margin: 0;
            color: #17324d;
            line-height: 1.6;
        }

        .recommendation {
            grid-column: 1 / -1;
        }

        .actions {
            display: flex;
            gap: 12px;
            padding: 0 30px 30px;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            padding: 12px 16px;
            color: #ffffff;
            font-weight: 700;
            text-decoration: none;
            background: #0f6ea8;
        }

        .button.secondary {
            color: #0f6ea8;
            background: #e7f3f8;
        }

        @media (max-width: 680px) {
            .result-content {
                grid-template-columns: 1fr;
                padding: 22px;
            }

            .result-header,
            .actions {
                padding-left: 22px;
                padding-right: 22px;
            }

            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="result-card">
            <div class="result-header">
                <span class="status-badge">Status: {{ $status }}</span>
                <h1>Hasil Laporan Banjir</h1>
                <p class="subtitle">Berikut ringkasan laporan yang telah dikirimkan.</p>
            </div>

            <div class="result-content">
                <div class="item">
                    <span>Nama Pelapor</span>
                    <strong>{{ $laporan['nama_pelapor'] }}</strong>
                </div>

                <div class="item">
                    <span>Lokasi</span>
                    <strong>{{ $laporan['lokasi'] }}</strong>
                </div>

                <div class="item">
                    <span>Tanggal Kejadian</span>
                    <strong>{{ \Carbon\Carbon::parse($laporan['tanggal'])->translatedFormat('d F Y') }}</strong>
                </div>

                <div class="item">
                    <span>Tinggi Air</span>
                    <strong>{{ rtrim(rtrim(number_format((float) $laporan['tinggi_air'], 2, ',', '.'), '0'), ',') }} cm</strong>
                </div>

                @if (!empty($laporan['keterangan']))
                    <div class="item">
                        <span>Keterangan</span>
                        <strong>{{ $laporan['keterangan'] }}</strong>
                    </div>
                @endif

                <div class="recommendation">
                    <span>Rekomendasi</span>
                    <p>{{ $rekomendasi }}</p>
                </div>
            </div>

            <div class="actions">
                <a class="button" href="{{ route('banjir.form') }}">Buat Laporan Baru</a>
                <a class="button secondary" href="{{ url('/home') }}">Ke Beranda</a>
            </div>
        </section>
    </main>
</body>
</html>
