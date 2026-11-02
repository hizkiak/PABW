<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LaporBanjir') | BPBD Kabupaten Bandung</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f6f9; }
        header, footer { background: #1e3a8a; color: white; padding: 15px; text-align: center; border-radius: 6px; }
        nav a { margin: 0 15px; text-decoration: none; color: #f3f4f6; font-weight: bold; }
        nav a:hover { color: #fbbf24; }
        .container { margin-top: 20px; min-height: 400px; }
        .card { background: white; border: 1px solid #e5e7eb; padding: 15px; margin-bottom: 15px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .badge { padding: 4px 8px; border-radius: 4px; color: white; font-weight: bold; font-size: 0.9em; }
        .badge-waspada { background-color: #eab308; } /* Yellow */
        .badge-siaga { background-color: #f97316; }   /* Orange */
        .badge-awas { background-color: #ef4444; }    /* Red */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #1e3a8a; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #1d4ed8; }
    </style>
</head>
<body>

    <header>
        <h1>LaporBanjir - BPBD Kabupaten Bandung</h1>
        <nav>
            <a href="{{ route('laporan.index') }}">Daftar Laporan</a>
            <a href="{{ route('laporan.create') }}">Buat Laporan</a>
        </nav>
    </header>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} BPBD Kabupaten Bandung - Sistem Pelaporan Banjir</p>
    </footer>

</body>
</html>