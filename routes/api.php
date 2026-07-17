<?php

use App\Http\Controllers\Api\AsignacionApiController;
use App\Http\Controllers\Api\AtencionApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ComentarioApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\EquipoApiController;
use App\Http\Controllers\Api\EvidenciaApiController;
use App\Http\Controllers\Api\FormatoAtencionApiController;
use App\Http\Controllers\Api\NotificacionApiController;
use App\Http\Controllers\Api\OficinaApiController;
use App\Http\Controllers\Api\TareaApiController;
use App\Http\Controllers\Api\UsuarioApiController;
use Illuminate\Support\Facades\Route;

// === PÚBLICO ===
Route::post('/auth/login', [AuthApiController::class, 'login']);
Route::post('/auth/register', [AuthApiController::class, 'register']);

Route::get('/ping', fn () => response()->json(['message' => 'SITEC API OK']));

// === AUTENTICADO ===
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/auth/logout', [AuthApiController::class, 'logout']);
    Route::get('/auth/profile', [AuthApiController::class, 'profile']);
    Route::put('/auth/profile', [AuthApiController::class, 'updateProfile']);

    // Dashboard
    Route::get('/dashboard', [DashboardApiController::class, 'index']);

    // Tareas - todos autenticados
    Route::post('/tareas', [TareaApiController::class, 'store']);
    Route::get('/tareas/{tarea}', [TareaApiController::class, 'show']);
    Route::post('/tareas/{tarea}/comentarios', [ComentarioApiController::class, 'store']);
    Route::post('/tareas/{tarea}/autoasignar', [TareaApiController::class, 'autoasignar']);

    // Notificaciones - todos autenticados
    Route::get('/notificaciones', [NotificacionApiController::class, 'index']);
    Route::post('/notificaciones/{notificacion}/leida', [NotificacionApiController::class, 'marcarLeida']);
    Route::post('/notificaciones/leer-todas', [NotificacionApiController::class, 'marcarTodasLeidas']);

    // === JEFE + PRACTICANTE ===
    Route::middleware('api_rol:jefe,practicante')->group(function () {
        Route::get('/tareas', [TareaApiController::class, 'index']);
        Route::put('/tareas/{tarea}', [TareaApiController::class, 'update']);
        Route::delete('/tareas/{tarea}', [TareaApiController::class, 'destroy']);

        Route::post('/tareas/{tarea}/aceptar', [TareaApiController::class, 'aceptar']);
        Route::post('/tareas/{tarea}/iniciar', [TareaApiController::class, 'iniciar']);
        Route::post('/tareas/{tarea}/finalizar', [TareaApiController::class, 'finalizar']);

        Route::post('/tareas/{tarea}/atenciones', [AtencionApiController::class, 'store']);
        Route::put('/atenciones/{atencion}', [AtencionApiController::class, 'update']);
        Route::get('/atenciones/{atencion}', [AtencionApiController::class, 'show']);

        Route::post('/tareas/{tarea}/evidencias', [EvidenciaApiController::class, 'store']);
        Route::delete('/evidencias/{evidencia}', [EvidenciaApiController::class, 'destroy']);

        Route::get('/formatos-atencion', [FormatoAtencionApiController::class, 'index']);
        Route::get('/formatos-atencion/{formatoAtencion}', [FormatoAtencionApiController::class, 'show']);
        Route::post('/tareas/{tarea}/formatos-atencion', [FormatoAtencionApiController::class, 'store']);
        Route::get('/tareas/{tarea}/formatos-atencion/defaults', [FormatoAtencionApiController::class, 'defaults']);
        Route::put('/formatos-atencion/{formatoAtencion}', [FormatoAtencionApiController::class, 'update']);
        Route::delete('/formatos-atencion/{formatoAtencion}', [FormatoAtencionApiController::class, 'destroy']);
        Route::get('/formatos-atencion/{formatoAtencion}/pdf', [FormatoAtencionApiController::class, 'pdf']);
        Route::post('/formatos-atencion/{formatoAtencion}/firma', [FormatoAtencionApiController::class, 'firma']);
    });

    // === SOLO JEFE ===
    Route::middleware('api_rol:jefe')->group(function () {
        // Tareas - acciones de jefe
        Route::post('/tareas/{tarea}/asignar', [TareaApiController::class, 'asignar']);
        Route::post('/tareas/{tarea}/observar', [TareaApiController::class, 'observar']);
        Route::post('/tareas/{tarea}/cancelar', [TareaApiController::class, 'cancelar']);

        // Asignaciones
        Route::post('/tareas/{tarea}/asignaciones', [AsignacionApiController::class, 'store']);
        Route::delete('/asignaciones/{asignacionTarea}', [AsignacionApiController::class, 'destroy']);

        // Usuarios
        Route::get('/usuarios', [UsuarioApiController::class, 'index']);
        Route::post('/usuarios', [UsuarioApiController::class, 'store']);
        Route::put('/usuarios/{usuario}', [UsuarioApiController::class, 'update']);
        Route::delete('/usuarios/{usuario}', [UsuarioApiController::class, 'destroy']);

        // Oficinas
        Route::get('/oficinas', [OficinaApiController::class, 'index']);
        Route::post('/oficinas', [OficinaApiController::class, 'store']);
        Route::put('/oficinas/{oficina}', [OficinaApiController::class, 'update']);
        Route::delete('/oficinas/{oficina}', [OficinaApiController::class, 'destroy']);

        // Equipos
        Route::get('/equipos', [EquipoApiController::class, 'index']);
        Route::post('/equipos', [EquipoApiController::class, 'store']);
        Route::put('/equipos/{equipo}', [EquipoApiController::class, 'update']);
        Route::delete('/equipos/{equipo}', [EquipoApiController::class, 'destroy']);
    });
});
