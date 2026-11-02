<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function formulir()
    {
        return view('formulir');
    }

    public function inputdata(Request $requestdata)
    {
        $Nama = $requestdata->input('Nama');
        $NIM = $requestdata->input('NIM');
        $Email = $requestdata->input('Email');
        $Programstudi = $requestdata->input('Programstudi');

        return view('formulir', compact('Nama', 'NIM', 'Email', 'Programstudi'));
    }
}
