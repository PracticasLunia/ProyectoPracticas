<?php

namespace App\Http\UseCases\Genero;


final readonly class EliminarGeneroRequest
{
    public function __construct(
        public int $genero_id
    ) {}
}
