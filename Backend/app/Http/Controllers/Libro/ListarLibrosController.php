<?php

namespace App\Http\Controllers\Libro;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\Request;

class ListarLibrosController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
        $Listadolibros= Libro::all();
        return response()->json(
            [
                'data' => $Listadolibros,
                'message' => 'Listado de libros',
            ]
        , 200);
    }
}
