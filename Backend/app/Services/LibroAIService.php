<?php

namespace App\Services;

use App\Models\Genero;
use OpenAI\Client;
use App\Models\Autor;
use App\Models\Libro;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class LibroAIService
{

    public function __construct(
        private Client $cliente
    )
    {
        $this->cliente= \OpenAI::factory()
            ->withBaseUri(config('services.azure_openai.endpoint') . '/openai/v1')
            ->withHttpHeader('api-key', config('services.azure_openai.api_key'))
            ->make();
    }

    public function generarLibros(): void
    {
        $schema = [
            'type' => 'object',
            'additionalProperties' => false,
            'properties' => [
                'libros' => [
                    'type'  => 'array',
                    'items' => [
                        'type' => 'object',
                        'additionalProperties' => false,
                        'properties' => [
                            'titulo'      => ['type' => 'string'],
                            'publicacion' => ['type' => 'integer'],
                            'sinopsis'    => ['type' => 'string'],
                            'num_paginas' => ['type' => 'integer'],
                            'autor'       => ['type' => 'string'],
                            'generos'     => ['type' => 'array', 'items' => [
                                'type' => 'string',
                                'enum' => ['Suspenso', 'Aventuras', 'Terror', 'Entretenimiento', 'Narrativo'],
                            ]],
                        ],
                        'required' => ['titulo', 'publicacion', 'sinopsis', 'num_paginas', 'autor', 'generos'],
                    ],
                ],
            ],
            'required' => ['libros'],
        ];

        $respuesta = $this->cliente->responses()->create([
            'model'        => config('services.azure_openai.model'), // gpt-5.4-nano
            'instructions' => 'Inventas libros de biblioteca realistas en español. El título nunca pasa de 50 caracteres.',
            'input'        => 'Genera 2 libros variados, de distintos géneros y épocas.',
            'text' => [
                'format' => [
                    'type'   => 'json_schema',
                    'name'   => 'lote_libros',
                    'strict' => true,
                    'schema' => $schema,
                ],
            ],
        ]);

        $datos = json_decode($respuesta->outputText, true);

        foreach ($datos['libros'] as $libro) {
            $validator = Validator::make($libro, [
                'titulo' => 'required|string|max:50',
                'publicacion' => 'required|integer|min:1500|max:' . date('Y'),
                'sinopsis' => 'required|string|min:50',
                'num_paginas' => 'required|integer|min:1',
                'autor' => 'required|string|max:255',
                'generos' => 'required|array|min:1',
                'generos.*' => 'string',
            ]);

            if ($validator->fails()) {
                continue;
            }

            // Crear o recuperar autor
            $autor = Autor::firstOrCreate([
                'nombre' => $libro['autor'],
            ]);

            // Crear libro
            $nuevoLibro = Libro::create([
                'titulo' => $libro['titulo'],
                'publicacion' => $libro['publicacion'],
                'sinopsis' => $libro['sinopsis'],
                'num_paginas' => $libro['num_paginas'],
                'isbn' => fake()->unique()->isbn13(),
                'autor_id' => $autor->id,
            ]);

            // Asociar géneros
            $generosIds = [];

            foreach ($libro['generos'] as $nombreGenero) {

                $genero = Genero::firstOrCreate([
                    'nombre' => $nombreGenero,

                ]);

                $generosIds[] = $genero->id;
            }

            $nuevoLibro->generos()->sync($generosIds);

            $endpoint = config('services.azure_openai.endpoint');

            $titulo = $libro['titulo'];
            $generosTexto = implode(', ', $libro['generos']);

            $resp = Http::withHeaders(['api-key' => config('services.azure_openai.api_key')])
                ->timeout(120)
                ->post($endpoint . '/openai/deployments/gpt-image-1/images/generations?api-version=2025-04-01-preview', [
                    'prompt'  => "Portada de libro profesional para una novela de {$generosTexto} titulada \"{$titulo}\". Diseño editorial cuidado, ilustración evocadora.",
                    'size'    => '1024x1536',
                    'quality' => 'low',
                    'n'       => 1,
                ]);

            $base64  = $resp->json('data.0.b64_json');
            $binario = base64_decode($base64);

            $manager = new ImageManager(new Driver());

            $imagen = $manager->read($binario)
                ->scale(width: 600);

            $imagenFinal = $imagen->toWebp(quality: 75);

            // guardar
            $nombreArchivo = 'portadas/' . Str::uuid() . '.webp';

            Storage::disk('local')->put($nombreArchivo, $imagenFinal);

            // actualizar libro
            $nuevoLibro->update([
                'portada_path' => $nombreArchivo
            ]);
        }
    }
}

?>
