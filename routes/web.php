<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\CashierController;

/*
|--------------------------------------------------------------------------
| Halaman Umum
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest.session')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.process');
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth.session')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Halaman Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.session', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        Route::post('/menu', [AdminController::class, 'storeMenu'])
            ->name('menu.store');

        Route::put('/menu/{id}', [AdminController::class, 'updateMenu'])
            ->name('menu.update');

        Route::delete('/menu/{id}', [AdminController::class, 'deleteMenu'])
            ->name('menu.delete');

        Route::put('/pesanan/{id}/status', [AdminController::class, 'updateStatus'])
            ->name('pesanan.status');
    });

/*
|--------------------------------------------------------------------------
| Halaman Siswa
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.session', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'dashboard'])
            ->name('dashboard');

        Route::post('/pesanan', [SiswaController::class, 'storePesanan'])
            ->name('pesanan.store');

        Route::get('/riwayat', [SiswaController::class, 'riwayatPesanan'])
            ->name('riwayat');
    });


Route::middleware(['auth.session', 'role:kasir'])
    ->prefix('kasir')
    ->name('kasir.')
    ->group(function () {
        Route::get('/dashboard', [CashierController::class, 'dashboard'])
            ->name('dashboard');

        Route::patch('/pembayaran/{id}/konfirmasi', [
            CashierController::class,
            'konfirmasiPembayaran'
        ])->name('pembayaran.konfirmasi');
    });
