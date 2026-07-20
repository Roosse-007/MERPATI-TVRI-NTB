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



/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/


Route::get('/', function () {

    return redirect()->route('login');

});





/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/


Route::get('/login',

    [AuthController::class,'showLogin']

)->name('login');




Route::post('/login',

    [AuthController::class,'login']

)->name('login.process');




Route::post('/logout',

    [AuthController::class,'logout']

)->name('logout');








/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/


Route::get('/dashboard',

    [DashboardController::class,'index']

)
->middleware('auth')
->name('dashboard');










/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/


Route::prefix('admin')->group(function(){



    Route::view('/dashboard',
        'admin.dashboard'
    )
    ->name('admin.dashboard');



    Route::view('/users',
        'admin.users'
    )
    ->name('admin.users');



    Route::view('/template-surat',
        'admin.template-surat'
    )
    ->name('admin.template');



    Route::view('/nomor-surat',
        'admin.nomor-surat'
    )
    ->name('admin.nomor');



    Route::view('/laporan',
        'admin.laporan'
    )
    ->name('admin.laporan');



    Route::view('/grafik',
        'admin.grafik'
    )
    ->name('admin.grafik');



    Route::view('/arsip',
        'admin.arsip'
    )
    ->name('admin.arsip');



    Route::view('/monitoring',
        'admin.monitoring'
    )
    ->name('admin.monitoring');



    Route::view('/setting',
        'admin.setting'
    )
    ->name('admin.setting');



});









/*
|--------------------------------------------------------------------------
| USER MANAGEMENT
|--------------------------------------------------------------------------
*/


Route::resource('users',

    UserController::class

)
->middleware('auth');







/*
|--------------------------------------------------------------------------
| MASTER DATA
|--------------------------------------------------------------------------
*/


Route::resource('unit-kerja',

    UnitKerjaController::class

)
->middleware('auth');




Route::resource('jabatan',

    JabatanController::class

)
->middleware('auth');




Route::resource('role',

    RoleController::class

)
->middleware('auth');




Route::resource('permission',

    PermissionController::class

)
->middleware('auth');









/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/


Route::get('/profile',function(){

    return view('profile.index');

})
->middleware('auth');









/*
|--------------------------------------------------------------------------
| SURAT
|--------------------------------------------------------------------------
*/


// halaman buat surat baru

Route::get('/surat/create',

    [SuratController::class,'create']

)
->middleware('auth')
->name('surat.create');





// simpan surat sebagai draft

Route::post('/surat',

    [SuratController::class,'store']

)
->middleware('auth')
->name('surat.store');







// daftar draft

Route::get('/surat/draft',

    [SuratController::class,'draft']

)
->middleware('auth')
->name('surat.draft');







// edit draft

Route::get('/surat/{id}/edit',

    [SuratController::class,'edit']

)
->middleware('auth')
->name('surat.edit');







// update draft

Route::put('/surat/{id}',

    [SuratController::class,'update']

)
->middleware('auth')
->name('surat.update');







// hapus draft

Route::delete('/surat/{id}',

    [SuratController::class,'destroy']

)
->middleware('auth')
->name('surat.destroy');







// kirim surat

Route::post('/surat/{id}/submit',

    [SuratController::class,'submit']

)
->middleware('auth')
->name('surat.submit');




// halaman buat surat baru

Route::get('/surat/baru',

[SuratController::class,'create']

)
->middleware('auth')
->name('surat.baru');


// detail surat

Route::get('/surat/{id}',

    [SuratController::class,'show']

)
->middleware('auth')
->whereNumber('id')
->name('surat.show');









/*
|--------------------------------------------------------------------------
| INBOX
|--------------------------------------------------------------------------
*/


Route::get('/inbox',

    [SuratController::class,'inboxWeb']

)
->middleware('auth')
->name('surat.inbox.web');







/*
|--------------------------------------------------------------------------
| TERKIRIM
|--------------------------------------------------------------------------
*/


Route::get('/surat/terkirim',

function(){

    return view('surat.terkirim');

})
->middleware('auth')
->name('surat.terkirim');








/*
|--------------------------------------------------------------------------
| APPROVAL PAGE
|--------------------------------------------------------------------------
*/


Route::get('/surat/approval',

function(){

    return view('surat.approval');

})
->middleware('auth')
->name('surat.approval');








/*
|--------------------------------------------------------------------------
| ARSIP
|--------------------------------------------------------------------------
*/


Route::get('/surat/arsip',

function(){

    return view('surat.arsip');

})
->middleware('auth')
->name('surat.arsip');








/*
|--------------------------------------------------------------------------
| ARCHIVE
|--------------------------------------------------------------------------
*/


Route::put('/surat/{id}/archive',

    [SuratController::class,'archive']

)
->middleware('auth')
->name('surat.archive');




Route::get('/archive',

    [SuratController::class,'archiveList']

)
->middleware('auth')
->name('surat.archive.list');








/*
|--------------------------------------------------------------------------
| SENT
|--------------------------------------------------------------------------
*/


Route::get('/sent',

    [SuratController::class,'sent']

)
->middleware('auth')
->name('surat.sent');









/*
|--------------------------------------------------------------------------
| APPROVAL ACTION
|--------------------------------------------------------------------------
*/


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









/*
|--------------------------------------------------------------------------
| DISPOSISI
|--------------------------------------------------------------------------
*/


Route::get('/disposisi',

    [DisposisiController::class,'index']

)
->middleware('auth');




Route::post('/disposisi',

    [DisposisiController::class,'store']

)
->middleware('auth');




Route::get('/disposisi/inbox/{userId}',

    [DisposisiController::class,'inbox']

)
->middleware('auth')
->whereNumber('userId');




Route::put('/disposisi/{id}/read',

    [DisposisiController::class,'read']

)
->middleware('auth');




Route::put('/disposisi/{id}/finish',

    [DisposisiController::class,'finish']

)
->middleware('auth');




Route::get('/disposisi/{id}',

    [DisposisiController::class,'show']

)
->middleware('auth');