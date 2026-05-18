<?php

namespace App\Http\Validators\Authentication;

use Illuminate\Foundation\Http\FormRequest;

final class RegisterValidator extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users,email",
            "password" => "required|string|min:8|confirmed",
        ];
    }

    public function messages() : array
    {
        return [
            "name.required" => "El nombre es requerido",
            "name.string" => "El nombre debe ser texto"
        ];

    }

}
