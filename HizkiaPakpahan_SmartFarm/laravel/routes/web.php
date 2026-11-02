<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmartFarmController;

Route::get('/', [SmartFarmController::class, 'index'])
    ->name('smartfarm.index');

Route::get('/home', [SmartFarmController::class, 'index'])
    ->name('home');

Route::get('/form', [SmartFarmController::class, 'form'])
    ->name('smartfarm.form');

Route::post('/hasil', [SmartFarmController::class, 'store'])
    ->name('smartfarm.store');

Route::get('/riwayat', [SmartFarmController::class, 'riwayat'])
    ->name('smartfarm.riwayat');

Route::get('/tentang', [SmartFarmController::class, 'tentang'])
    ->name('smartfarm.tentang');
