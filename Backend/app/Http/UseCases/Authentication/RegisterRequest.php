<?php

namespace App\Http\UseCases\Authentication;

use App\Models\User;

final readonly class RegisterRequest
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}
