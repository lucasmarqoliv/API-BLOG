<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Comentario;

class ComentarioControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function test_index()
    {
        $usuario = User::factory()->create();
        $token = $usuario->createToken('Test Token')->plainTextToken;

        $response = $this->getJson('/api/comentario/index',[
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
    }

    public function test_criando_comentario()
{
    // Cria um usuário e gera um token
    $usuario = User::factory()->create();
    $token = $usuario->createToken('Test Token')->plainTextToken;

    // Cria um post para associar o comentário
    $post = Post::factory()->create();

    // Dados do comentário
    $dados = [
        'texto' => 'Comentario teste',
        'post_id' => $post->id
    ];

    $csrfToken = csrf_token();

    // Faz a requisição para criar o comentário
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'X-CSRF-TOKEN' => $csrfToken,
    ])->postJson('/api/comentario/salvar', $dados);

    // Verifica se o status da resposta é 201
    $response->assertStatus(201);

    // Verifica se o comentário foi adicionado ao banco de dados
    $this->assertDatabaseHas('comentario', [
        'texto' => 'Comentario teste',
        'post_id' => $post->id
    ]);
}

public function test_atualizar_comentario()
{
    $user = User::factory()->create();
    $token = $user->createToken('Test Token')->plainTextToken;

    $post = Post::factory()->create();


    $comentario = Comentario::factory()->create([
        'texto' => 'Comentario de teste',
        'post_id' => $post->id
    ]);

    $dadosAtualizados = [
        'texto' => 'Comentario de teste atualizado',
        'post_id' => $post->id
    ];

    $csrfToken = csrf_token();


    $response = $this->putJson('/api/comentario/update/' .$comentario->id,
    $dadosAtualizados, [
        'Authorization' => 'Bearer '. $token,
        'X-CSRF-TOKEN' => $csrfToken,
    ]);


    $response->assertStatus(200);

    $this->assertDatabaseHas('comentario', [
        'id' => $comentario->id,
        'texto' => 'Comentario de teste atualizado',
        'post_id' => $post->id,
    ]);

    // Verifica se a resposta contém os dados atualizados
    $response->assertJsonFragment([
        'texto' => 'Comentario de teste atualizado',
        'post_id' => $post->id,
    ]);
}

public function test_excluir_comentario()
{
    $user = User::factory()->create();
    $token = $user->createToken('Test Token')->plainTextToken;

    $post = Post::factory()->create();

    $comentario = Comentario::factory()->create([
        'texto' => 'Comentario teste',
        'post_id' => $post->id
    ]);

    $csrfToken = csrf_token();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer '. $token,
        'X-CSRF-TOKEN' => $csrfToken,
    ])->deleteJson('/api/comentario/excluir/' . $comentario->id);

    $response->assertStatus(200);

    $this->assertDatabaseMissing('comentario', [
        'id' => $comentario->id,
        'texto' => 'Categoria teste',
        'post_id' => $post->id
    ]);
}

}
