<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('dashboard.index');
});


// LOGIN
Route::get('/login', function () {
    return view('auth.login');
});


// PROFILE
Route::get('/profile', function () {
    return view('profile.index');
});


// SURAT
// SURAT

Route::get('/surat/inbox', function () {
    return view('surat.inbox');
});


Route::get('/surat/draft', function () {
    return view('surat.draft');
});


Route::get('/surat/baru', function () {
    return view('surat.baru');
});


Route::get('/surat/terkirim', function () {
    return view('surat.terkirim');
});


Route::get('/surat/approval', function () {
    return view('surat.approval');
});


Route::get('/surat/disposisi', function () {
    return view('surat.disposisi');
});


Route::get('/surat/arsip', function () {
    return view('surat.arsip');
});

Route::get('/user', function () {
    return view('user.index');
});