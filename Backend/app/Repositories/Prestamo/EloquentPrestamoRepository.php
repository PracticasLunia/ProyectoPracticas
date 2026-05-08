<?php

namespace App\Repositories\Prestamo;

use App\Models\Libro;
use App\Models\Prestamo;
use App\Repositories\Prestamo\PrestamoRepositoryInterface;
use Illuminate\Support\Collection;
use Override;

class EloquentPrestamoRepository implements PrestamoRepositoryInterface{

    public function getAll(): Collection{
        return Prestamo::all();
    }

    public function getById(int $id): ? Prestamo{
        return Prestamo::find($id);
    }

    public function store(array $data): Prestamo {
        return Prestamo::create($data);
    }

    public function returnPrestamo(Prestamo $prestamo): Prestamo {
        $prestamo->update([
            'fecha_devolucion_real' => now()
        ]);
        return $prestamo;
    }

    public function isActive(int $libroId): bool {
        return
            Prestamo::where('libro_id', $libroId)
                ->whereNull('fecha_devolucion_real')
                ->exists();
    }

    public function prestamosDeLibro(Libro $libro): Collection {
        $prestamosLibros = $libro->load('prestamos');
        return $prestamosLibros->prestamos;
    }

}
