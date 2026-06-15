<?php

namespace App\Services;

use App\Models\Libro;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use App\Services\AzureOpenAIClient;
use Illuminate\Support\Str;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Imagick;

class LibroIndexacionService
{

    public function __construct(
        private AzureOpenAIClient $azureOpenAIClient
    ) {}

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
                'origen' => 'pdf_text',
            ];
        }

        return $resultado;
    }

    private function trocearTextoDePagina(string $texto): array {
        $texto = trim($texto);

        if ($texto === '') {
            return [];
        }

        $palabras = preg_split('/\s+/', $texto);

        $fragmentos = [];
        $chunkActual = [];
        $limitePalabras = 700;

        foreach ($palabras as $palabra) {

            $chunkActual[] = $palabra;

            if (count($chunkActual) >= $limitePalabras) {
                $fragmentos[] = implode(' ', $chunkActual);
                $chunkActual = [];
            }
        }

        if (! empty($chunkActual)) {
            $fragmentos[] = implode(' ', $chunkActual);
        }

        return $fragmentos;
    }

    private function crearEmbedding(string $texto): array{
        $respuesta = $this->azureOpenAIClient
            ->embeddings()
            ->create([
                'model' => config('services.azure_openai.embedding'),
                'input' => $texto,
            ]);

        return $respuesta->data[0]->embedding;
    }

    private function extraerTextoConOCR(string $rutaPdf, int $pagina): string {
        $imagick = new Imagick();

        $imagick->setResolution(300, 300);
        $imagick->readImage($rutaPdf.'['.($pagina - 1).']');

        $rutaTemporal = storage_path(
            'app/temp/'.Str::uuid().'.png'
        );

        $imagick->writeImage($rutaTemporal);

        $texto = (new TesseractOCR($rutaTemporal))
            ->lang('spa')
            ->run();

        return $texto;
    }
}
