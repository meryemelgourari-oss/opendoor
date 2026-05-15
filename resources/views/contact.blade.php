<x-app-layout>
    <div class="bg-slate-950 min-h-screen py-24 px-6 relative overflow-hidden">
        {{-- Lueurs d'ambiance --}}
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-600/10 blur-[120px] rounded-full -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-blue-500/5 blur-[100px] rounded-full translate-y-1/3 -translate-x-1/4"></div>

        <div class="max-w-5xl mx-auto relative z-10">
            
            {{-- Header --}}
            <div class="text-center mb-20">
                <span class="text-blue-500 font-black uppercase text-[11px] tracking-[0.6em] mb-4 block">Connexion Directe</span>
                <h1 class="font-luxury text-5xl md:text-7xl text-white italic font-extrabold">
                    L'Excellence à votre <br><span class="not-italic text-blue-600 drop-shadow-[0_0_15px_rgba(37,99,235,0.3)]">Portée</span>
                </h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- OPTION 1 : WHATSAPP (L'option la plus Luxe/Rapide) --}}
                <a href="https://wa.me/212600000000?text=Bonjour%20Open%20Door,%20je%20souhaite%20avoir des informations%20sur..." 
                   target="_blank"
                   class="group glass-slim p-10 rounded-[3rem] border border-white/10 hover:border-green-500/50 transition-all duration-500 relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-green-500/10 rounded-2xl flex items-center justify-center text-green-500 mb-8 group-hover:scale-110 group-hover:bg-green-500 group-hover:text-white transition-all duration-500">
                            <span class="material-symbols-outlined text-4xl">chat</span>
                        </div>
                        <h3 class="text-white font-luxury text-3xl italic font-bold mb-4">WhatsApp Business</h3>
                        <p class="text-slate-400 text-sm leading-relaxed mb-8">
                            Échangez en temps réel avec l'un de nos conseillers pour une réponse instantanée sur nos biens exclusifs.
                        </p>
                        <span class="text-green-500 font-black uppercase text-[10px] tracking-widest flex items-center gap-2">
                            Démarrer la discussion <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </span>
                    </div>
                    {{-- Effet de vague au survol --}}
                    <div class="absolute -bottom-12 -right-12 w-40 h-40 bg-green-500/5 rounded-full blur-3xl group-hover:bg-green-500/10 transition-all"></div>
                </a>

                {{-- OPTION 2 : EMAIL DIRECT --}}
                <a href="mailto:contact@opendoor.ma?subject=Demande d'information - Open Door" 
                   class="group glass-slim p-10 rounded-[3rem] border border-white/10 hover:border-blue-500/50 transition-all duration-500 relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-500 mb-8 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                            <span class="material-symbols-outlined text-4xl">mail</span>
                        </div>
                        <h3 class="text-white font-luxury text-3xl italic font-bold mb-4">Courriel Officiel</h3>
                        <p class="text-slate-400 text-sm leading-relaxed mb-8">
                            Envoyez-nous vos critères de recherche détaillés pour recevoir une sélection personnalisée "Off-Market".
                        </p>
                        <span class="text-blue-500 font-black uppercase text-[10px] tracking-widest flex items-center gap-2">
                            Envoyer un email <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </span>
                    </div>
                    <div class="absolute -bottom-12 -right-12 w-40 h-40 bg-blue-500/5 rounded-full blur-3xl group-hover:bg-blue-500/10 transition-all"></div>
                </a>

            </div>

            {{-- SECTION CARTE / LOCALISATION --}}
            <div class="mt-16 glass-slim p-4 rounded-[3.5rem] border border-white/10">
                <div class="relative h-[400px] w-full bg-slate-900 rounded-[2.5rem] overflow-hidden group">
                    {{-- Simulation de Map (Tu peux remplacer par un iframe Google Maps) --}}
                    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?q=80&w=2000')] bg-cover bg-center opacity-40 grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-[2s]"></div>
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent"></div>
                    
                    <div class="absolute bottom-10 left-10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center shadow-[0_0_20px_rgba(37,99,235,0.5)] animate-bounce">
                                <span class="material-symbols-outlined text-white">location_on</span>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-xl uppercase tracking-tighter">Safi Head Office</h4>
                                <p class="text-slate-400 text-xs font-medium uppercase tracking-[0.2em]">Quartier Administratif, Maroc</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer de la page --}}
            <div class="mt-16 text-center">
                <p class="text-slate-600 text-[10px] font-black uppercase tracking-[0.4em]">
                    Open Door Safi <span class="text-slate-800 mx-4">|</span> Luxury Real Estate Conciergerie
                </p>
            </div>
        </div>
    </div>
</x-app-layout>