<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    require base_path('Modules/Buku/routes/web.php');
    require base_path('Modules/Peminjaman/routes/web.php');
    require base_path('Modules/UserManagement/routes/web.php');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
