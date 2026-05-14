<?php

namespace App\Exceptions\Domain;

use RuntimeException;

class LibroYaPrestadoException extends RuntimeException
{

    public function __construct(int $libroId = 0)
    {
        parent::__construct("El libro {$libroId} ya tiene un prestamo activo");
    }
}
