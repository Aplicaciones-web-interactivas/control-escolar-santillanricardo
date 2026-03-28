<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaestroController;
use App\Http\Controllers\AlumnoController;

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

    // Calificaciones
    Route::get('/calificaciones', [AdminController::class, 'calificaciones'])->name('index.calificacion');
    Route::post('/calificaciones', [AdminController::class, 'saveCalificacion'])->name('save.calificacion');
    Route::get('/calificaciones/{id}/edit', [AdminController::class, 'editCalificacion'])->name('calificaciones.edit');
    Route::put('/calificaciones/{id}', [AdminController::class, 'updateCalificacion'])->name('update.calificacion');
    Route::delete('/calificaciones/{id}', [AdminController::class, 'deleteCalificacion'])->name('eliminar.calificacion');

    // Inscripciones
    Route::get('/inscripciones', [AdminController::class, 'inscripciones'])->name('index.inscripcion');
    Route::post('/inscripciones', [AdminController::class, 'saveInscripcion'])->name('save.inscripcion');
    Route::get('/inscripciones/{id}/edit', [AdminController::class, 'editInscripcion'])->name('inscripciones.edit');
    Route::put('/inscripciones/{id}', [AdminController::class, 'updateInscripcion'])->name('update.inscripcion');
    Route::delete('/inscripciones/{id}', [AdminController::class, 'deleteInscripcion'])->name('eliminar.inscripcion');

    // Maestro
    Route::get('/maestro/dashboard', [MaestroController::class, 'dashboard'])->name('maestro.dashboard');
    Route::get('/maestro/tareas', [MaestroController::class, 'tareas'])->name('maestro.tareas');
    Route::post('/maestro/tareas', [MaestroController::class, 'saveTarea'])->name('maestro.save.tarea');
    Route::get('/maestro/tareas/{id}/edit', [MaestroController::class, 'editTarea'])->name('maestro.edit.tarea');
    Route::put('/maestro/tareas/{id}', [MaestroController::class, 'updateTarea'])->name('maestro.update.tarea');
    Route::delete('/maestro/tareas/{id}', [MaestroController::class, 'deleteTarea'])->name('maestro.delete.tarea');
    Route::get('/maestro/tareas/{id}/entregas', [MaestroController::class, 'verEntregas'])->name('maestro.entregas');

    // Alumno
    Route::get('/alumno/dashboard', [AlumnoController::class, 'dashboard'])->name('alumno.dashboard');
    Route::get('/alumno/tareas', [AlumnoController::class, 'tareas'])->name('alumno.tareas');
    Route::post('/alumno/tareas/{id}/entregar', [AlumnoController::class, 'entregarTarea'])->name('alumno.entregar');
});
