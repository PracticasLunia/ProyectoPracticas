<?php

namespace App\Http\Validators\Libro;

use Illuminate\Foundation\Http\FormRequest;

final class ActualizarLibroValidator extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array {

    //Aunque el validator se use “dentro del controlador”, Laravel lo ejecuta ANTES. Se usa el parametro de la ruta
        $id = $this->route('id');

        return [
            "titulo" => "required|string",
            "isbn" => "required|string|unique:libros,isbn,".$id,
            "publicacion"=>"required|integer",
            "sinopsis"=>"nullable|max:255",
            "num_paginas"=>"required|integer|min:1|max:1000",
            "disponible" => "boolean",
            "autor_id"=> "required|exists:autores,id",
            "genero_ids" => "required|array",
            "portada" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048",
            "contenido"=>"nullable|file|mimes:pdf|max:20480",
        ];
    }
}
