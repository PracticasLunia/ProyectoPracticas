<?php

namespace App\Http\Validators\Prestamo;

use Illuminate\Foundation\Http\FormRequest;

final class CrearPrestamoValidator extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "libro_id" => "required|exists:libros,id",
            "nombre_lector" => "required|string",
            "email_lector" => "nullable|email",
            'fecha_prestamo' => "required|date",
            "fecha_devolucion_prevista" => "required|date|after_or_equal:fecha_prestamo",
            "fecha_devolucion_real" => "nullable|date",
            "observaciones" => "nullable|string"
        ];
    }
}
