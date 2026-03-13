<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('login');
});

Route::get('/registro', [RegisterController::class, 'showForm'])->name('register');
Route::post('/registro', [RegisterController::class, 'register'])->name('register.post');

Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'indexAdmin'])->name('dashboard');

    // Materias
    Route::get('/materias', [AdminController::class, 'materias'])->name('index.materia');
    Route::post('/materias', [AdminController::class, 'saveMateria'])->name('save.materias');
    Route::get('/materias/{id}/edit', [AdminController::class, 'editMateria'])->name('materias.edit');
    Route::put('/materias/{id}', [AdminController::class, 'updateMateria'])->name('update.materia');
    Route::delete('/materias/{id}', [AdminController::class, 'deleteMateria'])->name('eliminar.materia');

    // Horarios
    Route::get('/horarios', [AdminController::class, 'horarios'])->name('index.horario');
    Route::post('/horarios', [AdminController::class, 'saveHorario'])->name('save.horario');
    Route::get('/horarios/{id}/edit', [AdminController::class, 'editHorario'])->name('horarios.edit');
    Route::put('/horarios/{id}', [AdminController::class, 'updateHorario'])->name('update.horario');
    Route::delete('/horarios/{id}', [AdminController::class, 'deleteHorario'])->name('eliminar.horario');

    // Grupos
    Route::get('/grupos', [AdminController::class, 'grupos'])->name('index.grupo');
    Route::post('/grupos', [AdminController::class, 'saveGrupo'])->name('save.grupo');
    Route::get('/grupos/{id}/edit', [AdminController::class, 'editGrupo'])->name('grupos.edit');
    Route::put('/grupos/{id}', [AdminController::class, 'updateGrupo'])->name('update.grupo');
    Route::delete('/grupos/{id}', [AdminController::class, 'deleteGrupo'])->name('eliminar.grupo');
});