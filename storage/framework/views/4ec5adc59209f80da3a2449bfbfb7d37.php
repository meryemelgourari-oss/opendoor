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
    <main class="w-full pb-20 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-slate-50 via-white to-blue-50/30">
        <div class="px-6 py-8 md:py-12 md:px-16">

            
            <div class="relative mb-10 md:mb-16">
                <div>
                    <div class="flex items-center gap-4 mb-4">
                        <span class="h-[3px] w-12 md:w-20 bg-blue-600 rounded-full"></span>
                        <span class="text-blue-600 font-black uppercase tracking-[0.3em] md:tracking-[0.5em] text-[10px] md:text-[14px]">
                            Catalogue
                        </span>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 md:gap-8">
                    <p class="mt-2 md:mt-6 text-slate-500 font-medium text-base md:text-lg max-w-md border-l-2 border-blue-600 pl-6">
                        Une sélection rigoureuse des biens les plus prestigieux du Maroc.
                    </p>
                    
                    
                    <div class="group relative inline-flex items-center justify-between lg:justify-start gap-4 bg-white/80 backdrop-blur-md p-2 pl-5 rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/40 w-full lg:w-auto">
                        <span class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400">Trier par</span>
                        <select id="sortSelector" onchange="handleSort(this.value)"
                            class="border-none bg-transparent text-xs md:text-sm font-black text-blue-900 focus:ring-0 cursor-pointer pr-10">
                            <option value="latest" <?php echo e(request('sort') == 'latest' ? 'selected' : ''); ?>>Plus récents</option>
                            <option value="price_asc" <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>Prix croissant</option>
                            <option value="price_desc" <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>Prix décroissant</option>
                        </select>
                    </div>
                </div>
            </div>

            
            <div class="sticky top-4 md:top-6 z-50 mb-12 p-2 md:p-2.5 bg-slate-900/95 backdrop-blur-xl rounded-3xl md:rounded-[2.2rem] shadow-2xl border border-white/10">
                <form action="<?php echo e(route('properties.index')); ?>" method="GET" class="flex flex-col lg:flex-row items-center gap-2">
                    <?php if(request('sort')): ?> <input type="hidden" name="sort" value="<?php echo e(request('sort')); ?>"> <?php endif; ?>

                    
                    <div class="w-full lg:w-60 p-1 bg-white/5 rounded-2xl md:rounded-[1.8rem] flex items-center relative overflow-hidden">
                        <label class="flex-1 relative z-10 cursor-pointer py-2 md:py-2.5 text-center">
                            <input type="radio" name="contract" value="vente" class="hidden" onchange="this.form.submit()" <?php echo e(request('contract', 'vente') == 'vente' ? 'checked' : ''); ?>>
                            <span class="text-[9px] font-black uppercase tracking-widest <?php echo e(request('contract', 'vente') == 'vente' ? 'text-slate-900' : 'text-slate-400'); ?>">Acheter</span>
                        </label>
                        <label class="flex-1 relative z-10 cursor-pointer py-2 md:py-2.5 text-center">
                            <input type="radio" name="contract" value="location" class="hidden" onchange="this.form.submit()" <?php echo e(request('contract') == 'location' ? 'checked' : ''); ?>>
                            <span class="text-[9px] font-black uppercase tracking-widest <?php echo e(request('contract') == 'location' ? 'text-slate-900' : 'text-slate-400'); ?>">Louer</span>
                        </label>
                        <div class="absolute top-1 bottom-1 left-1 w-[calc(50%-2px)] bg-white rounded-xl md:rounded-[1.5rem] transition-all duration-500 <?php echo e(request('contract') == 'location' ? 'translate-x-full' : ''); ?>"></div>
                    </div>

                    
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 w-full lg:flex-1">
                        <div class="relative">
                            <select name="city" onchange="this.form.submit()" class="w-full py-3 md:py-3.5 pl-9 md:pl-10 pr-4 bg-white/5 border border-white/5 rounded-xl md:rounded-[1.5rem] text-[10px] md:text-[11px] font-bold text-white focus:ring-1 focus:ring-blue-500 appearance-none">
                                <option value="" class="text-slate-900">Villes</option>
                                <?php $__currentLoopData = ['Casablanca', 'Rabat', 'Marrakech', 'Tanger', 'Agadir', 'Safi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ville): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ville); ?>" class="text-slate-900" <?php echo e(request('city') == $ville ? 'selected' : ''); ?>><?php echo e($ville); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-blue-400 text-xs md:text-sm">explore</span>
                        </div>

                        <div class="relative">
                            <select name="type" onchange="this.form.submit()" class="w-full py-3 md:py-3.5 pl-9 md:pl-10 pr-4 bg-white/5 border border-white/5 rounded-xl md:rounded-[1.5rem] text-[10px] md:text-[11px] font-bold text-white focus:ring-1 focus:ring-blue-500 appearance-none">
                                <option value="" class="text-slate-900">Types</option>
                                <?php $__currentLoopData = ['appartement' => 'Appart', 'maison' => 'Maison', 'terrain' => 'Terrain', 'commercial' => 'Commerce']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val); ?>" class="text-slate-900" <?php echo e(request('type') == $val ? 'selected' : ''); ?>><?php echo e($lab); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-blue-400 text-xs md:text-sm">home_work</span>
                        </div>

                        <div class="relative">
                            <input name="min_surface" value="<?php echo e(request('min_surface')); ?>" placeholder="M² Min" type="number" class="w-full py-3 md:py-3.5 pl-9 md:pl-10 bg-white/5 border border-white/5 rounded-xl md:rounded-[1.5rem] text-[10px] md:text-[11px] font-bold text-white placeholder:text-slate-500">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-blue-400 text-xs md:text-sm">square_foot</span>
                        </div>

                        <div class="relative">
                            <input name="max_surface" value="<?php echo e(request('max_surface')); ?>" placeholder="M² Max" type="number" class="w-full py-3 md:py-3.5 pl-9 md:pl-10 bg-white/5 border border-white/5 rounded-xl md:rounded-[1.5rem] text-[10px] md:text-[11px] font-bold text-white placeholder:text-slate-500">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-blue-400 text-xs md:text-sm">space_dashboard</span>
                        </div>
                    </div>

                    
                    <div class="flex items-center gap-2 w-full lg:w-auto">
                        <button type="submit" class="flex-1 lg:px-8 py-3 md:py-3.5 bg-blue-600 text-white font-black rounded-xl md:rounded-[1.5rem] hover:bg-blue-500 transition-all uppercase tracking-widest text-[9px] md:text-[10px]">
                            Filtrer
                        </button>
                        <a href="<?php echo e(route('properties.index')); ?>" class="p-3 bg-white/5 rounded-xl text-slate-400 hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-lg">restart_alt</span>
                        </a>
                    </div>
                </form>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-10 mb-20">
                <?php $__empty_1 = true; $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="group relative bg-white rounded-[2.5rem] md:rounded-[3rem] p-3 md:p-4 transition-all duration-700 hover:shadow-2xl border border-slate-100">
                    <div class="relative h-60 md:h-72 overflow-hidden rounded-[2rem] md:rounded-[2.5rem] mb-6">
                        <img src="<?php echo e($property->ressources->first() ? asset('storage/' . $property->ressources->first()->resourceable->path) : asset('images/default.jpeg')); ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                        
                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur-md px-4 py-2 rounded-xl shadow-xl text-blue-600 font-black text-[10px] md:text-xs">
                                <?php echo e(number_format($property->price, 0, ',', ' ')); ?> DH
                            </span>
                        </div>

                        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 w-[85%] translate-y-10 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                            <a href="<?php echo e(route('properties.show', $property)); ?>" class="flex items-center justify-center gap-3 w-full py-3.5 bg-white rounded-xl text-slate-900 font-black text-[9px] md:text-[10px] uppercase tracking-widest shadow-2xl hover:bg-blue-600 hover:text-white">
                                Explorer <span class="material-symbols-outlined text-sm">east</span>
                            </a>
                        </div>
                    </div>

                    <div class="px-2 md:px-4 pb-2 md:pb-4">
                        <span class="text-[8px] md:text-[9px] font-black text-blue-500 uppercase tracking-widest"><?php echo e($property->type); ?></span>
                        <h3 class="text-slate-900 font-bold text-lg md:text-xl leading-tight mt-1 mb-4 italic font-serif truncate"><?php echo e($property->title); ?></h3>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                            <div class="flex items-center gap-2 overflow-hidden">
                                <span class="material-symbols-outlined text-slate-400 text-sm">location_on</span>
                                <span class="text-[10px] md:text-[11px] font-bold text-slate-500 truncate"><?php echo e($property->city); ?></span>
                            </div>
                            <span class="text-[9px] md:text-[10px] font-black text-slate-900 bg-slate-100 px-3 py-1.5 rounded-lg flex-shrink-0"><?php echo e($property->surface); ?> m²</span>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full py-20 md:py-32 text-center">
                    <span class="material-symbols-outlined text-slate-200 text-6xl mb-4">auto_awesome_motion</span>
                    <p class="text-slate-400 font-serif italic text-xl">Aucune pépite trouvée.</p>
                </div>
                <?php endif; ?>
            </div>

            
            <div class="flex justify-center mb-20 md:mb-40">
                <div class="bg-white p-2 rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
                    <?php echo e($properties->links()); ?>

                </div>
            </div>

            
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-8 bg-slate-900 rounded-[2.5rem] md:rounded-[4rem] p-10 md:p-16 relative overflow-hidden flex flex-col justify-end group min-h-[350px] md:h-[500px]">
                    <div class="absolute top-0 right-0 p-10 md:p-16">
                        <span class="material-symbols-outlined text-blue-500 text-6xl md:text-8xl opacity-20 group-hover:rotate-45 transition-transform duration-1000">all_inclusive</span>
                    </div>
                    <div class="relative z-10">
                        <h2 class="text-white font-serif text-3xl md:text-6xl italic font-black mb-6 leading-tight">L'avant-garde <br><span class="text-blue-500">Immobilière.</span></h2>
                        <p class="text-slate-400 max-w-md text-base md:text-lg leading-relaxed">
                            Nous sélectionnons des cadres de vie uniques basés sur des données de marché exclusives.
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-6">
                    <div class="bg-blue-600 rounded-[2.5rem] md:rounded-[3.5rem] p-8 md:p-10 flex flex-col justify-between text-white hover:scale-[1.02] transition-transform">
                        <div class="size-12 md:size-14 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mb-6 lg:mb-0">
                            <span class="material-symbols-outlined">workspace_premium</span>
                        </div>
                        <div>
                            <h4 class="font-black text-xl md:text-2xl mb-2 italic font-serif">Certifié OpenDoor</h4>
                            <p class="text-blue-100 text-xs md:text-sm">42 points de contrôle avant publication.</p>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-[2.5rem] md:rounded-[3.5rem] p-8 md:p-10 flex flex-col justify-between shadow-2xl hover:scale-[1.02] transition-transform">
                        <div class="size-12 md:size-14 bg-slate-900 rounded-2xl flex items-center justify-center text-white mb-6 lg:mb-0">
                            <span class="material-symbols-outlined">support_agent</span>
                        </div>
                        <div>
                            <h4 class="font-black text-xl md:text-2xl text-slate-900 mb-2 italic font-serif">Conciergerie 24/7</h4>
                            <p class="text-slate-500 text-xs md:text-sm italic">Accompagnement humain constant.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script>
        function handleSort(value) {
            let url = new URL(window.location.href);
            url.searchParams.set('sort', value);
            window.location.href = url.toString();
        }
    </script>

    <style>
        select { background-image: none !important; }
        .pagination { display: flex; gap: 0.5rem; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .group { animation: fadeInUp 0.6s ease backwards; }
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\opendoor v-final\opendoor\resources\views/properties/index.blade.php ENDPATH**/ ?>