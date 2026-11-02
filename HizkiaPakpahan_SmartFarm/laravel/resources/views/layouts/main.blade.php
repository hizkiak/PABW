<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SmartFarm Monitoring')</title>
    <style>
        :root {
            --bg: #eef7ef;
            --panel: #ffffff;
            --primary: #1f8a4c;
            --primary-dark: #17693a;
            --accent: #f3b33d;
            --text: #183326;
            --muted: #64766d;
            --line: #d9e8de;
            --danger: #c54834;
            --warning: #ad7414;
            --success: #257445;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
        }

        a {
            color: var(--primary-dark);
            text-decoration: none;
            font-weight: 700;
        }

        .site-header {
            background: var(--panel);
            border-bottom: 1px solid var(--line);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .nav {
            align-items: center;
            display: flex;
            gap: 18px;
            justify-content: space-between;
            margin: 0 auto;
            max-width: 1120px;
            padding: 16px 20px;
        }

        .brand {
            color: var(--primary-dark);
            font-size: 22px;
            font-weight: 800;
        }

        .nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .nav-links a {
            border-radius: 6px;
            color: var(--text);
            padding: 8px 10px;
        }

        .nav-links a:hover {
            background: #e7f3ea;
        }

        .container {
            margin: 0 auto;
            max-width: 1120px;
            padding: 28px 20px 48px;
        }

        .hero {
            align-items: center;
            background: linear-gradient(135deg, #e0f4df 0%, #ffffff 52%, #fff3d5 100%);
            border: 1px solid var(--line);
            border-radius: 8px;
            display: grid;
            gap: 24px;
            grid-template-columns: 1.5fr 1fr;
            margin-bottom: 24px;
            padding: 34px;
        }

        .hero h1 {
            font-size: clamp(30px, 5vw, 54px);
            line-height: 1.08;
            margin: 0 0 12px;
        }

        .hero p {
            color: var(--muted);
            font-size: 18px;
            margin: 0 0 22px;
        }

        .hero-visual {
            background: #dff0df;
            border: 1px solid var(--line);
            border-radius: 8px;
            min-height: 220px;
            padding: 22px;
        }

        .field-row {
            align-items: end;
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(4, 1fr);
            margin-top: 18px;
        }

        .crop-line {
            background: #7cc071;
            border-radius: 999px;
            height: 16px;
            margin-top: 16px;
        }

        .crop-line:nth-child(2) {
            width: 90%;
        }

        .crop-line:nth-child(3) {
            width: 72%;
        }

        .crop-line:nth-child(4) {
            width: 82%;
        }

        .button {
            background: var(--primary);
            border: 0;
            border-radius: 6px;
            color: #ffffff;
            cursor: pointer;
            display: inline-block;
            font-weight: 700;
            padding: 11px 16px;
        }

        .button.secondary {
            background: #ffffff;
            border: 1px solid var(--line);
            color: var(--primary-dark);
        }

        .grid {
            display: grid;
            gap: 16px;
        }

        .grid.three {
            grid-template-columns: repeat(3, 1fr);
        }

        .card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 20px;
        }

        .metric {
            color: var(--primary-dark);
            font-size: 32px;
            font-weight: 800;
            margin: 8px 0 0;
        }

        .muted {
            color: var(--muted);
        }

        .section-title {
            margin: 28px 0 12px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            min-width: 760px;
            width: 100%;
        }

        th,
        td {
            border-bottom: 1px solid var(--line);
            padding: 12px;
            text-align: left;
        }

        th {
            background: #f5fbf6;
            color: var(--primary-dark);
        }

        label {
            display: block;
            font-weight: 700;
            margin-bottom: 6px;
        }

        input,
        select {
            border: 1px solid var(--line);
            border-radius: 6px;
            font: inherit;
            padding: 10px 12px;
            width: 100%;
        }

        .form-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(2, 1fr);
        }

        .form-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .alert {
            background: #e8f6ec;
            border: 1px solid #bde2c7;
            border-radius: 8px;
            color: var(--success);
            margin-bottom: 16px;
            padding: 12px 14px;
        }

        .error {
            color: var(--danger);
            font-size: 14px;
            margin-top: 4px;
        }

        .badge {
            border-radius: 999px;
            display: inline-block;
            font-size: 13px;
            font-weight: 700;
            padding: 4px 10px;
        }

        .badge.kering {
            background: #fde8e2;
            color: var(--danger);
        }

        .badge.normal {
            background: #e5f5ea;
            color: var(--success);
        }

        .badge.basah {
            background: #e9f0ff;
            color: #315b9c;
        }

        footer {
            border-top: 1px solid var(--line);
            color: var(--muted);
            padding: 22px 20px;
            text-align: center;
        }

        @media (max-width: 760px) {
            .hero,
            .grid.three,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .nav {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <nav class="nav">
            <a class="brand" href="{{ route('smartfarm.index') }}">SmartFarm</a>
            <div class="nav-links">
                <a href="{{ route('smartfarm.index') }}">Dashboard</a>
                <a href="{{ route('smartfarm.form') }}">Input Monitoring</a>
                <a href="{{ route('smartfarm.riwayat') }}">Riwayat</a>
                <a href="{{ route('smartfarm.tentang') }}">Tentang</a>
            </div>
        </nav>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2026 SmartFarm Monitoring Pertanian Cerdas</p>
    </footer>
</body>
</html>
