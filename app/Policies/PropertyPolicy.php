<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
{
    /**
     * Autoriser tout le monde (même non-connecté) à voir la liste.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Autoriser tout le monde à voir le détail d'une annonce.
     */
    public function view(?User $user, Property $property): bool
    {
        return true;
    }

    /**
     * Seul un utilisateur authentifié (qui deviendra propriétaire) ou l'admin peut créer.
     */
    public function create(User $user): bool
    {
         return $user->is_admin || $user->id !== null; 
    }

    /**
     * Seul le propriétaire de l'annonce ou l'administrateur peut modifier.
     */
    public function update(User $user, Property $property): bool
    {
        return $user->id === $property->user_id || $user->is_admin;
    }

    /**
     * Seul le propriétaire de l'annonce ou l'administrateur peut supprimer.
     */
    public function delete(User $user, Property $property): bool
    {
        return $user->id === $property->user_id || $user->is_admin;
    }
}
