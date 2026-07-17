<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('dashboard.index');
});
// ==========================
// HALAMAN DASHBOARD
// ==========================

Route::get('/', 
    [DashboardController::class,'index']
)->name('dashboard');


// ==========================
// AUTH
// ==========================

Route::get('/login', function () {
    return view('auth.login');
});


// ==========================
// PROFILE
// ==========================

Route::get('/profile', function () {
    return view('profile.index');
});


// ==========================
// HALAMAN SURAT (BLADE)
// ==========================

Route::get('/surat/inbox', function () {
    return view('surat.inbox');
})->name('surat.inbox');


Route::get('/surat/draft', function () {
    return view('surat.draft');
})->name('surat.draft');


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


// ==========================
// SURAT API / CONTROLLER
// ==========================


// Resource harus PALING BAWAH
Route::resource('surat', SuratController::class)
    ->whereNumber('surat');


// Submit Draft
Route::post('/surat/{id}/submit',
    [SuratController::class,'submit']
)->whereNumber('id')
->name('surat.submit');


// Arsip Surat
Route::put('/surat/{id}/archive',
    [SuratController::class,'archive']
)->whereNumber('id')
->name('surat.archive');


// List Arsip
Route::get('/archive',
    [SuratController::class,'archiveList']
)->name('surat.archive.list');


// Surat Terkirim
Route::get('/sent',
    [SuratController::class,'sent']
)->name('surat.sent');



// ==========================
// INBOX
// ==========================

Route::get('/inbox',
    [SuratController::class,'inboxWeb']
)->name('surat.inbox.web');


Route::get('/inbox/ktu',
    [SuratController::class,'inboxKtu']
)->name('surat.inbox.ktu');


Route::get('/inbox/kepala-stasiun',
    [SuratController::class,'inboxKepalaStasiun']
)->name('surat.inbox.kepala');



// ==========================
// APPROVAL
// ==========================

Route::post('/approval/kpp/{id}',
    [ApprovalController::class,'approveKpp']
)->whereNumber('id');


Route::post('/approval/kpp/{id}/reject',
    [ApprovalController::class,'rejectKpp']
)->whereNumber('id');


Route::post('/approval/ktu/{id}',
    [ApprovalController::class,'approveKtu']
)->whereNumber('id');


Route::post('/approval/ktu/{id}/reject',
    [ApprovalController::class,'rejectKtu']
)->whereNumber('id');


Route::post('/approval/kepala-stasiun/{id}',
    [ApprovalController::class,'approveKepalaStasiun']
)->whereNumber('id');


Route::post('/approval/kepala-stasiun/{id}/reject',
    [ApprovalController::class,'rejectKepalaStasiun']
)->whereNumber('id');



// TESTING APPROVAL

Route::get('/testing/approve-kpp/{id}',
    [ApprovalController::class,'approveKpp']
)->whereNumber('id');


Route::get('/testing/approve-ktu/{id}',
    [ApprovalController::class,'approveKtu']
)->whereNumber('id');


Route::get('/testing/approve-kepala-stasiun/{id}',
    [ApprovalController::class,'approveKepalaStasiun']
)->whereNumber('id');



// ==========================
// DISPOSISI
// ==========================

Route::get('/disposisi',
    [DisposisiController::class,'index']
);


Route::post('/disposisi',
    [DisposisiController::class,'store']
);


// harus sebelum /disposisi/{id}
Route::get('/disposisi/inbox/{userId}',
    [DisposisiController::class,'inbox']
)->whereNumber('userId');


Route::put('/disposisi/{id}/read',
    [DisposisiController::class,'read']
)->whereNumber('id');


Route::put('/disposisi/{id}/finish',
    [DisposisiController::class,'finish']
)->whereNumber('id');


Route::get('/disposisi/{id}',
    [DisposisiController::class,'show']
)->whereNumber('id');



// USER

Route::get('/user', function () {
    return view('user.index');
});