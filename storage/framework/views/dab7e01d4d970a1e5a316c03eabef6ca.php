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
    
    <div x-data="{ activeTab: 'overview', sidebarOpen: false }" class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950 font-sans relative">

        
        <div x-show="sidebarOpen"
            @click="sidebarOpen = false"
            x-transition:enter="transition opacity-0 duration-300"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition opacity-100 duration-300"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30 lg:hidden">
        </div>

        
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 w-64 lg:static lg:w-72 flex-shrink-0 border-r border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 flex flex-col h-full shadow-2xl z-40 transition-transform duration-300 ease-in-out">

            
            <div class="p-6 flex lg:hidden items-center justify-between">
                <span class="text-blue-600 font-black italic">OpenDoor</span>
                <button @click="sidebarOpen = false" class="text-slate-500">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            
            <nav class="px-3 py-4 flex-1 overflow-y-auto space-y-1.5 custom-scrollbar">
                <?php
                $navItems = [
                ['id' => 'overview', 'label' => 'Tableau de bord', 'icon' => 'dashboard', 'color' => 'blue'],
                ['id' => 'annonces', 'label' => 'Mes Annonces', 'icon' => 'ads_click', 'color' => 'blue'],
                ['id' => 'comments', 'label' => 'Commentaires', 'icon' => 'chat_bubble', 'color' => 'blue'],
                ];
                ?>

                <?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button @click="activeTab = '<?php echo e($item['id']); ?>'; if(window.innerWidth < 1024) sidebarOpen = false"
                    :class="activeTab === '<?php echo e($item['id']); ?>' ? 'bg-blue-600 shadow-lg shadow-blue-600/20 text-white scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/50'"
                    class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 group">
                    <span class="material-symbols-outlined text-[22px]"><?php echo e($item['icon']); ?></span>
                    <div class="flex-1 flex items-center justify-between min-w-0">
                        <span class="font-bold text-[10px] uppercase tracking-wider truncate"><?php echo e($item['label']); ?></span>
                        <?php if($item['id'] === 'comments' && isset($pendingCommentsCount) && $pendingCommentsCount > 0): ?>
                        <span class="h-4 min-w-4 rounded-full bg-rose-500 flex items-center justify-center text-[9px] font-black text-white px-1">
                            <?php echo e($pendingCommentsCount); ?>

                        </span>
                        <?php endif; ?>
                    </div>
                </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="pt-4 pb-2 px-4">
                    <div class="h-px bg-slate-100 dark:bg-slate-800 w-full"></div>
                </div>

                
                <button @click="activeTab = 'reclamations'; if(window.innerWidth < 1024) sidebarOpen = false"
                    :class="activeTab === 'reclamations' ? 'bg-slate-800 text-white shadow-lg' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800'"
                    class="w-full px-4 py-3 rounded-xl flex items-center gap-3 transition-all duration-200">
                    <span class="material-symbols-outlined text-[22px]">inventory_2</span>
                    <span class="font-bold text-[10px] uppercase tracking-wider">Réclamations</span>
                </button>

                <button @click="activeTab = 'porter-plainte'; if(window.innerWidth < 1024) sidebarOpen = false"
                    :class="activeTab === 'porter-plainte' ? 'bg-rose-500 text-white shadow-lg' : 'text-slate-500 dark:text-slate-400 hover:bg-rose-50 dark:hover:bg-rose-500/10'"
                    class="w-full px-4 py-3 rounded-xl flex items-center gap-3 transition-all duration-200">
                    <span class="material-symbols-outlined text-[22px]">report_problem</span>
                    <span class="font-bold text-[10px] uppercase tracking-wider">Porter Plainte</span>
                </button>

                
                <div class="mt-auto pt-10 pb-4">
                    <div class="flex items-center gap-3 p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50">
                        <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center text-white font-black text-sm shrink-0">
                            <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-black text-slate-900 dark:text-white truncate uppercase tracking-tighter"><?php echo e(Auth::user()->name); ?></p>
                            <p class="text-[8px] font-bold text-blue-600 uppercase tracking-widest">Pro</p>
                        </div>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="shrink-0">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-7 h-7 flex items-center justify-center text-slate-400 hover:text-rose-500 transition-all">
                                <span class="material-symbols-outlined text-lg">logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </aside>

        
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden relative">

            
            <header class="lg:hidden print:hidden flex items-center justify-between p-4 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
                <button @click="sidebarOpen = true" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <span class="font-black text-[10px] uppercase tracking-widest text-blue-600">Mon Espace</span>
                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white text-xs font-bold">
                    <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                </div>
            </header>

            
            <div class="flex-1 overflow-y-auto ">
                <div class="max-w-5xl mx-auto">

                    
                    <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
                        <?php echo $__env->make('properties.user.dashboard.partials.overview', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>

                    <div x-show="activeTab === 'annonces'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
                        <?php echo $__env->make('properties.user.dashboard.partials.myProperties', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>

                    
                    <div x-show="activeTab === 'comments'" x-cloak
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        <?php echo $__env->make('properties.user.dashboard.partials.comments', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    <div x-show="activeTab === 'messages'" x-cloak
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        
                        <?php echo $__env->make('properties.user.dashboard.partials.messages', ['messages' => $userMessages ?? []], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    
                    <div x-show="activeTab === 'reclamations'" x-cloak
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        <?php echo $__env->make('properties.user.dashboard.partials.reclamations', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    
                    <div x-show="activeTab === 'porter-plainte'" x-cloak
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        
                        <section class="max-w-4xl mx-auto">
                            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden">
                                <div class="p-10 bg-rose-500 text-white">
                                    <h1 class="text-3xl font-black uppercase italic tracking-tighter">Ouvrir un ticket</h1>
                                    <p class="opacity-80 text-sm font-medium mt-2 uppercase tracking-widest">Décrivez votre problème technique ou litige.</p>
                                </div>

                                <form action="<?php echo e(route('reclamations.store')); ?>" method="POST" class="p-10 space-y-8">
                                    <?php echo csrf_field(); ?>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Sujet</label>
                                            <input type="text" name="subject" required class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl p-4 focus:ring-2 focus:ring-rose-500 transition-all text-slate-900 dark:text-white font-bold">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Priorité</label>
                                            <select name="priority" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl p-4 focus:ring-2 focus:ring-rose-500 transition-all text-slate-900 dark:text-white font-bold uppercase text-xs">
                                                <option value="basse">Basse</option>
                                                <option value="normale" selected>Normale</option>
                                                <option value="urgente">Urgente</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Description</label>
                                        <textarea name="content" rows="6" required class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl p-4 focus:ring-2 focus:ring-rose-500 transition-all text-slate-900 dark:text-white font-medium"></textarea>
                                    </div>

                                    <button type="submit" class="w-full bg-rose-500 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rose-600 transition-all shadow-xl shadow-rose-500/20 flex items-center justify-center gap-3">
                                        <span class="material-symbols-outlined">send</span> Envoyer la réclamation
                                    </button>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>
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
<?php endif; ?>

<style>
   @media print {
    /* 1. Cacher les éléments globaux du layout */
    .print\:hidden, 
    aside, 
    header, 
    nav, 
    footer,
    [role="navigation"],
    button, /* Cache tous les boutons (Imprimer, Supprimer, etc.) */
    form,   /* Cache les formulaires d'action */
    .lg\:hidden {
        display: none !important;
    }

    /* 2. Réinitialiser la structure pour que le contenu ne soit pas coupé */
    html, body {
        height: auto !important;
        overflow: visible !important;
        background: white !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* 3. Cibler précisément la zone de contenu */
    main, 
    .flex-1, 
    .overflow-y-auto {
        display: block !important;
        height: auto !important;
        overflow: visible !important;
        width: 100% !important;
        position: static !important;
        margin: 0 !important;
        padding: 0 !important;
        min-height: 0 !important;
    }

    /* 4. Ajustement spécifique pour ta Stats Grid et tes Cards */
    .grid {
        display: grid !important;
        gap: 1.5rem !important;
    }

    /* Force le fond blanc des cartes pour l'impression (certains navigateurs les ignorent) */
    .bg-white, .dark\:bg-slate-900 {
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: none !important;
    }

    /* Garder les couleurs des textes importantes */
    .text-slate-900, .text-slate-600 {
        color: #000000 !important;
    }
    
    .text-primary, .text-blue-600 {
        color: #2563eb !important;
    }

    /* Empêcher de couper une carte ou une ligne de tableau en plein milieu entre deux pages */
    .bg-white, tr, .rounded-3xl {
        page-break-inside: avoid !important;
    }

    @page {
        margin: 1cm;
        size: auto;
    }
}

    .custom-scrollbar::-webkit-scrollbar {
        width: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
</style>
<?php /**PATH C:\Users\HP\Desktop\opendoor v-final\opendoor\resources\views/properties/user/dashboard/index.blade.php ENDPATH**/ ?>