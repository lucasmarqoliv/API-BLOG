<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentario';
    
    protected $fillable = ['texto','post_id'];

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
