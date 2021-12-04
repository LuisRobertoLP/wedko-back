<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\Proyecto\ProyectoController;
use App\Http\Controllers\Proyecto\ProyectoUsuariosController;
use App\Http\Controllers\Proyecto\ProyectoComentarioController;
use App\Http\Controllers\Proyecto\ProyectoActividadController;
use App\Http\Controllers\Proyecto\ProyectoActividadComentarioController;
use App\Http\Controllers\Proyecto\ProyectoActividadUsuariosController;
use App\Http\Controllers\Usuario\UsuarioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::group(['middleware' => ['auth:api']], function () {
    //validar toke
    Route::get('/renew', [TokenController::class, 'renew']);

    Route::get('/usuarios/{nombre}', [UsuarioController::class, 'index'])->name('usuarios');

    //proyectos
    Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos');
    Route::post('/proyecto', [ProyectoController::class, 'store'])->name('proyecto.store');
    Route::get('/proyecto/{id}/show', [ProyectoController::class, 'show'])->name('proyecto.show');
    Route::put('/proyecto/{id}', [ProyectoController::class, 'update'])->name('proyecto.update');
    
    //usuarios proyecto
    Route::get('/proyecto/{id}/usuarios', [ProyectoUsuariosController::class, 'index'])->name('proyectos.usuarios');
    Route::post('/proyecto/{id}/usuario/store', [ProyectoUsuariosController::class, 'store'])->name('proyecto.usuario.store');
    Route::get('/proyecto/{id}/buscar_usuario/{nombre}', [ProyectoUsuariosController::class, 'buscar_usuario'])->name('proyectos.buscar_usuario');

    //comentarios
    Route::get('/proyecto/{id}/comentarios', [ProyectoComentarioController::class, 'index'])->name('proyectos.comentarios');
    Route::post('/proyecto/{id}/comentario/store', [ProyectoComentarioController::class, 'store'])->name('proyecto.comentario.store');

    //comentarios actividades
    Route::get('/actividad/{id}/comentarios', [ProyectoActividadComentarioController::class, 'index'])->name('actividad.comentarios');
    Route::post('/actividad/{id}/comentario/store', [ProyectoActividadComentarioController::class, 'store'])->name('actividad.comentario.store');

    //actividades proyecto
    Route::get('/proyecto/{id}/actividades', [ProyectoActividadController::class, 'index'])->name('proyectos.actividades');
    Route::post('/proyecto/{id}/actividad/store', [ProyectoActividadController::class, 'store'])->name('proyecto.actividad.store');
    Route::put('/proyecto/{id}/actividad/{proyecto_actividad_id}/update', [ProyectoActividadController::class, 'update'])->name('proyecto.actividad.update');
    Route::get('/proyecto/{id}/actividad/{proyecto_actividad_id}/show', [ProyectoActividadController::class, 'show'])->name('proyecto.actividad.show');
    
    //usuarios proyecto actividad
    Route::get('/proyecto/{id}/actividad/{proyecto_actividad_id}/usuarios', [ProyectoActividadUsuariosController::class, 'index'])->name('proyectos.actividad.usuarios');
    Route::post('/proyecto/{id}/actividad/{proyecto_actividad_id}/usuario/store', [ProyectoActividadUsuariosController::class, 'store'])->name('proyecto.actividad.usuario.store');

});
