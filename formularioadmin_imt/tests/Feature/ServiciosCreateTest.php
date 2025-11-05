<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Coordinaciones;

class ServiciosCreateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_servicio_can_be_created_with_optional_coordinacion(): void
    {
        $coordinacion = Coordinaciones::create(['nombre' => 'Coord Test', 'fecha_creacion' => now()]);

        $payload = [
            'nombre' => 'Servicio de Prueba',
            'coordinacion_predeterminada_id' => $coordinacion->id,
            'descripcion' => 'Descripción opcional',
        ];

        $response = $this->post(route('servicios.store'), $payload);

        $response->assertRedirect(route('servicios'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('servicios', [
            'nombre' => 'Servicio de Prueba',
            'coordinacion_predeterminada_id' => $coordinacion->id,
        ]);
    }

    public function test_servicios_store_requires_nombre(): void
    {
        $payload = [
            'nombre' => '',
        ];

        $response = $this->post(route('servicios.store'), $payload);

        $response->assertSessionHasErrors(['nombre']);
        $this->assertDatabaseCount('servicios', 0);
    }
}