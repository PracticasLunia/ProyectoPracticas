<?php

namespace App\Http\UseCases\Prestamo;

final readonly class CrearPrestamoRequest
{
    public function __construct(
        public int $libro_id,
        public string $nombre_lector,
        public ?string $email_lector,
        public string $fecha_prestamo,
        public string $fecha_devolucion_prevista,
        public ?string $fecha_devolucion_real,
        public ?string $observaciones
    ) {}
}
