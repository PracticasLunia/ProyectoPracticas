<?php

namespace App\Http\UseCases\Chat;

use App\Services\AzureOpenAIClient;
use App\Services\Chat\ToolExecutor;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use function Illuminate\Support\now;

final readonly class SendMessage {

    public function __construct(
        private AzureOpenAIClient $cliente
    ){}

    public function handle(SendMessageRequest $request): array{

        $inicio = now()->toIso8601String();

        $toolExecutor = new ToolExecutor(
            $request->user,
            app(AzureOpenAIClient::class)
        );

        $input        = $request->messages;
        $iteraciones  = 0;
        $maxIteraciones = 5;
        $respuesta    = null;

        while ($iteraciones < $maxIteraciones) {

            $respuesta = $this->cliente->responses()->create([
                'model'        => $request->model,
                'instructions' => $this->systemPrompt(),
                'input'        => $input,
                'tools'        => $this->definirTools(),
            ]);

            $functionCalls = [];

            foreach ($respuesta->output as $item) {
                if ($item->type === 'function_call') {
                    $functionCalls[] = $item;
                }
            }

            if (empty($functionCalls)) {
                break;
            }

            foreach ($functionCalls as $call) {

                $args      = json_decode($call->arguments ?? '{}', true) ?: [];
                $resultado = $toolExecutor->ejecutar($call->name, $args);

                $fuentesRag = [];

                if ($call->name === 'buscar_en_contenido_libros') {
                    $fuentesRag = $resultado;
                }

                $input[] = [
                    'type'      => 'function_call',
                    'name'      => $call->name,
                    'call_id'   => $call->callId,
                    'arguments' => $call->arguments,
                ];
                $input[] = [
                    'type'    => 'function_call_output',
                    'call_id' => $call->callId,
                    'output'  => json_encode($resultado, JSON_UNESCAPED_UNICODE),
                ];
            }

            $iteraciones++;
        }

        $despues = now()->toIso8601String();

        $texto = $respuesta->outputText;

        $citas = [];
        foreach ($respuesta->output as $item) {
            if ($item->type === 'message') {
                foreach ($item->content as $contenido) {
                    foreach ($contenido->annotations ?? [] as $anotacion) {
                        if ($anotacion->type === 'url_citation') {
                            $citas[] = ['url' => $anotacion->url, 'title' => $anotacion->title];
                        }
                    }
                }
            }
        }

        $despues = now()->toIso8601String();

        if (! app()->runningUnitTests()) {

            Http::withBasicAuth(
                config('services.langfuse.public_key'),
                config('services.langfuse.secret_key'),
            )->timeout(2)->post(config('services.langfuse.host') . '/api/public/ingestion', [
                'batch' => [[
                    'id' => Str::uuid()->toString(),
                    'timestamp' => now()->toIso8601String(),
                    'type' => 'generation-create',
                    'body' => [
                        'id' => Str::uuid()->toString(),
                        'traceId' => Str::uuid()->toString(),
                        'name' => 'chat-asistente',
                        'model' => $request->model,
                        'input' => $request->messages,           // instructions + mensaje del usuario
                        'output' => $respuesta,         // texto de la respuesta
                        'startTime' => $inicio,
                        'endTime' => $despues,
                        'usage' => [
                            'inputTokens'  => $usage->inputTokens ?? null,
                            'outputTokens' => $usage->outputTokens ?? null,
                            'totalTokens'  => $usage->totalTokens ?? null,
                        ],
                    ],
                ]],
            ]);
        }

        $data = [
            'texto' => $texto,
            'citas' => $citas,
            'fuentes' => $fuentesRag ?? [],
        ];

        return $data;

    }

    private function systemPrompt(): string
    {
        return '
            Eres el bibliotecario virtual de la biblioteca de Lunia.

            Reglas de uso de tools:
            - Si el usuario pregunta por sus datos, préstamos o historial, usa las tool de obtener_mi_perfil.
            - Si pregunta si existe un libro, autor o género en la biblioteca, usa buscar_libros_en_catalogo.
            - Si pregunta por el contenido de un libro, resumen, temas, personajes, explicación, comparación, ficha de lectura o preguntas de examen, usa una tool de buscar_en_contenido_libros.
            - No respondas sobre el contenido interno de un libro sin consultar antes una tool.
            - Si la tool no devuelve contexto suficiente, dilo claramente.
            - Cuando uses contenido de PDFs, cita siempre título y página.

            Responde de forma breve, útil y con tono de bibliotecario.
        ';
    }

    private function definirTools(): array
    {
        return [
            [
                'type' => 'function',
                'name' => 'obtener_mi_perfil',
                'description' => 'Devuelve el nombre y email del usuario autenticado actualmente. Úsala cuando el usuario pregunte por sus datos personales o quieras personalizar el saludo.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => new \stdClass(),
                    'required' => [],
                ],
            ],
            [
                'type' => 'function',
                'name' => 'obtener_mis_prestamos',
                'description' => 'Devuelve los libros que el usuario tiene en préstamo activo (sin devolver). Incluye título, autor, fecha de préstamo y fecha de devolución prevista.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => new \stdClass(),
                    'required' => [],
                ],
            ],
            [
                'type' => 'function',
                'name' => 'obtener_mi_historial_lectura',
                'description' => 'Devuelve los últimos 5 libros que el usuario ha leído (devueltos), ordenados del más reciente al más antiguo. Útil para hacer recomendaciones basadas en sus gustos.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => new \stdClass(),
                    'required' => [],
                ],
            ],
            [
                'type' => 'function',
                'name' => 'buscar_libros_en_catalogo',
                'description' => 'Busca libros en el catálogo de la biblioteca por título, autor o palabras de la sinopsis. Úsala cuando el usuario pregunte si la biblioteca tiene un libro o un autor concreto.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'termino' => [
                            'type' => 'string',
                            'description' => 'Texto a buscar — título, nombre de autor o palabra clave.',
                        ],
                    ],
                    'required' => ['termino'],
                ],
            ],
            ['type' => 'web_search'],
            [
                'type' => 'function',
                'name' => 'buscar_en_contenido_libros',
                'description' => 'Busca en el contenido real de los PDFs de la biblioteca usando retrieval semantico. Devuelve fragmentos relevantes con titulo del libro, pagina y texto.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'consulta' => [
                            'type' => 'string',
                            'description' => 'Pregunta o tema a buscar dentro del contenido de los libros.',
                        ],
                    ],
                    'required' => ['consulta'],
                ]
            ],
            [
                'type' => 'function',
                'name' => 'resumir_libro',
                'description' => 'Obtiene fragmentos reales del PDF indexado de un libro para crear resúmenes, fichas de lectura, temas principales, personajes, explicaciones o preguntas de comprensión. Úsala siempre que el usuario pida resumir o entender el contenido de un libro concreto.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'titulo' => [
                            'type' => 'string',
                            'description' => 'Título completo o parcial del libro que el usuario quiere resumir.',
                        ],
                    ],
                    'required' => ['titulo'],
                ],
            ],

        ];
    }
}

?>
