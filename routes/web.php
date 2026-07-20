<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DisposisiController;



// ==========================
// HALAMAN AWAL
// ==========================


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/





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
}); //

Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================
// DASHBOARD
// ==========================

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// ==========================
// AUTHENTICATION
// ==========================

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// ==========================
// USER MANAGEMENT
// ==========================

Route::get('/users', [UserController::class, 'index'])
    ->middleware('permission:user.view')
    ->name('users.index');

Route::get('/users/create', [UserController::class, 'create'])
    ->middleware('permission:user.create')
    ->name('users.create');

Route::post('/users', [UserController::class, 'store'])
    ->middleware('permission:user.create')
    ->name('users.store');

Route::get('/users/{user}/edit', [UserController::class, 'edit'])
    ->middleware('permission:user.edit')
    ->name('users.edit');

Route::put('/users/{user}', [UserController::class, 'update'])
    ->middleware('permission:user.edit')
    ->name('users.update');

Route::delete('/users/{user}', [UserController::class, 'destroy'])
    ->middleware('permission:user.delete')
    ->name('users.destroy');


// ==========================
// UNIT KERJA
// ==========================

Route::resource('unit-kerja', UnitKerjaController::class)
    ->except(['show'])
    ->middleware('permission:master.view');


// ==========================
// JABATAN
// ==========================

Route::resource('jabatan', JabatanController::class)
    ->except(['show'])
    ->middleware('permission:master.view');


// ==========================
// ROLE
// ==========================

Route::resource('role', RoleController::class)
    ->except(['show'])
    ->middleware('permission:master.view');


// ==========================
// PERMISSION
// ==========================

Route::resource('permission', PermissionController::class)
    ->except(['show'])
    ->middleware('permission:master.view');


// ==========================
// PROFILE
// ==========================

Route::get('/profile', function () {
    return view('profile.index');
});


// ==========================
// HALAMAN SURAT
// ==========================

// Kotak Masuk
Route::get('/surat/inbox', [SuratController::class, 'inboxWeb'])
    ->name('surat.inbox');

// Draft
Route::get('/surat/draft', [SuratController::class, 'draftWeb'])
    ->name('surat.draft');

// Buat Surat
Route::get('/surat/baru', function () {
    return view('surat.baru');
})->name('surat.create');

// Surat Terkirim
Route::get('/surat/terkirim', [SuratController::class, 'sent'])
    ->name('surat.sent');

// Approval
Route::get('/surat/approval', function () {
    return view('surat.approval');
});

// Disposisi

// Arsip


Route::get('/surat/draft', function () {
    return view('surat.draft');
})->name('surat.draft');

Route::get('/surat/baru', function () {
    return view('surat.baru');
});

Route::get('/surat/terkirim', function () {
    return view('surat.terkirim');
});

Route::get('/surat/approval', [ApprovalController::class, 'index'])
    ->name('surat.approval');

Route::get('/surat/disposisi', function () {
    return view('surat.disposisi');
});

Route::get('/surat/arsip', [SuratController::class, 'archiveWeb'])
    ->name('surat.arsip');


// ==========================
// SURAT CONTROLLER
// ==========================
Route::get(
    '/surat/{id}/detail',
    [SuratController::class,'showWeb']
)->whereNumber('id')
->name('surat.detail');

Route::resource('surat', SuratController::class)
    ->whereNumber('surat');

Route::get('/surat/{id}/detail',
    [SuratController::class, 'showWeb']
)->whereNumber('id')
 ->name('surat.detail');

Route::post('/surat/{id}/submit',
    [SuratController::class, 'submit']
)->whereNumber('id')
->name('surat.submit');


Route::put('/surat/{id}/archive',
    [SuratController::class, 'archive']
)->whereNumber('id')
->name('surat.archive');


Route::get('/archive',
    [SuratController::class, 'archiveList']
)->name('surat.archive.list');


Route::get('/sent',
    [SuratController::class, 'sent']
)->name('surat.sent');




// ==========================
// INBOX
// ==========================


// ==========================
// APPROVAL
// ==========================

Route::post('/approval/kpp/{id}',
    [ApprovalController::class,'approveKpp']
);

Route::post('/approval/kpp/{id}/reject',
    [ApprovalController::class,'rejectKpp']
);

Route::post('/approval/ktu/{id}',
    [ApprovalController::class,'approveKtu']
);

Route::post('/approval/ktu/{id}/reject',
    [ApprovalController::class,'rejectKtu']
);

Route::post('/approval/kepala-stasiun/{id}',
    [ApprovalController::class,'approveKepalaStasiun']
);

Route::post('/approval/kepala-stasiun/{id}/reject',
    [ApprovalController::class,'rejectKepalaStasiun']
);


// ==========================
// DISPOSISI
// ==========================
Route::get(
    '/surat/disposisi',
    [DisposisiController::class, 'indexWeb']
)->name('surat.disposisi.index');

Route::get('/surat/{id}/disposisi', [DisposisiController::class, 'showWeb'])
    ->whereNumber('id')
    ->name('surat.disposisi');

Route::post(
    '/surat/disposisi/store',
    [DisposisiController::class, 'storeWeb']
)->name('surat.disposisi.store');

Route::get('/disposisi',
    [DisposisiController::class,'index']
);

Route::post('/disposisi',
    [DisposisiController::class,'store']
);

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