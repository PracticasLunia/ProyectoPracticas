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

        $autor= $this->autoresRepository->getById($id);

        if(is_null($autor)){
             return response()->json([
                'data'=>null,
                'message'=>'Autor no encontrado',
                'errors'=>[]
            ], 404 );
        }

        $librosDeAutor= $this->autoresRepository->getBooks($autor);

        return response()->json([
            "data" => $librosDeAutor,
            "message" => "Libros del Autor",
            "errors" => [],
        ], 200);
        
    }
}
