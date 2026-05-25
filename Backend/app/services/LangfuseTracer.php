<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

final class LangfuseTracer
{
    public function trace(
        string $model,
        string $input,
        string $output,
        $usage,
        \Carbon\Carbon $inicio,
        \Carbon\Carbon $fin
    ): void {
        Http::withBasicAuth(
            config('services.langfuse.public_key'),
            config('services.langfuse.secret_key'),
        )
        ->timeout(2)
        ->post(config('services.langfuse.host') . '/api/public/ingestion', [
            'batch' => [[
                'id' => Str::uuid()->toString(),
                'timestamp' => now()->toIso8601String(),
                'type' => 'generation-create',
                'body' => [
                    'id' => Str::uuid()->toString(),
                    'traceId' => Str::uuid()->toString(),
                    'name' => 'chat-asistente',
                    'model' => $model,
                    'input' => $input,
                    'output' => $output,
                    'startTime' => $inicio->toIso8601String(),
                    'endTime' => $fin->toIso8601String(),
                    'usage' => [
                        'inputTokens'  => $usage->inputTokens ?? null,
                        'outputTokens' => $usage->outputTokens ?? null,
                        'totalTokens'  => $usage->totalTokens ?? null,
                    ],
                ],
            ]],
        ]);
    }
}
