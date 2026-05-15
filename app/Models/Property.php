<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'type_transaction',
        'type_bien',
        'surface',
        'rooms',
        'city',
        'address',
        'phone',
        'status',
        'views_count',
        'is_approved',
        'approved_at',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'is_approved'  => 'boolean',
        'approved_at'  => 'datetime',
        'price'        => 'decimal:2',
        'views_count'  => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    public function ressources()
    {
        return $this->hasMany(Ressource::class);
    }
}
