<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


// Halaman utama langsung ke dashboard admin

Route::redirect('/', '/admin/dashboard');



/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/


Route::prefix('admin')->group(function () {


    // Dashboard

    Route::view('/dashboard', 'admin.dashboard')
        ->name('admin.dashboard');



    // Kelola User

    Route::view('/users', 'admin.users')
        ->name('admin.users');



    // Template Surat

    Route::view('/template-surat', 'admin.template-surat')
        ->name('admin.template');



    // Nomor Surat

    Route::view('/nomor-surat', 'admin.nomor-surat')
        ->name('admin.nomor');



    // Laporan

    Route::view('/laporan', 'admin.laporan')
        ->name('admin.laporan');



    // Grafik

    Route::view('/grafik', 'admin.grafik')
        ->name('admin.grafik');



    // Arsip

    Route::view('/arsip', 'admin.arsip')
        ->name('admin.arsip');



    // Monitoring

    Route::view('/monitoring', 'admin.monitoring')
        ->name('admin.monitoring');



    // Setting

    Route::view('/setting', 'admin.setting')
        ->name('admin.setting');


});