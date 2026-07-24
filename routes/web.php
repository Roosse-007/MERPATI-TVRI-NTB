<?php


use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PengesahanController;

use App\Http\Controllers\BalasanSuratController;
use App\Http\Controllers\LampiranController;
use App\Http\Controllers\TemplateSuratController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NomorSuratController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DisposisiController;





/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/


Route::get('/', function(){

    return redirect()->route('login');

});








/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/


Route::get('/login',
[
    AuthController::class,
    'showLogin'

])
->name('login');




Route::post('/login',
[
    AuthController::class,
    'login'

])
->name('login.process');




Route::post('/logout',
[
    AuthController::class,
    'logout'

])
->name('logout');



// ==========================
// NOMOR SURAT
// ==========================

Route::prefix('admin')
->middleware('auth')
->group(function(){


    Route::get('/nomor-surat',
    [
        NomorSuratController::class,
        'index'
    ])
    ->name('admin.nomor');


    Route::get('/nomor-surat/create',
    [
        NomorSuratController::class,
        'create'
    ])
    ->name('admin.nomor.create');


    Route::post('/nomor-surat',
    [
        NomorSuratController::class,
        'store'
    ])
    ->name('admin.nomor.store');


    Route::get('/nomor-surat/{id}/edit',
    [
        NomorSuratController::class,
        'edit'
    ])
    ->whereNumber('id')
    ->name('admin.nomor.edit');


    Route::put('/nomor-surat/{id}',
    [
        NomorSuratController::class,
        'update'
    ])
    ->whereNumber('id')
    ->name('admin.nomor.update');


    Route::delete('/nomor-surat/{id}',
    [
        NomorSuratController::class,
        'destroy'
    ])
    ->whereNumber('id')
    ->name('admin.nomor.destroy');


});
/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/


Route::get('/dashboard',
[
    DashboardController::class,
    'index'

])
->middleware('auth')
->name('dashboard');





/*
|--------------------------------------------------------------------------
| LAPORAN
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/laporan',
    [
        LaporanController::class,
        'index'
    ]
)
->middleware('auth')
->name('admin.laporan');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/


Route::prefix('admin')
->middleware('auth')
->group(function(){


    Route::get(
        '/dashboard',
        [
            DashboardController::class,
            'index'
        ]
    )
    ->name('admin.dashboard');



    Route::view(
        '/users',
        'admin.users'
    )
    ->name('admin.users');



    Route::view(
        '/grafik',
        'admin.grafik'
    )
    ->name('admin.grafik');



    Route::view(
        '/arsip',
        'admin.arsip'
    )
    ->name('admin.arsip');



    Route::view(
        '/monitoring',
        'admin.monitoring'
    )
    ->name('admin.monitoring');



    Route::view(
        '/setting',
        'admin.setting'
    )
    ->name('admin.setting');


});




/*
|--------------------------------------------------------------------------
| TEMPLATE SURAT ADMIN
|--------------------------------------------------------------------------
*/


// HALAMAN TEMPLATE

Route::get(
    '/admin/template-surat',
    [TemplateSuratController::class,'index']
)
->name('admin.template');





// TAMBAH TEMPLATE

Route::post(
    '/admin/template-surat',
    [TemplateSuratController::class,'store']
)
->name('template.store');





// FORM EDIT TEMPLATE

Route::get(
    '/admin/template-surat/{id}/edit',
    [TemplateSuratController::class,'edit']
)
->name('template.edit');





// UPDATE TEMPLATE

Route::put(
    '/admin/template-surat/{id}',
    [TemplateSuratController::class,'update']
)
->name('template.update');





// HAPUS TEMPLATE

Route::delete(
    '/admin/template-surat/{id}',
    [TemplateSuratController::class,'destroy']
)
->name('template.destroy');





// AKTIF / NONAKTIF TEMPLATE

Route::patch(
    '/admin/template-surat/{id}/status',
    [TemplateSuratController::class,'toggleStatus']
)
->name('template.status');

/*
|--------------------------------------------------------------------------
| USER MANAGEMENT
|--------------------------------------------------------------------------
*/


Route::resource(
    'users',
    UserController::class
)
->middleware('auth');









/*
|--------------------------------------------------------------------------
| MASTER DATA
|--------------------------------------------------------------------------
*/


Route::resource(
    'unit-kerja',
    UnitKerjaController::class
)
->middleware('auth');




Route::resource(
    'jabatan',
    JabatanController::class
)
->middleware('auth');




Route::resource(
    'role',
    RoleController::class
)
->middleware('auth');




Route::resource(
    'permission',
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


// Buat surat baru

Route::get('/surat/baru',
[
    SuratController::class,
    'create'

])
->middleware('auth')
->name('surat.create');





// Simpan surat

Route::post('/surat',
[
    SuratController::class,
    'store'

])
->middleware('auth')
->name('surat.store');





// Draft surat

Route::get('/surat/draft',
[
    SuratController::class,
    'draft'

])
->middleware('auth')
->name('surat.draft');





// Edit draft

Route::get('/surat/{id}/edit',
[
    SuratController::class,
    'edit'

])
->middleware('auth')
->whereNumber('id')
->name('surat.edit');





// Update draft

Route::put('/surat/{id}',
[
    SuratController::class,
    'update'

])
->middleware('auth')
->whereNumber('id')
->name('surat.update');





// Hapus draft

Route::delete('/surat/{id}',
[
    SuratController::class,
    'destroy'

])
->middleware('auth')
->whereNumber('id')
->name('surat.destroy');





// Kirim surat approval

Route::post('/surat/{id}/submit',
[
    SuratController::class,
    'submit'

])
->middleware('auth')
->whereNumber('id')
->name('surat.submit');





// Detail surat web

Route::get('/surat/{id}/detail',
[
    SuratController::class,
    'showWeb'

])
->middleware('auth')
->whereNumber('id')
->name('surat.detail');





// Detail API

Route::get('/api/surat/{id}',
[
    SuratController::class,
    'show'

])
->whereNumber('id');
// ==========================
// INBOX SURAT
// ==========================


Route::get('/inbox',
[
    SuratController::class,
    'inboxWeb'

])
->middleware('auth')
->name('surat.inbox');







// ==========================
// SURAT TERKIRIM
// ==========================


Route::get('/sent',
[
    SuratController::class,
    'sent'

])
->middleware('auth')
->name('surat.sent');







// ==========================
// ARSIP SURAT
// ==========================


// arsipkan surat

Route::put('/surat/{id}/archive',
[
    SuratController::class,
    'archive'

])
->middleware('auth')
->whereNumber('id')
->name('surat.archive');





// list arsip API

Route::get('/archive',
[
    SuratController::class,
    'archiveList'

])
->middleware('auth')
->name('surat.archive.list');





// halaman arsip

Route::get('/surat/arsip',
[
    SuratController::class,
    'archiveWeb'

])
->middleware('auth')
->name('surat.arsip');









// ==========================
// APPROVAL ACTION
// ==========================


Route::post('/approval/kpp/{id}',
[
    ApprovalController::class,
    'approveKpp'

])
->middleware('auth');




Route::post('/approval/kpp/{id}/reject',
[
    ApprovalController::class,
    'rejectKpp'

])
->middleware('auth');





Route::post('/approval/ktu/{id}',
[
    ApprovalController::class,
    'approveKtu'

])
->middleware('auth');




Route::post('/approval/ktu/{id}/reject',
[
    ApprovalController::class,
    'rejectKtu'

])
->middleware('auth');





Route::post('/approval/kepala-stasiun/{id}',
[
    ApprovalController::class,
    'approveKepalaStasiun'

])
->middleware('auth');





Route::post('/approval/kepala-stasiun/{id}/reject',
[
    ApprovalController::class,
    'rejectKepalaStasiun'

])
->middleware('auth');









// ==========================
// HALAMAN APPROVAL
// ==========================

Route::get(
    '/surat/approval',
    [
        ApprovalController::class,
        'index'
    ]
)
->name('surat.approval')
->middleware('auth');









// ==========================
// DISPOSISI
// ==========================


// ==========================
// FORM BUAT DISPOSISI DARI SURAT
// ==========================

Route::get('/surat/{id}/disposisi',
[
    DisposisiController::class,
    'createWeb'

])
->middleware('auth')
->whereNumber('id')
->name('surat.disposisi');





// ==========================
// SIMPAN DISPOSISI WEB
// ==========================

Route::post('/surat/disposisi',
[
    DisposisiController::class,
    'storeWeb'

])
->middleware('auth')
->name('disposisi.store');






// ==========================
// DETAIL DISPOSISI
// ==========================

Route::get('/surat/disposisi/{id}',
[
    DisposisiController::class,
    'showWeb'

])
->middleware('auth')
->whereNumber('id')
->name('disposisi.show');






// ==========================
// LIST SEMUA DISPOSISI
// ==========================

Route::get('/surat/disposisi',
[
    DisposisiController::class,
    'indexWeb'

])
->middleware('auth')
->name('disposisi.index');






// ==========================
// INBOX DISPOSISI USER
// ==========================

Route::get('/surat/disposisi/inbox/{userId}',
[
    DisposisiController::class,
    'inbox'

])
->middleware('auth')
->whereNumber('userId');







// ==========================
// TANDAI DISPOSISI DIBACA
// ==========================

Route::put('/surat/disposisi/{id}/read',
[
    DisposisiController::class,
    'read'

])
->middleware('auth')
->whereNumber('id');






// ==========================
// SELESAIKAN DISPOSISI
// ==========================

Route::put('/surat/disposisi/{id}/finish',
[
    DisposisiController::class,
    'finish'

])
->middleware('auth')
->whereNumber('id');
/*
|--------------------------------------------------------------------------
| LAMPIRAN SURAT
|--------------------------------------------------------------------------
*/
Route::post(
    '/lampiran/store',
    [
        LampiranController::class,
        'store'
    ]
)
->middleware('auth')
->name('lampiran.store');



Route::delete(
    '/lampiran/{id}',
    [
        LampiranController::class,
        'destroy'
    ]
)
->middleware('auth')
->name('lampiran.destroy');
// ==========================
// PENGESAHAN SURAT
// ==========================



/*
|--------------------------------------------------------------------------
| HALAMAN PILIH METODE PENGESAHAN
|--------------------------------------------------------------------------
*/

Route::get(
    '/surat/{id}/pengesahan',
    [
        PengesahanController::class,
        'create'
    ]
)
->middleware('auth')
->whereNumber('id')
->name('pengesahan.create');





/*
|--------------------------------------------------------------------------
| FORM UPLOAD TTE
|--------------------------------------------------------------------------
*/

Route::get(
    '/surat/{id}/pengesahan/tte',
    [
        PengesahanController::class,
        'formTTE'
    ]
)
->middleware('auth')
->whereNumber('id')
->name('pengesahan.tte.form');






/*
|--------------------------------------------------------------------------
| FORM UPLOAD QR CODE
|--------------------------------------------------------------------------
*/

Route::get(
    '/surat/{id}/pengesahan/qr',
    [
        PengesahanController::class,
        'formQR'
    ]
)
->middleware('auth')
->whereNumber('id')
->name('pengesahan.qr.form');







/*
|--------------------------------------------------------------------------
| SIMPAN UPLOAD TTE / QR
|--------------------------------------------------------------------------
*/

Route::post(
    '/surat/{id}/pengesahan/upload',
    [
        PengesahanController::class,
        'uploadPengesahan'
    ]
)
->middleware('auth')
->whereNumber('id')
->name('pengesahan.upload');







/*
|--------------------------------------------------------------------------
| VERIFIKASI QR CODE PUBLIK
|--------------------------------------------------------------------------
*/

Route::get(
    '/verifikasi/{kode}',
    function($kode){


        $data = \App\Models\PengesahanSurat::where(

            'nomor_verifikasi',

            $kode

        )->firstOrFail();



        return view(
            'verifikasi',
            compact('data')
        );


    }
)
->name('verifikasi');

// ==========================
// BALASAN
// ==========================
Route::get(
    '/surat/{id}/balas',
    [BalasanSuratController::class,'create']
)
->name('surat.balas');


Route::post(
    '/surat/{id}/balas',
    [BalasanSuratController::class,'store']
)
->name('surat.balas.store');
// ==========================
// SELESAI
// ==========================