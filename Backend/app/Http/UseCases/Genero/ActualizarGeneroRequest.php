<?php

namespace App\Http\UseCases\Genero;


final readonly class ActualizarGeneroRequest
{
    public function __construct(
        public string $nombre,
        public ?string $descripcion,

        public int $genero_id
    ) {}
}
