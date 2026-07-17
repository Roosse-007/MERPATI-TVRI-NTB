<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\JabatanController;




// Halaman awal
Route::get('/', function () {
    return view('welcome');
});


// Authentication

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// Dashboard

Route::get('/dashboard', function () {
    return view('dashboard.index');
})
->middleware('auth')
->name('dashboard');



// ======================
// USER MANAGEMENT
// ======================

Route::get('/users',
    [UserController::class, 'index']
)
->middleware('permission:user.view')
->name('users.index');


Route::get('/users/create',
    [UserController::class, 'create']
)
->middleware('permission:user.create')
->name('users.create');


Route::post('/users',
    [UserController::class, 'store']
)
->middleware('permission:user.create')
->name('users.store');


Route::get('/users/{user}/edit',
    [UserController::class, 'edit']
)
->middleware('permission:user.edit')
->name('users.edit');


Route::put('/users/{user}',
    [UserController::class, 'update']
)
->middleware('permission:user.edit')
->name('users.update');


Route::delete('/users/{user}',
    [UserController::class, 'destroy']
)
->middleware('permission:user.delete')
->name('users.destroy');




// ======================
// UNIT KERJA
// ======================

Route::get('/unit-kerja',
    [UnitKerjaController::class, 'index']
)
->middleware('permission:master.view')
->name('unit-kerja.index');


Route::get('/unit-kerja/create',
    [UnitKerjaController::class, 'create']
)
->middleware('permission:master.create')
->name('unit-kerja.create');


Route::post('/unit-kerja',
    [UnitKerjaController::class, 'store']
)
->middleware('permission:master.create')
->name('unit-kerja.store');


Route::get('/unit-kerja/{unit_kerja}/edit',
    [UnitKerjaController::class, 'edit']
)
->middleware('permission:master.edit')
->name('unit-kerja.edit');


Route::put('/unit-kerja/{unit_kerja}',
    [UnitKerjaController::class, 'update']
)
->middleware('permission:master.edit')
->name('unit-kerja.update');


Route::delete('/unit-kerja/{unit_kerja}',
    [UnitKerjaController::class, 'destroy']
)
->middleware('permission:master.delete')
->name('unit-kerja.destroy');




// ======================
// JABATAN
// ======================

Route::get('/jabatan',
    [JabatanController::class, 'index']
)
->middleware('permission:master.view')
->name('jabatan.index');


Route::get('/jabatan/create',
    [JabatanController::class, 'create']
)
->middleware('permission:master.create')
->name('jabatan.create');


Route::post('/jabatan',
    [JabatanController::class, 'store']
)
->middleware('permission:master.create')
->name('jabatan.store');


Route::get('/jabatan/{jabatan}/edit',
    [JabatanController::class, 'edit']
)
->middleware('permission:master.edit')
->name('jabatan.edit');


Route::put('/jabatan/{jabatan}',
    [JabatanController::class, 'update']
)
->middleware('permission:master.edit')
->name('jabatan.update');


Route::delete('/jabatan/{jabatan}',
    [JabatanController::class, 'destroy']
)
->middleware('permission:master.delete')
->name('jabatan.destroy');

// Role Management

Route::get('/role',
    [RoleController::class, 'index']
)
->middleware('permission:master.view')
->name('role.index');


Route::get('/role/create',
    [RoleController::class, 'create']
)
->middleware('permission:master.create')
->name('role.create');


Route::post('/role',
    [RoleController::class, 'store']
)
->middleware('permission:master.create')
->name('role.store');


Route::get('/role/{role}/edit',
    [RoleController::class, 'edit']
)
->middleware('permission:master.edit')
->name('role.edit');


Route::put('/role/{role}',
    [RoleController::class, 'update']
)
->middleware('permission:master.edit')
->name('role.update');


Route::delete('/role/{role}',
    [RoleController::class, 'destroy']
)
->middleware('permission:master.delete')
->name('role.destroy');

// ======================
// PERMISSION MANAGEMENT
// ======================

Route::get('/permission',
    [PermissionController::class, 'index']
)
->middleware('permission:master.view')
->name('permission.index');


Route::get('/permission/create',
    [PermissionController::class, 'create']
)
->middleware('permission:master.create')
->name('permission.create');


Route::post('/permission',
    [PermissionController::class, 'store']
)
->middleware('permission:master.create')
->name('permission.store');


Route::get('/permission/{permission}/edit',
    [PermissionController::class, 'edit']
)
->middleware('permission:master.edit')
->name('permission.edit');


Route::put('/permission/{permission}',
    [PermissionController::class, 'update'])
->middleware('permission:master.edit')
->name('permission.update');


Route::delete('/permission/{permission}',
    [PermissionController::class, 'destroy'])
->middleware('permission:master.delete')
->name('permission.destroy');