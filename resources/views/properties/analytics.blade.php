<x-app-layout>
    <div class="bg-[# rgba(255, 255, 255, 0.7)] min-h-screen py-16 px-4 relative overflow-hidden text-slate-900">
        {{-- Scripts nécessaires --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        {{-- Background FX - Lueurs douces --}}
        <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-blue-100/50 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] bg-indigo-50/50 blur-[100px] rounded-full"></div>

        {{-- Grille très discrète --}}
        <div class="absolute inset-0 opacity-[0.4] pointer-events-none"
            style="background-image: radial-gradient(#e2e8f0 1.5px, transparent 1.5px); background-size: 30px 30px;"></div>

        <div class="max-w-5xl mx-auto relative z-10">

            {{-- En-tête --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div>
                    <div class="flex items-center gap-4 mb-4">
                        <span class="h-[3px] w-20 bg-blue-600 rounded-full"></span>

                        <span class="text-blue-600 font-black uppercase tracking-[0.5em] text-[12px] md:text-[14px]">
                            Analyse de Marché
                        </span>
                    </div>
                </div>
                <div class="bg-white border border-slate-200 shadow-sm px-5 py-2 rounded-full">
                    <p class="text-[10px] text-slate-500 uppercase font-black tracking-widest flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        Données en temps réel
                    </p>
                </div>
            </div>

            {{-- Widgets --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Widget Prix Moyen --}}
                <div class="group bg-white border border-slate-200 p-8 rounded-[2.5rem] shadow-sm transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 rounded-2xl bg-blue-50 text-blue-600">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <span class="text-[10px] font-black px-2 py-1 rounded-lg bg-emerald-100 text-emerald-700">+2.4%</span>
                    </div>
                    <p class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Prix Moyen</p>
                    <h2 class="text-3xl font-black text-slate-900 mt-1">
                        {{ number_format($stats['avg_price'], 0, ',', ' ') }} <span class="text-sm text-blue-600 font-medium">DH</span>
                    </h2>
                </div>

                {{-- Widget Volume --}}
                <div class="group bg-white border border-slate-200 p-8 rounded-[2.5rem] shadow-sm transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 rounded-2xl bg-blue-50 text-blue-600">
                            <span class="material-symbols-outlined">analytics</span>
                        </div>
                        <div class="flex gap-1 h-4 items-end">
                            <div class="w-1 bg-blue-500 animate-bounce h-full"></div>
                            <div class="w-1 bg-blue-300 animate-bounce h-2/3" style="animation-delay: 0.1s"></div>
                            <div class="w-1 bg-blue-100 animate-bounce h-1/2" style="animation-delay: 0.2s"></div>
                        </div>
                    </div>
                    <p class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Annonces Actives</p>
                    <h2 class="text-3xl font-black text-slate-900 mt-1">
                        {{ $stats['total_listings'] }} <span class="text-sm text-blue-600 font-medium">Unités</span>
                    </h2>
                </div>

                {{-- Widget Secteur --}}
                <div class="group relative bg-blue-600 p-8 rounded-[2.5rem] shadow-lg shadow-blue-200 transition-all duration-500 hover:scale-[1.02] overflow-hidden">
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <div>
                            <p class="text-blue-100/80 font-bold uppercase text-[10px] tracking-widest">Secteur Top</p>
                            <h2 class="text-2xl font-black text-white mt-2 italic truncate">
                                {{ $stats['popular_district'] }}
                            </h2>
                        </div>
                        <a href="{{ route('properties.index', ['search' => $stats['popular_district']]) }}"
                            class="mt-8 flex items-center gap-2 text-[10px] font-black uppercase text-white bg-white/20 w-fit px-4 py-2 rounded-full backdrop-blur-md border border-white/10 transition-all duration-300 hover:bg-white/30 hover:gap-4 group/btn">

                            <span>Voir les annonces</span>

                            <span class="material-symbols-outlined text-xs transition-transform duration-300 group-hover/btn:translate-x-1">
                                arrow_forward
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Graphique Central --}}
            <div class="mt-10 bg-white border border-slate-200 rounded-[3.5rem] p-10 shadow-sm">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tight">Courbe de Croissance</h3>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Évolution des prix à Safi</p>
                    </div>
                    <div class="flex bg-slate-100 p-1 rounded-xl">
                        <button class="px-4 py-1.5 rounded-lg bg-white shadow-sm text-blue-600 text-[9px] font-black uppercase">Prix</button>
                        <button class="px-4 py-1.5 rounded-lg text-slate-500 text-[9px] font-black uppercase hover:text-slate-900">Demande</button>
                    </div>
                </div>

                <div class="h-80 w-full relative">
                    <canvas id="marketChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('marketChart').getContext('2d');
            const chartData = @json($chartData);

            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.1)');
            gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Prix Moyen',
                        data: chartData.values,
                        borderColor: '#2563eb',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#2563eb',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: '#f1f5f9'
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 10,
                                    weight: 'bold'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 10,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>