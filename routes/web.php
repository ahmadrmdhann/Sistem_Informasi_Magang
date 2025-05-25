<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\PengajuanMagangController;
use App\Http\Controllers\MahasiswaLowonganController;
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
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/prodi', [App\Http\Controllers\ProdiController::class, 'index'])->name('prodi.index');
        Route::get('/prodi/create', [App\Http\Controllers\ProdiController::class, 'create'])->name('prodi.create');
        Route::post('/prodi', [App\Http\Controllers\ProdiController::class, 'store'])->name('prodi.store');
        Route::get('/prodi/{id}/edit', [App\Http\Controllers\ProdiController::class, 'edit'])->name('prodi.edit');
        Route::put('/prodi/{id}', [App\Http\Controllers\ProdiController::class, 'update'])->name('prodi.update');
        Route::delete('/prodi/{id}', [App\Http\Controllers\ProdiController::class, 'destroy'])->name('prodi.destroy');

        Route::middleware('authorize:ADM')->prefix('admin')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('admin.index');
            Route::get('/level', [App\Http\Controllers\LevelController::class, 'index'])->name('level.index');
            Route::get('/level/create', [App\Http\Controllers\LevelController::class, 'create'])->name('level.create');
            Route::post('/level', [App\Http\Controllers\LevelController::class, 'store'])->name('level.store');
            Route::get('/level/{id}/edit', [App\Http\Controllers\LevelController::class, 'edit'])->name('level.edit');
            Route::put('/level/{id}', [App\Http\Controllers\LevelController::class, 'update'])->name('level.update');
            Route::delete('/level/{id}', [App\Http\Controllers\LevelController::class, 'destroy'])->name('level.destroy');
        });

    // Mitra routes
        Route::middleware('authorize:ADM')->prefix('partner')->group(function () {
            Route::get('/', [App\Http\Controllers\PartnerController::class, 'index'])->name('partner.index');
            Route::get('/create', [App\Http\Controllers\PartnerController::class, 'create'])->name('partner.create');
            Route::post('/', [App\Http\Controllers\PartnerController::class, 'store'])->name('partner.store');
            Route::get('/{id}/edit', [App\Http\Controllers\PartnerController::class, 'edit'])->name('partner.edit');
            Route::put('/{id}', [App\Http\Controllers\PartnerController::class, 'update'])->name('partner.update');
            Route::delete('/{id}', [App\Http\Controllers\PartnerController::class, 'destroy'])->name('partner.destroy');
        });

        // Resource route untuk lowongan magang
        Route::resource('lowongan', LowonganController::class);
    });

    // Dosen routes
    Route::middleware('authorize:DSN')->prefix('dosen')->group(function () {
        Route::get('/', [DosenController::class, 'index'])->name('dosen.index');
        // Add more dosen routes here
    });

    // Mahasiswa routes
    Route::middleware('authorize:MHS')->prefix('mahasiswa')->group(function () {
        Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
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
