<x-guest-layout>
    {{-- Ratio 40/60 pour minimiser l'image et élargir la zone de saisie --}}
    <div class="min-h-screen grid lg:grid-cols-[2fr_3fr] bg-slate-50">
        
        {{-- Section Gauche : Largeur réduite --}}
        <div class="hidden lg:flex relative bg-slate-900 overflow-hidden items-center justify-center p-8">
            <div class="absolute inset-0">
                <img src="{{ asset('images/porte.png') }}" class="w-full h-full object-cover opacity-30">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 via-slate-900/90 to-slate-900"></div>
            </div>
            
            <div class="relative z-10 max-w-xs text-center lg:text-left">
                <div class="flex items-center gap-3 mb-4">
                    <span class="h-[1px] w-8 bg-blue-500"></span>
                    <span class="text-blue-400 font-black uppercase tracking-[0.3em] text-[10px]">Premium Member</span>
                </div>
                <h1 class="text-white font-serif text-4xl italic font-black mb-4 leading-tight">
                    Votre nouvelle <br><span class="text-blue-500">histoire.</span>
                </h1>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Rejoignez la communauté exclusive d'OpenDoor au Maroc.
                </p>
            </div>
        </div>

        {{-- Section Droite : Formulaire aggrandi --}}
        <div class="flex items-center justify-center p-4 md:p-8 bg-white lg:bg-transparent">
            <div class="w-full max-w-xl"> {{-- Elargissement du conteneur --}}
                
                {{-- Logo Mobile --}}
                <div class="lg:hidden mb-6 text-center">
                    <h2 class="text-slate-900 font-serif text-2xl italic font-black">Open<span class="text-blue-600">Door</span></h2>
                </div>

                <div class="bg-white lg:shadow-xl lg:rounded-[1.5rem] lg:p-8 lg:border lg:border-slate-100">
                    <h2 class="hidden lg:block text-xl font-black text-slate-900 mb-6 uppercase tracking-tighter italic font-serif">Inscription</h2>

                    <form method="POST" action="{{ route('register') }}" class="space-y-3.5"> {{-- Marges réduites entre inputs --}}
                        @csrf

                        {{-- Nom Complet --}}
                        <div class="group">
                            <label for="name" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 group-focus-within:text-blue-600">Nom complet</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-lg group-focus-within:text-blue-500">person</span>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                    class="w-full pl-12 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-blue-500/20 transition-all"
                                    placeholder="Ex: Amine Bennani">
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        {{-- Email --}}
                        <div class="group">
                            <label for="email" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 group-focus-within:text-blue-600">Adresse Email</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-lg group-focus-within:text-blue-500">alternate_email</span>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full pl-12 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-blue-500/20 transition-all"
                                    placeholder="amine@example.com">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        {{-- Password Grid --}}
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="group">
                                <label for="password" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 group-focus-within:text-blue-600">Mot de passe</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-lg group-focus-within:text-blue-500">lock</span>
                                    <input id="password" type="password" name="password" required
                                        class="w-full pl-12 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-blue-500/20 transition-all"
                                        placeholder="••••••••">
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-1" />
                            </div>

                            <div class="group">
                                <label for="password_confirmation" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 group-focus-within:text-blue-600">Confirmation</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-lg group-focus-within:text-blue-500">shield_lock</span>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required
                                        class="w-full pl-12 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-blue-500/20 transition-all"
                                        placeholder="••••••••">
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 space-y-4">
                            <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl uppercase tracking-widest text-[10px] shadow-lg shadow-blue-500/20 transition-all active:scale-98">
                                Créer mon compte
                            </button>

                            <p class="text-center text-slate-400 text-[11px]">
                                Déjà membre ? 
                                <a href="{{ route('login') }}" class="text-blue-600 font-black hover:underline ml-1">Connectez-vous</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        input::-ms-reveal, input::-ms-clear { display: none; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .lg\:shadow-xl { animation: slideIn 0.5s ease-out; }
    </style>
</x-guest-layout>