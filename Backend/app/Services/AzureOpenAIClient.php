<?php

namespace App\Services;

use OpenAI\Client;

class AzureOpenAIClient
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

    public function responses()
    {
        return $this->cliente->responses();
    }

    public function embeddings(){
        return $this->cliente->embeddings();
    }
}
