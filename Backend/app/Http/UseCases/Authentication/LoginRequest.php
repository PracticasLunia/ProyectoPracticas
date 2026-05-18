<?php

namespace App\Http\UseCases\Authentication;

use App\Models\User;

final readonly class LoginRequest
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
