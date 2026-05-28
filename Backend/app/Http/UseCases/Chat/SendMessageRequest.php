<?php

namespace App\Http\UseCases\Chat;

use App\Models\User;

final readonly class SendMessageRequest
{
    public function __construct(
        public array $messages,
        public string $model,
         public User $user,
    ) {}
}
