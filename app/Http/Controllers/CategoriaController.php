<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{

    public function index()
    {
        $categorias = Categoria::all();
        return response()->json([
            'Mensagem' => 'Categorias listadas com sucesso',
            'dados' => $categorias
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validacao = Validator::make($request->all(),[
            'nome' => 'required|string|max:190',
            'descricao' => 'nullable|string|max:190'
        ]);

        if($validacao->fails()){
            return response()->json([
                'mensagem' => 'Erro de validaçaõ',
                'erros' => $validacao->errors()
            ],422);
        }

        $categoria = Categoria::create($request->all());
        return response()->json([
            'Mensagem' => 'Categorias cadastrada com sucesso',
            'dados' => $categoria
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = Categoria::find($id);
        if(!$categoria){
            return response()->json([
                'Mensagem' => 'Categoria não encontrada'
            ],404);
        }

        return response()->json([
            'Mensagem' => 'Categoria retornada com sucesso',
            'dados' => $categoria
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categoria = Categoria::find($id);

        if(!$categoria){
            return response()->json([
                'Mensagem' => 'Categoria não encontrada'
            ],404);
        }

        $validacao = Validator::make($request->all(),[
            'nome' => 'required|string|max:190',
            'descricao' => 'nullable|string|max:190'
        ]);

        if($validacao->fails()){
            return response()->json([
                'mensagem' => 'Erro de validaçaõ',
                'erros' => $validacao->errors()
            ],422);
        }

        $categoria->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao
        ]);
        return response()->json([
            'Mensagem' => 'Categoria retornada com sucesso',
            'dados' => $categoria
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::find($id);
        if(!$categoria){
            return response()->json([
                'Mensagem' => 'Categoria não encontrada'
            ],404);
        }
        $categoria->delete();
        return response()->json([
            'Mensagem' => 'Categoria removída com sucesso'
        ],200);
    }
}
