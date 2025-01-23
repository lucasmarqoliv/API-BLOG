<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Categoria;
use App\Models\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('comentarios')->get();
        return response()->json($posts, 201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        $tags = Tag::all();
        return view('post.cadastrar',compact('categorias','tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $foto = $request->foto->store('fotos','public');
        // //Post::create($request->all());
        $foto = null;
        $post = Post::create([
            'titulo' => $request->titulo,
            'conteudo' => $request->conteudo,
            'foto' => $foto,
            'categoria_id' => $request->categoria_id
        ]);

        $post->tags()->sync($request->tags);

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return response()->json($post, 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        $categorias = Categoria::all();
        return view('post.editar',compact('post','categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        $foto = $post->foto;
        if($request->foto != null){
            $foto = $request->foto->store('fotos','public');
        }



        $post->update([
            'titulo' => $request->titulo,
            'conteudo' => $request->conteudo,
            'foto' => $foto,
            'categoria_id' => $request->categoria_id
        ]);
        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('post.index');
    }
}
