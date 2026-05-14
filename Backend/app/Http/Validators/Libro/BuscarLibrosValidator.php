<?php

namespace App\Http\Validators\Libro;

use Illuminate\Foundation\Http\FormRequest;

final class BuscarLibrosValidator extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array {

        return [
            "titulo" => "nullable|string",
            "isbn" => "nullable|string",
            "publicacion"=>"nullable|integer",
            "sinopsis"=>"nullable|max:255",
            "num_paginas"=>"nullable|integer|min:1|max:1000",
            "disponible" => "nullable|boolean",
            "autor_id"=> "nullable|string",
            "genero_nombre" => "nullable|string",
        ];
    }
}
