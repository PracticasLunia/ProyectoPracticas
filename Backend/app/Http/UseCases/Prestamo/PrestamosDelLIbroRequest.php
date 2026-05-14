<?php

namespace App\Http\UseCases\Prestamo;

final readonly class PrestamosDelLibroRequest
{
    public function __construct(
        public int $libro_id,
    ) {}
}
