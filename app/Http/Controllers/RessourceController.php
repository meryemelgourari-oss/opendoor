<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ressource;
use Illuminate\Support\Facades\Storage;

class RessourceController extends Controller
{


    public function destroy($id)
    {
        // 1. Trouver la ressource polymorphique
        $ressource = Ressource::findOrFail($id);
        
        // 2. Récupérer l'objet lié (Image ou Vidéo)
        $media = $ressource->resourceable;

        if ($media) {
            // 3. Si c'est un fichier local (pas un lien YouTube), on le supprime du disque
            if (isset($media->path) && !empty($media->path)) {
                if (Storage::disk('public')->exists($media->path)) {
                    Storage::disk('public')->delete($media->path);
                }
            }

            // 4. Supprimer l'entrée dans la table 'images' ou 'videos'
            $media->delete();
        }

        // 5. Supprimer l'entrée dans la table 'ressources'
        $ressource->delete();

        return response()->json(['message' => 'Média supprimé avec succès']);
    }
}