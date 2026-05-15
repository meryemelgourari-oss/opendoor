<x-app-layout>
    <main>
        {{-- HERO SECTION --}}
        <section class="bg-blue-900 pt-40 pb-24 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-8 relative z-10">
                <h4 class="text-blue-400 font-black uppercase tracking-[0.3em] text-xs mb-4">L'agence</h4>
                <h1 class="text-white font-serif text-6xl md:text-8xl font-black italic leading-none">
                    Dépasser les <br> <span class="text-blue-300">frontières.</span>
                </h1>
            </div>
            {{-- Décoration abstraite --}}
            <div class="absolute top-0 right-0 w-1/2 h-full bg-blue-800/20 skew-x-12 transform origin-right"></div>
        </section>

        {{-- SECTION VISION --}}
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                    <div class="relative">
                        <div class="aspect-[4/5] rounded-[3rem] overflow-hidden shadow-2xl">
                            <img src="{{ asset('images/about.jpeg') }}" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -bottom-6 -right-6 bg-blue-600 text-white p-6 rounded-2xl shadow-xl">
                            <span class="block text-3xl font-black italic font-serif">2026</span>
                            <span class="text-[10px] uppercase tracking-widest font-bold">Fondation</span>
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="text-slate-900 font-serif text-5xl font-black italic mb-8 leading-tight">Notre Engagement</h2>
                        <div class="space-y-6">
                            <p class="text-slate-600 text-lg leading-relaxed font-medium">
                                OpenDoor n'est pas seulement une plateforme technologique développée . C'est le résultat d'une réflexion profonde sur la manière dont nous habitons nos espaces au Safi et partout au Maroc.
                            </p>
                            <div class="p-8 bg-slate-50 rounded-[2rem] border-l-4 border-blue-600 shadow-sm">
                                <p class="italic text-slate-800 font-serif text-xl leading-relaxed">
                                    "Nous croyons que chaque clé tournée est le début d'une nouvelle histoire."
                                </p>
                            </div>
                            <p class="text-slate-600 text-lg leading-relaxed font-medium">
                                Notre mission est de rendre l'immobilier accessible, transparent et surtout, tourné vers l'avenir.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION CHIFFRES --}}
        <section class="py-20 bg-slate-900">
            <div class="max-w-7xl mx-auto px-8 grid grid-cols-2 md:grid-cols-4 gap-12 text-center">
                <div>
                    <span class="block text-white text-5xl font-black mb-2 tracking-tighter">100%</span>
                    <span class="text-blue-400 uppercase text-[10px] tracking-widest font-bold">Digital</span>
                </div>
                <div>
                    <span class="block text-white text-5xl font-black mb-2 tracking-tighter">+500</span>
                    <span class="text-blue-400 uppercase text-[10px] tracking-widest font-bold">Visites</span>
                </div>
                <div>
                    <span class="block text-white text-5xl font-black mb-2 tracking-tighter">24/7</span>
                    <span class="text-blue-400 uppercase text-[10px] tracking-widest font-bold">Disponibilité</span>
                </div>
                <div>
                    <span class="block text-white text-5xl font-black mb-2 tracking-tighter">0</span>
                    <span class="text-blue-400 uppercase text-[10px] tracking-widest font-bold">Stress</span>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>