<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa</title>
</head>
<body>
    <h2>Daftar Mahasiswa</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
            <th>Umur</th>
        </tr>

        @foreach ($mahasiswa as $m)
        <tr>
            <td>{{ $m->nama }}</td>
            <td>{{ $m->email }}</td>
            <td>{{ $m->jurusan }}</td>
            <td>{{ $m->umur }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>