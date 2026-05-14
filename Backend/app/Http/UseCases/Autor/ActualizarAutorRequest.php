<?php

namespace App\Http\UseCases\Autor;


final readonly class ActualizarAutorRequest
{
    public function __construct(
        public string $nombre,
        public string $apellidos,
        public ?string $nacionalidad,
        public ?string $fecha_nacimiento,
        public ?string $biografia,
    ) {}
}
