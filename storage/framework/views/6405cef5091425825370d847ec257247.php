<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="bg-slate-950 min-h-screen py-24 px-6 relative overflow-hidden">
        
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-px bg-gradient-to-r from-transparent via-blue-500/50 to-transparent"></div>
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-blue-600/5 blur-[120px] rounded-full"></div>

        <div class="max-w-4xl mx-auto relative z-10">
            
            
            <div class="text-center mb-16">
                <span class="text-blue-500 font-black uppercase text-[10px] tracking-[0.5em] mb-4 block">Cadre Réglementaire</span>
                <h1 class="font-luxury text-5xl text-white italic font-extrabold mb-4">Mentions <span class="not-italic text-blue-600">Légales</span></h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Dernière mise à jour : Avril 2026</p>
            </div>

            
            <div class="glass-slim p-10 md:p-16 rounded-[3rem] border border-white/10 shadow-2xl space-y-12">
                
                
                <section>
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-8 h-px bg-blue-600"></span>
                        <h3 class="text-white font-luxury text-2xl italic font-bold">1. Édition du site</h3>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed ml-12">
                        Le présent site, accessible à l’URL <span class="text-white font-bold">www.opendoor.ma</span>, est édité par l’agence <span class="text-white font-bold">WebExperts</span>, située a Safi, Maroc. 
                        <br><br>
                        <span class="text-blue-500 font-black uppercase text-[10px] tracking-widest mr-2">Directeur de la publication :</span> EL GOURARI Meryem <br>
                        <span class="text-blue-500 font-black uppercase text-[10px] tracking-widest mr-2">Contact :</span> contact@opendoor.ma
                    </p>
                </section>

                
                <section>
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-8 h-px bg-blue-600"></span>
                        <h3 class="text-white font-luxury text-2xl italic font-bold">2. Hébergement</h3>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed ml-12">
                        Le site est actuellement hébergé dans un environnement de développement sécurisé via <span class="text-white font-bold">WampServer 64-bit</span> sur infrastructure locale (Windows PHP/MySQL). La transition vers un hébergement cloud haute performance est prévue pour la phase de production.
                    </p>
                </section>

                
                <section>
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-8 h-px bg-blue-600"></span>
                        <h3 class="text-white font-luxury text-2xl italic font-bold">3. Réglementation Immobilière</h3>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed ml-12 border-l-2 border-blue-600/30 pl-6 italic">
                        Open Door opère conformément à la législation marocaine régissant la profession d'agent immobilier. Les annonces publiées sur le site sont fournies à titre informatif. Les honoraires d'agence, sauf mention contraire, sont à la charge de l'acquéreur conformément aux usages de la profession.
                    </p>
                </section>

                
                <section>
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-8 h-px bg-blue-600"></span>
                        <h3 class="text-white font-luxury text-2xl italic font-bold">4. Données Personnelles</h3>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed ml-12">
                        Conformément à la loi n° 09-08 relative à la protection des personnes physiques à l'égard du traitement des données à caractère personnel, vous disposez d'un droit d'accès, de rectification et d'opposition aux informations vous concernant. 
                        <br><br>
                        Aucune donnée n'est revendue à des tiers. Les informations collectées via nos formulaires directs (WhatsApp/Mail) servent exclusivement à la gestion de votre projet immobilier.
                    </p>
                </section>

                
                <section>
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-8 h-px bg-blue-600"></span>
                        <h3 class="text-white font-luxury text-2xl italic font-bold">5. Propriété Intellectuelle</h3>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed ml-12">
                        L'architecture du site, les logos "OpenDoor", la charte graphique (Luxury Dark Mode) et les contenus textuels sont la propriété exclusive de l'éditeur. Toute reproduction, même partielle, sur quelque support que ce soit, est strictement interdite sans autorisation écrite préalable.
                    </p>
                </section>

                
                <section>
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-8 h-px bg-blue-600"></span>
                        <h3 class="text-white font-luxury text-2xl italic font-bold">6. Cookies & Traçabilité</h3>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed ml-12">
                        Le site peut utiliser des cookies pour améliorer l'expérience utilisateur et l'ergonomie (mémorisation de vos préférences de recherche). Vous pouvez configurer votre navigateur pour refuser ces cookies sans que cela n'affecte l'accès au contenu principal.
                    </p>
                </section>

            </div>

            
            <div class="mt-12 text-center">
                <a href="/" class="text-blue-500 font-black uppercase text-[10px] tracking-widest hover:text-white transition-colors">
                    Retour à l'accueil Open Door
                </a>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\opendoor v-final\opendoor\resources\views/legal.blade.php ENDPATH**/ ?>