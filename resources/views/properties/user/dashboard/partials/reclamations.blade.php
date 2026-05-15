<div class="py-12 bg-slate-50 dark:bg-slate-950 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- TOP NAVIGATION & TITLE --}}
            <div class="mb-8">
               
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter uppercase italic">Mes Plaintes</h1>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Gestion et suivi des tickets d'assistance</p>
                    </div>
                    
                </div>
            </div>

            {{-- MINI STATS : PRIORITÉS (Sécurisées avec multi-langue) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
                @php
                    // On définit les priorités pour le comptage (gère FR et EN)
                    $countUrgente = $reclamations->filter(fn($r) => in_array($r->priorite ?? $r->priority, ['urgente', 'urgent']))->count();
                    $countNormale = $reclamations->filter(fn($r) => in_array($r->priorite ?? $r->priority, ['normale', 'normal', 'medium']))->count();
                    $countBasse = $reclamations->filter(fn($r) => in_array($r->priorite ?? $r->priority, ['basse', 'low']))->count();
                @endphp

                {{-- Card Urgente --}}
                <div class="bg-white dark:bg-slate-900 p-5 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm flex items-center justify-between group hover:border-rose-500/30 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="size-12 rounded-2xl bg-rose-50 dark:bg-rose-900/20 flex items-center justify-center text-rose-500 font-black">
                            <span class="material-symbols-outlined">priority_high</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Urgentes</p>
                            <p class="text-xl font-black text-slate-900 dark:text-white">{{ $countUrgente }}</p>
                        </div>
                    </div>
                </div>

                {{-- Card Normale --}}
                <div class="bg-white dark:bg-slate-900 p-5 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm flex items-center justify-between group hover:border-blue-500/30 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="size-12 rounded-2xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-500 font-black">
                            <span class="material-symbols-outlined">bolt</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Normales</p>
                            <p class="text-xl font-black text-slate-900 dark:text-white">{{ $countNormale }}</p>
                        </div>
                    </div>
                </div>

                {{-- Card Basse --}}
                <div class="bg-white dark:bg-slate-900 p-5 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm flex items-center justify-between group hover:border-emerald-500/30 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="size-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-500 font-black">
                            <span class="material-symbols-outlined">low_priority</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Basses</p>
                            <p class="text-xl font-black text-slate-900 dark:text-white">{{ $countBasse }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLEAU PRINCIPAL --}}
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] overflow-hidden border border-slate-100 dark:border-slate-800 shadow-[30px_30px_80px_-15px_rgba(0,0,0,0.08)]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                                <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest">Sujet / Motif</th>
                                <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest text-center">Priorité</th>
                                <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest text-center">Statut</th>
                                <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest">Date</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                            @forelse($reclamations as $reclamation)
                                @php
                                    // Détection automatique des noms de colonnes
                                    $prio = strtolower($reclamation->priorite ?? $reclamation->priority ?? 'normale');
                                    $stat = strtolower($reclamation->statut ?? $reclamation->status ?? 'ouvert');
                                @endphp
                                <tr class="hover:bg-slate-50/30 dark:hover:bg-slate-800/30 transition-colors group">
                                    <td class="px-8 py-6">
                                        <p class="text-sm font-bold text-slate-900 dark:text-white mb-1 uppercase tracking-tight">{{ $reclamation->sujet ?? $reclamation->subject ?? 'Sans sujet' }}</p>
                                        <p class="text-xs text-slate-500 line-clamp-1 italic">{{ $reclamation->description ?? $reclamation->message }}</p>
                                    </td>

                                    <td class="px-6 py-6 text-center">
                                        <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border
                                            {{ in_array($prio, ['urgente', 'urgent']) ? 'bg-rose-50 text-rose-600 border-rose-100' : 
                                               (in_array($prio, ['normale', 'normal', 'medium']) ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-slate-50 text-slate-500 border-slate-200') }}">
                                            {{ $prio }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-6 text-center">
                                        <span class="px-4 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border flex items-center justify-center gap-2 mx-auto max-w-fit
                                            {{ in_array($stat, ['resolu', 'resolved', 'success']) ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 
                                               (in_array($stat, ['en_cours', 'pending', 'processing']) ? 'bg-amber-50 text-amber-600 border-amber-200' : 'bg-slate-100 text-slate-600 border-slate-200') }}">
                                            <span class="size-1.5 rounded-full {{ in_array($stat, ['resolu', 'resolved']) ? 'bg-emerald-500' : (in_array($stat, ['en_cours', 'pending']) ? 'bg-amber-500' : 'bg-slate-400') }}"></span>
                                            {{ $stat }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-6 text-xs font-bold text-slate-400">
                                        {{ $reclamation->created_at->format('d/m/Y') }}
                                    </td>

                                    <td class="px-8 py-6 text-right">
                                        <form action="{{ route('reclamations.destroy', $reclamation->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="size-9 inline-flex items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400 hover:bg-rose-600 hover:text-white hover:rotate-90 transition-all duration-300">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold uppercase text-[10px] tracking-[0.2em] italic">
                                        Aucun dossier trouvé
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
