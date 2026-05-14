<?php

namespace App\Http\UseCases\Prestamo;

final readonly class VerPrestamoRequest
{
    public function __construct(
        public int $prestamo_id,
    ) {}
}
