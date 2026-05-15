<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    protected $fillable = [

        'property_id',
        'resourceable_type',
        'resourceable_id',
    ];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Relation polymorphique : permet de pointer vers Image, Video ou Article
    public function resourceable()
    {
        return $this->morphTo();
    }
}
