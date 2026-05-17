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
        
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-600/10 blur-[150px] rounded-full -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-blue-500/5 blur-[120px] rounded-full translate-y-1/4 -translate-x-1/4"></div>

        <div class="max-w-6xl mx-auto relative z-10">
            
            <div class="text-center mb-24">
                <span class="text-blue-500 font-black uppercase text-[11px] tracking-[0.6em] mb-4 block">L'Innovation au service de l'immobilier</span>
                <h1 class="font-luxury text-5xl md:text-7xl text-white italic font-extrabold">
                    L'Expérience <span class="not-italic text-blue-600 drop-shadow-[0_0_15px_rgba(37,99,235,0.3)]">Open Door</span>
                </h1>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = [
                [
                'icon' => 'filter_frames',
                'title' => 'Gestion Média Avancée',
                'desc' => 'Une vitrine technologique où vos propriétés sont sublimées par un traitement d’image haute définition et un archivage intelligent.'
                ],
                [
                'icon' => 'home_work',
                'title' => 'Expertise Opeen Door',
                'desc' => 'Une connaissance profonde du marché local de Safi pour dénicher des pépites immobilières alliant charme traditionnel et confort moderne.'
                ],
                [
                'icon' => 'shield_with_heart',
                'title' => 'Transparence Totale',
                'desc' => 'Grâce à notre architecture logicielle, suivez l’état de votre dossier et de vos transactions en temps réel avec une clarté absolue.'
                ],
                [
                'icon' => 'auto_awesome',
                'title' => 'Automated Marketing',
                'desc' => 'Diffusion multi-canaux automatique de vos annonces pour atteindre les investisseurs les plus qualifiés au Maroc et à l’international.'
                ],
                [
                'icon' => 'account_balance',
                'title' => 'Conseil Patrimonial',
                'desc' => 'Au-delà de la vente, nous vous accompagnons dans la valorisation de votre patrimoine immobilier avec une vision à long terme.'
                ],
                [
                'icon' => 'electric_bolt',
                'title' => 'Réactivité Digitale',
                'desc' => 'Une plateforme optimisée pour une mise en relation éclair entre acheteurs et vendeurs, sans les frictions des agences classiques.'
                ]
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="glass-slim p-10 rounded-[3rem] border border-white/5 hover:border-blue-500/40 transition-all duration-500 group relative overflow-hidden">
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>

                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center mb-8 border border-white/10 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-110 transition-all duration-500">
                            <span class="material-symbols-outlined text-3xl text-blue-500 group-hover:text-white transition-colors">
                                <?php echo e($service['icon']); ?>

                            </span>
                        </div>

                        <h3 class="text-white font-luxury text-2xl italic font-bold mb-4 tracking-tight">
                            <?php echo e($service['title']); ?>

                        </h3>

                        <p class="text-slate-400 text-sm leading-relaxed font-medium">
                            <?php echo e($service['desc']); ?>

                        </p>
                    </div>

                    
                    <div class="absolute -bottom-2 -right-2 w-16 h-16 bg-blue-600/10 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="mt-24 text-center">
                <?php if(auth()->guard()->check()): ?>
                
                <a href="<?php echo e(route('properties.create')); ?>" class="inline-flex items-center gap-4 bg-white text-slate-950 font-black px-10 py-5 rounded-2xl uppercase tracking-widest text-xs hover:bg-blue-600 hover:text-white transition-all shadow-2xl shadow-white/5">
                    Lancer votre annonce avec nous
                    <span class="material-symbols-outlined text-sm">add_circle</span>
                </a>
                <?php else: ?>
                
                <a href="<?php echo e(route('register')); ?>" class="inline-flex items-center gap-4 bg-white text-slate-950 font-black px-10 py-5 rounded-2xl uppercase tracking-widest text-xs hover:bg-blue-600 hover:text-white transition-all shadow-2xl shadow-white/5">
                    Devenir membre Open Door
                    <span class="material-symbols-outlined text-sm">person_add</span>
                </a>
                <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\opendoor v-final\opendoor\resources\views/services.blade.php ENDPATH**/ ?>