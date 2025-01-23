<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;

Route::get('/token', function () {
    return csrf_token();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// As rotas abaixo requerem que o usuário esteja autenticado (token válido)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']); // Rota para logout
    Route::get('user', [AuthController::class, 'user']); // Rota para obter dados do usuário autenticado

    Route::get('post/',[PostController::class,'index'])->name('post.index');
    Route::post('post/salvar',[PostController::class,'store'])->name('post.store');
    Route::delete('post/excluir/{id}',[PostController::class,'destroy'])->name('post.destroy');
    Route::put('post/atualizar/{id}',[PostController::class,'update'])->name('post.update');
    Route::get('post/visualizar/{id}',[PostController::class,'show'])->name('post.show');
    Route::post('comentario/salvar',[ComentarioController::class,'store'])->name('comentario.salvar');

    Route::get('categorias/',[CategoriaController::class,'index'])->name('categoria.index');
    Route::post('categoria/salvar',[CategoriaController::class,'store'])->name('categoria.store');
    Route::get('categoria/visualizar/{id}',[CategoriaController::class,'show'])->name('categoria.show');
    Route::put('categoria/atualizar/{id}',[CategoriaController::class,'update'])->name('categoria.update');
    Route::delete('categoria/excluir/{id}',[CategoriaController::class,'destroy'])->name('categoria.destroy');

    Route::get('tags/',[TagController::class,'index'])->name('tag.index');
    Route::post('tag/salvar',[TagController::class,'store'])->name('tag.store');
    Route::get('tag/visualizar/{id}',[TagController::class,'show'])->name('tag.show');
    Route::put('tag/atualizar/{id}',[TagController::class,'update'])->name('tag.update');
    Route::delete('tag/excluir/{id}',[TagController::class,'destroy'])->name('tag.destroy');
});



