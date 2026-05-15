<?php

namespace App\Http\Validators\Genero;

use Illuminate\Foundation\Http\FormRequest;

final class ActualizarGeneroValidator extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "nombre" => "required|string",
            "descripcion"=>"nullable|string",
        ];
    }

    public function messages()
    {
        return [
            "nombre.required" => "El nombre es obligatorio",
            "nombre.string" => "El nombre debe ser un texto"
        ];
    }
}
