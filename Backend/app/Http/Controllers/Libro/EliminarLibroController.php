<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Libro\LibroRepositoryInterface;


class EliminarLibroController extends Controller
{
    public function __construct(
        private readonly LibroRepositoryInterface $librosRepository
    ){}

    public function __invoke(Request $request, $id){

        $libro = $this->librosRepository->getById($id);

        if(is_null($libro)){
            return response()->json([
                'data'=>null,
                'message'=>'Libro no encontrado',
                'errors'=>[]
            ], 404 );
        }

        $rutaPortada = $libro->portada_path;

        $libro->delete();

        //Eliminar la ruta de la portada asociada, si la tiene
        if ($rutaPortada) {
            Storage::disk('local')->delete($rutaPortada);
        }
        return response()->json([
            "data"=>null,
            "message"=>"Libro eliminado",
            "errors"=>[],
        ], 204);

    }
}
