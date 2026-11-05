<?php

namespace Modules\Buku\Database\Seeders;

use Modules\Buku\Models\Buku;
use Illuminate\Database\Seeder;

class BukuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            ['Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 8],
            ['Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1980, 5],
            ['Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia', 2009, 6],
            ['Ronggeng Dukuh Paruk', 'Ahmad Tohari', 'Gramedia', 1982, 4],
            ['Perahu Kertas', 'Dee Lestari', 'Bentang Pustaka', 2009, 7],
        ] as [$judul, $penulis, $penerbit, $tahun, $stok]) {
            Buku::firstOrCreate(['judul' => $judul], [
                'penulis' => $penulis, 'penerbit' => $penerbit,
                'tahun_terbit' => $tahun, 'stok' => $stok,
            ]);
        }
    }
}
