<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
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
        
    });

    // Dosen routes
    Route::middleware('authorize:DSN')->prefix('dosen')->group(function () {
        Route::get('/', [DosenController::class, 'index'])->name('dosen.index');
        // Add more dosen routes here
    });

    // Mahasiswa routes
    Route::middleware('authorize:MHS')->prefix('mahasiswa')->group(function () {
        Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        // Add more mahasiswa routes here
    });
});
