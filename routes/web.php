<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DisposisiController;


Route::get('/', function () {
    return view('dashboard.index');
});

// Resource Surat
Route::resource('surat', SuratController::class);

// Draft
Route::get('/draft', [SuratController::class, 'draft'])
    ->name('surat.draft');

// Submit Draft
Route::post('/surat/{id}/submit', [SuratController::class, 'submit'])
    ->name('surat.submit');

// Inbox KPP
Route::get('/inbox', [SuratController::class, 'inbox'])
    ->name('surat.inbox');

// Approval KPP
Route::post('/approval/kpp/{id}', [ApprovalController::class, 'approveKpp']);
Route::post('/approval/kpp/{id}/reject', [ApprovalController::class, 'rejectKpp']);

// Approval KTU
Route::post('/approval/ktu/{id}', [ApprovalController::class, 'approveKtu']);
Route::post('/approval/ktu/{id}/reject', [ApprovalController::class, 'rejectKtu']);

// Approval Kepala Stasiun
Route::post('/approval/kepala-stasiun/{id}', [ApprovalController::class, 'approveKepalaStasiun']);
Route::post('/approval/kepala-stasiun/{id}/reject', [ApprovalController::class, 'rejectKepalaStasiun']);

// testing
Route::get('/testing/approve-kpp/{id}', [ApprovalController::class, 'approveKpp']);
Route::get('/testing/approve-ktu/{id}', [ApprovalController::class, 'approveKtu']);
Route::get('/testing/approve-kepala-stasiun/{id}', [ApprovalController::class, 'approveKepalaStasiun']);

//inbox ktu
Route::get('/inbox/ktu', [SuratController::class, 'inboxKtu'])
    ->name('surat.inbox.ktu');

//inbox kepala stasiun
Route::get('/inbox/kepala-stasiun', 
[SuratController::class, 'inboxKepalaStasiun'])
->name('surat.inbox.kepala');

//disposisi
Route::get('/disposisi',
    [DisposisiController::class,'index']);

Route::post('/disposisi',
    [DisposisiController::class,'store']);

Route::get('/disposisi/inbox/{userId}',
    [DisposisiController::class,'inbox']);

Route::get('/disposisi/{id}',
    [DisposisiController::class,'show']);

Route::put('/disposisi/{id}/read',
    [DisposisiController::class,'read']);
Route::put('/disposisi/{id}/finish',
    [DisposisiController::class,'finish']);
Route::get('/sent', [SuratController::class, 'sent'])
    ->name('surat.sent');
Route::put('/surat/{id}/archive', [SuratController::class, 'archive'])
    ->name('surat.archive');
Route::get('/archive', [SuratController::class, 'archiveList'])
    ->name('surat.archive.list');

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
