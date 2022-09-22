<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ToolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//Route::resource('empresa', EmpresaController::class);//cuando tenemos un crud proyecto nomal


//Rutas publicas
Route::post('login', [AuthController::class, 'iniciarSesion']);
Route::post('registrar', [AuthController::class, 'guardarUsuario']);

Route::post('upload', [ToolController::class, 'uploadFile']);

//Rutas Protegidas (auth:sanctum)con token
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('menu/{rol_id}/{padreSesion}', [MenuController::class, 'verMenu']);
    
    Route::get('/empresas/listar', [EmpresaController::class, 'listar']);
    Route::get('/empresas/listar/{id}', [EmpresaController::class, 'verId']);
    Route::get('/empresas/buscar/{texto}', [EmpresaController::class, 'buscar']);
    Route::post('/empresas/guardar', [EmpresaController::class, 'guardar']);
    Route::put('/empresas/actualizar/{id}', [EmpresaController::class, 'actualizar']);
    Route::delete('/empresas/eliminar/{id}', [EmpresaController::class, 'eliminar']);
    Route::get('/empresas/reporte/{fechaInicio}/{fechaFin}', [EmpresaController::class, 'reporte']);

    //Ruta para traer imagenes
    Route::get('archivo/{folder}/{file}', [ToolController::class, 'verImagen']);
    
    Route::post('/cerrar-sesion', [AuthController::class, 'cerrarSesion']);
});

/* Route::group(['middleware' => ['cors']], function () {
    //Rutas a las que se permitirá acceso
    Route::post('upload', [ToolController::class, 'uploadFile']);
}); */



/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */


