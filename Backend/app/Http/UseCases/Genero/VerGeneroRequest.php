<?php

namespace App\Http\UseCases\Genero;


final readonly class VerGeneroRequest
{
    public function __construct(
        public int $genero_id
    ) {}
}
