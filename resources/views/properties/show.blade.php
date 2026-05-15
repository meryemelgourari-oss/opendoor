<x-app-layout>
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Récupération sécurisée des données PHP
        // On ajoute || 0 pour éviter une erreur JS si la variable est nulle
        const lat = {{ $property->latitude ?? 33.5731 }};
        const lng = {{ $property->longitude ?? -7.5898 }};
        const propertyTitle = "{{ addslashes($property->title) }}";
        const propertyCity = "{{ addslashes($property->city) }}";

        // 2. Initialisation de la carte
        const map = L.map('map').setView([lat, lng], 13);

        // 3. Chargement des tuiles OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // 4. Ajout du marqueur avec sa bulle info
        const marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup(`<b>${propertyTitle}</b><br>${propertyCity}`).openPopup();

        // 5. Correction critique pour Tailwind (problème de rendu initial)
        setTimeout(() => {
            map.invalidateSize();
        }, 200);
    });
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>

    <style>
        /* Scène 3D */
        .container-3d {
            position: relative;
            width: 100%;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            perspective: 1200px;
        }

        .carousel-3d {
            position: relative;
            width: 240px;
            height: 320px;
            transform-style: preserve-3d;
            animation: rotate-carousel 20s linear infinite;
        }

        @keyframes rotate-carousel {
            0% {
                transform: rotateY(0deg);
            }

            100% {
                transform: rotateY(360deg);
            }
        }

        .item-3d {
            position: absolute;
            inset: 0;
            transform-style: preserve-3d;
            transform: rotateY(calc(var(--i) * (360deg / var(--total)))) translateZ(350px);
            transition: 0.5s;
        }

        .container-3d:hover .carousel-3d {
            animation-play-state: paused;
        }

        .item-3d:hover {
            transform: rotateY(calc(var(--i) * (360deg / var(--total)))) translateZ(400px) scale(1.1);
            cursor: pointer;
        }

        .item-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.4), transparent);
            border-radius: 0.5rem;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .container-3d {
                height: 300px;
            }

            .carousel-3d {
                width: 150px;
                height: 200px;
            }

            .item-3d {
                transform: rotateY(calc(var(--i) * (360deg / var(--total)))) translateZ(200px);
            }
        }

        /* Carte Électrique */
        .electric-card::before,
        .electric-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent 0%, transparent 30%, #2563eb 45%, #60a5fa 50%, #2563eb 55%, transparent 70%, transparent 100%);
            animation: rotate-electric 4s linear infinite;
            z-index: 0;
        }

        .electric-card::after {
            filter: blur(15px);
            opacity: 0.5;
        }

        @keyframes rotate-electric {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <main class="flex-1 max-w-7xl mx-auto w-full px-4 md:px-10 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">

                {{-- En-tête --}}
                <section class="space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-3 py-1 bg-blue-600 text-white text-xs font-bold uppercase rounded-full">
                                    {{ $property->type_transaction == 'vente' ? 'À Vendre' : 'À Louer' }}
                                </span>
                                <span class="text-slate-500 text-sm flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                                    Publié {{ $property->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <h1 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-slate-100">{{ $property->title }}</h1>
                            <p class="text-slate-500 dark:text-slate-400 text-lg flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-blue-600">location_on</span> {{ $property->city }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-blue-600">{{ number_format($property->price, 0, ',', ' ') }} dh</p>
                            @if($property->surface > 0)
                            <p class="text-slate-500 text-sm">{{ number_format($property->price / $property->surface, 0, ',', ' ') }} dh / m²</p>
                            @endif
                        </div>
                    </div>

                    {{-- Carrousel 3D --}}
                    <section class="py-12 overflow-hidden rounded-xl  dark:bg-slate-950/50">
                        <div class="container-3d">
                            @php $allRessources = $property->ressources; @endphp
                            <div class="carousel-3d">
                                @forelse($allRessources as $index => $res)
                                @php $media = $res->resourceable; @endphp
                                @if($media)
                                <div class="item-3d" style="--i: {{ $index }}; --total: {{ $allRessources->count() }};">

                                    {{-- IMAGE --}}
                                    @if($res->resourceable_type == 'App\Models\Image')
                                    <img src="{{ asset('storage/' . $media->path) }}" alt="Photo" class="object-cover w-full h-full rounded-lg shadow-2xl">

                                    {{-- VIDÉO --}}
                                    @elseif($res->resourceable_type == 'App\Models\Video')
                                    <div class="w-full h-full bg-black rounded-lg flex items-center justify-center overflow-hidden relative">
                                        @if(isset($media->provider) && $media->provider === 'youtube')
                                        <div class="flex items-center justify-center h-full w-full bg-slate-100 dark:bg-slate-800 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-700 p-4">
                                            <a href="{{ $media->url }}"
                                                target="_blank"
                                                class="flex flex-col items-center gap-2 group transition-all transform hover:scale-105">
                                                {{-- Cercle d'icône type Play --}}
                                                <div class="w-12 h-12 bg-rose-600 text-white rounded-full flex items-center justify-center shadow-lg group-hover:bg-rose-500 transition-colors">
                                                    <span class="material-symbols-outlined text-2xl">play_circle</span>
                                                </div>
                                                {{-- Texte du lien --}}
                                                <div class="text-center">
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500">Vidéo YouTube</p>
                                                    <p class="text-xs font-bold text-blue-600 dark:text-blue-400 underline decoration-2 underline-offset-4">Regarder la vidéo</p>
                                                </div>
                                            </a>
                                        </div>
                                        @else
                                        <video controls class="w-full h-full object-cover">
                                            <source src="{{ asset('storage/' . $media->url) }}" type="video/mp4">
                                        </video>
                                        @endif
                                    </div>

                                    {{-- ARTICLE --}}
                                    @elseif($res->resourceable_type == 'App\Models\Article')
                                    <div class="w-full h-full bg-white dark:bg-slate-800 p-6 rounded-lg shadow-2xl flex flex-col justify-center border-t-4 border-blue-600">
                                        <span class="material-symbols-outlined text-blue-600 mb-2">article</span>
                                        <h4 class="font-bold text-slate-900 dark:text-slate-100 text-sm mb-2 uppercase">{{ $media->title }}</h4>
                                        <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-6 italic">"{{ $media->content }}"</p>
                                    </div>
                                    @endif

                                    <div class="item-overlay"></div>
                                </div>
                                @endif
                                @empty
                                <div class="absolute inset-0 flex items-center justify-center text-slate-400">Aucun média disponible</div>
                                @endforelse
                            </div>
                        </div>
                    </section>
                </section>
                {{-- SECTION LOCALISATION & ADRESSE --}}
                <section class="space-y-6 mt-12 pt-12 border-t border-slate-200 dark:border-slate-800">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                        <div>
                            <h3 class="text-2xl font-bold flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined text-blue-600">location_on</span>
                                Emplacement
                            </h3>
                            <p class="text-slate-500 dark:text-slate-400 max-w-xl">
                                Retrouvez ci-dessous l'adresse exacte et la situation géographique du bien à <strong>{{ $property->city }}</strong>.
                            </p>
                        </div>

                        <button
                            x-data="{ copied: false }"
                            @click="
        navigator.clipboard.writeText('{{ e($property->address) }}, {{ e($property->city) }}');
        copied = true;
        setTimeout(() => copied = false, 2000);
    "
                            class="flex items-center gap-2 px-4 py-2 rounded-xl transition-all text-sm font-medium border"
                            :class="copied ? 'bg-green-50 text-green-600 border-green-200' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-transparent hover:border-blue-200'">
                            <span class="material-symbols-outlined text-sm" x-text="copied ? 'check' : 'content_copy'"></span>
                            <span x-text="copied ? 'Copié !' : 'Copier l\'adresse'"></span>
                        </button>
                    </div>

                    {{-- Carte d'adresse stylisée --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1 space-y-4">
                            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm h-full">
                                <div class="space-y-6">
                                    <div>
                                        <label class="text-[10px] font-black uppercase tracking-widest text-blue-600 mb-1 block">Quartier / Ville</label>
                                        <p class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ $property->city }}</p>
                                    </div>

                                    <div>
                                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block">Adresse complète</label>
                                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                                            {{ $property->address ?? 'L\'adresse exacte sera communiquée lors de la prise de rendez-vous.' }}
                                        </p>
                                    </div>

                                    <div class="pt-4 border-t border-slate-50 dark:border-slate-800">
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($property->address . ' ' . $property->city) }}"
                                            target="_blank"
                                            class="flex items-center gap-2 text-blue-600 font-bold text-sm hover:underline">
                                            <span class="material-symbols-outlined text-sm">near_me</span>
                                            Ouvrir dans Itinéraire
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- La Carte Leaflet --}}
                        <div class="md:col-span-2">
                            <div id="map" class="w-full h-[350px] rounded-2xl shadow-inner border border-slate-200 dark:border-slate-800 z-0"></div>
                        </div>
                    </div>
                </section>

                {{-- Caractéristiques --}}
                <div class="flex flex-wrap gap-4 py-6 border-y border-slate-200 dark:border-slate-800">
                    <div class="flex items-center gap-3 bg-white dark:bg-slate-900 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 flex-1 min-w-[140px]">
                        <span class="material-symbols-outlined text-blue-600 p-2 bg-blue-50 rounded-lg">square_foot</span>
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-bold">Surface</p>
                            <p class="font-bold">{{ $property->surface }} m²</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white dark:bg-slate-900 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-800 flex-1 min-w-[140px]">
                        <span class="material-symbols-outlined text-blue-600 p-2 bg-blue-50 rounded-lg">category</span>
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-bold">Type</p>
                            <p class="font-bold capitalize">{{ $property->type_bien }}</p>
                        </div>
                    </div>
                </div>
{{-- Section Numéro Direct (Table Properties) --}}
<div class="flex items-center gap-2" x-data="{ copied: false }">
    
    {{-- On utilise $property->phone ici --}}
    <a href="tel:{{ $property->phone }}" 
       class="flex-1 flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-700 group transition-colors hover:border-blue-300">
        <span class="material-symbols-outlined text-blue-600 text-lg">call</span>
        <span class="font-black text-slate-900 dark:text-white tracking-tight">
            {{ $property->phone ?? 'Aucun numéro' }}
        </span>
    </a>

    {{-- Bouton Copier --}}
    <button 
        @click="
            navigator.clipboard.writeText('{{ $property->phone }}');
            copied = true;
            setTimeout(() => copied = false, 2000);
        "
        {{-- On désactive si le téléphone est vide --}}
        @if(!$property->phone) disabled title="Pas de numéro" @endif
        class="size-12 flex items-center justify-center rounded-xl border transition-all"
        :class="copied ? 'bg-green-500 border-green-500 text-white' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 text-slate-500 hover:text-blue-600 hover:border-blue-600'"
    >
        <span class="material-symbols-outlined text-xl" x-text="copied ? 'check' : 'content_copy'"></span>
    </button>
</div>
                {{-- Description --}}
                <section class="space-y-4">
                    <h3 class="text-2xl font-bold">Description</h3>
                    <div class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        {!! nl2br(e($property->description)) !!}
                    </div>


                    {{-- Section Commentaires --}}
                    <section class="mt-16 pt-12 border-t border-slate-200 dark:border-slate-800">
                        {{-- Header avec Badge Dynamique --}}
                        <div class="flex items-center gap-4 mb-10">
                            <h3 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white">Commentaires</h3>
                            <span class="inline-flex items-center justify-center px-4 py-1 bg-blue-600 text-white rounded-full text-sm font-black shadow-[4px_4px_10px_rgba(37,99,235,0.3)]">
                                {{ $property->commentaires->count() }}
                            </span>
                        </div>

                        {{-- Formulaire de Publication --}}
                        <form action="{{ route('comments.store', $property->id) }}" method="POST"
                            class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border-2 border-slate-100 dark:border-slate-800 shadow-[20px_20px_60px_-15px_rgba(0,0,0,0.05)] mb-12 transform transition-all focus-within:scale-[1.01]">
                            @csrf
                            <div class="flex flex-col md:flex-row gap-6">
                                {{-- Avatar du posteur --}}
                                <div class="hidden md:flex size-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 flex-shrink-0 items-center justify-center text-white text-xl font-black italic shadow-lg shadow-blue-500/20 transform -rotate-3">
                                    {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : '?' }}
                                </div>

                                <div class="flex-1 space-y-4">
                                    @guest
                                    <div class="relative group">
                                        <input type="text" name="guest_name" placeholder="Votre nom complet"
                                            class="w-full pl-4 pr-4 py-3 rounded-xl border-2 border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 focus:border-blue-500 focus:ring-0 transition-all outline-none font-medium" required>
                                    </div>
                                    @endguest

                                    <div class="relative">
                                        <textarea name="content" rows="3"
                                            class="w-full p-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 focus:border-blue-500 focus:ring-0 transition-all outline-none resize-none placeholder:text-slate-400 font-medium"
                                            placeholder="Une question sur ce bien ? Posez-la ici..." required></textarea>
                                    </div>

                                    <div class="flex justify-end pt-2">
                                        <button type="submit"
                                            class="group relative px-8 py-3 bg-blue-600 text-white font-black rounded-xl overflow-hidden shadow-[0_10px_20px_-5px_rgba(37,99,235,0.4)] hover:-translate-y-1 active:translate-y-0 transition-all duration-300">
                                            <span class="relative z-10 flex items-center gap-2">
                                                Publier le message
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        {{-- Flux de Commentaires --}}
                        <div class="space-y-6">
                            {{-- On ajoute ->where('is_approved', true) pour filtrer les résultats --}}
                            @forelse($property->commentaires()->where('is_approved', true)->latest()->get() as $comment)
                            <div class="flex gap-4 group">
                                <div class="size-10 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center font-bold">
                                    {{ substr($comment->user ? $comment->user->name : $comment->guest_name, 0, 1) }}
                                </div>
                                <div class="flex-1 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
                                    <div class="flex justify-between items-center mb-1">
                                        <h5 class="font-bold text-sm">
                                            {{ $comment->user ? $comment->user->name : $comment->guest_name }}
                                            @guest
                                            <span class="text-[10px] text-slate-400 font-normal ml-1">(Invité)</span>
                                            @endguest
                                        </h5>
                                        <span class="text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-slate-600 dark:text-slate-400 text-sm">{{ $comment->content }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 border-2 border-dashed border-slate-100 dark:border-slate-800 rounded-2xl">
                                <p class="text-slate-400 text-sm italic">Aucun commentaire publié pour le moment.</p>
                            </div>
                            @endforelse
                        </div>
                    </section>
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    <div class="electric-card relative p-[2px] overflow-hidden rounded-xl shadow-xl">
                        <div class="bg-white dark:bg-slate-900 rounded-[calc(0.75rem-1px)] p-6 relative z-10">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="size-16 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xl shadow-inner">
                                    {{ substr($property->user->name ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ $property->user->name ?? 'Agent Immobilier' }}</h4>
                                    <p class="text-slate-500 text-sm">Annonceur Particulier</p>
                                </div>
                            </div>

                            @if(auth()->id() !== $property->user_id)
                            <form action="{{ route('messages.store', $property) }}" method="POST" class="space-y-4">
                                @csrf
                                @guest
                                <div class="space-y-3">
                                    <input name="visitor_name" class="w-full rounded-xl border-slate-200" placeholder="Votre nom" type="text" required />
                                    <input name="visitor_email" class="w-full rounded-xl border-slate-200" placeholder="Votre email" type="email" required />
                                </div>
                                @endguest
                                <textarea name="content" class="w-full rounded-xl border-slate-200" rows="4" required>Bonjour, je souhaiterais obtenir plus de renseignements sur l'annonce : {{ $property->title }}</textarea>
                                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl shadow-lg flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-sm">send</span> Envoyer ma demande
                                </button>
                            </form>
                            @else
                            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 text-blue-700 text-sm text-center">
                                <p class="font-bold">C'est votre annonce</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </aside>
        </div>

        {{-- Annonces Similaires (SÉCURISÉES) --}}
        @if(isset($similarProperties) && $similarProperties->count() > 0)
        <section class="mt-16 pt-16 border-t border-slate-200">
            <h3 class="text-2xl font-bold mb-8">Annonces similaires</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($similarProperties as $similar)
                <a href="{{ route('properties.show', $similar->id) }}" class="group bg-white rounded-xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-xl transition-all">
                    @php
                    $firstImg = $similar->ressources->where('resourceable_type', \App\Models\Image::class)->first();
                    $imgPath = $firstImg ? $firstImg->resourceable->path : null;
                    @endphp
                    <div class="h-48 bg-center bg-cover" style="background-image: url('{{ $imgPath ? asset('storage/' . $imgPath) : asset('images/default.jpeg') }}');"></div>
                    <div class="p-4">
                        <p class="text-blue-600 font-bold">{{ number_format($similar->price, 0, ',', ' ') }} dh</p>
                        <h4 class="font-bold text-slate-900 group-hover:text-blue-600 truncate">{{ $similar->title }}</h4>
                        <p class="text-slate-500 text-sm">{{ $similar->city }} • {{ $similar->surface }} m²</p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif
    </main>
</x-app-layout>