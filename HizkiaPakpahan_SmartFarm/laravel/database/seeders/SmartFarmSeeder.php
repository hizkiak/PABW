<?php

namespace Database\Seeders;

use App\Models\SmartFarm;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class SmartFarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $lokasiOptions = ['Singaparna', 'Ciawi', 'Manonjaya'];
        $tanamanOptions = ['Cabai', 'Tomat', 'Selada', 'Pakcoi', 'Bayam', 'Mentimun'];

        for ($i = 1; $i <= 20; $i++) {
            SmartFarm::create([
                'lokasi' => $faker->randomElement($lokasiOptions),
                'nama_tanaman' => $faker->randomElement($tanamanOptions),
                'kelembapan_tanah' => $faker->numberBetween(20, 95),
                'suhu_udara' => $faker->numberBetween(22, 36),
                'kelembapan_udara' => $faker->numberBetween(45, 90),
            ]);
        }
    }
}
