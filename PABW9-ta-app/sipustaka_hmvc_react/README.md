# SiPustaka HMVC + React

Project Laravel 12 React Starter Kit dengan tiga modul HMVC:

- **Buku**: katalog untuk user, CRUD Inertia (`useForm`) untuk admin, pencarian dan pagination.
- **Peminjaman**: CRUD AJAX `fetch()` untuk semua pengguna, upload JPG/PNG/PDF maksimal 2 MB di `storage/app/public/bukti-peminjaman`, dan tautan untuk membuka berkas.
- **UserManagement**: CRUD akun dan role khusus admin. Akun admin yang sedang login tidak dapat dihapus atau diturunkan role-nya.

## Menjalankan di XAMPP

1. Jalankan Apache dan MySQL, lalu buat database `db_sipustaka` (collation `utf8mb4_unicode_ci`) melalui phpMyAdmin.
2. Pastikan `.env` memakai `DB_DATABASE=db_sipustaka`, `DB_USERNAME=root`, dan password MySQL lokal Anda.
3. Jalankan `composer install` dan `npm install`.
4. Jalankan `php artisan migrate --seed` dan `php artisan storage:link`.
5. Jalankan `npm run dev`, lalu buka project melalui Laravel (`php artisan serve`) atau konfigurasi Apache yang sesuai.

Akun awal dari seeder (password keduanya `password`):

| Role | Email |
| --- | --- |
| Admin | `admin@sipustaka.test` |
| User | `user@sipustaka.test` |

Registrasi publik selalu menetapkan role `user`. Semua halaman data dilindungi `auth`; halaman Buku admin dan UserManagement juga dilindungi middleware `role:admin`. User yang membuka route admin akan menerima HTTP 403.

## Pembuktian praktikum

- Untuk bukti authorization, login sebagai `user@sipustaka.test`, kunjungi `/buku` atau `/pengguna`, dan ambil screenshot halaman 403. Menu sidebar user menyediakan Katalog Buku dan Peminjaman.
- Untuk bukti AJAX, buka `/peminjaman`, buka DevTools → Network → Fetch/XHR, lalu tambah atau ubah peminjaman. Request `POST /peminjaman` (dan `GET /peminjaman/data`) terlihat tanpa navigasi halaman; unggah berkas kecil JPG/PNG/PDF untuk menguji tautan berkas.
- Di phpMyAdmin, pilih `db_sipustaka` → tabel `peminjaman` → Browse/Structure untuk menunjukkan kolom `bukti_path` beserta path yang tersimpan. Folder berkas berada di `storage/app/public/bukti-peminjaman` setelah upload.
