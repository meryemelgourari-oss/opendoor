
    <div class="py-12 bg-slate-50 dark:bg-slate-950 min-h-screen">
        {{-- Container ultra-large pour maximiser l'espace --}}
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Barre de titre & Bouton Retour --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 dark:text-white uppercase italic tracking-tighter">
                        Gestion des commentaires
                    </h1>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Modération des avis clients</p>
                </div>
                
                <a href="{{ route('dashboard.index') }}" 
                   class="group flex items-center gap-3 px-6 py-3 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:border-blue-500 dark:hover:border-blue-500 transition-all w-fit">
                    <span class="material-symbols-outlined text-xl group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    <span class="text-[10px] font-black uppercase tracking-widest">Retour au Dashboard</span>
                </a>
            </div>

            {{-- 1. Header & Stats Globales --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border-b-4 border-blue-500 shadow-sm flex items-center justify-between hover:scale-[1.02] transition-transform">
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 italic tracking-widest">Total Commentaires</p>
                        <span class="text-3xl font-black text-slate-900 dark:text-white">{{ $stats['total'] }}</span>
                    </div>
                    <div class="size-12 rounded-2xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-500">
                        <span class="material-symbols-outlined text-3xl">forum</span>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border-b-4 border-emerald-500 shadow-sm flex items-center justify-between hover:scale-[1.02] transition-transform">
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 italic tracking-widest">Publiés</p>
                        <span class="text-3xl font-black text-emerald-500">{{ $stats['approved'] }}</span>
                    </div>
                    <div class="size-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-500">
                        <span class="material-symbols-outlined text-3xl">check_circle</span>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border-b-4 border-amber-500 shadow-sm flex items-center justify-between hover:scale-[1.02] transition-transform">
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 italic tracking-widest">En attente</p>
                        <span class="text-3xl font-black text-amber-500">{{ $stats['pending'] }}</span>
                    </div>
                    <div class="size-12 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center text-amber-500">
                        <span class="material-symbols-outlined text-3xl">pending_actions</span>
                    </div>
                </div>
            </div>

            {{-- 2. Filtres de navigation rapides --}}
            <div class="flex gap-2 mb-8 bg-slate-200/50 dark:bg-slate-800/50 p-1.5 rounded-2xl w-fit backdrop-blur-sm border border-white/20">
                <a href="{{ route('dashboard.comments') }}"
                    class="px-6 py-2 rounded-xl text-[10px] font-black uppercase transition-all {{ !request('filter') ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">Tous</a>

                <a href="{{ route('dashboard.comments', ['filter' => 'pending']) }}"
                    class="px-6 py-2 rounded-xl text-[10px] font-black uppercase transition-all {{ request('filter') == 'pending' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'text-slate-500 hover:text-slate-700' }}">En attente</a>

                <a href="{{ route('dashboard.comments', ['filter' => 'approved']) }}"
                    class="px-6 py-2 rounded-xl text-[10px] font-black uppercase transition-all {{ request('filter') == 'approved' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-slate-500 hover:text-slate-700' }}">Approuvés</a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- 3. Sidebar: Stats par Annonce (Réduite à col-span-2) --}}
                <div class="lg:col-span-2 space-y-4">
                    <h3 class="text-[10px] font-black uppercase text-slate-900 dark:text-white px-2 flex items-center gap-2 tracking-tighter italic">
                        <span class="size-2 bg-primary rounded-full"></span> Par annonce
                    </h3>
                    <div class="space-y-3">
                        @foreach($propertiesWithStats as $prop)
                        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm hover:border-primary/30 transition-all">
                            <p class="text-[9px] font-black uppercase truncate text-slate-500 mb-2">{{ $prop->title }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-slate-400">{{ $prop->commentaires_count }} avis</span>
                                <span class="text-[9px] bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 px-2 py-0.5 rounded-md font-black italic">{{ $prop->approved_count }} OK</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- 4. Liste des messages (Élargie à col-span-10) --}}
                <div class="lg:col-span-10 space-y-6">
                    @forelse($comments as $comment)
                    <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm group hover:shadow-md transition-all duration-300">
                        <div class="p-4 md:p-5 flex flex-col lg:flex-row items-center gap-6"> {{-- Padding réduit de p-10 à p-5 --}}

                            {{-- Info Auteur (Plus compact) --}}
                            <div class="flex lg:flex-col items-center gap-3 lg:w-24 flex-shrink-0 lg:border-r border-slate-100 dark:border-slate-800 lg:pr-6">
                                <div class="size-12 rounded-xl bg-slate-900 dark:bg-primary flex items-center justify-center text-xl font-black text-white italic shadow-md">
                                    {{ substr($comment->user ? $comment->user->name : $comment->guest_name, 0, 1) }}
                                </div>
                                <div class="text-left lg:text-center">
                                    <h4 class="text-[10px] font-[1000] text-slate-900 dark:text-white uppercase truncate w-20">
                                        {{ $comment->user ? $comment->user->name : $comment->guest_name }}
                                    </h4>
                                    <span class="text-[8px] font-bold text-slate-400 block tracking-tighter italic">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            {{-- Bloc Message (Plus serré) --}}
                            <div class="flex-1 min-w-1 ">
                                <div class="mb-2"> {{-- Margin réduit --}}
                                    <span class="px-3 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[9px] font-black uppercase rounded-full border border-blue-100 dark:border-blue-800/50 inline-flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-xs">location_city</span>
                                        {{ $comment->property->title }}
                                    </span>
                                </div>

                                {{-- Bulle de contenu (Padding réduit de p-8 à p-4) --}}
                                <div class="relative bg-slate-50/50 dark:bg-slate-800/30 p-4 rounded-[1.5rem] border border-slate-100 dark:border-slate-800/50 w-full group-hover:bg-white dark:group-hover:bg-slate-800 transition-colors">
                                    <span class="material-symbols-outlined absolute -top-2 -left-1 text-4xl text-slate-200 dark:text-slate-700 opacity-30 select-none">format_quote</span>
                                    <p class="text-slate-700 dark:text-slate-300 text-sm md:text-base leading-snug italic font-medium relative z-10">
                                        {{ $comment->content }}
                                    </p>
                                </div>
                            </div>

                            {{-- Actions (Plus petits boutons) --}}
                            <div class=" ml-5 flex flex-row lg:flex-col gap-2 flex-shrink-0 justify-center items-center lg:pl-6 lg:border-l border-slate-100 dark:border-slate-800">
                                @if(!$comment->is_approved)
                                <form action="{{ route('comments.approve', $comment->id) }}" method="POST" class="w-full lg:w-auto">
                                    @csrf @method('PATCH')
                                    <button class="w-full lg:size-12 bg-emerald-500 text-white rounded-xl shadow-md hover:bg-emerald-600 hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-2 px-4 lg:px-0 h-10 lg:h-12" title="Approuver">
                                        <span class="material-symbols-outlined font-black text-xl">done</span>
                                        <span class="lg:hidden font-black uppercase text-[10px]">Approuver</span>
                                    </button>
                                </form>
                                @else
                                <div class="lg:size-12 px-4 lg:px-0 h-10 lg:h-12 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-500 rounded-xl flex items-center justify-center border border-emerald-100 dark:border-emerald-800 gap-2 w-full lg:w-auto">
                                    <span class="material-symbols-outlined font-black text-xl">verified</span>
                                </div>
                                @endif

                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')" class="w-full lg:w-auto">
                                    @csrf @method('DELETE')
                                    <button class="w-full lg:size-12 bg-rose-50 dark:bg-rose-900/20 text-rose-500 rounded-xl border border-rose-100 dark:border-rose-900/30 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center gap-2 px-4 lg:px-0 h-10 lg:h-12" title="Supprimer">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                        <span class="lg:hidden font-black uppercase text-[10px]">Supprimer</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-32 text-center bg-white dark:bg-slate-900 rounded-[3rem] border-4 border-dashed border-slate-100 dark:border-slate-800">
                        <span class="material-symbols-outlined text-8xl text-slate-200 mb-4">cloud_off</span>
                        <h3 class="text-xl font-black text-slate-400 uppercase italic">Aucun commentaire trouvé</h3>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>