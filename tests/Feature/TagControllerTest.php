<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class TagControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_index_tag()
    {
    // Cria um usuário e gera o token
    $usuario = User::factory()->create();
    $token = $usuario->createToken('Test Token')->plainTextToken;

    // Realiza a requisição GET para o índice com o Bearer token
    $response = $this->getJson('/api/tags', [
        'Authorization' => 'Bearer ' . $token,
    ]);

    // Verifica se a resposta tem status 200
    $response->assertStatus(200);
    }

    public function test_criando_tag()
    {
         // Cria um usuário e gera o token
        $usuario = User::factory()->create();
        $token = $usuario->createToken('Test Token')->plainTextToken;

         // Dados para criação de categoria
        $dados = [
            'nome' => 'TAG Teste',
        ];

        $csrfToken = csrf_token();

         // Realiza a requisição POST com o token Bearer
        $response = $this->postJson('/api/tag/salvar', $dados, [
            'Authorization' => 'Bearer ' . $token,
        ]);

          // Verifica se a resposta tem status 201 (Created)
        $response->assertStatus(201);

          // Verifica se a categoria foi criada
        $this->assertDatabaseHas('tag', [
            'nome' => 'TAG Teste',
        ]);
    }

    public function test_atualizando_tag()
    {
        // Cria um usuário e gera o token Bearer
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        // Cria uma categoria existente
        $tag = Tag::factory()->create([
            'nome' => 'TAG Antiga',
        ]);

        // Dados para atualizar a categoria
        $dadosAtualizados = [
            'nome' => 'TAG Atualizada',
        ];

        $csrfToken = csrf_token();

        // Realiza a requisição PUT para atualizar a categoria com o Bearer token
        $response = $this->putJson('/api/tag/atualizar/' . $tag->id, $dadosAtualizados, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Verifica se a resposta tem status 200 OK
        $response->assertStatus(200);

        // Verifica se a categoria foi realmente atualizada no banco de dados
        $this->assertDatabaseHas('tag', [
            'id' => $tag->id,
            'nome' => 'TAG Atualizada',
        ]);

        // Verifica se a resposta contém os dados atualizados
        $response->assertJsonFragment([
            'nome' => 'TAG Atualizada',
        ]);
    }

    public function test_excluir_tag()
{
    // Cria um usuário e gera um token
    $user = User::factory()->create();
    $token = $user->createToken('Test Token')->plainTextToken;

    // Cria uma categoria para ser excluída
    $tag = Tag::factory()->create([
        'nome' => 'TAG teste',
    ]);


    // Faz a requisição de exclusão
    $response = $this->withHeaders([ // O método withHeaders adiciona o cabeçalho de autorização corretamente, garantindo que haja um espaço após 'Bearer'.
        'Authorization' => 'Bearer ' . $token,
    ])->deleteJson('/api/tag/excluir/' . $tag->id);

    // Verifica se o status da resposta é 200
    $response->assertStatus(201);

    // Verifica se a categoria foi removida do banco de dados
    $this->assertDatabaseMissing('tag', [
        'id' => $tag->id,
        'nome' => 'TAG teste',
    ]);
}
}
