<?php

namespace App\Http\UseCases\Chat;

use App\Services\AzureOpenAIClient;
use Illuminate\Support\Collection;
use OpenAI\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use function Illuminate\Support\now;

final readonly class SendMessage {

    public function __construct(
        private AzureOpenAIClient $cliente
    ){}

    public function handle(SendMessageRequest $request): array{

        $inicio = now()->toIso8601String();

        $respuesta = $this->cliente->responses()->create([
            'model'        => $request->model,
            'instructions' => $this->systemPrompt(),
            'input'        => $request->messages,
            'tools'        => [
                ['type' => 'web_search'],
            ],
        ]);

        $despues = now()->toIso8601String();

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
        ';
    }

}

?>
