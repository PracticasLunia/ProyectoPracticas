<?php

namespace App\Services\Chat;

use App\Models\Libro;
use App\Models\User;

final class ToolExecutor
{
    public function __construct(
        private readonly User $user
    ) {}

    public function ejecutar(string $nombre, array $argumentos): array
    {
        return match ($nombre) {
            'obtener_mi_perfil'           => $this->obtenerMiPerfil(),
            'obtener_mis_prestamos'       => $this->obtenerMisPrestamos(),
            'obtener_mi_historial_lectura' => $this->obtenerMiHistorialLectura(),
            'buscar_libros_en_catalogo'   => $this->buscarLibrosEnCatalogo($argumentos['termino'] ?? ''),
            default                       => ['error' => "Tool desconocida: {$nombre}"],
        };
    }

    private function obtenerMiPerfil(): array
    {
        return [
            'nombre' => $this->user->name,
            'email'  => $this->user->email,
        ];
    }

    private function obtenerMisPrestamos(): array
    {
        $prestamos = $this->user->prestamos()
            ->whereNull('fecha_devolucion_real')
            ->with('libro.autor')
            ->orderBy('fecha_prestamo', 'desc')
            ->get();

        return $prestamos->map(fn ($p) => [
            'titulo'         => $p->libro->titulo,
            'autor'          => $p->libro->autor->nombre ?? 'desconocido',
            'fecha_prestamo' => $p->fecha_prestamo,
            'fecha_devolucion_prevista' => $p->fecha_devolucion_prevista,
        ])->all();
    }

    private function obtenerMiHistorialLectura(): array
    {
        $prestamos = $this->user->prestamos()
            ->whereNotNull('fecha_devolucion_real')
            ->with('libro.autor')
            ->orderBy('fecha_devolucion_real', 'desc')
            ->limit(5)
            ->get();

        return $prestamos->map(fn ($p) => [
            'titulo'                => $p->libro->titulo,
            'autor'                 => $p->libro->autor->nombre ?? 'desconocido',
            'fecha_devolucion_real' => $p->fecha_devolucion_real,
        ])->all();
    }

    private function buscarLibrosEnCatalogo(string $termino): array
    {
        if ($termino === '') {
            return ['error' => 'Falta el término de búsqueda'];
        }

        $libros = Libro::with('autor')
            ->where('titulo', 'like', "%{$termino}%")
            ->orWhereHas('autor', fn ($q) => $q->where('nombre', 'like', "%{$termino}%"))
            ->orWhere('sinopsis', 'like', "%{$termino}%")
            ->limit(10)
            ->get();

        return $libros->map(fn ($l) => [
            'id'         => $l->id,
            'titulo'     => $l->titulo,
            'autor'      => $l->autor->nombre ?? 'desconocido',
            'publicacion' => $l->publicacion,
            'disponible' => $l->getTienePrestamoActivoAttribute() === false,
        ])->all();
    }
}
