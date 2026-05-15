<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Commentaire;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Vue principale du Dashboard utilisateur
     */
    public function index()
    {
        $user   = Auth::user();
        $userId = $user->id;

        // Propriétés de l'utilisateur
        $myProperties = Property::with('ressources')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        // Commentaires sur ses annonces
        $comments = Commentaire::whereHas('property', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with('property')->latest()->get();

        // Stats pour les propriétés (avec comptage commentaires)
        $propertiesWithStats = Property::where('user_id', $userId)
            ->withCount(['commentaires as approved_count' => fn($q) => $q->where('is_approved', true)])
            ->withCount('commentaires')
            ->get();

        // Statistiques globales
        $stats = [
            'total'            => $myProperties->count(),
            'publiees'         => $myProperties->where('status', 'publiee')->count(),
            'actives'          => $myProperties->where('status', 'publiee')->count(),
            'brouillons'       => $myProperties->where('status', 'brouillon')->count(),
            'attente'          => $myProperties->where('status', 'brouillon')->count(),
            'archivees'        => $myProperties->where('status', 'archivee')->count(),
            'archivee'         => $myProperties->where('status', 'archivee')->count(),
            'pending'          => $comments->where('is_approved', false)->count(),
            'pending_comments' => $comments->where('is_approved', false)->count(),
            'approved'         => $comments->where('is_approved', true)->count(),
            'total_comments'   => $comments->count(),
        ];

        $pendingCommentsCount = $stats['pending'];
        $totalVues = $myProperties->sum('views_count');

        // Messages reçus sur ses annonces (colonne is_read)
        $unreadMessagesCount = Message::whereHas('property', fn($q) => $q->where('user_id', $userId))
            ->where('is_read', false)
            ->count();

        $userMessages = Message::whereHas('property', fn($q) => $q->where('user_id', $userId))
            ->latest()
            ->get();

        // Réclamations de l'utilisateur
        $reclamations = $user->reclamations()->latest()->get();

        return view('properties.user.dashboard.index', compact(
            'userMessages',
            'myProperties',
            'reclamations',
            'stats',
            'unreadMessagesCount',
            'comments',
            'pendingCommentsCount',
            'totalVues',
            'propertiesWithStats'
        ));
    }

    /**
     * Sous-page : liste de mes annonces
     */
    public function myProperties()
    {
        $myProperties = Property::with('ressources')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('properties.user.dashboard.index', [
            'myProperties'        => $myProperties,
            'activeTab'           => 'properties',
            'stats'               => $this->quickStats(),
            'comments'            => collect(),
            'reclamations'        => collect(),
            'userMessages'        => collect(),
            'unreadMessagesCount' => 0,
            'pendingCommentsCount'=> 0,
            'totalVues'           => $myProperties->sum('views_count'),
            'propertiesWithStats' => collect(),
        ]);
    }

    /**
     * Sous-page : réclamations de l'utilisateur
     */
    public function myReclamations()
    {
        $reclamations = Auth::user()->reclamations()->latest()->get();

        return view('properties.user.dashboard.index', [
            'reclamations'        => $reclamations,
            'activeTab'           => 'reclamations',
            'myProperties'        => collect(),
            'stats'               => $this->quickStats(),
            'comments'            => collect(),
            'userMessages'        => collect(),
            'unreadMessagesCount' => 0,
            'pendingCommentsCount'=> 0,
            'totalVues'           => 0,
            'propertiesWithStats' => collect(),
        ]);
    }

    /**
     * Helper : statistiques rapides sans re-charger toutes les données
     */
    private function quickStats(): array
    {
        $userId = Auth::id();
        $props  = Property::where('user_id', $userId)->get();

        return [
            'total'            => $props->count(),
            'publiees'         => $props->where('status', 'publiee')->count(),
            'actives'          => $props->where('status', 'publiee')->count(),
            'brouillons'       => $props->where('status', 'brouillon')->count(),
            'attente'          => $props->where('status', 'brouillon')->count(),
            'archivees'        => $props->where('status', 'archivee')->count(),
            'archivee'         => $props->where('status', 'archivee')->count(),
            'pending'          => 0,
            'pending_comments' => 0,
            'approved'         => 0,
            'total_comments'   => 0,
        ];
    }
}
