<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Liste des messages reçus (dashboard utilisateur).
     */
    public function index()
    {
        $userId = Auth::id();

        $userMessages = Message::whereHas('property', fn($q) => $q->where('user_id', $userId))
            ->latest()
            ->get();

        // Marquer comme lus
        Message::whereHas('property', fn($q) => $q->where('user_id', $userId))
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('properties.user.dashboard.index', [
            'userMessages'        => $userMessages,
            'activeTab'           => 'messages',
            'myProperties'        => collect(),
            'reclamations'        => collect(),
            'comments'            => collect(),
            'stats'               => [
                'total' => 0, 'publiees' => 0, 'actives' => 0,
                'brouillons' => 0, 'attente' => 0, 'archivees' => 0,
                'archivee' => 0, 'pending' => 0, 'pending_comments' => 0,
                'approved' => 0, 'total_comments' => 0,
            ],
            'unreadMessagesCount' => 0,
            'pendingCommentsCount'=> 0,
            'totalVues'           => 0,
            'propertiesWithStats' => collect(),
        ]);
    }

    /**
     * Stocker un message envoyé sur une annonce (public + authentifié).
     */
    public function store(Request $request, Property $property)
    {
        $rules = [
            'content' => 'required|string|min:10',
        ];

        if (!Auth::check()) {
            $rules['visitor_name']  = 'required|string|max:100';
            $rules['visitor_email'] = 'required|email|max:255';
        }

        $request->validate($rules);

        Message::create([
            'property_id'   => $property->id,
            'receiver_id'   => $property->user_id,
            'visitor_name'  => Auth::check() ? Auth::user()->name  : $request->visitor_name,
            'visitor_email' => Auth::check() ? Auth::user()->email : $request->visitor_email,
            'content'       => $request->content,
            'is_read'       => false,
        ]);

        return back()->with('success', 'Votre message a été envoyé avec succès !');
    }
}
