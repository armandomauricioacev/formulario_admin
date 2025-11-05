<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntidadesProcedenciaCreateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_entidad_procedencia_can_be_created(): void
    {
        $payload = [
            'nombre' => 'Entidad de Prueba',
        ];

        $response = $this->post(route('entidades-procedencia.store'), $payload);

        $response->assertRedirect(route('entidades-procedencia'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('entidades_procedencia', [
            'nombre' => 'Entidad de Prueba',
        ]);
    }

    public function test_entidades_store_requires_nombre(): void
    {
        $payload = [
            'nombre' => '',
        ];

        $response = $this->post(route('entidades-procedencia.store'), $payload);

        $response->assertSessionHasErrors(['nombre']);
        $this->assertDatabaseCount('entidades_procedencia', 0);
    }
}