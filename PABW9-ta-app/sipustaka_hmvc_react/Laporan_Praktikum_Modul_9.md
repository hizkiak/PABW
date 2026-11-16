# LAPORAN PRAKTIKUM MODUL 9
## HMVC, Authorization, dan AJAX dengan React — SiPustaka

## 2. Tujuan Praktikum

Melalui praktikum ini saya ingin membangun aplikasi perpustakaan yang kodenya terpisah menurut fitur, tetapi tetap terhubung dalam satu project Laravel. Saya juga ingin memahami bagaimana halaman React berkomunikasi dengan Laravel melalui Inertia dan AJAX, bagaimana hak akses admin dan anggota dibedakan, serta bagaimana validasi dan berkas bukti peminjaman ditangani.

## 4. Langkah-Langkah Praktikum

### Tahap A: Menyiapkan Laravel React Starter Kit dan database

**1. Membuat project.** Project dibuat menggunakan Laravel Installer dengan memilih React Starter Kit. Starter kit menyediakan React, TypeScript, Inertia.js, Tailwind CSS, dan autentikasi Laravel.

```bash
laravel new sipustaka_hmvc_react
cd sipustaka_hmvc_react
```

**2. Membuat database.** Database `db_sipustaka` dibuat melalui phpMyAdmin atau perintah SQL berikut.

```sql
CREATE DATABASE db_sipustaka CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Koneksi MySQL kemudian diatur pada file `.env`.

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_sipustaka
DB_USERNAME=root
DB_PASSWORD=
FILESYSTEM_DISK=public
```

**3. Memasang dependensi dan menyiapkan database.**

```bash
composer install
npm install
php artisan migrate --seed
php artisan storage:link
```

Seeder menambahkan akun admin `admin@sipustaka.test`, akun user `user@sipustaka.test`, dan lima data buku contoh. Password awal kedua akun adalah `password`.

### Tahap B: Memasang HMVC dan membuat modul

**1. Memasang package modul.**

```bash
composer require nwidart/laravel-modules:12.0 wikimedia/composer-merge-plugin:^2.1
```

**2. Menyiapkan manifest Composer untuk setiap modul.** Modul yang digunakan adalah `Buku`, `Peminjaman`, dan `UserManagement`. Setiap modul memiliki `module.json`, `composer.json`, route, controller, model, Form Request, migration, dan halaman React. Contoh namespace pada `Modules/Buku/composer.json`:

```json
{
  "autoload": {
    "psr-4": {
      "Modules\\Buku\\": "app/"
    }
  }
}
```

**3. Mengatur Composer Merge Plugin.** File `composer.json` utama membaca manifest Composer yang berada di dalam folder modul.

```json
"extra": {
  "merge-plugin": {
    "include": ["Modules/*/composer.json"],
    "recurse": true,
    "replace": false,
    "ignore-duplicates": true
  }
}
```

Setelah namespace ditambahkan, autoload diperbarui dan modul diaktifkan.

```bash
composer dump-autoload
php artisan module:enable Buku
php artisan module:enable Peminjaman
php artisan module:enable UserManagement
php artisan module:list
```

### Tahap C: Menghubungkan halaman React dalam modul

Pada tahap ini Laravel tetap menangani URL, autentikasi, validasi, dan akses database. React bertugas menampilkan antarmuka. Inertia menghubungkan keduanya: controller mengembalikan nama halaman React beserta data props, lalu resolver di frontend mencari file TSX yang sesuai.

**1. Membuat folder halaman pada setiap modul.** Halaman diletakkan di dalam struktur modul agar kode antarmuka sekelompok dengan fitur backend-nya. Struktur yang dipakai dalam project ini:

```text
Modules/
├── Buku/resources/js/pages/index.tsx
├── Peminjaman/resources/js/pages/index.tsx
└── UserManagement/resources/js/pages/index.tsx
```

Setiap `index.tsx` adalah komponen React yang menjadi halaman utama modul tersebut. Misalnya, halaman Buku menerima props `buku`, `filters`, dan `canManage`; halaman Peminjaman mengambil datanya melalui request AJAX setelah halaman dimuat.

**2. Mengembalikan nama halaman dari controller.** Nama yang diberikan ke `Inertia::render()` harus mengikuti pola `NamaModul/namaHalaman`. Bagian setelah garis miring cocok dengan lokasi file di dalam `resources/js/pages` modul.

```php
// Modules/Buku/app/Http/Controllers/BukuController.php
return Inertia::render('Buku/index', [
    'buku' => $buku,
    'filters' => $r->only('search'),
    'canManage' => $r->user()->role === 'admin',
]);

// Modules/Peminjaman/app/Http/Controllers/PeminjamanController.php
return Inertia::render('Peminjaman/index');

// Modules/UserManagement/app/Http/Controllers/UserController.php
return Inertia::render('UserManagement/index', [
    'users' => User::query()->orderBy('name')->paginate(10),
]);
```

Sebagai contoh, `Inertia::render('Buku/index')` akan dicari pada file `Modules/Buku/resources/js/pages/index.tsx`. Data array kedua pada `Inertia::render()` diterima komponen sebagai props. Penulisan nama modul dan halaman harus sama persis dengan nama pada resolver dan struktur folder.

**3. Menyiapkan daftar file halaman di resolver.** Pada `resources/js/app.tsx`, `import.meta.glob()` meminta Vite mengumpulkan modul halaman sebagai map yang bisa dimuat saat diperlukan. `appPages` menunjuk halaman starter kit dalam `resources/js/pages`, sedangkan `modulePages` mencakup halaman di seluruh folder modul.

```tsx
const appPages = import.meta.glob('./pages/**/*.tsx');
const modulePages = import.meta.glob(
    '../../Modules/**/resources/js/pages/**/*.tsx',
);
```

**4. Mengarahkan nama halaman ke lokasi yang benar.** Resolver memecah nama seperti `Buku/index` menjadi nama modul `Buku` dan sisa path `index`. Daftar `moduleNames` berfungsi sebagai daftar modul yang dikenali. Jika modul cocok, file dicari di folder modul. Jika tidak cocok, resolver memakai folder halaman utama. Fallback ini penting untuk halaman seperti `auth/login` dan `dashboard` yang tidak termasuk modul.

```tsx
const appPages = import.meta.glob('./pages/**/*.tsx');
const modulePages = import.meta.glob('../../Modules/**/resources/js/pages/**/*.tsx');
const moduleNames: Record<string, string> = {
    Buku: 'Buku',
    Peminjaman: 'Peminjaman',
    UserManagement: 'UserManagement',
};

if (name.includes('/')) {
    const [module, ...page] = name.split('/');
    if (moduleNames[module]) {
        return resolvePageComponent(
            `../../Modules/${moduleNames[module]}/resources/js/pages/${page.join('/')}.tsx`,
            modulePages,
        );
    }
}

return resolvePageComponent(`./pages/${name}.tsx`, appPages);
```

Dengan aturan tersebut, `Buku/index` menuju `../../Modules/Buku/resources/js/pages/index.tsx`, sementara `auth/login` menuju `./pages/auth/login.tsx`. `resolvePageComponent()` mengambil komponen dari map Vite dan menampilkan error jika file yang dirujuk tidak ditemukan; karena itu ejaan nama di controller, resolver, dan nama file perlu konsisten.

**5. Menyediakan entry point React dan Vite.** Fungsi `createInertiaApp()` menjalankan aplikasi Inertia. Di bagian `setup`, `createRoot(el)` membuat root React pada elemen yang disediakan template Blade, kemudian `<App {...props} />` memasang halaman dan props dari server. `vite.config.js` mendaftarkan `resources/js/app.tsx` dan `resources/css/app.css` sebagai input Vite, serta plugin React dan Tailwind. Template `resources/views/app.blade.php` memanggil input tersebut dengan `@vite` dan menyediakan elemen `@inertia` sebagai tempat halaman React dirender.

**6. Memasukkan file modul ke pemindaian Tailwind.** Tailwind perlu membaca file TSX modul untuk mengetahui class utility yang benar-benar dipakai. Sumber ini ditambahkan ke `resources/css/app.css`:

```css
@source '../../Modules/**/resources/js/**/*.tsx';
```

Pola glob tersebut mencakup file TSX di seluruh modul. Tanpa sumber itu, beberapa class yang hanya muncul di halaman modul mungkin tidak diikutkan ke CSS hasil build.

**7. Alur saat halaman dibuka.** Contoh ketika admin membuka halaman manajemen buku: browser meminta `/buku`; route memanggil `BukuController@index`; controller mengambil data dan memanggil `Inertia::render('Buku/index', props)`; Inertia mengirim nama halaman dan props; resolver mencari `Modules/Buku/resources/js/pages/index.tsx`; React merender komponen dengan props tersebut. Untuk anggota, route `/katalog` memakai controller yang sama, tetapi prop `canManage` bernilai `false` sehingga komponen menyembunyikan form dan tombol CRUD. Akses admin tetap dibatasi di backend oleh middleware route.

**8. Menjalankan frontend saat pengembangan.** Jalankan Vite bersama aplikasi Laravel agar perubahan TSX dan CSS diproses:

```bash
npm run dev
```

Untuk membuat asset statis yang siap dimuat tanpa dev server, gunakan `npm run build`. Pada praktik lokal, server Laravel juga harus berjalan (misalnya melalui `php artisan serve` atau skrip `composer run dev`). Jika muncul error halaman tidak ditemukan, periksa nama pada `Inertia::render()`, key di `moduleNames`, lokasi file TSX, dan output Vite.

### Tahap D: Authentication dan role pengguna

**1. Menambahkan kolom role.** Kolom `role` ditambahkan pada tabel `users` dengan nilai awal `user`. Migrasi tambahan menggunakan `Schema::hasColumn()` agar bisa dipakai pada database yang tabel `users`-nya sudah pernah dibuat.

**2. Membatasi role hasil registrasi.** Proses registrasi starter kit menetapkan role `user` di server, sehingga pilihan role tidak berasal dari input browser.

```php
$user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => 'user',
]);
```

**3. Membuat akun contoh.** Database seeder membuat satu admin dan satu user agar perbedaan menu dan hak akses dapat dicoba.

### Tahap E: Authorization dengan middleware role

**1. Membuat middleware.** Middleware memeriksa role pengguna yang sedang login. Jika role tidak sesuai, Laravel mengembalikan HTTP 403.

```php
public function handle(Request $request, Closure $next, string ...$roles): Response
{
    abort_unless(
        $request->user() && in_array($request->user()->role, $roles, true),
        403,
    );

    return $next($request);
}
```

**2. Mendaftarkan alias middleware.** Alias `role` didaftarkan pada `bootstrap/app.php`, lalu route admin menggunakan `role:admin` bersama middleware `auth`.

```php
$middleware->alias([
    'role' => \App\Http\Middleware\RoleMiddleware::class,
]);
```

**3. Menampilkan menu menurut role.** Role dibagikan sebagai shared props Inertia. Sidebar menampilkan menu Buku dan UserManagement untuk admin, sedangkan anggota mendapat Katalog Buku dan Peminjaman. Pemeriksaan route tetap dilakukan di backend, bukan hanya dengan menyembunyikan menu.

### Tahap F: CRUD Buku dengan Inertia

**1. Menentukan field dan validasi.** Data Buku terdiri dari `judul`, `penulis`, `penerbit`, `tahun_terbit`, dan `stok`. Form Request memeriksa semua field sebelum controller menyimpan perubahan.

**2. Membatasi route.** Route `/buku` untuk admin diproteksi oleh `auth` dan `role:admin`. Route `/katalog` hanya memerlukan login sehingga anggota dapat melihat daftar buku.

**3. Membuat form React.** Halaman Buku memakai `useForm()` untuk tambah dan ubah data.

```tsx
function submit(e: React.FormEvent) {
    e.preventDefault();
    const done = () => {
        form.reset();
        setEditing(null);
    };

    editing
        ? form.put(`/buku/${editing.id}`, { onSuccess: done })
        : form.post('/buku', { onSuccess: done });
}
```

Controller menerima parameter pencarian judul atau penulis dan mengembalikan hasil dengan pagination. Pesan validasi ditampilkan di dekat field yang bermasalah.

### Tahap G: CRUD Peminjaman menggunakan AJAX dan upload berkas

**1. Menentukan field dan validasi.** Data peminjaman mencakup `nama_peminjam`, `judul_buku`, `tanggal_pinjam`, `tanggal_kembali`, `status`, dan `bukti_path`. Form Request membatasi berkas ke JPG/JPEG/PNG/PDF maksimal 2 MB.

**2. Memuat dan mengubah data tanpa navigasi.** React mengambil daftar dari `GET /peminjaman/data` dan mengirim tambah, ubah, serta hapus melalui `fetch()`. Contoh pengiriman form:

```tsx
const body = new FormData();
Object.entries(form).forEach(([key, value]) => {
    if (value !== null && value !== '') {
        body.append(key, value as string | Blob);
    }
});

const response = await fetch('/peminjaman', {
    method: 'POST',
    headers: {
        Accept: 'application/json',
        'X-CSRF-TOKEN': csrfToken,
    },
    body,
});
```

Untuk edit, frontend menyertakan `_method=PUT` di `FormData`. CSRF token dibaca dari meta tag pada Blade. Berkas disimpan pada disk `public`; path-nya disimpan di kolom `bukti_path`. Saat berkas diganti, berkas lama dihapus; saat data dihapus, berkas terkait juga dihapus.

### Tahap H: CRUD UserManagement

Modul UserManagement dibatasi untuk admin. Form Request memvalidasi nama, email, password, dan role. Admin dapat menambah akun, mengubah informasi dan role, serta menghapus akun. Pemeriksaan backend menolak penghapusan akun sendiri dan penurunan role akun admin yang sedang digunakan.

### Tahap I: Menjalankan dan menguji melalui browser

**1. Menjalankan aplikasi.** Server Laravel dan Vite dapat dijalankan bersama:

```bash
composer run dev
```

**2. Memeriksa role.** Login sebagai admin dan user secara bergantian, lalu pastikan menu sidebar berbeda. Saat login sebagai user, buka `/buku` atau `/pengguna` secara langsung dan periksa bahwa halaman admin menghasilkan HTTP 403.

**3. Memeriksa AJAX.** Pada halaman Peminjaman, buka DevTools → Network → Fetch/XHR, kemudian tambah atau ubah transaksi. Request `GET /peminjaman/data` dan `POST /peminjaman` harus terlihat tanpa perpindahan halaman penuh.

**4. Memeriksa upload.** Unggah file JPG, PNG, atau PDF di bawah 2 MB. Buka tautan bukti, lalu periksa berkas pada `storage/app/public/bukti-peminjaman` dan path pada kolom `bukti_path` di phpMyAdmin. Uji pula file yang tidak sesuai format atau melebihi batas ukuran.

## 5. Rincian Kode yang Dibuat

Bagian ini menjelaskan file utama yang membentuk setiap fitur. Urutan penjelasan mengikuti aliran request: route menerima URL, Form Request memvalidasi input, controller memproses data, model menghubungkan aplikasi dengan tabel, lalu halaman React menampilkan hasilnya.

### 5.1 Struktur dan konfigurasi HMVC

**`composer.json` utama.** Bagian `extra.merge-plugin.include` memasukkan `Modules/*/composer.json` ke konfigurasi Composer. Dengan `recurse: true`, manifest modul juga dapat memuat manifest turunannya. `ignore-duplicates: true` mencegah peringatan saat definisi yang sama ditemukan. Di setiap manifest modul, `autoload.psr-4` memetakan namespace, misalnya `Modules\\Buku\\` ke direktori `app/`. Setelah mengubah pemetaan namespace, jalankan `composer dump-autoload` agar class controller, model, dan request dapat ditemukan.

**`modules_statuses.json` dan `module.json`.** File status menyimpan modul mana yang aktif. `module.json` menjadi metadata modul yang dibaca Laravel Modules. Struktur modul membagi kode berdasarkan fitur: route, controller, request, model, migration, dan halaman React tidak dicampur dengan fitur lain.

**`routes/web.php` utama.** Route halaman utama dan dashboard didaftarkan di sini. Di dalam kelompok `auth`, file route dari tiga modul dimuat menggunakan `require base_path(...)`. Artinya semua URL modul berada di middleware autentikasi yang sama; middleware role yang lebih khusus diterapkan pada route admin di file route masing-masing modul.

**`resources/js/app.tsx`.** Inertia membuat daftar halaman aplikasi utama (`appPages`) dan halaman modul (`modulePages`) dengan `import.meta.glob`. Resolver memeriksa awalan nama halaman. Nama seperti `Buku/index` diarahkan ke `Modules/Buku/resources/js/pages/index.tsx`; halaman yang bukan nama modul, misalnya `auth/login`, tetap diarahkan ke `resources/js/pages`. Daftar `moduleNames` membatasi nama modul yang boleh dipetakan.

**`resources/css/app.css`.** Direktif `@source '../../Modules/**/resources/js/**/*.tsx';` meminta Tailwind memindai class CSS yang digunakan komponen React di dalam semua modul. Tanpa sumber ini, class pada file modul dapat tidak ikut masuk ke CSS hasil build.

**`resources/views/app.blade.php`.** Template root Inertia memuat meta tag `csrf-token`, directive `@routes`, asset Vite, dan root `@inertia`. Meta token dibaca halaman Peminjaman untuk menyertakan perlindungan CSRF pada request `fetch()`.

### 5.2 Login, role, dan pembatasan akses

**`database/migrations/2026_01_01_000000_add_role_to_users_table.php`.** Migrasi memeriksa `Schema::hasColumn()` sebelum menambah kolom `role`. Kolom berupa string dengan nilai awal `user`; pengecekan mencegah penambahan ulang pada database yang kolomnya sudah ada. `down()` menghapus kolom saat migrasi dibatalkan.

**`app/Models/User.php`.** Field `role` dimasukkan ke `$fillable`, sehingga dapat disimpan melalui operasi mass assignment yang dikendalikan server. Password dan token tetap masuk `$hidden`; cast password menggunakan hash Laravel. Role tidak diberikan melalui formulir registrasi umum.

**`app/Http/Controllers/Auth/RegisteredUserController.php`.** Saat registrasi publik membuat akun, nilai role ditetapkan menjadi `user` dari sisi server. Dengan demikian pengguna tidak dapat membuat akun admin hanya dengan mengubah request browser.

**`app/Http/Middleware/RoleMiddleware.php`.** Method `handle()` memastikan ada pengguna login dan role pengguna cocok dengan salah satu role yang diizinkan. Jika kondisi salah, `abort_unless(..., 403)` menghentikan request dengan status Forbidden; jika benar, request diteruskan dengan `$next($request)`.

**`bootstrap/app.php`.** Alias `role` didaftarkan agar route dapat menulis middleware singkat `role:admin`. Middleware `HandleInertiaRequests` juga ditambahkan ke kelompok web supaya props bersama tersedia pada halaman Inertia.

**`app/Http/Middleware/HandleInertiaRequests.php`.** Method `share()` meneruskan data user yang sedang login, role, nama aplikasi, kutipan, dan pesan flash `success` ke React. Karena role tersedia sebagai prop, antarmuka dapat menyesuaikan tampilan dan menu. Pemeriksaan izin sebenarnya tetap berlangsung di middleware route dan Form Request.

**`Modules/Buku/routes/web.php` dan `Modules/UserManagement/routes/web.php`.** Route CRUD admin dibungkus `role:admin`. Route katalog `/katalog` hanya mewajibkan login karena seluruh file modul sudah dimuat di dalam kelompok `auth` pada route utama. User yang mencoba URL admin akan ditolak sebelum controller dijalankan.

### 5.3 Modul Buku: database, backend, dan React

**`Modules/Buku/database/migrations/2026_01_01_000001_create_buku_table.php`.** Migration membuat tabel `buku` dengan kolom id, judul, penulis, penerbit, tahun terbit, stok, serta timestamps. `tahun_terbit` memakai unsigned small integer dan `stok` memakai unsigned integer bernilai awal nol.

**`Modules/Buku/app/Models/Buku.php`.** Model menetapkan tabel secara eksplisit ke `buku` dan mendefinisikan lima field yang boleh diisi: judul, penulis, penerbit, tahun terbit, dan stok. Pengaturan ini menjadi penghubung operasi Eloquent dengan tabel katalog.

**`Modules/Buku/app/Http/Requests/BukuRequest.php`.** `authorize()` hanya mengizinkan admin. `rules()` mewajibkan judul, penulis, penerbit, tahun, dan stok; teks dibatasi panjangnya, tahun harus berada pada rentang 1000 hingga tahun depan, sedangkan stok tidak boleh negatif. Jika validasi gagal, Laravel mengembalikan error yang dapat ditampilkan Inertia pada form.

**`Modules/Buku/app/Http/Controllers/BukuController.php`.** `index()` mencari kecocokan pada judul atau penulis bila query `search` diisi, mengurutkan berdasarkan judul, membatasi hasil menjadi delapan item per halaman, dan mempertahankan query pencarian pada link pagination. Controller lalu merender halaman Inertia `Buku/index` beserta data buku, filter, dan flag `canManage`. `store()` membuat data dari hasil validasi; `update()` memperbarui model; `destroy()` menghapus model. Ketiganya mengirim pesan flash setelah berhasil.

**`Modules/Buku/routes/web.php`.** URL `/buku` dan operasi POST, PUT, DELETE berada dalam kelompok admin. URL `/katalog` memakai method index yang sama untuk tampilan baca. Karena controller mengirim `canManage`, halaman dapat menampilkan katalog sederhana untuk anggota dan form/aksi CRUD untuk admin.

**`Modules/Buku/resources/js/pages/index.tsx`.** Tipe `Book` dan `Page` mendeskripsikan data yang diterima dari Laravel. `useForm()` mengelola nilai input dan error validasi. Fungsi `start()` mengisi form kosong atau data buku yang akan diedit. Fungsi `submit()` memilih POST untuk tambah atau PUT untuk edit, lalu mengosongkan form jika berhasil. Pencarian memakai `router.get()` dan pagination memakai link Inertia. Bagian form dan kolom aksi hanya muncul saat `canManage` bernilai benar; tabel katalog tetap tampil untuk anggota.

### 5.4 Modul Peminjaman: AJAX dan berkas bukti

**`Modules/Peminjaman/database/migrations/2026_01_01_000002_create_peminjaman_table.php`.** Migration membuat field nama peminjam, judul buku, tanggal pinjam, tanggal kembali yang boleh kosong, status dengan nilai awal `Dipinjam`, dan `bukti_path` yang boleh kosong. `user_id` menjadi foreign key nullable ke tabel users dan menggunakan `nullOnDelete()`, sehingga data transaksi tidak otomatis ikut terhapus jika akun dihapus.

**`Modules/Peminjaman/app/Models/Peminjaman.php`.** Model menetapkan tabel `peminjaman`, daftar `$fillable`, cast tanggal ke format `Y-m-d`, dan relasi `user()` sebagai `belongsTo` ke model User. Relasi ini dipakai saat daftar transaksi dimuat.

**`Modules/Peminjaman/app/Http/Requests/PeminjamanRequest.php`.** Request mengizinkan pengguna yang sudah login. Nama dan judul wajib diisi; tanggal kembali boleh kosong tetapi tidak boleh sebelum tanggal pinjam; status hanya boleh `Dipinjam` atau `Dikembalikan`. Field bukti bersifat opsional dan dibatasi ke JPG/JPEG/PNG/PDF maksimal 2048 KB.

**`Modules/Peminjaman/app/Http/Controllers/PeminjamanController.php`.** `index()` membuka halaman Inertia. `list()` mengembalikan JSON transaksi dengan relasi nama user dan pagination sepuluh data. `store()` mengambil field tervalidasi selain file, menyimpan file ke disk `public` di folder `bukti-peminjaman`, menambahkan ID user login, lalu membalas JSON dengan status 201. `update()` hanya mengganti file jika file baru dikirim; sebelum menggantinya controller menghapus file lama. `destroy()` menghapus file terkait jika ada, lalu menghapus record. Operasi tulis di sini diizinkan bagi pengguna login, sesuai `authorize()` pada Form Request.

**`Modules/Peminjaman/routes/web.php`.** Route menyediakan halaman `/peminjaman`, endpoint JSON `GET /peminjaman/data`, serta endpoint POST, PUT, DELETE untuk data transaksi. Semua route memerlukan login dari kelompok route utama.

**`Modules/Peminjaman/resources/js/pages/index.tsx`.** State React menyimpan daftar transaksi, nilai form, id yang diedit, error, pesan, dan status proses. `load()` mengambil daftar lewat `fetch()` dan dipanggil pertama kali oleh `useEffect()`. Saat submit, field dan file disusun dalam `FormData`; saat edit, `_method=PUT` ditambahkan dan request dikirim sebagai POST agar upload multipart dapat diproses Laravel. Header `Accept: application/json` meminta respons JSON, sedangkan `X-CSRF-TOKEN` mengambil token dari meta tag Blade. Status 422 dipetakan ke pesan di bawah field. Jika berhasil, form direset dan daftar dimuat ulang. Fungsi `remove()` meminta konfirmasi, mengirim DELETE dengan token CSRF, lalu memuat ulang tabel. Link bukti dibentuk dari path yang disimpan sebagai `/storage/{bukti_path}`.

### 5.5 Modul UserManagement

**`Modules/UserManagement/routes/web.php`.** `Route::resource()` mendaftarkan endpoint index, store, update, dan destroy dalam kelompok admin. Parameter resource `pengguna` dipetakan ke nama parameter `user`; route create, show, dan edit dikecualikan karena form berada pada satu halaman React.

**`Modules/UserManagement/app/Http/Requests/UserRequest.php`.** Request memastikan aktor adalah admin. Nama, email, dan role wajib diisi; email harus unik kecuali untuk record yang sedang diedit; role hanya `admin` atau `user`. Password wajib dan minimal delapan karakter saat membuat akun, tetapi boleh kosong saat edit.

**`Modules/UserManagement/app/Http/Controllers/UserController.php`.** `index()` mengirim daftar pengguna terurut dan berpaginasi ke Inertia. `store()` memvalidasi lalu melakukan hash password sebelum membuat akun. `update()` mempertahankan password lama jika field password kosong dan mencegah admin menurunkan role akun sendiri. `destroy()` menolak penghapusan akun yang sedang dipakai; selain itu pengguna dapat dihapus dan pesan flash dikirim.

**`Modules/UserManagement/resources/js/pages/index.tsx`.** Halaman memakai `useForm()` untuk membuat dan mengedit akun, memilih role, menampilkan pesan validasi, serta mengirim POST/PUT melalui router Inertia. Tabel menandai akun yang sedang login, menyediakan tombol edit, dan meminta konfirmasi sebelum delete. Link pagination berpindah halaman melalui `router.visit()`.

### 5.6 Data contoh dan menjalankan aplikasi

**`database/seeders/DatabaseSeeder.php`.** `updateOrCreate()` menyiapkan akun admin dan anggota berdasarkan email, sehingga seeder dapat dijalankan ulang tanpa menggandakan akun. Laravel melakukan hashing password melalui cast pada model User. Loop berikutnya menambahkan lima koleksi contoh berdasarkan judul buku.

**Urutan menjalankan kode setelah konfigurasi.** `composer install` memasang package PHP dan `npm install` memasang package frontend. `composer dump-autoload` menyegarkan autoload modul. `php artisan migrate --seed` membuat tabel dan data awal, `php artisan storage:link` membuat tautan publik untuk file pada disk public, dan `composer run dev` menjalankan server pengembangan yang dikonfigurasi project.

## 6. Analisis dan Pembahasan

- **Penerapan HMVC.** Package `nwidart/laravel-modules` membantu membagi SiPustaka menjadi modul Buku, Peminjaman, dan UserManagement. Masing-masing modul memiliki route, controller, model, validasi, migration, dan halaman React sendiri. Pemisahan ini membuat tanggung jawab tiap fitur mudah dicari dan dikembangkan tanpa mencampur seluruh logika pada satu tempat.

- **Peran React dan Inertia.js.** Controller Laravel tetap mengatur request dan akses ke model, lalu `Inertia::render()` memilih halaman React dan mengirim data sebagai props. Inertia menghubungkan Laravel dengan React tanpa perlu membuat API terpisah untuk setiap halaman. Shared props juga dapat menyediakan data pengguna, role, dan pesan flash ke antarmuka.

- **Authentication dan authorization.** Authentication memastikan pengguna memiliki sesi login yang sah. Authorization menentukan tindakan yang boleh dilakukan setelah identitasnya diketahui. Karena itu, aplikasi menggunakan `auth` untuk mewajibkan login dan middleware `role:admin` untuk route tertentu. Menu yang tidak ditampilkan pada sidebar bukan pengganti perlindungan route.

- **Cara kerja middleware role.** Middleware membaca role dari pengguna yang login sebelum controller dijalankan. Jika role tidak cocok, proses dihentikan dengan HTTP 403. Dengan demikian user yang mengetik URL admin secara langsung tetap tidak dapat membuka halaman tersebut.

- **Perbedaan CRUD Inertia dan CRUD AJAX.** CRUD Buku menggunakan `useForm()` milik Inertia. Form mengikuti alur request Laravel dan error validasi tersedia pada state form. CRUD Peminjaman memakai `fetch()` dan JSON; data tabel dimuat atau diperbarui tanpa reload penuh. Respons 422 ditangani frontend dengan membaca objek `errors` dan menampilkan pesan di bawah field terkait.

- **Alasan menggunakan `FormData`.** `FormData` dapat mengirim field teks bersama isi file dalam satu request multipart. Browser mengatur boundary multipart secara otomatis, sehingga kode tidak perlu menentukan header `Content-Type` sendiri. CSRF token tetap dikirim melalui header agar request AJAX berbasis session Laravel dapat divalidasi.

- **Penyimpanan dan penghapusan berkas.** Berkas disimpan di disk `public` supaya dapat dibuka melalui tautan `/storage/...`. Database menyimpan path relatif, bukan isi file. Ketika file diganti atau transaksi dihapus, file sebelumnya ikut dihapus agar storage tidak menyimpan berkas yatim.

- **Class modul tidak ditemukan.** Route pernah gagal menemukan controller dengan namespace `Modules\\...` karena autoload Composer belum diperbarui. Namespace PSR-4 ditambahkan ke manifest modul dan Composer Merge Plugin, lalu autoload dibuat ulang menggunakan `composer dump-autoload`.

- **Halaman React kosong atau tidak ditemukan.** Resolver awal memperlakukan semua nama dengan `/` sebagai nama modul. Akibatnya halaman starter kit seperti `auth/login` diarahkan ke lokasi yang keliru. Resolver kemudian dibatasi hanya untuk nama modul yang terdaftar; halaman lainnya tetap dicari di `resources/js/pages`.

- **Style halaman modul tidak muncul.** Tailwind tidak otomatis memindai file TSX di luar folder halaman utama. Baris `@source '../../Modules/**/resources/js/**/*.tsx';` ditambahkan ke `app.css`, kemudian asset Vite dibangun kembali.

- **Asset tidak termuat setelah Vite berhenti.** File `public/hot` yang tertinggal menunjuk ke dev server yang sudah tidak berjalan. File tersebut dihapus agar Laravel memakai asset production dari `public/build/manifest.json`; browser perlu dimuat ulang tanpa cache setelah perubahan.

- **Error 419, 422, dan 403.** Error 419 dapat terjadi jika CSRF token atau session tidak ikut pada request AJAX; solusinya mengirim token dan memakai session browser yang sama. Error 422 menandakan validasi gagal dan frontend menampilkan pesan dari respons JSON. Error 403 pada route admin adalah hasil yang benar ketika user mencoba mengakses fitur yang hanya untuk admin.

- **Pail pada Windows.** Log XAMPP menunjukkan Pail memerlukan ekstensi `pcntl` yang tidak tersedia pada PHP Windows. Perintah Pail dihapus dari skrip `composer run dev` supaya Laravel, queue worker, dan Vite dapat dijalankan tanpa kegagalan tersebut.

## 7. Kesimpulan

SiPustaka berhasil menerapkan pemisahan fitur dengan HMVC serta menampilkan halaman modul menggunakan React. CRUD Buku menunjukkan penggunaan Inertia untuk form dan pagination, sedangkan CRUD Peminjaman menunjukkan penggunaan AJAX untuk memperbarui data tanpa navigasi penuh dan `FormData` untuk upload file. Praktikum ini juga memperjelas perbedaan authentication dan authorization, serta pentingnya middleware, validasi, CSRF, dan pengelolaan file agar fitur dapat digunakan sesuai role dengan aman.
