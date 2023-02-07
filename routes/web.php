<?php

use App\Http\Controllers\Absen\AbsenController as MyAbsenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\AbsenController as AllAbsenController;
use App\Http\Controllers\Master\CutiFormatController;
use App\Http\Controllers\Master\JabatanController;
use App\Http\Controllers\Master\LokasiController;
use App\Http\Controllers\Master\PermissionController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\ShiftController;
use App\Http\Controllers\Master\StatusController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');

Route::middleware('auth')->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/{user:username}', [ProfileController::class, 'update'])->name('profile.update');

    // Master Prefix
    Route::prefix('/master')->name('master.')->group(function () {

        // Users
        Route::get('/users/{user:username}/edit-user-role', [UserController::class, 'editUserRole'])->name('user.editUserRole');
        Route::put('/users/{user:username}/update-user-role', [UserController::class, 'updateUserRole'])->name('user.updateUserRole');
        Route::resource('/users', UserController::class)->names('user')->scoped(['user' => 'username']);

        // Roles
        Route::get('/roles/{role:name}/edit-role-permission', [RoleController::class, 'editRolePermission'])->name('role.editRolePermission');
        Route::put('/roles/{role:name}/update-role-permission', [RoleController::class, 'updateRolePermission'])->name('role.updateRolePermission');
        Route::resource('/roles', RoleController::class)->names('role')->except('show')->scoped(['role' => 'name']);

        // Permission
        Route::resource('/permission', PermissionController::class)->names('permission')->except('show')->scoped(['permission' => 'name']);

        // Shift
        Route::post('/shift/slug', [ShiftController::class, 'slug'])->name('shift.slug');
        Route::resource('/shift', ShiftController::class)->names('shift')->except('show')->scoped(['shift' => 'slug']);

        // Lokasi
        Route::post('/lokasi/slug', [LokasiController::class, 'slug'])->name('lokasi.slug');
        Route::resource('/lokasi', LokasiController::class)->names('lokasi')->except('show')->scoped(['lokasi' => 'slug']);

        // Status
        Route::post('/status/slug', [StatusController::class, 'slug'])->name('status.slug');
        Route::resource('/status', StatusController::class)->names('status')->except('show')->scoped(['status' => 'slug']);

        // Jabatan
        Route::post('/jabatan/slug', [JabatanController::class, 'slug'])->name('jabatan.slug');
        Route::resource('/jabatan', JabatanController::class)->names('jabatan')->except('show')->scoped(['jabatan' => 'slug']);

        // Cuti Format
        Route::get('/cuti-format', [CutiFormatController::class, 'index'])->name('cuti.format.index');
        Route::put('/cuti-format/{cutiFormat}/edit', [CutiFormatController::class, 'edit'])->name('cuti.format.edit');

        // Absen
        Route::get('/absen', [AllAbsenController::class, 'index'])->name('absen.index');
        // Cek Validasi Filter Absen
        Route::post('/absen/validasi-filter', [MyAbsenController::class, 'filterAbsen'])->name('absen.filterAbsen');

        // Datatable Master
        Route::get('/get-users', [UserController::class, 'datatableUsers'])->name('user.datatable');
        Route::get('/get-roles', [RoleController::class, 'datatableRoles'])->name('role.datatable');
        Route::get('/get-permissions', [PermissionController::class, 'datatablePermissions'])->name('permission.datatable');
        Route::get('/get-shifts', [ShiftController::class, 'datatableShifts'])->name('shift.datatable');
        Route::get('/get-lokasis', [LokasiController::class, 'datatableLokasis'])->name('lokasi.datatable');
        Route::get('/get-status', [StatusController::class, 'datatableStatus'])->name('status.datatable');
        Route::get('/get-jabatans', [JabatanController::class, 'datatableJabatans'])->name('jabatan.datatable');
        Route::get('/get-allAbsens', [AllAbsenController::class, 'datatableAllAbsens'])->name('allAbsen.datatable');
    });

    // Absen Prefix
    Route::prefix('/absen')->name('absen.')->group(function () {
        // Absen
        Route::get('/', [MyAbsenController::class, 'index'])->name('index');
        Route::post('/', [MyAbsenController::class, 'absen'])->name('store');
        Route::get('/show/{absen}', [MyAbsenController::class, 'show'])->name('show');

        // My Absen
        Route::get('/my-absen', [MyAbsenController::class, 'myAbsen'])->name('myAbsen');

        // Datatable Absen
        Route::get('/get-myAbsens', [MyAbsenController::class, 'datatableMyAbsens'])->name('myAbsen.datatable');

        // Cek Validasi Filter Absen
        Route::post('/validasi-filter', [MyAbsenController::class, 'filterAbsen'])->name('filterAbsen');
    });
});

// auth
require __DIR__ . '/auth.php';
