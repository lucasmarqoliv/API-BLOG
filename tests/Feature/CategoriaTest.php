<?php

namespace Tests\Feature;

use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriaTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_cadastro_test()
    {
        $categoria = Categoria::create([
            'nome' => 'Equipamentos',
            'descricao' => 'Equipamentos de informática'
        ]);

        $this->assertDatabaseHas('categoria',[
            'nome' => 'Equipamentos',
            'descricao' => 'Equipamentos de informática'
        ]);

        $this->assertEquals('Equipamentos', $categoria->nome);
        $this->assertEquals('Equipamentos de informática', $categoria->descricao);
    }

    public function test_atualizar_categoria()
    {
        $categoria = Categoria::create([
            'nome' => 'Equipamentos',
            'descricao' => 'Equipamentos de informática'
        ]);

        $categoria->update([
                'nome' => 'Equipamentos atualizados',
                'descricao' => 'Equipamentos de informática atualizados'
            ]);

        $this->assertDatabaseHas('categoria',[
                'nome' => 'Equipamentos atualizados',
                'descricao' => 'Equipamentos de informática atualizados'
            ]);
    }

    public function test_excluir_categoria()
    {
        $categoria = Categoria::create([
            'nome' => 'Equipamentos deletados',
            'descricao' => 'Equipamentos de informática deletados'
        ]);

        $this->assertDatabaseHas('categoria',[
                'nome' => 'Equipamentos deletados',
                'descricao' => 'Equipamentos de informática deletados'
            ]);

        $categoria->delete();

        $this->assertDatabaseMissing('categoria',[
                'nome' => 'Equipamentos deletados',
                'descricao' => 'Equipamentos de informática deletados'
            ]);
    }
}
