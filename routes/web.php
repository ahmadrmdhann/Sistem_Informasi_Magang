<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\MagangMahasiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\PengajuanMagangController;
use App\Http\Controllers\MahasiswaLowonganController;
use App\Http\Controllers\KeahlianController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layouts.landing');
})->name('landing');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [Authcontroller::class, 'postregister']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->level->level_kode == 'ADM') {
            return app(AdminController::class)->index();
        } elseif (auth()->user()->level->level_kode == 'DSN') {
            return app(DosenController::class)->index();
        } elseif (auth()->user()->level->level_kode == 'MHS') {
            return app(MahasiswaController::class)->index();
        }
        return redirect()->route('login');
    })->name('dashboard');

    // Admin routes
    Route::middleware('authorize:ADM')->prefix('admin')->group(function () {
        Route::prefix('prodi')->group(function () {
            Route::get('/', [ProdiController::class, 'index'])->name('prodi.index');
            Route::get('/create', [ProdiController::class, 'create'])->name('prodi.create');
            Route::post('/', [ProdiController::class, 'store'])->name('prodi.store');
            Route::get('/{id}/edit', [ProdiController::class, 'edit'])->name('prodi.edit');
            Route::put('/{id}', [ProdiController::class, 'update'])->name('prodi.update');
            Route::delete('/{id}', [ProdiController::class, 'destroy'])->name('prodi.destroy');
        });

        Route::prefix('level')->group(function () {
            Route::get('/', [App\Http\Controllers\LevelController::class, 'index'])->name('level.index');
            Route::get('/create', [App\Http\Controllers\LevelController::class, 'create'])->name('level.create');
            Route::post('/', [App\Http\Controllers\LevelController::class, 'store'])->name('level.store');
            Route::get('/{id}/edit', [App\Http\Controllers\LevelController::class, 'edit'])->name('level.edit');
            Route::put('/{id}', [App\Http\Controllers\LevelController::class, 'update'])->name('level.update');
            Route::delete('/{id}', [App\Http\Controllers\LevelController::class, 'destroy'])->name('level.destroy');
        });

        Route::prefix('user')->group(function () {
            Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
            Route::get('/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
            Route::get('/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');
            Route::post('/', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
            Route::get('/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
            Route::put('/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
            Route::delete('/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
        });

        Route::prefix('partner')->group(function () {
            Route::get('/', [App\Http\Controllers\PartnerController::class, 'index'])->name('partner.index');
            Route::get('/create', [App\Http\Controllers\PartnerController::class, 'create'])->name('partner.create');
            Route::post('/', [App\Http\Controllers\PartnerController::class, 'store'])->name('partner.store');
            Route::get('/{id}/edit', [App\Http\Controllers\PartnerController::class, 'edit'])->name('partner.edit');
            Route::put('/{id}', [App\Http\Controllers\PartnerController::class, 'update'])->name('partner.update');
            Route::delete('/{id}', [App\Http\Controllers\PartnerController::class, 'destroy'])->name('partner.destroy');
        });

        Route::prefix('lowongan')->group(function () {
            Route::get('/', [LowonganController::class, 'index'])->name('lowongan.index');
            Route::get('/create', [LowonganController::class, 'create'])->name('lowongan.create');
            Route::post('/', [LowonganController::class, 'store'])->name('lowongan.store');
            Route::get('/{id}/edit', [LowonganController::class, 'edit'])->name('lowongan.edit');
            Route::put('/{id}', [LowonganController::class, 'update'])->name('lowongan.update');
            Route::delete('/{id}', [LowonganController::class, 'destroy'])->name('lowongan.destroy');
        });

        Route::prefix('periode')->group(function () {
            Route::get('/', [PeriodeController::class, 'index'])->name('periode.index');
            Route::get('/create', [PeriodeController::class, 'create'])->name('periode.create');
            Route::post('/', [PeriodeController::class, 'store'])->name('periode.store');
            Route::get('/{id}/edit', [PeriodeController::class, 'edit'])->name('periode.edit');
            Route::put('/{id}', [PeriodeController::class, 'update'])->name('periode.update');
            Route::delete('/{id}', [PeriodeController::class, 'destroy'])->name('periode.destroy');
        });
        Route::prefix('pmm')->group(function () {
            Route::get('/', [MagangMahasiswaController::class, 'index'])->name('pmm.index');
            Route::get('/{id}', [MagangMahasiswaController::class, 'show'])->name('pmm.show');
            Route::get('/{id}/edit', [MagangMahasiswaController::class, 'edit'])->name('pmm.edit');
            Route::put('/{id}', [MagangMahasiswaController::class, 'update'])->name('pmm.update');
            Route::post('/{id}/status', [MagangMahasiswaController::class, 'updateStatus'])->name('pmm.updateStatus');
        });
        Route::prefix('keahlian')->group(function () {
            Route::get('/', [KeahlianController::class, 'index'])->name('keahlian.index');
            Route::get('/create', [KeahlianController::class, 'create'])->name('keahlian.create');
            Route::post('/', [KeahlianController::class, 'store'])->name('keahlian.store');
            Route::get('/{id}/edit', [KeahlianController::class, 'edit'])->name('keahlian.edit');
            Route::put('/{id}', [KeahlianController::class, 'update'])->name('keahlian.update');
            Route::delete('/{id}', [KeahlianController::class, 'destroy'])->name('keahlian.destroy');
        });
    });

    // Dosen routes
    Route::middleware('authorize:DSN')->prefix('dosen')->group(function () {
        Route::get('/', [DosenController::class, 'index'])->name('dosen.index');
        // Add more dosen routes here
    });

    // Mahasiswa routes
    Route::middleware('authorize:MHS')->prefix('mahasiswa')->group(function () {
        Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('/profile', [MahasiswaController::class, 'profile'])->name('mahasiswa.profile');

        Route::prefix('profile')->group(function () {
            Route::get('/', [MahasiswaController::class, 'profile'])->name('mahasiswa.profile');
            Route::put('/', [MahasiswaController::class, 'updateProfile'])->name('mahasiswa.profile.update');
            Route::put('/password', [MahasiswaController::class, 'updatePassword'])->name('mahasiswa.profile.password.update');
        });

        Route::get('/pengajuan', [PengajuanMagangController::class, 'index'])->name('mahasiswa.pengajuan');
        Route::get('mahasiswa/pengajuan', [PengajuanMagangController::class, 'index'])->name('pengajuan.index');
        Route::post('mahasiswa/pengajuan', [PengajuanMagangController::class, 'store'])->name('pengajuan.store');
        // Add more mahasiswa routes here
    });

    Route::middleware(['auth', 'authorize:MHS'])->prefix('mahasiswa')->group(function () {
        Route::get('lowongan', [MahasiswaLowonganController::class, 'index'])->name('mahasiswa.lowongan.index');
        Route::post('lowongan/{id}/apply', [MahasiswaLowonganController::class, 'apply'])->name('mahasiswa.lowongan.apply');
    });
});
