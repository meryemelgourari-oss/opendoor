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
    <main class="w-full min-h-screen pb-20 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-slate-50 via-white to-blue-50/30">
        
        
        <div class="px-6 pt-12 md:px-16">
            <div class="relative mb-12">
                <div class="flex items-center gap-4 mb-4">
                    <span class="h-[3px] w-12 md:w-20 bg-blue-600 rounded-full"></span>
                    <span class="text-blue-600 font-black uppercase tracking-[0.3em] md:tracking-[0.5em] text-[10px] md:text-[14px]">
                        Mon Compte
                    </span>
                </div>
                <h1 class="text-slate-900 font-serif text-3xl md:text-5xl italic font-black leading-tight">
                    Gestion du <span class="text-blue-600">Profil.</span>
                </h1>
            </div>

            
            <div class="max-w-7xl mx-auto space-y-8 md:space-y-12">
                
                
                <section class="group relative bg-white rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-12 shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden transition-all duration-500 hover:shadow-2xl">
                    <div class="absolute top-0 right-0 p-8 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity">
                        <span class="material-symbols-outlined text-[120px] text-slate-900">badge</span>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="size-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                <span class="material-symbols-outlined text-xl">contact_page</span>
                            </div>
                            <h3 class="text-lg font-black uppercase tracking-widest text-slate-900 italic font-serif">Informations</h3>
                        </div>
                        
                        <div class="max-w-2xl">
                            <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>
                </section>

                
                <section class="group relative bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-12 shadow-2xl border border-white/5 overflow-hidden transition-all duration-500">
                    <div class="absolute top-0 right-0 p-8 opacity-10">
                        <span class="material-symbols-outlined text-[120px] text-blue-500">security</span>
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="size-10 rounded-xl bg-white/10 flex items-center justify-center text-blue-400">
                                <span class="material-symbols-outlined text-xl">lock_reset</span>
                            </div>
                            <h3 class="text-lg font-black uppercase tracking-widest text-white italic font-serif">Sécurité</h3>
                        </div>

                        <div class="max-w-2xl text-slate-300 profile-dark-form">
                            <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>
                </section>

                
                <section class="group relative bg-white rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-12 shadow-xl border border-red-50 overflow-hidden">
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="size-10 rounded-xl bg-red-50 flex items-center justify-center text-red-500">
                                <span class="material-symbols-outlined text-xl">heart_broken</span>
                            </div>
                            <h3 class="text-lg font-black uppercase tracking-widest text-red-600 italic font-serif">Zone Sensible</h3>
                        </div>

                        <div class="max-w-2xl">
                            <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <style>
        /* Optimisation des formulaires inclus pour matcher le design OpenDoor */
        
        /* Cible les inputs à l'intérieur des partials de Breeze */
        .max-w-xl input[type="text"], 
        .max-w-xl input[type="email"], 
        .max-w-xl input[type="password"] {
            @apply w-full border-none bg-slate-50 rounded-2xl py-3.5 px-5 font-bold text-slate-900 focus:ring-2 focus:ring-blue-500/20 transition-all mb-1;
        }

        /* Style spécifique pour la section sombre (Sécurité) */
        .profile-dark-form input {
            @apply bg-white/5 text-white placeholder:text-slate-500 !important;
        }
        .profile-dark-form label {
            @apply text-slate-400 !important;
        }
        .profile-dark-form p {
            @apply text-slate-500 !important;
        }

        /* Boutons de sauvegarde */
        .max-w-xl button[type="submit"] {
            @apply mt-4 px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl uppercase tracking-widest text-[10px] transition-all active:scale-95 shadow-lg shadow-blue-500/20;
        }

        /* Section Delete button */
        .max-w-xl button.bg-red-600 {
            @apply bg-red-500 hover:bg-red-600 rounded-xl px-8 py-3.5 font-black uppercase tracking-widest text-[10px];
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        section { animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both; }
        section:nth-child(2) { animation-delay: 0.1s; }
        section:nth-child(3) { animation-delay: 0.2s; }
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
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\opendoor v-final\opendoor\resources\views/profile/edit.blade.php ENDPATH**/ ?>