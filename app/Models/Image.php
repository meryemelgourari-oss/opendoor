<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'path',
        'caption',
    ];
    public function ressources()
    {
        return $this->morphMany(Ressource::class, 'resourceable');
    }
}
