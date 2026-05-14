<?php

namespace App\Http\Controllers\Prestamo;

use App\Exceptions\Domain\LibroYaPrestadoException;
use App\Http\Controllers\Controller;
use App\Http\UseCases\Prestamo\CrearPrestamo;
use App\Http\UseCases\Prestamo\CrearPrestamoRequest;
use App\Http\Validators\Prestamo\CrearPrestamoValidator;
use Illuminate\Validation\ValidationException;

class CrearPrestamoController extends Controller
{

    public function __construct(
        private readonly CrearPrestamo $crearPrestamo
    ){}

    public function __invoke(CrearPrestamoValidator $request){

    try {
        $prestamo = $this->crearPrestamo->handle(new CrearPrestamoRequest(
            libro_id: (int) $request->input('libro_id'),
            nombre_lector: $request->input('nombre_lector'),
            email_lector: $request->input('email_lector'),
            fecha_prestamo: $request->input('fecha_prestamo'),
            fecha_devolucion_prevista: $request->input('fecha_devolucion_prevista'),
            fecha_devolucion_real: $request->input('fecha_devolucion_real'),
            observaciones: $request->input('observaciones'),
        ));

        return response()->json([
            "data" => $prestamo,
            "message" => "Prestamo creado correctamente",
            "errors" => []
        ], 201);

    }
    catch (LibroYaPrestadoException $e) {
        return response()->json([
            'data' => null,
            'message' => $e->getMessage(),
            'errors' => [],
        ], 409);
    }
    catch (ValidationException $e) {
        return response()->json([
            "data" => null,
            "message" => "No se pudo crear el prestamo",
            "errors" => $e->errors()
        ], 422);
    }

    }
}
