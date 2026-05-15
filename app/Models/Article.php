<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'author_name'];

     public function ressources() {
    return $this->morphMany(Ressource::class, 'resourceable');
}
}
