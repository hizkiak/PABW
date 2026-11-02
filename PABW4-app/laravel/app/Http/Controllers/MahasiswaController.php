<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    // Tamppilkan form input
    public function form()
    {
        return view('form');
    }

    // Simpan data dari form
    public function simpan(Request $request)
    {
        Mahasiswa::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'jurusan' => $request->jurusan,
            'umur' => $request->umur
        ]);

        return "Data Mahasiswa berhasil disimpan!";
    }

    // Tampilkan daftar mahasiswa
    public function daftar()
    {
        $data = Mahasiswa::all();
        return view('mahasiswa', ['mahasiswa' => $data]);
    }
}
