<?php

namespace Tests\Feature;

use Tests\TestCase;

class TurnoTest extends TestCase
{
    /**
     * Verifica que la ruta principal de turnos responde correctamente.
     */
    public function test_pagina_turnos_responde_correctamente(): void
    {
        $response = $this->get('/turnos/crear');

        $response->assertStatus(200);
    }
}
