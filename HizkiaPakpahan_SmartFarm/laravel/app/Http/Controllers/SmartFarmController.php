<?php

namespace App\Http\Controllers;

use App\Models\SmartFarm;
use Illuminate\Http\Request;

class SmartFarmController extends Controller
{
    public function index()
    {
        $data = SmartFarm::latest()->take(5)->get();
        $totalData = SmartFarm::count();
        $rataKelembapanTanah = round((float) SmartFarm::avg('kelembapan_tanah'), 1);
        $rataSuhuUdara = round((float) SmartFarm::avg('suhu_udara'), 1);
        $rataKelembapanUdara = round((float) SmartFarm::avg('kelembapan_udara'), 1);

        return view('home', compact(
            'data',
            'totalData',
            'rataKelembapanTanah',
            'rataSuhuUdara',
            'rataKelembapanUdara'
        ));
    }

    public function form()
    {
        return view('smartfarm.form');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lokasi' => 'required|string|max:255',
            'nama_tanaman' => 'required|string|max:255',
            'kelembapan_tanah' => 'required|integer',
            'suhu_udara' => 'required|integer',
            'kelembapan_udara' => 'required|integer',
        ]);

        SmartFarm::create($validatedData);

        return redirect()
            ->route('smartfarm.riwayat')
            ->with('success', 'Data monitoring SmartFarm berhasil disimpan.');
    }

    public function riwayat()
    {
        $data = SmartFarm::latest()->get();

        return view('smartfarm.riwayat', compact('data'));
    }

    public function tentang()
    {
        return view('tentang');
    }
}
