<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporBanjirController extends Controller
{
    private $defaultLaporan = [
        ['nama' => 'Jackson Lubis', 'lokasi' => 'Kecamatan Dayeuhkolot', 'tinggi' => 25],
        ['nama' => 'Siti Sitanggang', 'lokasi' => 'Kecamatan Baleendah', 'tinggi' => 50],
        ['nama' => 'Younglex Butar-butar', 'lokasi' => 'Kecamatan Bojongsoang', 'tinggi' => 85],
    ];
    
    public function index()
    {
        $laporanList = session('laporanList', $this->defaultLaporan);
        return view('laporan.index', compact('laporanList'));
    }
    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $newLaporan = [
            'nama' => $request->input('nama', 'Pelapor Tanpa Nama'),
            'lokasi' => $request->input('lokasi', 'Lokasi Tidak Diisi'),
            'tinggi' => (int) $request->input('tinggi', 0),
        ];

        if ($request->isMethod('post')) {
            $currentList = session('laporanList', $this->defaultLaporan);
            array_unshift($currentList, $newLaporan);
            session(['laporanList' => $currentList]);
        }

        return view('laporan.konfirmasi', ['data' => $newLaporan]);
    }
}