<?php

namespace Tests\Feature;

use App\Models\Comentario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ComentarioTest extends TestCase
{
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_cadastro_comentario()
    {
        $comentario = Comentario::create([
            'texto' => 'Comentario de teste',
            'post_id' => 1
        ]);

        $this->assertDatabaseHas('comentario', [
            'texto' => 'Comentario de teste',
            'post_id' => 1
        ]);

        $this->assertEquals(
            'Comentario de teste',
            $comentario->texto);
        $this->assertEquals(
            1, $comentario->post_id
        );
    }

    public function test_atualizar_comentario()
    {
        $comentario = Comentario::create([
            'texto' => 'Texte',
            'post_id' => 2
        ]);

        $comentario->update([
            'texto' => 'Teste',
            'post_id' => 2
        ]);

        $this->assertDatabaseHas('comentario',[
            'texto' => 'Teste',
            'post_id' => 2
        ]);
    }

    public function test_excluir_comentario()
    {
        $comentario = Comentario::create([
            'texto' => 'Teste de excluir',
            'post_id' => 1
        ]);

        $this->assertDataBaseHas('comentario',[
            'texto' => 'Teste de excluir',
            'post_id' => 1
        ]);

        $comentario->delete();

        $this->assertDatabaseMissing('comentario',[
            'texto' => 'Teste de excluir',
            'post_id' => 1
        ]);
    }
}
