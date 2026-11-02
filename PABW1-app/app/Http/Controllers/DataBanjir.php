<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataBanjir extends Controller
{
    public function form()
    {
        return view('FormBanjir');
    }

    public function proses(Request $request)
    {
        $data = $request->validate([
            'nama_pelapor' => ['required', 'string', 'max:100'],
            'lokasi' => ['required', 'string', 'max:150'],
            'tanggal' => ['required', 'date'],
            'tinggi_air' => ['required', 'numeric', 'min:0', 'max:1000'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        $tinggiAir = (float) $data['tinggi_air'];

        if ($tinggiAir >= 150) {
            $status = 'Darurat';
            $rekomendasi = 'Segera koordinasi evakuasi warga dan hubungi petugas penanggulangan bencana.';
        } elseif ($tinggiAir >= 80) {
            $status = 'Waspada';
            $rekomendasi = 'Pantau kenaikan air, siapkan barang penting, dan laporkan jika air terus naik.';
        } elseif ($tinggiAir >= 30) {
            $status = 'Siaga';
            $rekomendasi = 'Amankan area rendah dan periksa saluran air di sekitar lokasi.';
        } else {
            $status = 'Aman';
            $rekomendasi = 'Kondisi masih terkendali, tetap lakukan pemantauan berkala.';
        }

        return view('hasilbanjir', [
            'laporan' => $data,
            'status' => $status,
            'rekomendasi' => $rekomendasi,
        ]);
    }
}
