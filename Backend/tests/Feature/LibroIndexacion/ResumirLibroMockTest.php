<?php

use App\Models\Autor;
use App\Models\Libro;
use App\Models\LibroFragmento;
use App\Models\User;
use App\Services\AzureOpenAIClient;
use App\Services\Chat\ToolExecutor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Mockery;

class ResumirLibroMockTest extends TestCase{

    use RefreshDatabase;

    private User $user;
    private Autor $autor;
    private Libro $libro;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->autor = Autor::factory()->create();
        $this->libro  = Libro::factory()->create([
            'autor_id' => $this->autor->id,
        ]);

        Sanctum::actingAs($this->user);
    }

    public function test_resumir_libro_devuelve_error_con_titulo_vacio(): void{

        $executor = app(ToolExecutor::class);

        $resultado = $executor->ejecutar(
            'resumir_libro',
            ['titulo' => '']
        );

        $this->assertEquals(
            ['error' => 'Falta el título del libro'],
            $resultado
        );

    }

    public function test_resumir_libro_encuentra_libro_por_titulo_parcial(): void{

        $autor = Autor::factory()->create([
            'nombre' => 'Frank Herbert',
        ]);

        $libro = Libro::factory()->create([
            'titulo' => 'Dune',
            'autor_id' => $autor->id,
        ]);

        LibroFragmento::create([
            'libro_id' => $libro->id,
            'pagina' => 3,
            'orden' => 0,
            'texto' => 'Arrakis es un planeta desértico...',
            'embedding' => [0.1,0.2,0.3],
            'origen' => 'pdf_text',
        ]);

        $executor = app(ToolExecutor::class);

        $resultado = $executor->ejecutar(
            'resumir_libro',
            ['titulo' => 'Du']
        );

        $this->assertEquals('Dune', $resultado['libro']['titulo']);

        $this->assertEquals(
            'Frank Herbert',
            $resultado['libro']['autor']
        );

        $this->assertCount(
            1,
            $resultado['fragmentos']
        );

        $this->assertEquals(
            3,
            $resultado['fragmentos'][0]['pagina']
        );

    }

    public function test_resumir_libro_ejecuta_tool_y_devuelve_ficha(): void{


        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $libro = Libro::factory()->create([
            'titulo' => 'Dune',
            'autor_id' => $this->autor->id,
        ]);

        LibroFragmento::create([
            'libro_id' => $libro->id,
            'pagina' => 3,
            'orden' => 0,
            'texto' => 'Paul Atreides vive en Arrakis...',
            'embedding' => [0.1,0.2,0.3],
            'origen' => 'pdf_text',
        ]);

        LibroFragmento::create([
            'libro_id' => $libro->id,
            'pagina' => 7,
            'orden' => 0,
            'texto' => 'La especia melange es el recurso más valioso...',
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
                            'name' => 'resumir_libro',
                            'callId' => '123',
                            'arguments' => json_encode([
                                'titulo' => 'Dune',
                            ]),
                        ],
                    ],
                ],

                (object)[
                    'outputText' =>
                        'Ficha de lectura: Dune

    Resumen corto:
    Paul Atreides llega a Arrakis...

    Temas principales:
    - Poder
    - Ecología

    Fuentes:
    - Dune, página 3
    - Dune, página 7',

                    'output' => [],
                ]
            );

        $this->app->instance(
            AzureOpenAIClient::class,
            $mock
        );

        $response = $this->postJson('/api/chat', [
            'messages' => [
                [
                    'role' => 'user',
                    'content' => 'Hazme una ficha de lectura de Dune',
                ],
            ],
        ]);

        $response->assertStatus(200);

        $response->assertJsonPath(
            'data.texto',
            'Ficha de lectura: Dune

    Resumen corto:
    Paul Atreides llega a Arrakis...

    Temas principales:
    - Poder
    - Ecología

    Fuentes:
    - Dune, página 3
    - Dune, página 7'
        );

    }

}


?>
