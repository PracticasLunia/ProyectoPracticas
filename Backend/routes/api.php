<?php
//imports

use App\Http\Controllers\AuthAuthentication\LoginController;
use App\Http\Controllers\AuthAuthentication\LogoutController;
use App\Http\Controllers\AuthAuthentication\RegisterController;
use App\Http\Controllers\AuthAuthentication\UserController;
use App\Http\Controllers\Autor\ActualizarAutorController;
use App\Http\Controllers\Autor\CrearAutorController;
use App\Http\Controllers\Autor\EliminiarAutorController;
use App\Http\Controllers\Autor\LibrosDeAutorController;
use App\Http\Controllers\Autor\ListarAutoresController;
use App\Http\Controllers\Autor\VerAutorController;
use App\Http\Controllers\Genero\ActualizarGeneroController;
use App\Http\Controllers\Genero\CrearGeneroController;
use App\Http\Controllers\Genero\EliminarGeneroController;
use App\Http\Controllers\Genero\LibrosDeGeneroController;
use App\Http\Controllers\Genero\ListarGenerosController;
use App\Http\Controllers\Genero\VerGeneroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Controllers-----------------------------------------
use App\Http\Controllers\Libro\ListarLibrosController;
use App\Http\Controllers\Libro\BuscarLibrosController;
use App\Http\Controllers\Libro\VerLibroController;
use App\Http\Controllers\Libro\CrearLibroController;
use App\Http\Controllers\Libro\ActualizarLibroController;
use App\Http\Controllers\Libro\ContenidoLibroController;
use App\Http\Controllers\Libro\EliminarLibroController;
use App\Http\Controllers\Libro\PortadaLibroController;
use App\Http\Controllers\Prestamo\CrearPrestamoController;
use App\Http\Controllers\Prestamo\DevolverPrestamoController;
use App\Http\Controllers\Prestamo\ListarPrestamosController;
use App\Http\Controllers\Prestamo\PrestamosDeLibroController;
use App\Http\Controllers\Prestamo\VerPrestamoController;

//Routes Authentication----------------------
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', UserController::class);
    Route::post('/logout', LogoutController::class);
});


//Routes Libros---------------------------------------------
Route::get('/libros/buscar', BuscarLibrosController::class);
Route::get('/libros', ListarLibrosController::class);
Route::get('/libros/{id}', VerLibroController::class);

//Proteccion de rutas con middleware para usuarios auntenticados
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/libros', CrearLibroController::class);
    Route::put('/libros/{id}', ActualizarLibroController::class);
    Route::delete('/libros/{id}', EliminarLibroController::class);
    Route::get('libros/{id}/portada', PortadaLibroController::class);
    Route::get('libros/{id}/contenido', ContenidoLibroController::class);
});

//Routes Autores--------------------------------------
Route::get('/autores', ListarAutoresController::class);
Route::get('autores/{id}', VerAutorController::class);
Route::post('autores', CrearAutorController::class);
Route::put('autores/{id}', ActualizarAutorController::class);
Route::delete('autores/{id}', EliminiarAutorController::class);

//Routes Generos--------------------------------------
Route::get('/generos', ListarGenerosController::class);
Route::get('generos/{id}', VerGeneroController::class);
Route::post('generos', CrearGeneroController::class);
Route::put('generos/{id}', ActualizarGeneroController::class);
Route::delete('generos/{id}', EliminarGeneroController::class);

//Routes prestamos---------------------------------------
Route::get('prestamos', ListarPrestamosController::class);
Route::get('prestamos/{id}', VerPrestamoController::class);
Route::post('prestamos', CrearPrestamoController::class);
Route::put('prestamos/{id}/devolver', DevolverPrestamoController::class);
Route::get('prestamos/{id}/libro', PrestamosDeLibroController::class);

//Libros by autor
Route::get('autores/{id}/libros', LibrosDeAutorController::class);
//Libros by genero
Route::get('generos/{id}/libros', LibrosDeGeneroController::class);
//Busqueda ampliada
