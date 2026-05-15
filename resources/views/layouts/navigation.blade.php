<nav x-data="{ 
        open: false, 
        isScrolled: false 
    }"
    x-init="window.addEventListener('scroll', () => { isScrolled = window.scrollY > 10 })"
    :class="{ 'py-2': isScrolled, 'py-4': !isScrolled }"
    class=" print:hidden sticky top-0 z-50 transition-all duration-500 ease-out perspective-1000">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div
            :class="{ 
                'bg-white/90 backdrop-blur-xl shadow-xl border-blue-100/50 rotate-x-2 scale-[0.98]': isScrolled,
                'bg-white/60 backdrop-blur-md border-transparent': !isScrolled 
            }"
            class="relative flex justify-between h-16 px-4 rounded-3xl border transition-all duration-700 ease-in-out transform-gpu shadow-sm"
            style="transform-style: preserve-3d;">

            <div class="flex items-center">
                {{-- LOGO --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="transition-transform hover:scale-105 flex items-center gap-2">
                        <x-application-logo class="block h-8 w-auto text-blue-600" />
                        <span class="text-xl font-extrabold tracking-tight text-blue-900">
                            Open<span class="text-blue-500">Door</span>
                        </span>
                    </a>
                </div>

                {{-- LIENS DE NAVIGATION (FRANÇAIS) --}}
                <div class="hidden space-x-6 sm:ms-10 sm:flex">
                    @php $navLinks = [
                    'home' => 'Accueil',
                    'properties.index' => 'Catalogue',
                    'properties.nearby' => 'Autour de moi',
                    'properties.analytics' => 'Analyse du marché',
                    ]; @endphp

                    @foreach($navLinks as $route => $label)
                    <a href="{{ Route::has($route) ? route($route) : '#' }}"
                        class="relative inline-flex items-center px-1 pt-1 pb-2 text-[11px] font-black uppercase tracking-widest transition-all group {{ request()->routeIs($route) ? 'text-blue-600' : 'text-slate-500 hover:text-blue-500' }}">

                        {{ $label }}

                        {{-- Ligne d'accentuation placée tout en bas --}}
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-500 transform {{ request()->routeIs($route) ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- ZONE UTILISATEUR --}}
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                @guest
                <a href="{{ route('login') }}" class="text-[11px] font-black uppercase tracking-widest text-slate-600 hover:text-blue-700 px-4">Connexion</a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all">S'inscrire</a>
                @endguest

                @auth
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center bg-slate-50 p-1 pr-4 rounded-2xl border border-slate-100 hover:bg-white transition-all group">
                                <div class="w-8 h-8 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold text-xs">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="ms-2 text-[11px] font-black text-slate-700 uppercase tracking-tighter">{{ Auth::user()->name }}</span>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @if(Auth::user()->is_admin == 1)
                            <x-dropdown-link :href="route('admin.dashboard')" class="text-blue-600 font-black italic">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">shield_person</span>
                                    ADMINISTRATION
                                </div>
                            </x-dropdown-link>
                            <div class="border-t border-slate-100 my-1"></div>
                            @endif
                            <x-dropdown-link :href="route('dashboard.index')">Tableau de bord</x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}"> @csrf
                                <x-dropdown-link :href="route('logout')" class="text-red-500 font-bold" onclick="event.preventDefault(); this.closest('form').submit();">Déconnexion</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                @endauth
            </div>

            {{-- MOBILE BURGER --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-blue-600 hover:bg-blue-50 transition-all">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    {{-- MENU MOBILE --}}
    {{-- MENU MOBILE MINIMISÉ --}}
    <div x-show="open"
        x-transition.duration.300ms
        class="sm:hidden absolute inset-x-4 top-20 bg-white/95 backdrop-blur-2xl rounded-[2rem] border border-blue-100 shadow-2xl p-4 z-50 overflow-y-auto max-h-[80vh]">

        <div class="space-y-4">
            {{-- Navigation en Grille pour gagner de la place --}}
            <nav class="grid grid-cols-2 gap-2 text-center border-b border-slate-50 pb-3">
                @foreach($navLinks as $route => $label)
                <a href="{{ Route::has($route) ? route($route) : '#' }}"
                    class="text-[10px] font-black uppercase tracking-tight text-slate-700 bg-slate-50/50 py-2 rounded-lg">
                    {{ $label }}
                </a>
                @endforeach
            </nav>

            {{-- Auth --}}
            @guest
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('login') }}" class="py-3 text-center text-[10px] font-black uppercase bg-slate-50 rounded-xl text-slate-600 italic">Connexion</a>
                <a href="{{ route('register') }}" class="py-3 text-center text-[10px] font-black uppercase bg-blue-600 rounded-xl text-white shadow-md">S'inscrire</a>
            </div>
            @else
            <div class="bg-blue-50/50 rounded-2xl p-3 border border-blue-100/50">
                {{-- Profil Compact --}}
                <div class="flex items-center gap-2 mb-3 bg-white/80 p-1.5 rounded-xl shadow-sm">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold text-xs">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-black uppercase text-slate-800 truncate leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-[8px] font-bold text-blue-500 uppercase tracking-tighter">Membre Pro</p>
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-blue-700 font-black text-[10px] uppercase p-2 bg-blue-100 rounded-lg">
                        <span class="material-symbols-outlined text-base">shield_person</span> Admin
                    </a>
                    @endif

                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('dashboard.index') }}" class="flex items-center justify-center gap-1.5 text-[9px] font-bold text-slate-600 p-2 bg-white rounded-lg border border-slate-100">
                            <span class="material-symbols-outlined text-base">dashboard</span> Board
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center justify-center gap-1.5 text-[9px] font-bold text-slate-600 p-2 bg-white rounded-lg border border-slate-100">
                            <span class="material-symbols-outlined text-base">person</span> Profil
                        </a>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="mt-1">
                        @csrf
                        <button class="w-full py-2.5 flex justify-center items-center gap-2 text-[10px] font-black text-rose-500 uppercase bg-rose-50 rounded-lg border border-rose-100">
                            <span class="material-symbols-outlined text-base">logout</span> Déconnexion
                        </button>
                    </form>
                </div>
            </div>
            @endguest
        </div>
    </div>
</nav>

<style>
    .perspective-1000 {
        perspective: 1000px;
    }

    .rotate-x-2 {
        transform: rotateX(4deg) translateY(5px);
    }

    .rotate-x-12 {
        transform: rotateX(-15deg);
    }
</style>