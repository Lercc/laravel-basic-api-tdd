<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_example()
    {
        // $this->withoutExceptionHandling();
        // 1
        // Simular que se hace una peticion de guardado  mediante api

        $response = $this->json('POST', '/api/posts', [
            'title' => 'post de prueba',
        ]);
        
        // 2
        // comprobar que se esta guardando correctamente
        // para eso comprobamos que me devuelva los tributos guardados,

        $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
        
            // luego comprobar si los campos retornados son iguales a los campos ingresados
            ->assertJson(['title' => 'post de prueba'])

            // comprobar si se a creado un recurso
            // 201 -> recurso creado
            ->assertStatus(201);

            // Comprobar que el recurso existe en la BD
            $this->assertDatabaseHas('posts',['title' => 'post de prueba']);
    }
}
