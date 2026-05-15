<?php

namespace App\Http\UseCases\Genero;


final readonly class CrearGeneroRequest
{
    public function __construct(
        public string $nombre,
        public ?string $descripcion,
    ) {}
}
