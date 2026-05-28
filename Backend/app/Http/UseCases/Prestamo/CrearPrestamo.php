<?php

namespace App\Http\UseCases\Prestamo;
use App\Repositories\Prestamo\PrestamoRepositoryInterface;
use App\Exceptions\Domain\LibroYaPrestadoException;
use App\Models\Prestamo;
use App\Models\User;

final readonly class CrearPrestamo {

    public function __construct(
        private PrestamoRepositoryInterface $prestamosRepository,
    ){}

    public function handle(CrearPrestamoRequest $request): ?Prestamo {

        // Verificar si ya existe un préstamo activo
        $prestamoActivo = $this->prestamosRepository->existePrestamoActivo($request->libro_id);

        if ($prestamoActivo) {
            throw new LibroYaPrestadoException($request->libro_id);
        }

        //Verificar si el correo esta asociado a un usuario
        $userId = $request->email_lector
            ? User::where('email', $request->email_lector)->value('id')
            : null;

        $prestamo = $this->prestamosRepository->store([
            'libro_id' => $request->libro_id,
            'user_id' => $userId,
            'nombre_lector' => $request->nombre_lector,
            'email_lector' => $request->email_lector,
            'fecha_prestamo' => $request->fecha_prestamo,
            'fecha_devolucion_prevista' => $request->fecha_devolucion_prevista,
            'fecha_devolucion_real' => $request->fecha_devolucion_real,
            'observaciones' => $request->observaciones,
        ]);

        return $prestamo;

    }

}

?>
