<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Libro\ListarLibros;
use Illuminate\Http\Request;
use App\Repositories\Libro\LibroRepositoryInterface;

class ListarLibrosController extends Controller
{
    public function __construct(
        private readonly ListarLibros $listar_libros
    ){}

    public function __invoke(Request $request){

        $listadoLibros = $this->listar_libros->handle();

        return response()->json([
            'data' => $listadoLibros,
            'message' => 'Listado de libros',
        ], 200);
    }
}
