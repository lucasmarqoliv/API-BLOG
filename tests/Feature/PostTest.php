<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_cadastro_post()
    {
        $post = Post::create([
            'titulo' => 'Post de teste',
            'conteudo' => 'Conteudo post de teste',
            'foto' => 'imagem',
            'categoria_id' => 1
        ]);

        $this->assertDatabaseHas('posts',[
            'titulo' => 'Post de teste',
            'conteudo' => 'Conteudo post de teste',
            'foto' => 'imagem',
            'categoria_id' => 1
        ]);

        $this->assertEquals('Post de teste', $post->titulo);
        $this->assertEquals('Conteudo post de teste', $post->conteudo);
        $this->assertEquals('imagem', $post->foto);
        $this->assertEquals(1, $post->categoria_id);
    }

    public function test_atualizar_post()
    {
        $post = Post::create([
            'titulo' => 'Post de teste',
            'conteudo' => 'Conteudo post de teste',
            'foto' => 'imagem',
            'categoria_id' => 1
        ]);

        $post->update([
            'titulo' => 'Post de teste editado',
            'conteudo' => 'Conteudo de post de teste editado',
            'foto' => 'imagem editada',
            'categoria_id' => 1
        ]);

        $this->assertDatabaseHas('posts',[
            'titulo' => 'Post de teste editado',
            'conteudo' => 'Conteudo de post de teste editado',
            'foto' => 'imagem editada',
            'categoria_id' => 1
        ]);
    }

    public function test_excluir_post()
    {
        $post = Post::create([
            'titulo' => 'Post de teste deletado',
            'conteudo' => 'Conteudo post de teste deletado',
            'foto' => 'imagem deletada',
            'categoria_id' => 1
        ]);

        $this->assertDatabaseHas('posts',[
                'titulo' => 'Post de teste deletado',
                'conteudo' => 'Conteudo post de teste deletado',
                'foto' => 'imagem deletada',
                'categoria_id' => 1
        ]);

        $post->delete();

        $this->assertDatabaseMissing('posts',[
                'titulo' => 'Post de teste deletado',
                'conteudo' => 'Conteudo post de teste deletado',
                'foto' => 'imagem deletada',
                'categoria_id' => 1
            ]);
    }
}
