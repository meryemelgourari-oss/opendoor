<x-guest-layout>
    {{-- Changement de ratio : lg:grid-cols-[2fr_3fr] pour minimiser l'image et élargir les inputs --}}
    <div class="min-h-screen grid lg:grid-cols-[2fr_3fr] bg-slate-50">
        
        {{-- Section Gauche : Largeur réduite --}}
        <div class="hidden lg:flex relative bg-slate-900 overflow-hidden items-center justify-center p-8">
            <div class="absolute inset-0">
                <img src="{{ asset('images/salon.png') }}" class="w-full h-full object-cover opacity-30">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 via-slate-900/90 to-slate-900"></div>
            </div>
            
            <div class="relative z-10 max-w-xs"> {{-- max-w réduit --}}
                <div class="flex items-center gap-3 mb-4"> {{-- margin réduit --}}
                    <span class="h-[1px] w-8 bg-blue-500"></span>
                    <span class="text-blue-400 font-black uppercase tracking-[0.3em] text-[10px]">Open Door</span>
                </div>
                <h1 class="text-white font-serif text-4xl italic font-black mb-4 leading-tight">
                    Ravi de vous <br><span class="text-blue-500">revoir.</span>
                </h1>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Gérez vos favoris et accédez à vos échanges exclusifs.
                </p>
            </div>
        </div>

        {{-- Section Droite : Zone de saisie élargie --}}
        <div class="flex items-center justify-center p-4 md:p-8 bg-white lg:bg-transparent">
            <div class="w-full max-w-lg"> {{-- max-w-sm passé en max-w-lg pour élargir les inputs --}}
                
                {{-- Logo Mobile --}}
                <div class="lg:hidden mb-6 text-center">
                    <h2 class="text-slate-900 font-serif text-3xl italic font-black">Open<span class="text-blue-600">Door</span></h2>
                </div>

                <div class="bg-white lg:shadow-xl lg:rounded-[1.5rem] lg:p-8 lg:border lg:border-slate-100">
                    <h2 class="hidden lg:block text-xl font-black text-slate-900 mb-6 uppercase tracking-tighter italic font-serif">Connexion</h2>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-4"> {{-- Réduction space-y --}}
                        @csrf

                        <div class="group">
                            <label for="email" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 group-focus-within:text-blue-600">Identifiant</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-lg group-focus-within:text-blue-500">alternate_email</span>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-slate-300"
                                    placeholder="votre@email.com">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <div class="group">
                            <div class="flex justify-between items-center mb-1">
                                <label for="password" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 group-focus-within:text-blue-600">Mot de passe</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-[10px] font-bold text-blue-600 hover:underline uppercase">Oublié ?</a>
                                @endif
                            </div>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-lg group-focus-within:text-blue-500">lock</span>
                                <input id="password" type="password" name="password" required
                                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-blue-500/20 transition-all"
                                    placeholder="••••••••">
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <div class="flex items-center py-1">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                                <input id="remember_me" type="checkbox" class="rounded border-slate-200 text-blue-600 shadow-sm focus:ring-blue-500/20 size-4" name="remember">
                                <span class="ms-2 text-[10px] font-bold text-slate-500 uppercase">{{ __('Se souvenir de moi') }}</span>
                            </label>
                        </div>

                        <div class="pt-2 space-y-4">
                            <button type="submit" class="w-full py-3.5 bg-slate-900 hover:bg-blue-600 text-white font-black rounded-xl uppercase tracking-widest text-[10px] shadow-lg transition-all active:scale-98">
                                Se connecter
                            </button>

                            <p class="text-center text-slate-400 text-[11px]">
                                Pas encore de compte ? 
                                <a href="{{ route('register') }}" class="text-blue-600 font-black hover:underline ml-1">Créer un profil</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeInBlur {
            from { opacity: 0; filter: blur(8px); transform: translateY(5px); }
            to { opacity: 1; filter: blur(0); transform: translateY(0); }
        }
        .lg\:shadow-xl { animation: fadeInBlur 0.4s ease-out; }
    </style>
</x-guest-layout>