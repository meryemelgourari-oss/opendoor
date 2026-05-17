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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,wght@1,400;1,700&family=Inter:wght@400;600;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
        }

        .font-luxury {
            font-family: 'Bodoni Moda', serif;
        }

        /* Glassmorphism plus léger et fin */
        .glass-slim {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Image Reveal plus subtil */
        .reveal-container:hover .reveal-img {
            transform: scale(1.05);
        }

        .reveal-img {
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        /* Masquer la scrollbar tout en gardant la fonctionnalité */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Support du scroll-snap fluide */
        .snap-x {
            scroll-snap-type: x mandatory;
        }

        .snap-start {
            scroll-snap-align: start;
        }

        /* Correction pour l'effet reveal sur les nouvelles cartes */
        .reveal-container:hover .reveal-img {
            transform: scale(1.1) rotate(1deg);
        }
    </style>

    
    <div x-data="{ 
    frame: 1, 
    totalFrames: 5,
    isPaused: false,
    init() {
        setInterval(() => {
            if (!this.isPaused) {
                this.frame = (this.frame < this.totalFrames) ? this.frame + 1 : 1;
            }
        }, 5000);
    } 
}"
        
        class="perspective-container relative h-[60vh] md:h-[50vh] w-full bg-slate-950 overflow-hidden shadow-2xl">

        
        
        <?php $__currentLoopData = [
        1 => ['img' => 'porte.png', 'sub' => 'Bienvenue chez OpenDoor', 'title' => 'Votre rêve commence...'],
        2 => ['img' => 'salon.png', 'sub' => 'Découvrez', 'title' => 'L\'espace idéal.'],
        3 => ['img' => 'chambre.png', 'sub' => 'Vivez', 'title' => 'Votre confort.'],
        4 => ['img' => 'local.png', 'sub' => 'Lancez', 'title' => 'Votre activité.']
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div x-show="frame === <?php echo e($index); ?>" x-cloak
            x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="frame-future" x-transition:enter-end="frame-active"
            x-transition:leave="transition ease-in duration-800" x-transition:leave-start="frame-active" x-transition:leave-end="frame-past"
            class="absolute inset-0 z-30 flex items-center justify-center bg-slate-950">

            <img src="<?php echo e(asset('images/' . $data['img'])); ?>" class="absolute inset-0 w-full h-full object-cover opacity-40 md:opacity-50">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>

            <div class="relative z-10 text-center px-6">
                <span class="text-white font-extrabold tracking-[0.2em] md:tracking-[0.4em] uppercase text-[9px] md:text-[11px] mb-2 md:mb-3 block opacity-90 drop-shadow-md">
                    <?php echo e($data['sub']); ?>

                </span>
                <h2 class="font-luxury text-white text-2xl md:text-5xl font-extrabold italic drop-shadow-[0_4px_4px_rgba(0,0,0,0.9)] leading-tight">
                    <?php echo e($data['title']); ?>

                </h2>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <div x-show="frame === 5" x-cloak
            x-init="$watch('frame', value => isPaused = (value === 5))"
            class="absolute inset-0 z-40 bg-slate-900 flex items-center justify-center px-4">

            <div class="relative z-10 text-center w-full max-w-xl">
                <span class="text-blue-400 font-extrabold uppercase text-[10px] md:text-[11px] tracking-[0.2em] mb-2 md:mb-3 block">Open Door Search</span>
                <h1 class="font-luxury text-2xl md:text-4xl text-white font-extrabold italic mb-6 md:mb-8 leading-tight">
                    L'immobilier <span class="not-italic font-black text-white underline decoration-blue-500 decoration-2 underline-offset-8">essentiel</span>
                </h1>

                
                <form action="<?php echo e(route('properties.index')); ?>" method="GET"
                    @mouseenter="isPaused = true" @mouseleave="if(frame !== 5) isPaused = false"
                    class="glass-slim p-1.5 rounded-full flex items-center gap-2 border border-white/20 shadow-2xl">

                    <input type="text" name="city" placeholder="Ville, quartier..."
                        @focus="isPaused = true"
                        
                        class="flex-1 bg-transparent border-none focus:ring-0 text-sm md:text-base px-4 md:px-5 text-white placeholder:text-slate-400 w-full">

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 md:px-7 py-2.5 md:py-3 rounded-full transition-all flex items-center gap-2 shadow-lg active:scale-95">
                        <span class="material-symbols-outlined text-sm">search</span>
                        <span class="hidden md:inline text-xs font-black uppercase tracking-widest">Chercher</span>
                    </button>
                </form>
            </div>
        </div>

        
        <div class="absolute bottom-4 md:bottom-6 left-1/2 -translate-x-1/2 z-50 flex gap-2 bg-slate-950/40 px-3 py-1.5 rounded-full backdrop-blur-sm border border-white/5">
            <template x-for="i in totalFrames">
                <button @click="frame = i"
                    :class="frame === i ? 'bg-blue-500 w-6 md:w-8' : 'bg-white/30 w-1.5 md:w-2'"
                    class="h-1.5 md:h-2 rounded-full transition-all duration-500"></button>
            </template>
        </div>
    </div>
    
    
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-16 mt-8 md:mt-10 relative z-20 perspective-1000">
        
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <?php $__currentLoopData = [
            ['icon' => 'home', 'label' => 'Maison'],
            ['icon' => 'apartment', 'label' => 'Apparts'], 
            ['icon' => 'storefront', 'label' => 'Commerces'],
            ['icon' => 'landscape', 'label' => 'Terrains']
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            
            <div class="electric-card-container group"
                onmousemove="if(window.innerWidth > 768) handleCardTilt(event, this)"
                onmouseleave="resetCardTilt(this)">

                
                <div class="electric-card relative bg-slate-900 p-4 md:p-6 rounded-[1.5rem] md:rounded-[2rem] shadow-xl flex items-center gap-3 md:gap-4 cursor-pointer transition-transform duration-150 ease-out will-change-transform">

                    
                    <div class="electric-border opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative z-10 flex items-center gap-3 md:gap-4 w-full">
                        
                        <div class="w-10 h-10 md:w-12 md:h-12 flex-shrink-0 bg-blue-950/50 border border-blue-500/30 text-blue-400 rounded-xl md:rounded-2xl flex items-center justify-center shadow-[0_0_15px_rgba(37,99,235,0.3)] group-hover:border-blue-400 group-hover:text-blue-300 transition-all duration-300 relative overflow-hidden">
                            <span class="material-symbols-outlined absolute text-3xl md:text-5xl text-blue-500/10 scale-150 group-hover:animate-pulse">bolt</span>
                            <span class="material-symbols-outlined text-xl md:text-2xl relative z-10"><?php echo e($item['icon']); ?></span>
                        </div>

                        
                        <div class="flex flex-col flex-1 overflow-hidden">
                            
                            <span class="font-black text-[10px] md:text-sm text-slate-100 tracking-tighter md:tracking-tight group-hover:text-blue-300 transition-colors uppercase truncate group-hover:drop-shadow-[0_0_5px_rgba(37,99,235,0.7)]">
                                <?php echo e($item['label']); ?>

                            </span>
                        </div>
                    </div>

                    
                    <div class="absolute inset-0 rounded-[1.5rem] md:rounded-[2rem] group-hover:shadow-[inset_0_0_30px_rgba(37,99,235,0.4)] transition-shadow duration-300 pointer-events-none"></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    
    <section class="max-w-5xl mx-auto px-6 py-12 space-y-20">

        
        <?php $cat = ['id' => 'maison', 'title' => 'Dernières Maisons']; ?>
        <div class="category-slide-group">
            <div class="flex justify-between items-end mb-6">
                <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tighter"><?php echo e($cat['title']); ?></h2>
                <a href="<?php echo e(route('properties.index', ['type_bien' => $cat['id']])); ?>" class="text-[9px] font-bold text-blue-600 underline underline-offset-4 uppercase">Tout explorer</a>
            </div>
            <div class="flex gap-4 overflow-x-auto pb-6 snap-x no-scrollbar">
                <?php $__empty_1 = true; $__currentLoopData = $latestProperties->where('type_bien', $cat['id']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="min-w-[320px] snap-start group relative h-[220px] rounded-[2rem] overflow-hidden shadow-xl">
                    <img src="<?php echo e($property->ressources->first() ? asset('storage/' . $property->ressources->first()->resourceable->path) : asset('images/default.jpeg')); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent"></div>
                    <div class="absolute bottom-0 p-6 w-full flex justify-between items-end">
                        <div>
                            <p class="text-blue-400 font-bold text-[10px] uppercase mb-0.5"><?php echo e($property->city); ?></p>
                            <h3 class="text-white text-base font-bold"><?php echo e($property->title); ?></h3>
                        </div>
                        <span class="bg-white text-slate-950 px-3 py-1.5 rounded-full font-black text-xs"><?php echo e(number_format($property->price, 0, ',', ' ')); ?> DH</span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-slate-400 text-sm italic">Bientôt disponible...</p>
                <?php endif; ?>
            </div>
        </div>

        
        <?php $cat = ['id' => 'appartement', 'title' => 'Appartements Récents']; ?>
        <div class="category-slide-group">
            <div class="text-center mb-8">
                <span class="text-indigo-500 font-bold text-[9px] uppercase tracking-[0.4em]">SÉLECTION URBAN</span>
                <h2 class="text-2xl font-luxury italic font-extrabold text-slate-900"><?php echo e($cat['title']); ?></h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php $__currentLoopData = $latestProperties->where('type_bien', $cat['id'])->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="group border-b border-slate-200 pb-4">
                    <div class="aspect-[4/5] rounded-xl overflow-hidden mb-3 bg-slate-100">
                        <img src="<?php echo e($property->ressources->first() ? asset('storage/' . $property->ressources->first()->resourceable->path) : asset('images/default.jpeg')); ?>" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                    </div>
                    <div class="flex justify-between items-start">
                        <h3 class="font-bold text-slate-800 text-sm"><?php echo e($property->title); ?></h3>
                        <span class="text-indigo-600 font-black text-sm"><?php echo e(number_format($property->price, 0, ',', ' ')); ?> DH</span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <?php $cat = ['id' => 'terrain', 'title' => 'Terrains & Lots']; ?>
        <div class="bg-amber-50 rounded-[2rem] p-8 border border-amber-100">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center text-white scale-90">
                    <span class="material-symbols-outlined text-xl">landscape</span>
                </div>
                <h2 class="text-xl font-black text-amber-900 uppercase"><?php echo e($cat['title']); ?></h2>
            </div>
            <div class="flex gap-4 overflow-x-auto no-scrollbar">
                <?php $__currentLoopData = $latestProperties->where('type_bien', $cat['id']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="min-w-[200px] bg-white p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-full h-24 rounded-lg mb-3 bg-slate-200 overflow-hidden">
                        <img src="<?php echo e($property->ressources->first() ? asset('storage/' . $property->ressources->first()->resourceable->path) : asset('images/default.jpeg')); ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-amber-100 text-amber-700 text-[9px] font-bold px-2 py-0.5 rounded-md"><?php echo e($property->surface); ?> m²</span>
                    </div>
                    <h3 class="font-bold text-slate-800 text-xs truncate mb-3"><?php echo e($property->title); ?></h3>
                    <a href="<?php echo e(route('properties.show', $property->id)); ?>" class="text-amber-600 font-bold text-[10px] flex items-center gap-1">Détails <span class="material-symbols-outlined text-xs">east</span></a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        
        <?php $cat = ['id' => 'commercial', 'title' => 'Locaux Commerciaux']; ?>
        <div class="category-slide-group">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tighter"><?php echo e($cat['title']); ?></h2>
                    <div class="h-1 w-12 bg-blue-600 mt-1"></div>
                </div>
                <a href="<?php echo e(route('properties.index', ['type_bien' => $cat['id']])); ?>" class="group flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-blue-600 transition-colors">
                    VOIR TOUT <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $latestProperties->where('type_bien', $cat['id'])->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 group">
                    <div class="w-1/3 relative overflow-hidden">
                        <img src="<?php echo e($property->ressources->first() ? asset('storage/' . $property->ressources->first()->resourceable->path) : asset('images/default.jpeg')); ?>" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute top-3 left-3">
                            <span class="bg-slate-900/80 backdrop-blur-md text-white text-[8px] font-bold px-2 py-1 rounded-lg uppercase">Pro</span>
                        </div>
                    </div>
                    <div class="w-2/3 p-5 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-blue-600 font-bold text-[10px] uppercase"><?php echo e($property->city); ?></span>
                                <span class="font-black text-slate-900 text-sm"><?php echo e(number_format($property->price, 0, ',', ' ')); ?> DH</span>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base leading-tight mb-2 group-hover:text-blue-600 transition-colors"><?php echo e($property->title); ?></h3>
                            <p class="text-slate-500 text-xs line-clamp-2"><?php echo e(Str::limit($property->description, 70)); ?></p>
                        </div>
                        <div class="flex items-center gap-4 pt-4 border-t border-slate-50">
                            <div class="flex items-center gap-1 text-slate-400">
                                <span class="material-symbols-outlined text-sm">straighten</span>
                                <span class="text-[10px] font-bold"><?php echo e($property->surface); ?> m²</span>
                            </div>
                            <a href="<?php echo e(route('properties.show', $property->id)); ?>" class="ml-auto text-slate-900 font-bold text-[10px] uppercase tracking-wider">Découvrir</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full py-10 text-center bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                        <p class="text-slate-400 text-sm italic">Aucun local commercial disponible pour le moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    
    <section class="max-w-5xl mx-auto px-6 py-10">
        <div class="relative rounded-[2.5rem] overflow-hidden bg-slate-950 p-10 shadow-2xl">
            <div class="absolute top-0 right-0 w-1/3 h-full opacity-10 pointer-events-none">
                <img src="<?php echo e(asset('images/porte.png')); ?>" class="w-full h-full object-cover grayscale">
            </div>
            <div class="relative z-10 max-w-xl">
                <span class="text-blue-500 font-black uppercase text-[9px] tracking-[0.3em] mb-3 block">Partenariat Open Door</span>
                <h2 class="font-luxury text-3xl text-white italic font-extrabold mb-4 leading-tight">
                    Transformez votre bien en <span class="text-blue-500">opportunité.</span>
                </h2>
                <p class="text-slate-400 text-xs mb-8 leading-relaxed max-w-md">
                    Rejoignez la première plateforme immobilière de Safi. Visibilité premium et gestion intelligente.
                </p>
                <div class="flex gap-3">
                    <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard.index')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">add_circle</span> Publier
                    </a>
                    <?php else: ?>
                    <a href="<?php echo e(route('register')); ?>" class="bg-white text-slate-950 px-6 py-3 rounded-xl text-[10px] font-black uppercase flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">person_add</span> S'inscrire
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    
    <footer class="relative bg-slate-950 pt-16 pb-4 overflow-hidden border-t border-white/5">
        <div class="max-w-7xl mx-auto px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 mb-8">

                
                <div class="space-y-4">
                    <span class="font-luxury text-2xl italic font-extrabold text-white">Open<span class="text-blue-500">Door</span></span>
                    <p class="text-slate-500 text-[12px] leading-relaxed max-w-xs">L'immobilier à Safi avec élégance et technologie.</p>
                </div>

                
                <div>
                    <h4 class="font-black uppercase tracking-widest text-[9px] text-blue-500 mb-6 italic">Menu</h4>
                    <ul class="space-y-2">
                        <?php $__currentLoopData = ['Services' => route('services'), 'À propos' => route('about'),'Mentions Legales'=> route('legal'), 'Contact' => route('contact')]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e($u); ?>" class="text-[11px] font-bold text-slate-400 hover:text-white transition-colors"><?php echo e($l); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                
                <div>
                    <h4 class="font-black uppercase tracking-widest text-[9px] text-blue-500 mb-6 italic">
                        Contact
                    </h4>
                    <p class="text-[9px] uppercase text-slate-500 font-black tracking-widest mb-1">Siège social</p>
                    <p class="text-sm font-bold text-slate-200">Safi, Maroc</p>
                    <p class="text-[9px] uppercase text-slate-500 font-black tracking-widest mb-1">Assistance</p>
                    <p class="text-sm font-black text-blue-400 hover:text-blue-300 transition-colors cursor-pointer">
                        contact@opendoor.ma
                    </p>
                </div>


                
                <div class="bg-blue-900/20 backdrop-blur-md p-6 rounded-[1.5rem] border border-white/5">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="flex h-1.5 w-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                        <h4 class="text-blue-400 text-[8px] uppercase font-black">Nouveautés</h4>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-black text-white tracking-tighter"><?php echo e($newPropertiesCount); ?></span>
                        <span class="text-blue-300 text-[8px] uppercase font-black"><?php echo e(Str::plural('Opportunité', $newPropertiesCount)); ?></span>
                    </div>
                </div>

            </div>
        </div>
    </footer>
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
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\opendoor v-final\opendoor\resources\views/welcome.blade.php ENDPATH**/ ?>