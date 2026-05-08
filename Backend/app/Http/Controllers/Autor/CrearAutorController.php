<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Repositories\Autor\AutorRepositoryInterface;

class CrearAutorController extends Controller
{

    public function __construct(
        private readonly AutorRepositoryInterface $autoresRepository
    ){}

    public function __invoke(Request $request){

        try {
        $request->validate([
            "nombre" => "required|string",
            "apellidos" => "required|string",
            "nacionalidad" => "nullable|string",
            "fecha_nacimiento"=>"nullable|date",
            "biografia"=>"nullable|string",
        ]);

        }catch (ValidationException $e) {
             return response()->json([
                'data'=>null,
                'message'=>'El autor no se pudo crear, errores de validación',
                'errors'=>$e->errors(),
            ], 404 );
        }

        //$autor = Autor::create($request->all());
        //No enviar toda la request que involucra recibir HTTP validar ,transformar input ,decidir response
        //$data = $request->validated();

        $data = [
            'nombre' => $request->input('nombre'),
            'apellidos' => $request->input('apellidos'),
            'nacionalidad' =>$request->input('nacionalidad'),
            'fecha_nacimiento' => $request->input('fecha_nacimiento'),
            'biografia' => $request->input('biografia'),
        ];

        $autor = $this->autoresRepository->store($data);

        return response()->json([
            "data" => $autor,
            "message" => "Autor creado correctamente",
            "errors" => []
        ], 200);
    }
}
