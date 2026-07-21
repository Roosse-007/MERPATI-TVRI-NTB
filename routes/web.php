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
| ADMIN
|--------------------------------------------------------------------------
*/


Route::prefix('admin')
->middleware('auth')
->group(function(){



    Route::view(
        '/dashboard',
        'admin.dashboard'
    )
    ->name('admin.dashboard');



    Route::get('/users', [UserController::class, 'index'])
    ->name('admin.users');



    Route::view(
        '/template-surat',
        'admin.template-surat'
    )
    ->name('admin.template');



    Route::view(
        '/nomor-surat',
        'admin.nomor-surat'
    )
    ->name('admin.nomor');



    Route::view(
        '/laporan',
        'admin.laporan'
    )
    ->name('admin.laporan');



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


Route::get('/surat/approval',
[
    SuratController::class,
    'approval'
])
->middleware('auth')
->name('surat.approval');









// ==========================
// DISPOSISI
// ==========================


// Halaman daftar disposisi

Route::get('/surat/disposisi',
[
    DisposisiController::class,
    'indexWeb'

])
->middleware('auth')
->name('disposisi.index');





// Form buat disposisi dari surat

Route::get('/surat/{id}/disposisi',
[
    DisposisiController::class,
    'showWeb'

])
->middleware('auth')
->whereNumber('id')
->name('surat.disposisi');





// Simpan disposisi dari form

Route::post('/surat/disposisi',
[
    DisposisiController::class,
    'storeWeb'

])
->middleware('auth')
->name('disposisi.store');





// Detail disposisi

Route::get('/surat/disposisi/{id}',
[
    DisposisiController::class,
    'show'

])
->middleware('auth')
->whereNumber('id')
->name('disposisi.show');





// Inbox disposisi user

Route::get('/surat/disposisi/inbox/{userId}',
[
    DisposisiController::class,
    'inbox'

])
->middleware('auth')
->whereNumber('userId');





// Tandai dibaca

Route::put('/surat/disposisi/{id}/read',
[
    DisposisiController::class,
    'read'

])
->middleware('auth')
->whereNumber('id');





// Selesaikan disposisi

Route::put('/surat/disposisi/{id}/finish',
[
    DisposisiController::class,
    'finish'

])
->middleware('auth')
->whereNumber('id');


// ==========================
// SELESAI
// ==========================