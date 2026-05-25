<?php

namespace App\Http\UseCases\Chat;


final readonly class SendMessageRequest
{
    public function __construct(
        public string $message,
        public string $model,
    ) {}
}
