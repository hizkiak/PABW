<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Mahasiswa</title>
</head>
<body>
    <h2>Form Input Mahasiswa</h2>

    <form action="/simpan" method="POST">
        @csrf
        <label>Nama:</label>
        <input type="text" name="nama" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" required><br><br>

        <label>Jurusan:</label>
        <input type="text" name="jurusan" required><br><br>

        <label>Umur:</label>
        <input type="number" name="umur" required><br><br>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>