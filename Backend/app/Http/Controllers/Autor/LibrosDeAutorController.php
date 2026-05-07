<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Autor\AutorRepositoryInterface;

class LibrosDeAutorController extends Controller
{

    public function __construct(
        private readonly AutorRepositoryInterface $autoresRepository
    ){}

    public function __invoke(Request $request, $id){

        $librosDeAutor= $this->autoresRepository->getBooks($id);

        if(is_null($librosDeAutor)){
             return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[]
            ], 404 );
        }

        return response()->json([
            "data" => $librosDeAutor,
            "message" => "Libros del Autor",
            "errors" => [],
        ], 200);

        try {

            $autor=Autor::with('libros')->findOrFail($id);
            $autorLibros=$autor->libros()->with('generos')->get();

            //Devuelve unicamente los libros, con sus generos relacionados, de aquel autor
            return response()->json([
                "data" => $autorLibros,
                "message" => "Libros del Autor",
                "errors" => [],
            ], 200);

        }catch (ModelNotFoundException) {
             return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[]
            ], 404 );
        }
    }
}
