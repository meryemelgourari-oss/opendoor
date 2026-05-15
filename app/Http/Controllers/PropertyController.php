<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Image;
use App\Models\Video;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class PropertyController extends Controller
{
    use AuthorizesRequests;
    /**
     * Filtre mutualisé optimisé
     */
    private function applyFilters(Request $request)
    {
        $query = Property::with('ressources')
            ->where('status', 'publiee')
            ->where('is_approved', true);

        if ($request->filled('contract')) {
            $query->where('type_transaction', $request->contract);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('type')) {
            $query->where('type_bien', $request->type);
        }

        if ($request->filled('min_surface')) {
            $query->where('surface', '>=', $request->min_surface);
        }
        if ($request->filled('max_surface')) {
            $query->where('surface', '<=', $request->max_surface);
        }

        switch ($request->get('sort')) {
            case 'price_asc':  $query->orderBy('price', 'asc'); break;
            case 'price_desc': $query->orderBy('price', 'desc'); break;
            default:           $query->latest(); break;
        }

        return $query->paginate(12)->withQueryString();
    }

    public function index(Request $request)
    {
        // Utilisation de la Policy pour vérifier si l'accès à la liste est permis
        $this->authorize('viewAny', Property::class);

        $properties = $this->applyFilters($request);
        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        // Utilisation de la Policy
        $this->authorize('create', Property::class);

        return view('properties.user.actions.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Property::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'rooms' => 'nullable|integer|min:1|max:50',
            'description' => 'required|string',
            'type_bien' => 'required|in:appartement,maison,terrain,commercial',
            'type_transaction' => 'required|in:vente,location',
            'price' => 'required|numeric|min:0',
            'surface' => 'required|integer',
            'city' => 'required|string',
            'address'   => 'required|string|max:500',
            'phone'     => 'required|string|max:20',
            'status'    => 'required|in:publiee,brouillon,archivee',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'videos.*' => 'nullable|mimes:mp4,mov,ogg,qt|max:40000',
            'youtube_links.*' => 'nullable|url',
            'articles.*.title' => 'nullable|string|max:255',
            'articles.*.content' => 'nullable|string',
        ]);

        try {
            $property = DB::transaction(function () use ($request, $validated) {
                $property = Property::create(array_merge($validated, [
                    'user_id' => Auth::id()
                ]));

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $file) {
                        $path = $file->store('properties/images', 'public');
                        $img = Image::create([
                            'path' => $path,
                            'caption' => 'Photo de ' . $property->title
                        ]);
                        $this->linkResource($property, $img);
                    }
                }

                if ($request->filled('youtube_links')) {
                    foreach ($request->youtube_links as $url) {
                        if (!empty($url)) {
                            $video = Video::create([
                                'url' => $url,
                                'provider' => 'youtube'
                            ]);
                            $this->linkResource($property, $video);
                        }
                    }
                }

                if ($request->filled('articles')) {
                    foreach ($request->articles as $articleData) {
                        if (!empty($articleData['content'])) {
                            $article = Article::create([
                                'title' => $articleData['title'] ?? 'Note sur ' . $property->title,
                                'content' => $articleData['content'],
                                'author_name' => Auth::user()->name
                            ]);
                            $this->linkResource($property, $article);
                        }
                    }
                }

                return $property;
            });

            return redirect()->route('dashboard.my-properties')
                ->with('success', "L'annonce a été enregistrée avec succès.");
        } catch (\Exception $e) {
            Log::error("Erreur création propriété : " . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Erreur technique : ' . $e->getMessage()]);
        }
    }

    private function linkResource($property, $model)
    {
        $property->ressources()->create([
            'resourceable_type' => get_class($model),
            'resourceable_id' => $model->id,
        ]);
    }

    public function show(Property $property)
    {
        $this->authorize('view', $property);

        if (Auth::id() !== $property->user_id) {
            $property->increment('views_count');
        }

        $similarProperties = Property::where('type_bien', $property->type_bien)
            ->where('id', '!=', $property->id)
            ->where('status', 'publiee')
            ->where('is_approved', true)
            ->limit(3)
            ->get();

        return view('properties.show', compact('property', 'similarProperties'));
    }

    public function edit(Property $property)
    {
        // Remplacement de authorizeOwner par authorize() native de la Policy
        $this->authorize('update', $property);

        return view('properties.user.actions.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
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
            'type_transaction' => 'sometimes|required|in:vente,location',
            'type_bien'        => 'sometimes|required|in:appartement,maison,terrain,commercial',
            'resources.*'       => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,mov,quicktime|max:51200',
            'new_video_links.*' => 'nullable|url',
        ]);

        $property->update($validated);

        // Gestion des ressources (logique simplifiée pour l'exemple)
        if ($request->hasFile('resources')) {
            foreach ($request->file('resources') as $file) {
                $path = $file->store('properties/' . $property->id, 'public');
                $mime = $file->getMimeType();

                if (str_contains($mime, 'video')) {
                    $videoModel = Video::create(['url' => $path, 'provider' => 'local']);
                    $this->linkResource($property, $videoModel);
                } else {
                    $imageModel = Image::create(['path' => $path]);
                    $this->linkResource($property, $imageModel);
                }
            }
        }

        return redirect()->route('dashboard.my-properties')->with('success', 'Annonce mise à jour.');
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);

        Storage::disk('public')->deleteDirectory('properties/' . $property->id);
        $property->delete();

        return back()->with('success', 'L’annonce a été supprimée.');
    }

    public function updateStatus(Request $request, Property $property)
    {
        $this->authorize('update', $property);
        
        $request->validate(['status' => 'required|in:publiee,brouillon,archivee']);
        $property->update(['status' => $request->status]);

        return back()->with('success', 'Statut modifié.');
    }
}