<?php

use Illuminate\Support\Facades\Route;
use Modules\Peminjaman\Http\Controllers\PeminjamanController;

Route::middleware(['auth', 'role:admin,user'])
    ->prefix('peminjaman')
    ->name('peminjaman.')
    ->group(function () {

        Route::get('/', [PeminjamanController::class, 'index'])
            ->name('index');

        Route::get('/data', [PeminjamanController::class, 'data'])
            ->name('data');

        Route::post('/', [PeminjamanController::class, 'store'])
            ->name('store');

        Route::get('/{id}', [PeminjamanController::class, 'show'])
            ->name('show');

        Route::put('/{id}', [PeminjamanController::class, 'update'])
            ->name('update');

        Route::delete('/{id}', [PeminjamanController::class, 'destroy'])
            ->name('destroy');
    });
