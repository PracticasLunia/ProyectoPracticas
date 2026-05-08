<?php

namespace App\Http\Controllers\Prestamo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Repositories\Prestamo\PrestamoRepositoryInterface;

class CrearPrestamoController extends Controller
{

    public function __construct(
        private readonly PrestamoRepositoryInterface $prestamosRepository
    ){}

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

    $libroId = $request->input('libro_id');

    // Verificar si ya existe un préstamo activo
    $prestamoActivo = $this->prestamosRepository->isActive($libroId);

    if ($prestamoActivo) {
        return response()->json([
            'data' => null,
            'message' => 'Este libro ya tiene un prestamo activo',
            'errors' => []
        ], 422);
    }

    $data = [
        'libro_id' => $request->input('libro_id'),
        'nombre_lector' => $request->input('nombre_lector'),
        'email_lector' => $request->input('email_lector'),
        'fecha_prestamo' => $request->input('fecha_prestamo'),
        'fecha_devolucion_prevista' => $request->input('fecha_devolucion_prevista'),
        'fecha_devolucion_real' => $request->input('fecha_devolucion_real'),
        'observaciones' => $request->input('observaciones')
    ];

    $prestamo = $this->prestamosRepository->store($data);

    return response()->json([
        "data" => $prestamo,
        "message" => "Prestamo creado correctamente",
        "errors" => []
    ], 201);

    }
}
