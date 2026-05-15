<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Enregistrer un témoignage (public).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|min:3|max:100',
            'content' => 'required|string|min:10|max:500',
            'rating'  => 'required|integer|min:1|max:5',
        ], [
            'name.required'    => 'Merci d\'indiquer votre nom.',
            'name.min'         => 'Votre nom doit contenir au moins 3 caractères.',
            'content.required' => 'Le message est obligatoire.',
            'content.min'      => 'Votre message doit faire au moins 10 caractères.',
            'rating.required'  => 'N\'oubliez pas de donner une note !',
            'rating.min'       => 'La note minimale est de 1 étoile.',
            'rating.max'       => 'La note maximale est de 5 étoiles.',
        ]);

        Testimonial::create([
            'name'        => $validated['name'],
            'content'     => $validated['content'],
            'rating'      => $validated['rating'],
            'is_approved' => false,
        ]);

        return back()->with('success', 'Merci ! Votre avis sera publié après modération.');
    }

    /**
     * Mettre à jour le statut d'un témoignage (Admin).
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $testimonial->update([
            'is_approved' => $request->status === 'approved',
        ]);
        return back()->with('success', 'Statut du témoignage mis à jour !');
    }

    /**
     * Supprimer un témoignage (Admin).
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Témoignage supprimé.');
    }
}
