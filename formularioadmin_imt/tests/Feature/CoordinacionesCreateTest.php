<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Coordinaciones;

class CoordinacionesCreateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Desactivar middleware para pruebas de endpoints protegidos
        $this->withoutMiddleware();
    }

    public function test_can_create_coordinacion_with_all_fields(): void
    {
        $payload = [
            'nombre' => 'Coordinación de Prueba',
            'coordinador' => 'Juan Pérez',
            'correo_coordinador' => 'juan.perez@example.com',
            'asistente' => 'María López',
            'correo_asistente' => 'maria.lopez@example.com',
            'representante' => 'Carlos Ruiz',
            'correo_representante' => 'carlos.ruiz@example.com',
        ];

        $response = $this->post(route('coordinaciones.store'), $payload);

        $response->assertRedirect(route('coordinaciones'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('coordinaciones', [
            'nombre' => 'Coordinación de Prueba',
            'coordinador' => 'Juan Pérez',
            'correo_coordinador' => 'juan.perez@example.com',
            'asistente' => 'María López',
            'correo_asistente' => 'maria.lopez@example.com',
            'representante' => 'Carlos Ruiz',
            'correo_representante' => 'carlos.ruiz@example.com',
        ]);
    }

    public function test_coordinaciones_store_validates_nombre_and_emails(): void
    {
        $payload = [
            // 'nombre' faltante
            'coordinador' => 'Juan Pérez',
            'correo_coordinador' => 'correo_invalido',
            'asistente' => 'María López',
            'correo_asistente' => 'tambien_invalido',
            'representante' => 'Carlos Ruiz',
            'correo_representante' => 'no_es_email',
        ];

        $response = $this->post(route('coordinaciones.store'), $payload);

        $response->assertSessionHasErrors(['nombre', 'correo_coordinador', 'correo_asistente', 'correo_representante']);
        $this->assertDatabaseCount('coordinaciones', 0);
    }
}