<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('registro');
});

Route::get('/registro', [RegisterController::class, 'showForm'])->name('register');
Route::post('/registro', [RegisterController::class, 'register'])->name('register.post');

Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'indexAdmin'])->name('dashboard');
    Route::get('/materias', [AdminController::class, 'materias'])->name('index.materia');
    Route::post('/materias', [AdminController::class, 'saveMateria'])->name('save.materias');
    Route::delete('/materias/{id}', [AdminController::class, 'deleteMateria'])->name('eliminar.materia');
    Route::get('/materias/{id}/edit', [AdminController::class, 'editMateria'])->name('materias.edit');
    Route::put('/materias/{id}', [AdminController::class, 'updateMateria'])->name('update.materia');
});