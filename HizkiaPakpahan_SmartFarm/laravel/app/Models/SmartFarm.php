<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmartFarm extends Model
{
    protected $table = 'smart_farms';

    protected $fillable = [
        'lokasi',
        'nama_tanaman',
        'kelembapan_tanah',
        'suhu_udara',
        'kelembapan_udara',
    ];

    public function getKategoriAttribute(): string
    {
        return self::kategoriDariKelembapan($this->kelembapan_tanah);
    }

    public function getRekomendasiAttribute(): string
    {
        return self::rekomendasiDariKelembapan($this->kelembapan_tanah);
    }

    public static function kategoriDariKelembapan(int $nilai): string
    {
        if ($nilai < 35) {
            return 'Kering';
        }

        if ($nilai < 75) {
            return 'Normal';
        }

        return 'Basah';
    }

    public static function rekomendasiDariKelembapan(int $nilai): string
    {
        if ($nilai < 35) {
            return 'Lakukan penyiraman tambahan.';
        }

        if ($nilai < 75) {
            return 'Pertahankan jadwal perawatan lahan.';
        }

        return 'Hentikan penyiraman sementara dan cek drainase.';
    }
}
