<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
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

        $response = $this->getJson('/api/post', [
            'Authorization' => 'Bearer '.$token,
        ]);

        $response->assertStatus(200);
    }

    public function test_criando_post()
    {
        $usuario = User::factory()->create();
        $token = $usuario->createToken('Test Token')->plainTextToken;

        $categoria = Categoria::factory()->create();

        $data = date('H:i:s');

        $dados = [
            'titulo' => 'Post de teste',
            'conteudo' => 'Conteudo de teste',
            'foto' => 'imagem',
            'categoria_id' => $categoria->id
        ];


        $response = $this->postJson('/api/post/salvar', $dados, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('posts', [
            'titulo' => 'Post de teste',
            'conteudo' => 'Conteudo de teste',
            'foto' => 'imagem',
            'categoria_id' => $categoria->id
        ]);
    }

    public function test_atualizando_post()
    {
        $usuario = User::factory()->create();
        $token = $usuario->createToken('Test Token')->plainTextToken;

        $categoria = Categoria::factory()->create();

        $data = date('H:i:s');

        $post = Post::factory()->create([
            'titulo' => 'Post de teste antigo',
            'conteudo' => 'Conteudo de teste',
            'foto' => 'imagem',
            'categoria_id' => $categoria->id
        ]);

        $dadosAtualizados = [
            'titulo' => 'Post de teste atualizado',
            'conteudo' => 'Conteudo de teste',
            'foto' => 'imagem',
            'categoria_id' => $categoria->id
        ];


        $response = $this->putJson('/api/post/atualizar/' . $post->id,
        $dadosAtualizados, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('posts', [
            'titulo' => 'Post de teste atualizado',
            'conteudo' => 'Conteudo de teste',
            'foto' => null,
            'categoria_id' => $categoria->id
        ]);

        // Verifica se a resposta contém os dados atualizados
        $response->assertJsonFragment([
            'titulo' => 'Post de teste atualizado',
            'conteudo' => 'Conteudo de teste',
            'foto' => null,
            'categoria_id' => $categoria->id
        ]);
    }

    public function test_excluir_post()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        $categoria = Categoria::factory()->create();

        $post = Post::factory()->create([
            'titulo' => 'Post de teste',
            'conteudo' => 'Conteudo de teste',
            'foto' => 'imagem',
            'categoria_id' => $categoria->id
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson('/api/post/excluir/' .$post->id);

        $response->assertStatus(201);

        $this->assertDatabaseMissing('posts', [
            'titulo' => 'Post de teste',
            'conteudo' => 'Conteudo de teste',
            'foto' => 'imagem',
            'categoria_id' => $categoria->id
        ]);
    }
}
