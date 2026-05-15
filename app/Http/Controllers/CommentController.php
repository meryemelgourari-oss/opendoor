<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Liste des commentaires pour le dashboard utilisateur (onglet commentaires).
     */
    public function dashboardIndex()
    {
        $userId = Auth::id();

        $comments = Commentaire::whereHas('property', fn($q) => $q->where('user_id', $userId))
            ->with('property')
            ->latest()
            ->get();

        return view('properties.user.dashboard.index', [
            'comments'            => $comments,
            'activeTab'           => 'comments',
            'myProperties'        => collect(),
            'reclamations'        => collect(),
            'userMessages'        => collect(),
            'stats'               => [
                'total' => 0, 'publiees' => 0, 'actives' => 0,
                'brouillons' => 0, 'attente' => 0, 'archivees' => 0,
                'archivee' => 0, 'pending' => $comments->where('is_approved', false)->count(),
                'pending_comments' => $comments->where('is_approved', false)->count(),
                'approved' => $comments->where('is_approved', true)->count(),
                'total_comments' => $comments->count(),
            ],
            'unreadMessagesCount' => 0,
            'pendingCommentsCount'=> $comments->where('is_approved', false)->count(),
            'totalVues'           => 0,
            'propertiesWithStats' => collect(),
        ]);
    }

    /**
     * Enregistrer un nouveau commentaire (Public).
     */
    public function store(Request $request, Property $property)
    {
        $request->validate([
            'content'    => 'required|string|min:5|max:1000',
            'guest_name' => 'nullable|string|max:100',
        ], [
            'content.required' => 'Le message ne peut pas être vide.',
            'content.min'      => 'Le message doit faire au moins 5 caractères.',
        ]);

        Commentaire::create([
            'content'     => $request->content,
            'guest_name'  => Auth::check() ? null : $request->guest_name,
            'user_id'     => Auth::id(),
            'property_id' => $property->id,
            'is_approved' => false,
        ]);

        return back()->with('success', 'Votre commentaire a été envoyé et sera visible après validation.');
    }

    /**
     * Approuver un commentaire.
     */
    public function approve(Commentaire $comment)
    {
        if (Auth::id() !== $comment->property->user_id) {
            abort(403, 'Action non autorisée.');
        }
        $comment->update(['is_approved' => true]);
        return back()->with('success', 'Le commentaire est désormais public !');
    }

    /**
     * Supprimer un commentaire.
     */
    public function destroy(Commentaire $comment)
    {
        if (Auth::id() !== $comment->property->user_id) {
            abort(403);
        }
        $comment->delete();
        return back()->with('success', 'Le commentaire a été supprimé définitivement.');
    }
}
