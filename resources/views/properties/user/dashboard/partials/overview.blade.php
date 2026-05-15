<header class="h-20 print:hidden flex-shrink-0 flex items-center justify-between px-10 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 z-10">
    <h2 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tighter">
        {{ isset($isReclamation) ? 'Support & Litiges' : 'Tableau de bord' }}
    </h2>

    <div class="flex items-center gap-4">
        {{-- Nouvelle Annonce --}}
        <a href="{{ route('properties.create') }}"
            class="px-4 py-2.5 rounded-xl flex items-center gap-3 transition-all duration-300 group {{ request()->routeIs('properties.create') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
            <span class="material-symbols-outlined text-[20px]">add_circle</span>
            <span class="font-bold text-[10px] uppercase tracking-wider">Nouvelle Annonce</span>
        </a>

        <div class="h-8 w-px bg-slate-200 dark:border-slate-700 mx-2"></div>

        {{-- Actions secondaires --}}
        <div class="flex items-center gap-2">
            <button onclick="window.print()" title="Imprimer le rapport" class="size-10 flex items-center justify-center text-slate-500 bg-white dark:bg-slate-800 rounded-xl hover:text-blue-600 border border-slate-100 dark:border-slate-700 transition-all shadow-sm">
                <span class="material-symbols-outlined text-xl">print</span>
            </button>

            <button @click="activeTab = 'messages'"
                class="size-10 flex items-center justify-center text-slate-500 bg-white dark:bg-slate-800 rounded-xl hover:text-blue-600 relative border border-slate-100 dark:border-slate-700 transition-all shadow-sm">

                <span class="material-symbols-outlined text-xl">mail</span>

                @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                <span class="absolute -top-1 -right-1 flex h-4 w-4">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-4 w-4 bg-rose-500 text-[8px] font-bold text-white items-center justify-center">
                        {{ $unreadMessagesCount > 9 ? '9+' : $unreadMessagesCount }}
                    </span>
                </span>
                @endif
            </button>
        </div>
    </div>
</header>

{{-- ZONE DE CONTENU SCROLLABLE --}}
<div class="flex-1 overflow-y-auto p-10 space-y-12">

    {{-- 1. STATS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <x-stats-card label="Annonces Actives" :value="$stats['actives']" icon="check_circle" trend="Stable" trendColor="emerald" />
        <x-stats-card label="En Attente" :value="$stats['attente']" icon="pending" trend="Vérification" trendColor="amber" />
        <x-stats-card label="Archivées" :value="$stats['archivee']" icon="inventory_2" trend="Global" trendColor="blue" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- 2. RECENT ADS --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-2xl font-black text-slate-900 dark:text-white italic tracking-tighter">Mes dernières annonces</h3>
                <a href="{{ route('properties.create') }}" class="text-[10px] font-black uppercase tracking-widest text-primary hover:underline">+ Ajouter</a>
            </div>

            <div class="grid gap-4">
                @forelse($myProperties as $property)
                <div class="bg-white dark:bg-slate-900 p-4 rounded-3xl border border-slate-100 dark:border-slate-800 flex items-center gap-6 group hover:shadow-xl transition-all duration-300">
                    {{-- Thumbnail Logic --}}
                    <div class="w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0 bg-slate-100 relative shadow-inner">
                        @php
                        $resource = $property->ressources->first();
                        $media = $resource ? $resource->resourceable : null;
                        @endphp
                        @if($media)
                        <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                        <img src="{{ asset('default.jpeg') }}" class="w-full h-full object-cover">
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 {{ $property->status == 'publiee' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-amber-500/10 text-amber-500' }} text-[8px] font-black uppercase rounded">
                                {{ $property->status ?? 'En ligne' }}
                            </span>
                            <span class="text-slate-400 text-[9px] font-bold uppercase">{{ $property->created_at->diffForHumans() }}</span>
                        </div>
                        <h4 class="font-black text-slate-900 dark:text-white truncate text-base tracking-tight">{{ $property->title }}</h4>
                        <p class="text-primary font-black text-xs">{{ number_format($property->price, 0, ',', ' ') }} dh</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('properties.show', $property->id) }}" class="p-2.5 bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-primary rounded-xl transition-all">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </a>
                        <form action="{{ route('properties.destroy', $property->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2.5 bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-rose-500 rounded-xl transition-all">
                                <span class="material-symbols-outlined text-lg">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="bg-slate-50 dark:bg-slate-900 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-[2.5rem] p-12 text-center">
                    <p class="text-slate-400 font-bold text-sm">Aucune annonce.</p>
                </div>
                @endforelse
            </div>
        </div>
        {{-- ACTIVITY FEED --}}
        <div class="space-y-6">
            <h3 class="text-2xl font-black text-slate-900 dark:text-white italic tracking-tighter px-2">Activités & Infos</h3>
            <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="space-y-8">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-blue-500/10 text-blue-500 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-lg font-bold">info</span>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-tighter">Bienvenue sur AdPortal</p>
                            <p class="text-xs text-slate-500 mt-1">Aujourd'hui</p>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                        <p class="text-[11px] text-slate-500 leading-relaxed font-medium">
                            En tant que membre, vous pouvez gérer vos biens, modifier vos tarifs et suivre la visibilité de vos annonces en temps réel.
                        </p>
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <div class="text-center">
                            <p class="text-xl font-black text-slate-900 dark:text-white">100%</p>
                            <p class="text-[8px] font-black uppercase tracking-widest text-slate-400">Visibilité</p>
                        </div>
                        <div class="w-px h-8 bg-slate-100 dark:bg-slate-800"></div>
                        <div class="text-center">
                            <p class="text-xl font-black text-slate-900 dark:text-white">Active</p>
                            <p class="text-[8px] font-black uppercase tracking-widest text-slate-400">Statut</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION : MES RÉCLAMATIONS ENVOYÉES (Limité aux 3 dernières) --}}
    <div class="mt-12 space-y-6">
        <div class="flex items-center justify-between px-2">
            <div class="flex flex-col">
                <h3 class="text-2xl font-black text-slate-900 dark:text-white italic tracking-tighter">Dernières réclamations</h3>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Aperçu de l'historique récent</span>
            </div>
            {{-- Optionnel : Bouton pour voir tout si tu as une route dédiée --}}
            <a href="{{route('reclamations.index')}}" class="text-[9px] font-black uppercase tracking-widest text-blue-500 hover:text-blue-600 transition-colors bg-blue-50 dark:bg-blue-900/20 px-3 py-1.5 rounded-lg border border-blue-100 dark:border-blue-800">Voir tout</a>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50">
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Sujet</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Priorité</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Statut</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Date</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        {{-- LIMITATION À 3 --}}
                        @forelse($reclamations->take(3) as $reclamation)
                        <tr x-data="{ isVisible: true }"
                            x-show="isVisible"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all">

                            <td class="px-8 py-6">
                                <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $reclamation->subject }}</p>
                                <p class="text-[11px] text-slate-500 mt-1 truncate max-w-xs">{{ $reclamation->message }}</p>
                            </td>

                            <td class="px-8 py-6">
                                <span class="text-[9px] font-black uppercase px-2 py-1 rounded-lg border 
                                {{ $reclamation->priority == 'urgente' ? 'border-rose-100 text-rose-500 bg-rose-50' : 'border-slate-200 text-slate-500 bg-slate-50' }}">
                                    {{ $reclamation->priority }}
                                </span>
                            </td>

                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full 
                                    {{ $reclamation->status == 'resolu' ? 'bg-emerald-500' : ($reclamation->status == 'en_cours' ? 'bg-amber-500' : 'bg-rose-500 animate-pulse') }}">
                                    </span>
                                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300 capitalize">{{ $reclamation->status }}</span>
                                </div>
                            </td>

                            <td class="px-8 py-6 text-xs text-slate-400 font-medium">
                                {{ $reclamation->created_at->format('d/m/Y') }}
                            </td>

                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <button @click="isVisible = false"
                                        title="Masquer de la vue"
                                        class="group relative size-10 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400 hover:bg-amber-500 hover:text-white transition-all duration-300">
                                        <span class="material-symbols-outlined text-xl">visibility_off</span>
                                    </button>

                                    <form action="{{ route('reclamations.destroy', $reclamation->id) }}" method="POST"
                                        onsubmit="return confirm('Supprimer définitivement cette réclamation ?')"
                                        class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            title="Supprimer définitivement"
                                            class="group relative size-10 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400 hover:bg-rose-600 hover:text-white hover:rotate-90 transition-all duration-300">
                                            <span class="material-symbols-outlined text-xl">delete_forever</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center">
                                <p class="text-slate-400 italic text-sm">Aucune réclamation récente.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- SECTION : SUIVI DES COMMENTAIRES (Limité aux 3 derniers) --}}
    <div class="mt-12 space-y-6">
        <div class="flex items-center justify-between px-2">
            <div class="flex flex-col">
                <h3 class="text-2xl font-black text-slate-900 dark:text-white italic tracking-tighter">Derniers commentaires</h3>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Modérations récentes</span>
            </div>
        </div>

        <div class="grid gap-6">
            {{-- LIMITATION À 3 --}}
            @forelse($comments->take(3) as $comment)
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-6 border border-slate-100 dark:border-slate-800 shadow-[10px_10px_40px_-15px_rgba(0,0,0,0.05)] flex flex-col md:flex-row md:items-center gap-6 group transition-all hover:shadow-xl">

                {{-- Avatar & Info --}}
                <div class="flex items-center gap-4 min-w-[200px]">
                    <div class="size-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center font-black text-blue-600 shadow-inner">
                        {{ substr($comment->user ? $comment->user->name : $comment->guest_name, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white text-sm">{{ $comment->user ? $comment->user->name : $comment->guest_name }}</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                {{-- Contenu & Annonce liée --}}
                <div class="flex-1">
                    <p class="text-slate-600 dark:text-slate-400 text-sm italic mb-2">"{{ $comment->content }}"</p>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800/50">
                        <span class="material-symbols-outlined text-blue-600 text-xs">home</span>
                        <span class="text-[11px] font-black text-blue-600 uppercase">{{ $comment->property->title }}</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3">
                    @if(!$comment->is_approved)
                    <form action="{{ route('comments.approve', $comment->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="px-6 py-2.5 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 transition-all active:scale-95">
                            Approuver
                        </button>
                    </form>
                    @else
                    <span class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-400 text-[10px] font-black uppercase rounded-xl border border-slate-200 dark:border-slate-700">
                        Déjà Public
                    </span>
                    @endif

                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Supprimer ce commentaire ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2.5 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-colors">
                            <span class="material-symbols-outlined">delete_outline</span>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-20 bg-white dark:bg-slate-900 rounded-[3rem] border-2 border-dashed border-slate-200 dark:border-slate-800">
                <span class="material-symbols-outlined text-5xl text-slate-300 mb-4">chat_bubble_outline</span>
                <p class="text-slate-500 font-bold">Aucun commentaire récent.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Masquer la scrollbar pour Chrome/Safari mais garder le scroll */
    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }

    @media print {

        .no-print,
        header,
        button,
        aside,
        form {
            display: none !important;
        }

        main {
            overflow: visible !important;
            width: 100% !important;
        }

        .bg-white {
            background-color: white !important;
            border: 1px solid #eee !important;
        }
    }
</style>
@endpush