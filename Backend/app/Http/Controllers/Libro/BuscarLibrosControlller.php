<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\Request;

class BuscarLibrosController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $q)
    {
        //
       $libros= Libro::where('titulo' , 'LIKE', "%{$q}%")->get();

       if($libros->isEmpty()){
        return response()->json([
            "Ningun libro encontrado", 404
        ]);
       }
       else{
        return response()->json([
            $libros, 200
        ]);
       }
    }
}
