<?php

use App\Http\Controllers\DashboardController;
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

    // Master Prefix
    Route::prefix('/master')->name('master.')->group(function () {
        // profile
        // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Users
        Route::get('/users', [UserController::class, 'index'])->name('user.index');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('user.show');
        Route::get('/users/{user}/edit-user-role', [UserController::class, 'editUserRole'])->name('user.editUserRole');
        Route::put('/users/{user}/update-user-role', [UserController::class, 'updateUserRole'])->name('user.updateUserRole');

        // Roles
        Route::get('/roles/{role}/edit-role-permission', [RoleController::class, 'editRolePermission'])->name('role.editRolePermission');
        Route::put('/roles/{role}/update-role-permission', [RoleController::class, 'updateRolePermission'])->name('role.updateRolePermission');
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

        // Datatable
        Route::get('/get-users', [UserController::class, 'datatableUsers'])->name('user.datatable');
        Route::get('/get-roles', [RoleController::class, 'datatableRoles'])->name('role.datatable');
        Route::get('/get-permissions', [PermissionController::class, 'datatablePermissions'])->name('permission.datatable');
        Route::get('/get-shifts', [ShiftController::class, 'datatableShifts'])->name('shift.datatable');
        Route::get('/get-lokasis', [LokasiController::class, 'datatableLokasis'])->name('lokasi.datatable');
        Route::get('/get-status', [StatusController::class, 'datatableStatus'])->name('status.datatable');
        Route::get('/get-jabatans', [JabatanController::class, 'datatableJabatans'])->name('jabatan.datatable');
    });
});

// auth
require __DIR__ . '/auth.php';