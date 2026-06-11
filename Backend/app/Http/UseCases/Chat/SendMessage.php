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

        $toolExecutor = new ToolExecutor($request->user);
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
        ];

        return $data;

    }

    private function systemPrompt(): string
    {
        return '
           Eres el bibliotecario virtual de la biblioteca de Lunia.
           Responde de forma breve y útil, citando fuentes cuando hagas búsquedas en internet.
           Si te preguntan algo que no tiene que ver con libros o lectura,
           recuérdale amablemente que estás aquí para ayudarle con la biblioteca
           Puedes usar varias tools entre si, por ejemplo cuando te realizan una consulta que dependa una de la otra,
           siempre que tenga sentido obviamente.
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
        ];
    }
}

?>
