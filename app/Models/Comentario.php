<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $table = 'comentario';

    protected $fillable = ['texto','post_id'];

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
