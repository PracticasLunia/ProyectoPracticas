<?php

namespace App\Http\Validators\Autor;

use Illuminate\Foundation\Http\FormRequest;
use Override;

final class ActualizarAutorValidator extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "nombre" => "required|string",
            "apellidos" => "required|string",
            "nacionalidad" => "nullable|string",
            "fecha_nacimiento"=>"nullable|date",
            "biografia"=>"nullable|string",
        ];
    }

    public function messages() : array
    {
        return [
            "nombre.required" => "El nombre es requerido",
            "nombre.string" => "El nombre debe ser texto"
        ];

    }

}
