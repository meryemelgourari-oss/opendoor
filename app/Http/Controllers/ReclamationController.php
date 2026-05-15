<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reclamation;
use Illuminate\Support\Facades\Auth;

class ReclamationController extends Controller
{
    /**
     * Formulaire de création (redirige vers dashboard avec onglet actif).
     */
    public function create()
    {
        return redirect()->route('dashboard.index', ['tab' => 'reclamations'])
            ->with('info', 'Utilisez le formulaire ci-dessous pour soumettre une réclamation.');
    }

    /**
     * Enregistrer une nouvelle réclamation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject'  => 'required|string|max:191',
            'content'  => 'required|string|min:10',
            'priority' => 'required|in:basse,normale,urgente',
        ]);

        Reclamation::create([
            'user_id'  => Auth::id(),
            'subject'  => $validated['subject'],
            'message'  => $validated['content'],
            'priority' => $validated['priority'],
            'status'   => 'ouvert',
            'is_read'  => false,
        ]);

        return redirect()->route('dashboard.index')
            ->with('success', 'Réclamation envoyée avec succès !');
    }

    /**
     * Mettre à jour le statut d'une réclamation (Admin).
     * Note: status enum values: ouvert, en_cours, résolu
     */
    public function update(Request $request, Reclamation $reclamation)
    {
        $request->validate([
            'status' => 'required|in:ouvert,en_cours,resolu',
        ]);

        $reclamation->update([
            'status'  => $request->status,
            'is_read' => true,
        ]);

        return back()->with('success', 'Statut de la réclamation mis à jour.');
    }

    /**
     * Supprimer une réclamation (Utilisateur — la sienne uniquement).
     */
    public function destroy(Reclamation $reclamation)
    {
        if ($reclamation->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $reclamation->delete();

        return back()->with('success', 'Réclamation annulée avec succès.');
    }
}
