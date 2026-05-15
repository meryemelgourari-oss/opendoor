<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
   use HasFactory;

    /**
     * Les attributs qui peuvent être assignés massivement.
     * Comme ton formulaire est ouvert aux non-connectés, 
     * on définit strictement ce qui peut être enregistré.
     */
    protected $fillable = [
        'name',
        'content',
        'rating',
        'is_approved',
    ];

    /**
     * Optionnel : Cast pour s'assurer que is_approved est toujours un booléen
     */
    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer',
    ];

    /**
     * Helper pour obtenir l'initiale du nom (ex: "Karim Mansouri" -> "K")
     * Très utile pour ton design de cercle/carré bleu.
     */
    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->name, 0, 1));
    }

    /**
     * Scope pour ne récupérer que les avis validés par toi (en tant qu'admin)
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

}
