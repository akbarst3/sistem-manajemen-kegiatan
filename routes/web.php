<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Himpunan\Index;
use App\Livewire\Himpunan\Form;
use App\Livewire\Dosen\Dosen;
use App\Livewire\Mahasiswa\Mahasiswa;
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


//Route Himpunan
Route::middleware(['auth', 'role:himpunan'])
    ->prefix('himpunan')
    ->name('himpunan.')
    ->group(function () {
        Route::get('/daftar-kegiatan', Index::class)->name('kegiatan.index');
        Route::get('/daftar-kegiatan/create', Form::class)->name('kegiatan.create');
        Route::get('/daftar-kegiatan/edit/{id}', Form::class)->name('kegiatan.edit');
    });

// Route Dosen
Route::middleware(['auth', 'role:dosen'])
    ->prefix('dosen')
    ->name('dosen.')
    ->group(function () {
        Route::get('/review-kegiatan', Dosen::class)->name('kegiatan.review');
    });
// Route Mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {
        Route::get('/kegiatan', Mahasiswa::class)->name('kegiatan');
    });

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('/verification-pending', 'auth.verification-pending')->name('verification.pending');
Route::view('/', 'welcome');
require __DIR__ . '/auth.php';
