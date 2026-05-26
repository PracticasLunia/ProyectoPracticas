<?php

namespace Tests\Feature\Asistente;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Mockery;

class SendMessageMockTest extends TestCase{

    use RefreshDatabase;

    public function test_send_message_return_200(): void{
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $message = [
            "role" => "user",
            "content" => "Dime 2 autores",
        ];


        //Crea un objeto falso
        $mock = Mockery::mock(\App\Services\AzureOpenAIClient::class);


        //Verificara la accion o metodo a ejecutar
        $mock->shouldReceive('responses->create')
            ->once()
            ->andReturn((object) [
                'outputText' => 'Miguel de Cervantes y Victor Marie Hugo',
                'output' => []
            ]);

        //reemplaza el servicio real del contenedor de Laravel
        $this->app->instance(
            \App\Services\AzureOpenAIClient::class,
            $mock
        );

        $response = $this->postJson('/api/chat', [
            'messages' => [
                $message
            ]
        ]);

        $response->assertStatus(200);
    }

}
