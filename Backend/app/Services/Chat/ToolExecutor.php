<?php

namespace App\Services\Chat;

use App\Models\Libro;
use App\Models\LibroFragmento;
use App\Models\User;
use App\Services\AzureOpenAIClient;

final class ToolExecutor
{
    public function __construct(
        private readonly User $user,
        private AzureOpenAIClient $azureOpenAIClient
    ) {}

    public function ejecutar(string $nombre, array $argumentos): array
    {
        return match ($nombre) {
            'obtener_mi_perfil'           => $this->obtenerMiPerfil(),
            'obtener_mis_prestamos'       => $this->obtenerMisPrestamos(),
            'obtener_mi_historial_lectura' => $this->obtenerMiHistorialLectura(),
            'buscar_libros_en_catalogo'   => $this->buscarLibrosEnCatalogo($argumentos['termino'] ?? ''),
            'buscar_en_contenido_libros' => $this->buscarEnContenidoLibros($argumentos['consulta'] ?? ''),
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

    private function buscarEnContenidoLibros(string $consulta): array{
        if ($consulta === '') {
            return ['error' => 'Consulta vacía'];
        }

        $respuesta = $this->azureOpenAIClient->embeddings()->create([
            'model' => config('services.azure_openai.embedding'),
            'input' => $consulta,
        ]);

        $embeddingConsulta = $respuesta->toArray()['data'][0]['embedding'];

        $fragmentos = LibroFragmento::with('libro')
            ->limit(3000)
            ->get();

        $resultados = [];

        foreach ($fragmentos as $fragmento) {

            $score = $this->cosineSimilarity(
                $embeddingConsulta,
                $fragmento->embedding
            );

            $resultados[] = [
                'libro_id' => $fragmento->libro_id,
                'titulo'   => $fragmento->libro->titulo,
                'pagina'   => $fragmento->pagina,
                'texto'    => $fragmento->texto,
                'score'    => $score,
            ];
        }

        usort($resultados, fn ($a, $b) => $b['score'] <=> $a['score']);

        return array_slice($resultados, 0, 5);
    }

    private function cosineSimilarity(array $a, array $b): float{
        $dot = 0;
        $magA = 0;
        $magB = 0;

        foreach ($a as $i => $val) {
            $dot += $val * $b[$i];
            $magA += $val * $val;
            $magB += $b[$i] * $b[$i];
        }

        return $dot / (sqrt($magA) * sqrt($magB) + 1e-10);
    }



}
