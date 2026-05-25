<?php

namespace App\Http\Validators\Chat;

use Illuminate\Foundation\Http\FormRequest;
use Override;

final class SendMessageValidator extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "message" => "required|string",
        ];
    }

}
