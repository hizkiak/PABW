<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Buku\Models\Buku;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(['email' => 'admin@sipustaka.test'], ['name' => 'Admin SiPustaka', 'password' => 'password', 'role' => 'admin']);
        User::updateOrCreate(['email' => 'user@sipustaka.test'], ['name' => 'Anggota SiPustaka', 'password' => 'password', 'role' => 'user']);
        foreach ([['Laskar Pelangi','Andrea Hirata','Bentang Pustaka',2005,5],['Bumi Manusia','Pramoedya Ananta Toer','Hasta Mitra',1980,3],['Laut Bercerita','Leila S. Chudori','Kepustakaan Populer Gramedia',2017,4],['Pulang','Tere Liye','Republika',2015,6],['Filosofi Teras','Henry Manampiring','Kompas',2018,2]] as [$judul,$penulis,$penerbit,$tahun,$stok]) Buku::updateOrCreate(['judul'=>$judul],compact('judul','penulis','penerbit')+['tahun_terbit'=>$tahun,'stok'=>$stok]);
    }
}
