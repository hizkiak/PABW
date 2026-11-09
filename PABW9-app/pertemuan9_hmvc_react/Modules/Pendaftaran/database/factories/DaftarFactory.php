<?php

namespace Modules\Pendaftaran\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Pendaftaran\Models\Daftar;

class DaftarFactory extends Factory
{
    protected $model = Daftar::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'asal_sekolah' => 'SMA '.fake()->city(),
            'prodi_tujuan' => fake()->randomElement(['Informatika', 'Sistem Informasi', 'Teknik Elektro']),
            'email' => fake()->unique()->safeEmail(),
            'no_hp' => fake()->numerify('08##########'),
        ];
    }
}
