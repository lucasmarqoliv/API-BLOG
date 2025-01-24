<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use
Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    // garante que quando rodado o teste, o banco de dados é atualizado.
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_cadastro_tag()
    {
        $tag = Tag::create([ // create metodo de inserção no (banco de dados) do model
            'nome' => 'Noticias'
        ]);

        $this->assertDatabaseHas('tag',[ // verifica se dentro da tabela existe um registro com o nome noticias.
            'nome' => 'Noticias'
        ]);

        // $this->assertEquals('Noticias',$tag->nome); // verifica se o nome da tag que foi criada é o mesmo armazenado na variavel tag.
    }

    public function test_atualizar_tag()
    {
        $tag = Tag::create([
            'nome' => 'Forun'
        ]);

        $tag->update([
            'nome' => 'Forum'
        ]);

        $this->assertDatabaseHas('tag',[
            'nome' => 'Forum'
        ]);
    }

    public function test_excluir_tag()
    {
        $tag = Tag::create([
            'nome' => 'Blog'
        ]);

        $this->assertDatabaseHas('tag',[
            'nome' => 'Blog'
        ]);

        $tag->delete();

        $this->assertDatabaseMissing('tag',[ // verifica se o registro foi excluido do banco.
            'nome' => 'Blog'
        ]);

    }
}
