<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CobaController;
use App\Http\Controllers\DataBanjir;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/coba', [CobaController::class, 'index']);

Route::get('/final', function () {
    return view('home');
});

Route::get('/FormBanjir', [DataBanjir::class, 'form'])->name('banjir.form');
Route::post('/FormBanjir', [DataBanjir::class, 'proses'])->name('banjir.store');
