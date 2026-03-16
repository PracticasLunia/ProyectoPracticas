<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Controllers
use App\Http\Controllers\Libro\ListarLibrosController;
use App\Http\Controllers\Libro\BuscarLibrosController;
use App\Http\Controllers\Libro\VerLibroController;
use App\Http\Controllers\Libro\CrearLibroController;
use App\Http\Controllers\Libro\ActualizarLibroController;
use App\Http\Controllers\Libro\EliminarLibroController;


//Routes
Route::get('/libros', ListarLibrosController::class);
Route::get('/libros/buscar?q=', BuscarLibrosController::class);
Route::get('/libros/{id}', VerLibroController::class);
Route::post('/libros', CrearLibroController::class);
Route::put('/libros/{id}', ActualizarLibroController::class);
Route::delete('/libros/{id}', EliminarLibroController::class);
