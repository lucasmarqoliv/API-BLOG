<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Categoria;

class CategoriaControllerTest extends TestCase
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
        // Cria um usuário e gera o token
        $usuario = User::factory()->create();
        $token = $usuario->createToken('Test Token')->plainTextToken;

        // Realiza a requisição GET para o índice com o Bearer token
        $response = $this->getJson('/api/categorias', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Verifica se a resposta tem status 200
        $response->assertStatus(200);

    }

    public function test_criando_uma_categoria()
    {
         // Cria um usuário e gera o token
        $usuario = User::factory()->create();
        $token = $usuario->createToken('Test Token')->plainTextToken;

        // Dados para criação de categoria
        $dados = [
            'nome' => 'Categoria Teste',
            'descricao' => 'Descrição da categoria teste'
        ];

        // Realiza a requisição POST com o token Bearer
         $response = $this->postJson('/api/categoria/salvar', $dados, [
            'Authorization' => 'Bearer ' . $token,
        ]);

         // Verifica se a resposta tem status 201 (Created)
         $response->assertStatus(201);

         // Verifica se a categoria foi criada
         $this->assertDatabaseHas('categoria', [
             'nome' => 'Categoria Teste',
             'descricao' => 'Descrição da Categoria Teste',
         ]);
    }

    public function test_atualizando_categoria()
    {
        // Cria um usuário e gera o token Bearer
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->plainTextToken;

        // Cria uma categoria existente
        $categoria = Categoria::factory()->create([
            'nome' => 'Categoria Antiga',
            'descricao' => 'Descrição Antiga'
        ]);

        // Dados para atualizar a categoria
        $dadosAtualizados = [
            'nome' => 'Categoria Atualizada',
            'descricao' => 'Descrição Atualizada'
        ];

        // Realiza a requisição PUT para atualizar a categoria com o Bearer token
        $response = $this->putJson('/api/categoria/atualizar/' . $categoria->id, $dadosAtualizados, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Verifica se a resposta tem status 200 OK
        $response->assertStatus(200);

        // Verifica se a categoria foi realmente atualizada no banco de dados
        $this->assertDatabaseHas('categoria', [
            'id' => $categoria->id,
            'nome' => 'Categoria Atualizada',
            'descricao' => 'Descrição Atualizada',
        ]);

        // Verifica se a resposta contém os dados atualizados
        $response->assertJsonFragment([
            'nome' => 'Categoria Atualizada',
            'descricao' => 'Descrição Atualizada',
        ]);
    }

}
