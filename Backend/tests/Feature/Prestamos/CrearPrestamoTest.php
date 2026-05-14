<?php

namespace Tests\Feature\Prestamos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Libro;
use App\Models\Autor;
use App\Models\Prestamo;
use Override;

class CrearPrestamoTest extends TestCase
{
    use RefreshDatabase;

    private $libro;
    private $autor;
    private $prestamo;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->autor= Autor::factory()->create();

        $this->libro= Libro::factory()->create([
            'autor_id' => $this->autor->id
        ]);

    }

    public function test_creacion_prestamo_devuelve_201(): void{

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->prestamo = Prestamo::factory()->make([
            'libro_id' => $this->libro->id,
            'fecha_prestamo' => '2026-04-05',
            'fecha_devolucion_prevista' => '2026-05-05',
            'fecha_devolucion_real' => '2026-05-05',
        ]);

        $data = $this->prestamo->toArray();

        $response = $this->postJson('api/prestamos', $data);

        $response->assertStatus(201);
        $this->assertDatabaseCount('prestamos',1);
        $response->assertJsonPath('message', 'Prestamo creado correctamente');

    }

    public function test_creacion_prestamo_con_excepcion_de_validacion_devuelve_422(): void {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->prestamo = Prestamo::factory()->make([
            'libro_id' => $this->libro->id,
            'fecha_prestamo' => '2026-04-05',
            'fecha_devolucion_prevista' => '2026-04-04',
            'fecha_devolucion_real' => '2026-05-05',
        ]);

        $data = $this->prestamo->toArray();

        $response = $this->postJson('api/prestamos', $data);

        $response->assertStatus(422);
        $this->assertDatabaseCount('prestamos',0);
        //$response->assertJsonPath('message', 'No se pudo crear el prestamo');
    }

    public function test_crear_prestamo_con_libro_con_prestamo_activo_devuelve_409(): void {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        //Prestamo activo con libro previamente
        $prestamoActivo = Prestamo::factory()->create([
            'libro_id' => $this->libro->id,
            'fecha_prestamo' => '2026-04-05',
            'fecha_devolucion_prevista' => '2026-05-05',
            'fecha_devolucion_real' => null,
        ]);

        //Crear prestamo a libro que ya tiene uno activo
        $this->prestamo = Prestamo::factory()->make([
            'libro_id' => $this->libro->id,
            'fecha_prestamo' => '2026-04-05',
            'fecha_devolucion_prevista' => '2026-05-05',
            'fecha_devolucion_real' => '2026-05-05',
        ]);

        $data = $this->prestamo->toArray();

        $response = $this->postJson('api/prestamos', $data);

        $response->assertStatus(409);
        $this->assertDatabaseCount('prestamos',1);
        //$response->assertJsonPath('message', 'Este libro ya tiene un prestamo activo');

    }
}
