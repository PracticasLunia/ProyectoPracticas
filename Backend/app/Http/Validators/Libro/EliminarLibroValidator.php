<?php

namespace App\Http\Validators\Libro;

use Illuminate\Foundation\Http\FormRequest;

final class EliminarLibroValidator extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array {

    //Aunque el validator se use “dentro del controlador”, Laravel lo ejecuta ANTES. Se usa el parametro de la ruta
        $id = $this->route('id');

        return [

        ];
    }
}
