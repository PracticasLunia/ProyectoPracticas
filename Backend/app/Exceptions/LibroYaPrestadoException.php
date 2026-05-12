<?php

namespace App\Exceptions\Domain;

use Override;
use RunTimeException;
use Throwable;

class LibroYaPrestadoException extends RunTimeException
{

    public function __construct(int $libroId = 0)
    {
        return parent::__construct("El libro {$libroId} ya tiene un prestamo activo");
    }
}
