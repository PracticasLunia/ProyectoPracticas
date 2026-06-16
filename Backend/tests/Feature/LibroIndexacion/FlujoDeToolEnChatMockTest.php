<?php

namespace Tests\Feature\LibroIndexacion;

use App\Models\Autor;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Libro;
use App\Models\LibroFragmento;
use Laravel\Sanctum\Sanctum;
use App\Services\AzureOpenAIClient;
use Override;
use Mockery;


class FlujoDeToolEnChatMockTest extends TestCase
{
    use RefreshDatabase;

    private Autor $autor;
    private Libro $libro;

    //Funcion que se ejecuta para preparar cada test
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->autor = Autor::factory()->create();

    }


    public function test_chat_usa_tool_buscar_contenido_libros(): void
    {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->libro  = Libro::factory()->create([
            'autor_id' => $this->autor->id,
        ]);


        LibroFragmento::create([
            'libro_id' => $this->libro->id,
            'pagina' => 3,
            'orden' => 0,
            'texto' => 'Contenido importante del libro',
            'embedding' => [0.1,0.2,0.3],
            'origen' => 'pdf_text',
        ]);


        $mock = Mockery::mock(AzureOpenAIClient::class);


        $mock->shouldReceive('responses->create')
            ->twice()
            ->andReturn(

                (object)[
                    'outputText' => '',
                    'output' => [
                        (object)[
                            'type' => 'function_call',
                            'name' => 'buscar_en_contenido_libros',
                            'callId' => '123',
                            'arguments' => json_encode([
                                'consulta' => 'Contenido importante'
                            ]),
                        ]
                    ]
                ],

                (object)[
                    'outputText' => 'El texto aparece en la pagina 3',
                    'output'=>[]
                ]
            );


        $mock->shouldReceive('embeddings')
            ->once()
            ->andReturnSelf();


        $mock->shouldReceive('embeddings->create')
            ->once()
            ->andReturn(
                new class {
                    public function toArray(): array
                    {
                        return [
                            'data' => [
                                [
                                    'embedding' => [0.1, 0.2, 0.3]
                                ]
                            ]
                        ];
                    }
                }
            );


        $this->app->instance(
            AzureOpenAIClient::class,
            $mock
        );


        $response = $this->postJson('/api/chat',[
            'messages'=>[
                [
                    'role'=>'user',
                    'content'=>'Busca en el libro'
                ]
            ]
        ]);


        $response->assertStatus(200);

        $response->assertJsonPath(
            'data.texto',
            'El texto aparece en la pagina 3'
        );

    }
}
