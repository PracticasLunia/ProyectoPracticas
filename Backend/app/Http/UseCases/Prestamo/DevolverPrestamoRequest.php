<?php

namespace App\Http\UseCases\Prestamo;

final readonly class DevolverPrestamoRequest
{
    public function __construct(
        public int $prestamo_id,
    ) {}
}
