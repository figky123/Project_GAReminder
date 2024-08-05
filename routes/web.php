<?php

use App\Http\Controllers\Auth\LoginController as UserAuthController;
use App\Http\Controllers\DataPenerbanganController as PenerbanganController;
use App\Http\Controllers\KelolaUserController;
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
    return view('welcome');
});


Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');


Route::get('/penerbangan', [PenerbanganController::class, 'index'])->name('penerbangan.index');
Route::post('/penerbangan/store', [PenerbanganController::class, 'store'])->name('penerbangan.store');
// Di web.php
Route::get('/penerbangan/{id}/edit', [PenerbanganController::class, 'edit'])->name('penerbangan.edit');
Route::put('/penerbangan/{id}', [PenerbanganController::class, 'update'])->name('penerbangan.update');
Route::delete('/penerbangan/{id}', [PenerbanganController::class, 'destroy'])->name('penerbangan.destroy');


Route::get('/users', [KelolaUserController::class, 'index'])->name('users.index');
Route::post('/users', [KelolaUserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [KelolaUserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [KelolaUserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [KelolaUserController::class, 'destroy'])->name('users.destroy');
