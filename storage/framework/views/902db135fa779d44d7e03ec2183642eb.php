
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>

    <style>
        /* --- 1. Animation de Dépliage 3D pour les badges --- */
        @keyframes badgeUnfold {
            0% {
                transform: rotateX(-90deg) translateZ(20px);
                opacity: 0;
            }

            100% {
                transform: rotateX(0deg) translateZ(0);
                opacity: 1;
            }
        }

        .status-badge {
            transform-origin: top;
            animation: badgeUnfold 0.6s cubic-bezier(0.23, 1, 0.32, 1) both;
            backface-visibility: hidden;
        }

        /* --- 2. Effet de profondeur 3D sur les lignes du tableau --- */
        .property-row {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
            perspective: 1000px;
        }

        .property-row:hover {
            transform: translateZ(20px);
            /* Soulève la ligne en 3D */
            z-index: 10;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            cursor: pointer;
        }

        /* Applique un flou léger aux autres lignes quand une est survolée */
        .divide-y:hover .property-row:not(:hover) {
            filter: blur(1px) opacity(0.7);
        }

        /* --- 3. Style pour les cartes de statistiques (Tilt 3D) --- */
        .stat-card-3d {
            transform-style: preserve-3d;
            perspective: 1000px;
            backface-visibility: hidden;
        }

        /* Soulève le contenu intérieur de la carte pour l'effet parallaxe */
        .stat-card-3d .inner-content {
            transform: translateZ(50px);
        }
    </style>

    <main class="flex-1 flex flex-col max-w-[1200px] mx-auto w-full px-4 lg:px-10 py-8" x-data="{ searchOpen: false }">
        
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
            <div class="flex flex-col gap-1">
                <h1 class="text-slate-900 dark:text-slate-100 text-3xl lg:text-4xl font-black leading-tight tracking-[-0.033em]">Mes annonces</h1>
                <p class="text-slate-500 dark:text-slate-400 text-base font-normal">Gérez et suivez la performance de vos publications en temps réel.</p>
            </div>
            <a href="<?php echo e(route('properties.create')); ?>" class="flex items-center justify-center gap-2 rounded-2xl h-14 px-8 bg-blue-600 text-white text-sm font-black shadow-xl shadow-blue-200/50 hover:bg-blue-700 hover:scale-105 transition-all text-center">
                <span class="material-symbols-outlined text-lg">add</span>
                <span>CRÉER UNE NOUVELLE ANNONCE</span>
            </a>
        </div>

        
        <div class="bg-white dark:bg-slate-950 rounded-2xl border border-slate-100 dark:border-slate-800/50 overflow-hidden shadow-sm">
            
            <div class="p-5 border-b border-slate-100 dark:border-slate-800/50 bg-slate-50/50 dark:bg-slate-900/50">
                <form action="<?php echo e(route('dashboard.my-properties')); ?>" method="GET" class="flex flex-col md:flex-row gap-5">
                    <div class="flex-1">
                        <div class="flex w-full h-12 items-stretch rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700/50 focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 transition-all">
                            <div class="text-slate-400 flex items-center justify-center pl-4">
                                <span class="material-symbols-outlined text-[20px]">search</span>
                            </div>
                            <input name="search" value="<?php echo e(request('search')); ?>"
                                class="w-full min-w-0 flex-1 border-none bg-transparent focus:ring-0 text-slate-900 dark:text-slate-100 placeholder:text-slate-400/70 px-4 text-sm font-medium"
                                placeholder="Rechercher par titre..."
                                onchange="this.form.submit()" />
                        </div>
                    </div>

                    <div class="flex gap-2.5 overflow-x-auto pb-2 md:pb-0">
                        
                        <a href="<?php echo e(route('dashboard.my-properties')); ?>"
                            class="flex h-12 items-center justify-center gap-2.5 rounded-xl border px-5 whitespace-nowrap <?php echo e(!request('status') ? 'bg-blue-50/50 text-blue-600 border-blue-200' : 'bg-white dark:bg-slate-900 text-slate-600 border-slate-200/60 dark:border-slate-700/50'); ?>">
                            <span class="text-sm font-bold">Toutes</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black <?php echo e(!request('status') ? 'bg-blue-600 text-white' : 'bg-slate-200/70 text-slate-600'); ?>"><?php echo e($stats['total']); ?></span>
                        </a>

                        
                        <a href="<?php echo e(route('dashboard.my-properties', ['status' => 'publiee'])); ?>"
                            class="flex h-12 items-center justify-center gap-2.5 rounded-xl border px-5 whitespace-nowrap <?php echo e(request('status') == 'publiee' ? 'bg-green-50/70 text-green-700 border-green-200' : 'bg-white dark:bg-slate-900 text-slate-600 border-slate-200/60 dark:border-slate-700/50'); ?>">
                            <span class="text-sm font-bold">Publiées</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black <?php echo e(request('status') == 'publiee' ? 'bg-green-600 text-white' : 'bg-slate-200/70 text-slate-600'); ?>"><?php echo e($stats['publiees']); ?></span>
                        </a>

                        
                        <a href="<?php echo e(route('dashboard.my-properties', ['status' => 'brouillon'])); ?>"
                            class="flex h-12 items-center justify-center gap-2.5 rounded-xl border px-5 whitespace-nowrap <?php echo e(request('status') == 'brouillon' ? 'bg-orange-50/70 text-orange-700 border-orange-200' : 'bg-white dark:bg-slate-900 text-slate-600 border-slate-200/60 dark:border-slate-700/50'); ?>">
                            <span class="text-sm font-bold">Brouillons</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black <?php echo e(request('status') == 'brouillon' ? 'bg-orange-600 text-white' : 'bg-slate-200/70 text-slate-600'); ?>"><?php echo e($stats['brouillons']); ?></span>
                        </a>

                        
                        <a href="<?php echo e(route('dashboard.my-properties', ['status' => 'archivee'])); ?>"
                            class="flex h-12 items-center justify-center gap-2.5 rounded-xl border px-5 whitespace-nowrap <?php echo e(request('status') == 'archivee' ? 'bg-slate-100 text-slate-700 border-slate-200/60 dark:border-slate-700/50' : 'bg-white dark:bg-slate-900 text-slate-600 border-slate-200/60 dark:border-slate-700/50'); ?>">
                            <span class="text-sm font-bold">Archivées</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black <?php echo e(request('status') == 'archivee' ? 'bg-slate-600 text-white' : 'bg-slate-200/70 text-slate-600'); ?>"><?php echo e($stats['archivees']); ?></span>
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-widest border-b border-slate-100 dark:border-slate-800/50">
                            <th class="px-7 py-5">Annonce</th>
                            <th class="px-6 py-5">Statut</th>
                            <th class="px-6 py-5">Vues</th> 
                            <th class="px-6 py-5">Prix</th>
                            <th class="px-6 py-5">Date</th>
                            <th class="px-7 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50 bg-white dark:bg-slate-950">
                        <?php $__empty_1 = true; $__currentLoopData = $myProperties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="property-row group">
                            <td class="px-7 py-6">
                                <div class="flex items-center gap-5">
                                    
                                    <div class="relative size-20 rounded-[1.25rem] overflow-hidden bg-slate-100 dark:bg-slate-900 ring-1 ring-slate-100 dark:ring-slate-800 group-hover:scale-105 transition-transform duration-500">
                                        <?php
                                        $resource = $property->ressources->first();
                                        $media = $resource ? $resource->resourceable : null;
                                        ?>
                                        <?php if($media): ?>
                                        <img src="<?php echo e(asset('storage/' . $media->path)); ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <span class="material-symbols-outlined text-2xl">image</span>
                                        </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="flex flex-col gap-1 min-w-0">
                                        <a href="<?php echo e(route('properties.show', $property->id)); ?>" class="text-base font-black text-slate-950 dark:text-white group-hover:text-blue-600 transition-colors leading-tight truncate max-w-[280px]">
                                            <?php echo e($property->title); ?>

                                        </a>
                                        <div class="flex items-center gap-2 text-slate-400">
                                            <span class="text-[11px] font-medium uppercase tracking-tight"><?php echo e($property->city ?? 'Maroc'); ?></span>
                                            <span class="size-1 rounded-full bg-slate-200"></span>
                                            <span class="text-[11px] font-medium uppercase tracking-tight capitalize text-blue-600"><?php echo e($property->type_bien ?? 'Bien'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </td>


                            <td class="px-6 py-6">
                                <?php
                                // Vérifie si l'annonce est publiée mais pas encore validée par l'admin
                                $isPending = ($property->status === 'publiee' && !$property->is_approved);

                                $statusMap = [
                                'publiee' => $isPending
                                ? 'text-amber-600 dark:text-amber-400 bg-amber-500/10 border-amber-500/20' // En attente
                                : 'text-green-600 dark:text-green-400 bg-green-500/10 border-green-500/20', // Approuvée
                                'brouillon' => 'text-slate-500 dark:text-slate-400 bg-slate-500/10 border-slate-500/20',
                                'archivee' => 'text-orange-600 dark:text-orange-400 bg-orange-500/10 border-orange-500/20'
                                ];
                                $currentStyle = $statusMap[$property->status] ?? 'text-slate-500 bg-slate-500/10 border-slate-500/20';
                                ?>
                                <span class="status-badge inline-flex items-center px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border <?php echo e($currentStyle); ?>">
                                    <span class="size-1.5 rounded-full bg-current mr-2 <?php echo e($isPending ? 'animate-pulse' : ''); ?>"></span>
                                    <?php if($property->status === 'publiee'): ?>
                                    <?php echo e($isPending ? 'En attente d\'approbation' : 'En ligne'); ?>

                                    <?php else: ?>
                                    <?php echo e($property->status); ?>

                                    <?php endif; ?>
                                </span>
                            </td>
                            
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-2.5">
                                    <div class="size-9 rounded-lg bg-blue-50/50 dark:bg-slate-900 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </div>
                                    <span class="text-sm font-black text-slate-900 dark:text-slate-100">
                                        <?php echo e(number_format($property->views_count ?? 0, 0, ',', ' ')); ?>

                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-6 font-bold text-sm text-slate-950 dark:text-white">
                                <?php echo e(number_format($property->price, 0, ',', ' ')); ?> DH
                            </td>

                            <td class="px-6 py-6 text-xs text-slate-500 font-medium">
                                <?php echo e($property->created_at->format('d/m/Y')); ?>

                            </td>

                            <td class="px-7 py-6 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="<?php echo e(route('properties.edit', $property->id)); ?>" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all" title="Modifier">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    <form action="<?php echo e(route('properties.destroy', $property->id)); ?>" method="POST" onsubmit="return confirm('Voulez-vous supprimer cette annonce ?');">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-7 py-16 text-center">
                                <div class="text-center space-y-3">
                                    <span class="material-symbols-outlined text-5xl text-slate-300">draft_orders</span>
                                    <p class="text-slate-500 font-bold text-lg">Aucune annonce trouvée.</p>
                                    <p class="text-slate-400 text-sm">Créez votre première annonce pour la voir apparaître ici.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="p-5 border-t border-slate-100 dark:border-slate-800/50 bg-slate-50/30">
                <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Total : <?php echo e($myProperties->count()); ?> annonces</span>
            </div>
        </div>

        
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">

            
            <div class="stat-card-3d bg-white dark:bg-slate-950 p-7 rounded-2xl border border-slate-100 dark:border-slate-800/50 shadow-sm relative overflow-hidden group"
                data-tilt data-tilt-max="10" data-tilt-glare data-tilt-max-glare="0.2">
                <div class="absolute -right-6 -bottom-6 text-blue-600/5 group-hover:scale-110 transition-transform duration-700">
                    <span class="material-symbols-outlined text-[130px]">monitoring</span>
                </div>
                <div class="inner-content relative z-10 space-y-5">
                    <div class="size-14 bg-blue-600 rounded-xl flex items-center justify-center text-white mb-4 shadow-lg shadow-blue-600/30">
                        <span class="material-symbols-outlined text-2xl">trending_up</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-widest mb-1">Vues cumulées</h4>
                        <p class="text-4xl font-black text-slate-950 dark:text-white leading-none"><?php echo e(number_format($totalVues, 0, ',', ' ')); ?></p>
                    </div>
                    <p class="text-xs text-slate-400 font-medium">Impact global de vos publications</p>
                </div>
            </div>

            
            <div class="bg-white dark:bg-slate-950 p-7 rounded-2xl border border-slate-100 dark:border-slate-800/50 shadow-sm relative overflow-hidden group">
                <div class="absolute -right-6 -bottom-6 text-slate-200/40 dark:text-slate-800/20 group-hover:scale-110 transition-transform duration-700">
                    <span class="material-symbols-outlined text-[130px]">inventory_2</span>
                </div>
                <div class="inner-content relative z-10 space-y-5">
                    <div class="size-14 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-600 mb-4 shadow-lg shadow-black/5">
                        <span class="material-symbols-outlined text-2xl">bento</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-widest mb-1">Brouillons</h4>
                        <p class="text-4xl font-black text-slate-950 dark:text-white leading-none"><?php echo e($stats['brouillons']); ?></p>
                    </div>
                    <p class="text-xs text-slate-400 font-medium">Annonces prêtes à être publiées</p>
                </div>
            </div>

            
            <div class="bg-white dark:bg-slate-950 p-7 rounded-2xl border border-slate-100 dark:border-slate-800/50 shadow-sm relative overflow-hidden group">
                <div class="absolute -right-6 -bottom-6 text-green-600/5 group-hover:scale-110 transition-transform duration-700">
                    <span class="material-symbols-outlined text-[130px]">task_alt</span>
                </div>
                <div class="inner-content relative z-10 space-y-5">
                    <div class="size-14 bg-green-500 rounded-xl flex items-center justify-center text-white mb-4 shadow-lg shadow-green-500/30">
                        <span class="material-symbols-outlined text-2xl">publish</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-widest mb-1">Annonces Actives</h4>
                        <p class="text-4xl font-black text-slate-950 dark:text-white leading-none">
                            <?php echo e($myProperties->where('status', 'publiee')->where('is_approved', true)->count()); ?>

                        </p>
                    </div>
                    <p class="text-xs text-slate-400 font-medium">Annonces visibles sur le marché</p>
                </div>
            </div>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation de Tilt.js pour les cartes avec data-tilt
            if (window.VanillaTilt) {
                VanillaTilt.init(document.querySelectorAll(".stat-card-3d"), {
                    max: 10,
                    speed: 400,
                    glare: true,
                    "max-glare": 0.2,
                    startX: 0,
                    startY: 0
                });
            }
        });
    </script>
<?php /**PATH C:\Users\HP\Desktop\opendoor v-final\opendoor\resources\views/properties/user/dashboard/partials/myProperties.blade.php ENDPATH**/ ?>