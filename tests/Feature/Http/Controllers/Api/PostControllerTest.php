<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Post;
use App\Models\User;
use Faker\Factory;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store()
    {
        // $this->withoutExceptionHandling();
        // 1
        // Simular que se hace una peticion de guardado  mediante api
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->json('POST', '/api/posts', [
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

    public function test_validate_title()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')->json('POST','/api/posts',[
            'title' => ''
        ]);

        $response->assertStatus(422) // solicitud no procesada
            ->assertJsonValidationErrors('title');
    }

    public function test_show()
    {
        $post = Post::factory()->create();

        $user = User::factory()->create();
        
        $response = $this->actingAs($user, 'api')->json('GET',"/api/posts/$post->id");

        $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
            ->assertJson(['title' => $post->title])
            ->assertStatus(200); // ok
    }

    public function test_404_show()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->json('GET',"/api/posts/1000");

        $response->assertStatus(404);
    }

    public function test_update()
    {
        // $this->withoutExceptionHandling();
        $post = Post::factory()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->json('PUT', "/api/posts/$post->id", [
            'title' => 'nuevo'
        ]);

        $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
            ->assertJson(['title' => 'nuevo'])
            ->assertStatus(200);

        $this->assertDatabaseHas('posts',['title' => 'nuevo']);
    }

    public function test_delete()
    {
        // $this->withoutExceptionHandling();
        $post = Post::factory()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->json('DELETE', "/api/posts/$post->id");

        $response->assertSee(null)
            ->assertStatus(204); //sin contenido

        $this->assertDatabaseMissing('posts',['title' => $post->id]);
    }

    public function test_index()
    {
        // $this->withoutExceptionHandling();
        $post = Post::factory(5)->create();

        $user = User::factory()->create();
        
        $response = $this->actingAs($user, 'api')->json('GET', "/api/posts");

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'created_at', 'updated_at']
            ]
        ])->assertStatus(200);
    }

    public function test_guest()
    {
        $response = $this->json('GET', '/api/posts')->assertStatus(401);
    }
}
