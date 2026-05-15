<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<main class="flex-1 overflow-y-auto p-2 lg:p-4 bg-slate-50 dark:bg-slate-950">

    <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-10 print:hidden">
        <div>
            <h2 class="text-4xl font-black tracking-tight italic uppercase underline decoration-blue-500 decoration-4 dark:text-white">Gestionnaire Central</h2>
            <p class="text-slate-500 font-medium mt-1">Interactions clients et modération</p>
        </div>
        <button onclick="window.print()" class="flex items-center gap-2 bg-slate-900 dark:bg-white dark:text-slate-900 text-white px-5 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:scale-105 transition-all shadow-xl">
            <span class="material-symbols-outlined text-sm">print</span>
            Imprimer Rapport
        </button>
    </header>

    <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-wrap items-end gap-3 print:hidden bg-white dark:bg-slate-900 p-4 rounded-2xl shadow-sm border border-slate-200/50 mb-6">
        <div class="flex flex-col gap-1">
            <label class="text-[10px] font-black uppercase text-slate-400 ml-2">Du</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-bold focus:ring-2 focus:ring-blue-500 transition-all">
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-[10px] font-black uppercase text-slate-400 ml-2">Au</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-bold focus:ring-2 focus:ring-blue-500 transition-all">
        </div>
        <button type="submit" class="bg-blue-600 text-white p-2.5 rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/20">
            <span class="material-symbols-outlined text-sm">filter_alt</span>
        </button>
        @if(request('date_from') || request('date_to'))
        <a href="{{ route('admin.dashboard') }}" class="text-[10px] font-black uppercase text-rose-500 hover:underline mb-3 ml-2">Effacer</a>
        @endif
    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
        @php
        $mini_stats = [
        ['label' => 'Vues', 'val' => $stats['total_views'] ?? 0, 'icon' => 'visibility', 'color' => 'text-emerald-500'],
        ['label' => 'A valider', 'val' => $testimonials->where('is_approved', false)->count(), 'icon' => 'rate_review', 'color' => 'text-amber-500'],
        ['label' => 'Réclamations', 'val' => $stats['pending_reclamations'] ?? 0, 'icon' => 'warning', 'color' => 'text-rose-500'],
        ['label' => 'Utilisateurs', 'val' => $stats['users_count'] ?? 0, 'icon' => 'group', 'color' => 'text-blue-500'],
        ['label' => 'Annonces', 'val' => $stats['properties_count'] ?? 0, 'icon' => 'real_estate_agent', 'color' => 'text-indigo-500'],
        ];
        @endphp
        @foreach($mini_stats as $ms)
        <div class="bg-white dark:bg-slate-900 p-4 rounded-[2rem] border border-slate-200/50 shadow-sm flex items-center gap-4 transition-transform hover:scale-[1.02]">
            <div class="w-10 h-10 rounded-2xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center {{ $ms['color'] }}">
                <span class="material-symbols-outlined">{{ $ms['icon'] }}</span>
            </div>
            <div>
                <p class="text-[9px] font-black uppercase text-slate-400">{{ $ms['label'] }}</p>
                <h3 class="text-lg font-black dark:text-white">{{ number_format($ms['val']) }}</h3>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white dark:bg-slate-900 p-8 rounded-[3rem] border border-slate-200/60 shadow-2xl mb-12">
        <div class="mb-8">
            <h4 class="text-xl font-black italic uppercase dark:text-white">Analyse de Performance</h4>
            <p class="text-xs text-slate-400 font-medium italic">
                {{ request('date_from') && request('date_to') 
                            ? 'Du ' . \Carbon\Carbon::parse(request('date_from'))->format('d/m/Y') . ' au ' . \Carbon\Carbon::parse(request('date_to'))->format('d/m/Y') 
                            : 'Vue Globale' }}
            </p>
        </div>
        <div class="h-[350px] w-full">
            <canvas id="statsChart"></canvas>
        </div>
    </div>

    <div class="w-full flex flex-col gap-8 mb-8">

        <div id="reclamations-section" class="w-full bg-white dark:bg-slate-900 rounded-[3rem] p-8 border border-slate-200/60 shadow-sm">
            <h4 class="text-xl font-black italic uppercase text-indigo-600 mb-8">Réclamations urgentes</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-[600px] overflow-y-auto custom-scrollbar pr-2">
                @forelse($reclamations as $rec)
                <div class="p-5 rounded-[2rem] bg-slate-50 dark:bg-slate-800/50 hover:bg-indigo-50 transition-all border border-transparent hover:border-indigo-100 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-md 
                            {{ $rec->status === 'resolu' ? 'bg-emerald-100 text-emerald-600' : ($rec->status === 'en_cours' ? 'bg-amber-100 text-amber-600' : 'bg-rose-100 text-rose-600 animate-pulse') }}">
                                {{ $rec->status }}
                            </span>
                            <span class="text-[9px] font-bold text-slate-400">{{ $rec->created_at->diffForHumans() }}</span>
                        </div>

                        <h5 class="font-bold text-sm mb-1 dark:text-white">{{ $rec->subject }}</h5>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-4">{{ $rec->message }}</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-lg bg-slate-300 flex items-center justify-center text-[10px] font-bold text-white uppercase">
                                {{ substr($rec->user->name ?? '?', 0, 1) }}
                            </div>
                            <span class="text-[10px] font-bold text-slate-600 dark:text-slate-400">{{ $rec->user->name ?? 'Anonyme' }}</span>
                        </div>

                        <form action="{{ route('admin.reclamations.update', $rec) }}" method="POST" class="w-full">
                            @csrf
                            @method('PATCH')

                            @if($rec->status === 'ouvert')
                            <input type="hidden" name="status" value="en_cours">
                            <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black uppercase rounded-xl transition-all shadow-md shadow-indigo-200">
                                Prendre en charge
                            </button>
                            @elseif($rec->status === 'en_cours')
                            <input type="hidden" name="status" value="resolu">
                            <button type="submit" class="w-full py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-[10px] font-black uppercase rounded-xl transition-all shadow-md shadow-emerald-200">
                                Marquer comme résolu
                            </button>
                            @else
                            <button type="button" disabled class="w-full py-2 bg-slate-200 text-slate-500 text-[10px] font-black uppercase rounded-xl cursor-not-allowed">
                                Terminée
                            </button>
                            @endif
                        </form>
                    </div>
                </div>
                @empty
                <p class="col-span-full text-center py-10 text-slate-400 italic">Aucune réclamation.</p>
                @endforelse
            </div>
        </div>

        <div id="testimonials-section" class="w-full bg-white dark:bg-slate-900 rounded-[3rem] p-8 border border-slate-200/60 shadow-sm">
            <h4 class="text-xl font-black italic uppercase text-amber-500 mb-8">Modération Avis</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-[600px] overflow-y-auto custom-scrollbar pr-2">
                @forelse($testimonials as $testimony)
                <div class="p-5 rounded-[2rem] border {{ $testimony->is_approved ? 'border-emerald-100 bg-emerald-50/20' : 'border-amber-100 bg-amber-50/20' }}">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white font-black text-xs">
                            {{ substr($testimony->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs font-black dark:text-white">{{ $testimony->name }}</p>
                            <p class="text-[9px] text-slate-400 uppercase font-bold">{{ $testimony->created_at->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>
                    <p class="text-xs italic text-slate-600 dark:text-slate-400 mb-4 font-medium">"{{ $testimony->content }}"</p>
                    <div class="flex gap-2">
                        <form action="{{ route('admin.testimonials.update', $testimony) }}" method="POST" class="flex-1">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="{{ $testimony->is_approved ? 'pending' : 'approved' }}">
                            <button class="w-full py-2.5 rounded-xl text-[9px] font-black uppercase tracking-tighter transition-all {{ $testimony->is_approved ? 'bg-slate-200 text-slate-600' : 'bg-emerald-500 text-white shadow-lg' }}">
                                {{ $testimony->is_approved ? 'Désactiver' : 'Approuver' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.testimonials.destroy', $testimony) }}" method="POST" onsubmit="return confirm('Supprimer cet avis ?')">
                            @csrf @method('DELETE')
                            <button class="p-2.5 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="col-span-full text-slate-400 text-center py-10 italic">Aucun témoignage reçu.</p>
                @endforelse
            </div>
        </div>

    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        @media print {
            .lg\:grid-cols-5 {
                display: grid !important;
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 10px
            }

            header::after {
                content: "Période : {{ request('date_from', 'Début') }} - {{ request('date_to', 'Aujourd\'hui') }}";
                display: block;
                font-size: 12px;
                margin-top: 10px;
                font-weight: bold;
            }
        }
    </style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('statsChart');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['UTILISATEURS ACTIFS', 'UTILISATEURS INACTIFS', 'ANNONCES PUBLIÉES', 'ANNONCES ARCHIVÉES', 'ANNONCES EN BROUILLONS'],
                datasets: [{
                    label: 'STATISTIQUES DE GESTION DU SITE',
                    // Injection directe des valeurs PHP
                    data: [
                        {{ $stats['active_users_count'] ?? 0 }},
                        {{ $stats['inactive_users_count'] ?? 0 }},
                        {{ $stats['published_count'] ?? 0 }},
                        {{ $stats['archived_count'] ?? 0 }},
                        {{ $stats['draft_count'] ?? 0 }}
                    ],
                    backgroundColor: ['#3b82f6', '#94a3b8', '#03f407', '#f40f0f', '#f59e0b'],
                    borderRadius: 12,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: { family: 'Inter', weight: 'bold', size: 10 }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5],
                            color: 'rgba(148, 163, 184, 0.1)'
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { weight: 'bold', size: 10 }
                        }
                    }
                }
            }
        });
    });
</script>
</main>
