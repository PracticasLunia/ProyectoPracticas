<?php

namespace App\Http\Validators\Chat;

use Illuminate\Foundation\Http\FormRequest;

final class SendMessageValidator extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "messages" => "required|array|min:1",
            "messages.*.role"    => "required|string|in:user,assistant",
            "messages.*.content" => "required|string",
        ];
    }

}
