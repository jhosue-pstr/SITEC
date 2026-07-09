<?php

use App\Http\Controllers\AsignacionTareaController;
use App\Http\Controllers\AtencionController;
use App\Http\Controllers\ComentarioTareaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EvidenciaController;
use App\Http\Controllers\FormatoAtencionController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\OficinaController;
use App\Http\Controllers\SolicitudWhatsappController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware('auth')->group(function () {
    Route::resource('oficinas', OficinaController::class);
    Route::resource('equipos', EquipoController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('tareas', TareaController::class);

    Route::post('/tareas/{tarea}/asignar', [TareaController::class, 'asignar'])->name('tareas.asignar');
    Route::post('/tareas/{tarea}/aceptar', [TareaController::class, 'aceptar'])->name('tareas.aceptar');
    Route::post('/tareas/{tarea}/iniciar', [TareaController::class, 'iniciar'])->name('tareas.iniciar');
    Route::post('/tareas/{tarea}/finalizar', [TareaController::class, 'finalizar'])->name('tareas.finalizar');
    Route::post('/tareas/{tarea}/observar', [TareaController::class, 'observar'])->name('tareas.observar');
    Route::post('/tareas/{tarea}/cancelar', [TareaController::class, 'cancelar'])->name('tareas.cancelar');

    Route::get('/tareas/{tarea}/atenciones/create', [AtencionController::class, 'create'])->name('atenciones.create');
    Route::post('/tareas/{tarea}/atenciones', [AtencionController::class, 'store'])->name('atenciones.store');
    Route::get('/atenciones/{atencion}/edit', [AtencionController::class, 'edit'])->name('atenciones.edit');
    Route::put('/atenciones/{atencion}', [AtencionController::class, 'update'])->name('atenciones.update');

    Route::post('/tareas/{tarea}/evidencias', [EvidenciaController::class, 'store'])->name('evidencias.store');
    Route::delete('/evidencias/{evidencia}', [EvidenciaController::class, 'destroy'])->name('evidencias.destroy');

    Route::post('/tareas/{tarea}/comentarios', [ComentarioTareaController::class, 'store'])->name('comentarios.store');

    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
    Route::post('/notificaciones/{notificacion}/leida', [NotificacionController::class, 'marcarLeida'])->name('notificaciones.leida');

    Route::post('/tareas/{tarea}/asignaciones', [AsignacionTareaController::class, 'store'])->name('asignaciones.store');
    Route::delete('/asignaciones/{asignacionTarea}', [AsignacionTareaController::class, 'destroy'])->name('asignaciones.destroy');

    Route::get('/solicitudes-whatsapp', [SolicitudWhatsappController::class, 'index'])->name('solicitudes-whatsapp.index');
    Route::post('/solicitudes-whatsapp', [SolicitudWhatsappController::class, 'store'])->name('solicitudes-whatsapp.store');

    Route::get('/formatos-atencion', [FormatoAtencionController::class, 'index'])->name('formatos-atencion.index');
    Route::get('/formatos-atencion/{formatoAtencion}', [FormatoAtencionController::class, 'show'])->name('formatos-atencion.show');
    Route::get('/formatos-atencion/{formatoAtencion}/edit', [FormatoAtencionController::class, 'edit'])->name('formatos-atencion.edit');
    Route::put('/formatos-atencion/{formatoAtencion}', [FormatoAtencionController::class, 'update'])->name('formatos-atencion.update');
    Route::delete('/formatos-atencion/{formatoAtencion}', [FormatoAtencionController::class, 'destroy'])->name('formatos-atencion.destroy');
    Route::get('/tareas/{tarea}/formatos-atencion/create', [FormatoAtencionController::class, 'create'])->name('formatos-atencion.create');
    Route::post('/tareas/{tarea}/formatos-atencion', [FormatoAtencionController::class, 'store'])->name('formatos-atencion.store');
});
