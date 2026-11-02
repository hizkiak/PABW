<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantau Banjir</title>
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
            padding: 48px 0;
        }

        .hero {
            border-radius: 8px;
            padding: 42px;
            color: #ffffff;
            background: linear-gradient(135deg, #0f6ea8, #239b82);
        }

        h1 {
            margin: 0 0 12px;
            max-width: 720px;
            font-size: 38px;
            line-height: 1.15;
        }

        p {
            margin: 0;
            max-width: 680px;
            line-height: 1.7;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 24px;
            border-radius: 8px;
            padding: 12px 16px;
            color: #0f6ea8;
            font-weight: 700;
            text-decoration: none;
            background: #ffffff;
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="hero">
            <h1>Sistem Laporan Banjir</h1>
            <p>Catat lokasi, tanggal kejadian, tinggi air, dan keterangan lapangan untuk mendapatkan kategori status laporan secara cepat.</p>
            <a class="button" href="{{ route('banjir.form') }}">Buka Form Laporan</a>
        </section>
    </main>
</body>
</html>
