<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CrearPrestamoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

    try {
        $request->validate([
            "libro_id" => "required|exists:libros,id",
            "nombre_lector" => "required|string",
            "email_lector" => "nullable|email",
            'fecha_prestamo' => "required|date",
            "fecha_devolucion_prevista" => "required|date|after_or_equal:fecha_prestamo",
            "fecha_devolucion_real" => "nullable|date",
            "observaciones" => "nullable|string"
        ]);

    } catch (ValidationException $e) {
        return response()->json([
            "data" => null,
            "message" => "No se pudo crear el prestamo",
            "errors" => $e->errors()
        ], 422);
    }

    $prestamo= Prestamo::create($request->all());

    return response()->json([
        "data" => $prestamo,
        "message" => "Prestamo creado correctamente",
        "errors" => []
    ], 200);

    }
}
