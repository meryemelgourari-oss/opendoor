<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use App\Models\Testimonial;
use App\Models\Reclamation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdmineController extends Controller
{
    use AuthorizesRequests;
    /**
     * Dashboard Admin : vue d'ensemble
     */
    public function index(Request $request)
    {
        $from   = $request->date_from;
        $to     = $request->date_to;
        $search = $request->search;

        // Utilisateurs
        $userQuery = User::where('is_admin', false);
        if ($request->filled('search')) {
            $userQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $users = $userQuery->latest()->paginate(20)->withQueryString();

        // Propriétés
        $propQuery = Property::with('user');
        if ($request->filled('search')) {
            $propQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $propQuery->where('status', $request->status);
        }
        $properties = $propQuery->latest()->paginate(15)->withQueryString();

        // Réclamations
        $recQuery = Reclamation::query();
        if ($from) $recQuery->whereDate('created_at', '>=', $from);
        if ($to)   $recQuery->whereDate('created_at', '<=', $to);
        $reclamations = $recQuery->latest()->get();

        // Témoignages
        $testiQuery = Testimonial::query();
        if ($from) $testiQuery->whereDate('created_at', '>=', $from);
        if ($to)   $testiQuery->whereDate('created_at', '<=', $to);
        $testimonials = $testiQuery->latest()->take(10)->get();

        // Annonces en attente de modération
        $properties_pending = Property::where('is_approved', false)
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to,   fn($q) => $q->whereDate('created_at', '<=', $to))
            ->latest()
            ->get();

        // Stats globales
        $stats         = $this->getGlobalStats($from, $to);
        $latestUsers = User::where('is_admin', false)->latest()->take(4)->get();
        $inactiveUsers = User::where('is_active', false)
            ->where('is_admin', false)
            ->latest()
            ->limit(6)
            ->get();

        return view('properties.admin.dashboard.index', compact(
            'users',
            'properties',
            'properties_pending',
            'stats',
            'inactiveUsers',
            'testimonials',
            'latestUsers',
            'reclamations'
        ));
    }

    /* -------------------------------------------------------------------------- */
    /*  GESTION DES ANNONCES (PROPERTIES)                                         */
    /* -------------------------------------------------------------------------- */
/**
 * Afficher le formulaire de création d'une annonce (Admin)
 */
public function createProperty()
{
    $this->authorize('create', Property::class);
    return view('properties.user.actions.create'); // Utilisez votre vue de création existante
}

/**
 * Enregistrer une nouvelle annonce (Admin)
 */
public function storeProperty(Request $request)
{
    $this->authorize('create', Property::class);
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'rooms' => 'nullable|integer|min:1|max:50',
        'city' => 'required|string',
        'address' => 'required|string|max:500',
        'phone' => 'required|string|max:20',
        'price' => 'required|numeric',
        'surface' => 'required|numeric',
        'type_transaction' => 'required|in:vente,location',
        'type_bien' => 'required|in:appartement,maison,terrain,commercial',
        'description' => 'nullable|string',
        'resources.*' => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,mov,quicktime|max:51200',
    ]);

    // On crée la propriété en l'attachant à l'admin (Auth::id()) 
    // et on l'approuve automatiquement
    $property = Property::create(array_merge($validated, [
        'user_id' => auth()->id(),
        'is_approved' => true,
        'approved_at' => now(),
        'status' => 'publiee'
    ]));

    // Gestion des images / vidéos (Logique identique à l'update)
    if ($request->hasFile('resources')) {
        foreach ($request->file('resources') as $file) {
            $path = $file->store('properties/' . $property->id, 'public');
            $mime = $file->getMimeType();

            if (str_contains($mime, 'video')) {
                $videoModel = \App\Models\Video::create(['url' => $path, 'provider' => 'local']);
                $property->ressources()->create([
                    'resourceable_id' => $videoModel->id,
                    'resourceable_type' => \App\Models\Video::class,
                ]);
            } else {
                $imageModel = \App\Models\Image::create(['path' => $path]);
                $property->ressources()->create([
                    'resourceable_id' => $imageModel->id,
                    'resourceable_type' => \App\Models\Image::class,
                ]);
            }
        }
    }

    return redirect()->route('admin.dashboard')->with('success', 'Annonce créée et publiée par l\'administration.');
}
    public function editProperty(Property $property)
    {
        // Utilise la Policy pour vérifier si c'est le proprio ou l'admin
        $this->authorize('update', $property);
        return view('properties.admin.actions.edit', compact('property'));
    }

    public function updateProperty(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'rooms' => 'nullable|integer|min:1|max:50',
            'city' => 'required|string',
            'address' => 'required|string|max:500',
            'price' => 'required|numeric',
            'surface' => 'required|numeric',
            'description' => 'nullable|string',
            'resources.*' => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,mov,quicktime|max:51200',
            'new_video_links.*' => 'nullable|url',
        ]);

        $property->update($validated);

        // Gestion des ressources (Images/Vidéos)
        if ($request->hasFile('resources')) {
            foreach ($request->file('resources') as $file) {
                $path = $file->store('properties/' . $property->id, 'public');
                $mime = $file->getMimeType();

                if (str_contains($mime, 'video')) {
                    $videoModel = \App\Models\Video::create(['url' => $path, 'provider' => 'local']);
                    $property->ressources()->create([
                        'resourceable_id' => $videoModel->id,
                        'resourceable_type' => \App\Models\Video::class,
                    ]);
                } else {
                    $imageModel = \App\Models\Image::create(['path' => $path]);
                    $property->ressources()->create([
                        'resourceable_id' => $imageModel->id,
                        'resourceable_type' => \App\Models\Image::class,
                    ]);
                }
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Annonce mise à jour.');
    }

    public function moderate(Request $request, Property $property)
    {
        $request->validate(['action' => 'required|in:active,rejected,publiee,brouillon,archivee']);

        if ($request->action === 'active') {
            $property->update(['is_approved' => true, 'status' => 'publiee', 'approved_at' => now()]);
            $msg = 'Annonce approuvée.';
        } elseif ($request->action === 'rejected') {
            $property->update(['is_approved' => false, 'status' => 'brouillon']);
            $msg = 'Annonce rejetée.';
        } else {
            $property->update(['status' => $request->action]);
            $msg = 'Statut mis à jour.';
        }

        return back()->with('success', $msg);
    }

    public function destroyProperty(Property $property)
    {
        $this->authorize('delete', $property);
        $property->delete();
        return back()->with('success', 'Annonce supprimée.');
    }

    /* -------------------------------------------------------------------------- */
    /*  GESTION DES UTILISATEURS                                                  */
    /* -------------------------------------------------------------------------- */

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
            'is_active' => true,
        ]);

        return back()->with('success', 'Utilisateur créé.');
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);
        $user->update($request->only('name', 'email'));
        return back()->with('success', 'Membre mis à jour.');
    }

    public function toggle(User $user)
    {
        if ($user->is_admin) return back()->with('error', 'Action interdite sur un admin.');
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'Statut du compte modifié.');
    }

    public function destroyUser(User $user)
    {
        if ($user->is_admin) return back()->with('error', 'Action interdite.');
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }

    /* -------------------------------------------------------------------------- */
    /*  STATS & INTERNE                                                           */
    /* -------------------------------------------------------------------------- */

    /**
     * API Chart.js — statistiques de vues (24h / 7j / 30j)
     */
    public function getViewsStats(Request $request)
    {
        $range = $request->query('range', '7d');
        $labels = [];
        $values = [];

        if ($range === '24h') {
            for ($i = 23; $i >= 0; $i--) {
                $date  = Carbon::now()->subHours($i);
                $labels[] = $date->format('H:00');
                $values[] = Property::whereDate('created_at', $date->toDateString())->sum('views_count');
            }
        } elseif ($range === '30d') {
            for ($i = 29; $i >= 0; $i--) {
                $date  = Carbon::now()->subDays($i);
                $labels[] = $date->format('d M');
                $values[] = Property::whereDate('created_at', $date->toDateString())->sum('views_count');
            }
        } else {
            for ($i = 6; $i >= 0; $i--) {
                $date  = Carbon::now()->subDays($i);
                $labels[] = $date->translatedFormat('D');
                $values[] = Property::whereDate('created_at', $date->toDateString())->sum('views_count');
            }
        }

        return response()->json(['labels' => $labels, 'values' => $values]);
    }

    /**
     * Statistiques globales centralisées
     */
    private function getGlobalStats($from = null, $to = null): array
    {
        $filter = function ($query) use ($from, $to) {
            if ($from) $query->whereDate('created_at', '>=', $from);
            if ($to)  $query->whereDate('created_at', '<=', $to);
            return $query;
        };

        return [
            'users_count' => $filter(User::where('is_admin', false))->count(),
            'properties_count'  => $filter(Property::query())->count(),
            'published_count' => $filter(Property::where('status', 'publiee'))->count(),
            'archived_count'  => $filter(Property::where('status', 'archivee'))->count(),
            'draft_count' => $filter(Property::where('status', 'brouillon'))->count(),
            'pending_properties_count' => $filter(Property::where('is_approved', false))->count(),
            'total_views' => $filter(Property::query())->sum('views_count') ?? 0,
            'active_users_count' => $filter(User::where('is_active', true)->where('is_admin', false))->count(),
            'inactive_users_count'  => $filter(User::where('is_active', false)->where('is_admin', false))->count(),
            'pending_reclamations'  => $filter(Reclamation::where('is_read', false))->count(),
        ];
    }
}
