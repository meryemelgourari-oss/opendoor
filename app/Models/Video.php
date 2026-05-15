<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

   protected $fillable = [
        'url',      
        'path',   
        'provider', 
    ];
     public function ressources() {
    return $this->morphMany(Ressource::class, 'resourceable');
}
}
