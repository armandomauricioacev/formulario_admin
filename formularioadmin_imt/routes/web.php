<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ========== RUTAS DE DEPENDENCIAS ==========
Route::get('/dependencias', [AdminController::class, 'dependenciasIndex'])
    ->middleware(['auth', 'verified'])->name('dependencias.index');

Route::post('/dependencias', [AdminController::class, 'dependenciaStore'])
    ->middleware(['auth', 'verified'])->name('dependencias.store');

Route::put('/dependencias/{dependencia}', [AdminController::class, 'dependenciaUpdate'])
    ->middleware(['auth', 'verified'])->name('dependencias.update');

Route::delete('/dependencias/{dependencia}', [AdminController::class, 'dependenciaDestroy'])
    ->middleware(['auth', 'verified'])->name('dependencias.destroy');

// ========== RUTAS DE TRÁMITES ==========
Route::get('/tramites', [AdminController::class, 'tramitesIndex'])
    ->middleware(['auth', 'verified'])->name('tramites');

Route::post('/tramites', [AdminController::class, 'tramitesStore'])
    ->middleware(['auth', 'verified'])->name('tramites.store');

Route::get('/tramites/{tramite}/edit', [AdminController::class, 'tramitesEdit'])
    ->middleware(['auth', 'verified'])->name('tramites.edit');

Route::put('/tramites/{tramite}', [AdminController::class, 'tramitesUpdate'])
    ->middleware(['auth', 'verified'])->name('tramites.update');

Route::delete('/tramites/{tramite}', [AdminController::class, 'tramitesDestroy'])
    ->middleware(['auth', 'verified'])->name('tramites.destroy');



// ========== RUTAS DE LÍNEAS DE CAPTURA ==========
Route::get('/lineas-captura', [AdminController::class, 'lineasCapturadasIndex'])
    ->middleware(['auth', 'verified'])->name('lineas-captura');

// IMPORTANTE: Esta ruta debe ir ANTES de la ruta con {linea}
// Ruta para eliminar líneas filtradas
Route::delete('/lineas-captura/delete-filtered', [AdminController::class, 'lineasCapturaDeleteFiltered'])
    ->middleware(['auth', 'verified'])->name('lineas-captura.delete-filtered');

// Ruta para eliminar línea individual
Route::delete('/lineas-captura/{linea}', [AdminController::class, 'lineaCapturaDestroy'])
    ->middleware(['auth', 'verified'])->name('lineas-captura.destroy');

// ========== RUTAS DE COORDINACIONES ==========
Route::get('/coordinaciones', [AdminController::class, 'coordinacionesIndex'])
    ->middleware(['auth', 'verified'])->name('coordinaciones');

Route::post('/coordinaciones', [AdminController::class, 'coordinacionesStore'])
    ->middleware(['auth', 'verified'])->name('coordinaciones.store');

Route::put('/coordinaciones/{coordinacion}', [AdminController::class, 'coordinacionesUpdate'])
    ->middleware(['auth', 'verified'])->name('coordinaciones.update');

Route::delete('/coordinaciones/{coordinacion}', [AdminController::class, 'coordinacionesDestroy'])
    ->middleware(['auth', 'verified'])->name('coordinaciones.destroy');

// Representante global de Coordinaciones
Route::post('/coordinaciones/representante', [AdminController::class, 'coordinacionesRepresentativeUpdate'])
    ->middleware(['auth', 'verified'])->name('coordinaciones.representante.update');

// ========== RUTAS DE ENTIDADES DE PROCEDENCIA ==========
Route::get('/entidades-procedencia', [AdminController::class, 'entidadesProcedenciaIndex'])
    ->middleware(['auth', 'verified'])->name('entidades-procedencia');

Route::post('/entidades-procedencia', [AdminController::class, 'entidadesProcedenciaStore'])
    ->middleware(['auth', 'verified'])->name('entidades-procedencia.store');

Route::put('/entidades-procedencia/{entidad}', [AdminController::class, 'entidadesProcedenciaUpdate'])
    ->middleware(['auth', 'verified'])->name('entidades-procedencia.update');

Route::delete('/entidades-procedencia/{entidad}', [AdminController::class, 'entidadesProcedenciaDestroy'])
    ->middleware(['auth', 'verified'])->name('entidades-procedencia.destroy');

Route::get('/servicios', [AdminController::class, 'serviciosIndex'])
    ->middleware(['auth', 'verified'])->name('servicios');

Route::post('/servicios', [AdminController::class, 'serviciosStore'])
    ->middleware(['auth', 'verified'])->name('servicios.store');

Route::put('/servicios/{servicio}', [AdminController::class, 'serviciosUpdate'])
    ->middleware(['auth', 'verified'])->name('servicios.update');

Route::delete('/servicios/{servicio}', [AdminController::class, 'serviciosDestroy'])
    ->middleware(['auth', 'verified'])->name('servicios.destroy');

Route::get('/solicitudes', [AdminController::class, 'solicitudesServiciosIndex'])
    ->middleware(['auth', 'verified'])->name('solicitudes');

// Eliminar solicitud individual
Route::delete('/solicitudes/{solicitud}', [AdminController::class, 'solicitudesServiciosDestroy'])
    ->middleware(['auth', 'verified'])->name('solicitudes.destroy');

// ========== RUTAS DE PERFIL ==========
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';