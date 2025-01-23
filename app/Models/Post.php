<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['titulo','conteudo', 'foto' ,'categoria_id'];

    public function comentarios(){
        return $this->hasMany(Comentario::class);
    }

    public function categoria(){
        return $this->belogsTo(Categoria::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
