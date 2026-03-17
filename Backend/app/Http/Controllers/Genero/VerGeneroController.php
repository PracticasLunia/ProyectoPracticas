<?php

namespace App\Http\Controllers\Genero;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use Illuminate\Http\Request;

class VerGeneroController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        //findOrFail return exception
        try {
            $genero=Genero::findOrFail($id);
            return response()->json(
                $genero , 200);
        } catch (\Throwable $th) {
            return response()->json(
                ["message"=>"Genero no encontrado"], 400);
        }
    }
}
