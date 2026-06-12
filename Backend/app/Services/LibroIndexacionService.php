<?php

namespace App\Services;

use App\Models\Libro;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class LibroIndexacionService
{
    public function handle(): void
    {
        Libro::query()
            ->whereNotNull('contenido_path')
            ->chunkById(20, function ($libros) {
                foreach ($libros as $libro) {
                    $this->indexarLibro($libro);
                }
            });
    }

    public function indexarLibro(Libro $libro): void
    {
        $paginas = $this->obtenerTextoPorPaginas(
            $libro->contenido_path
        );

        $libro->fragmentos()->delete();

        foreach ($paginas as $numeroPagina => $datosPagina) {

            $fragmentos = $this->trocearTextoDePagina(
                $datosPagina['texto']
            );

            foreach ($fragmentos as $orden => $textoFragmento) {

                $embedding = $this->crearEmbedding(
                    $textoFragmento
                );

                $libro->fragmentos()->create([
                    'pagina' => $numeroPagina,
                    'orden' => $orden,
                    'contenido' => $textoFragmento,
                    'origen' => $datosPagina['origen'],
                    'embedding' => $embedding,
                ]);
            }
        }
    }

    private function obtenerTextoPorPaginas(string $contenidoPath): array {
        $rutaPdf = Storage::disk('local')->path(
            $contenidoPath
        );

        $parser = new Parser();

        $pdf = $parser->parseFile($rutaPdf);

        $resultado = [];

        foreach ($pdf->getPages() as $indice => $pagina) {

            $numeroPagina = $indice + 1;

            $texto = trim($pagina->getText());

            if (mb_strlen($texto) < 50) {

                $texto = $this->extraerTextoConOCR(
                    $rutaPdf,
                    $numeroPagina
                );

                $resultado[$numeroPagina] = [
                    'texto' => $texto,
                    'origen' => 'ocr',
                ];

                continue;
            }

            $resultado[$numeroPagina] = [
                'texto' => $texto,
                'origen' => 'pdf',
            ];
        }

        return $resultado;
    }

    private function trocearTextoDePagina(string $texto): array {
        $texto = trim($texto);

        if ($texto === '') {
            return [];
        }

        return str_split($texto, 1000);
    }

    private function crearEmbedding(string $texto): array {

        return [];
    }

    private function extraerTextoConOCR(string $rutaPdf, int $pagina): string {

        

        return '';
    }
}
