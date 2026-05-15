<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Data Alpine étendue pour gérer le menu mobile --}}
    <div x-data="{ activeTab: 'overview', sidebarOpen: false }" class="flex h-screen overflow-hidden bg-[#f0f4f8] dark:bg-[#0f172a] font-sans antialiased relative">
        
        {{-- OVERLAY MOBILE (ferme la sidebar au clic à l'extérieur) --}}
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             x-transition:enter="transition opacity-30 duration-300" 
             x-transition:leave="transition opacity-0 duration-300"
             class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden">
        </div>

        {{-- SIDEBAR ADAPTATIVE --}}
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 w-64 lg:static lg:w-72 bg-white/80 dark:bg-slate-900/90 backdrop-blur-2xl border-r border-slate-200/60 dark:border-slate-800/60 flex flex-col shrink-0 z-50 transition-transform duration-300 ease-in-out print:hidden">
            <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto custom-scrollbar">
                <p class="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 m-4 ">Menu Principal</p>
                
                @php
                    $menuItems = [
                        ['id' => 'overview', 'label' => "Vue d'ensemble", 'icon' => 'grid_view'],
                        ['id' => 'users', 'label' => 'Utilisateurs', 'icon' => 'group'],
                        ['id' => 'properties', 'label' => 'Annonces', 'icon' => 'campaign'],
                    ];
                @endphp

                @foreach($menuItems as $item)
                    <button @click="activeTab = '{{ $item['id'] }}'; if(window.innerWidth < 1024) sidebarOpen = false"
                        :class="activeTab === '{{ $item['id'] }}' ? 'bg-blue-600 shadow-lg shadow-blue-600/20 text-white' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/50'"
                        class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300">
                        <span class="material-symbols-outlined text-[22px]">{{ $item['icon'] }}</span>
                        <span class="font-bold tracking-tight text-sm">{{ $item['label'] }}</span>
                    </button>
                @endforeach

                <div class="py-4"><div class="h-px bg-slate-100 dark:bg-slate-800 mx-4"></div></div>
                
                <p class="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 mb-4">Contrôle</p>
               {{-- Lien Témoignages --}}
<a href="#testimonials-section" 
   @click="activeTab = 'overview'"
   class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 text-slate-500 hover:bg-slate-100 hover:text-amber-600 dark:text-slate-400 dark:hover:bg-slate-800/50">
    <span class="material-symbols-outlined text-[22px]">reviews</span>
    <span class="font-semibold tracking-tight">Témoignages</span>
</a>

{{-- Lien Réclamations --}}
<a href="#reclamations-section" 
   @click="activeTab = 'overview'"
   class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 text-slate-500 hover:bg-slate-100 hover:text-indigo-600 dark:text-slate-400 dark:hover:bg-slate-800/50">
    <span class="material-symbols-outlined text-[22px]">report_problem</span>
    <span class="font-semibold tracking-tight">Réclamations</span>
</a>
            </nav>

            {{-- Profil --}}
            <div class="p-4">
                <div class="p-3 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-500 to-teal-400 flex items-center justify-center text-white font-black">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</span>
                        <span class="text-[9px] uppercase text-blue-400 font-black tracking-widest">Admin</span>
                    </div>
                </div>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            {{-- TOPBAR MOBILE --}}
            <header class="lg:hidden flex items-center justify-between p-4 bg-white border-b border-slate-200 dark:bg-slate-900 dark:border-slate-800">
                <button @click="sidebarOpen = true" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <span class="font-black text-xs uppercase tracking-widest text-slate-400">Dashboard</span>
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </header>

            {{-- ZONE DE CONTENU SCROLLABLE --}}
            <div class="flex-1 overflow-y-auto bg-slate-50 dark:bg-slate-950 ">
                <div class="max-w-7xl ">
                    <div x-show="activeTab === 'overview'" x-cloak x-transition.duration.400ms>
                        @include('properties.admin.dashboard.partials.overview')
                    </div>
                    <div x-show="activeTab === 'users'" x-cloak x-transition.duration.400ms>
                        @include('properties.admin.dashboard.partials.users')
                    </div>
                    <div x-show="activeTab === 'properties'" x-cloak x-transition.duration.400ms>
                        @include('properties.admin.dashboard.partials.properties')
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</x-app-layout>