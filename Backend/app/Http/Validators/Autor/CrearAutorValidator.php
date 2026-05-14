<?php

namespace App\Http\Validators\Autor;

use Illuminate\Foundation\Http\FormRequest;

final class CrearAutorValidator extends FormRequest
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
}
