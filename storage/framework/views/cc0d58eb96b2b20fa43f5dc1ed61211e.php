<nav x-data="{ 
        open: false, 
        isScrolled: false 
    }"
    x-init="window.addEventListener('scroll', () => { isScrolled = window.scrollY > 10 })"
    :class="{ 'py-2': isScrolled, 'py-4': !isScrolled }"
    class=" print:hidden sticky top-0 z-50 transition-all duration-500 ease-out perspective-1000">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div
            :class="{ 
                'bg-white/90 backdrop-blur-xl shadow-xl border-blue-100/50 rotate-x-2 scale-[0.98]': isScrolled,
                'bg-white/60 backdrop-blur-md border-transparent': !isScrolled 
            }"
            class="relative flex justify-between h-16 px-4 rounded-3xl border transition-all duration-700 ease-in-out transform-gpu shadow-sm"
            style="transform-style: preserve-3d;">

            <div class="flex items-center">
                
                <div class="shrink-0 flex items-center">
                    <a href="<?php echo e(route('home')); ?>" class="transition-transform hover:scale-105 flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'block h-8 w-auto text-blue-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'block h-8 w-auto text-blue-600']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
                        <span class="text-xl font-extrabold tracking-tight text-blue-900">
                            Open<span class="text-blue-500">Door</span>
                        </span>
                    </a>
                </div>

                
                <div class="hidden space-x-6 sm:ms-10 sm:flex">
                    <?php $navLinks = [
                    'home' => 'Accueil',
                    'properties.index' => 'Catalogue',
                    'properties.nearby' => 'Autour de moi',
                    'properties.analytics' => 'Analyse du marché',
                    ]; ?>

                    <?php $__currentLoopData = $navLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(Route::has($route) ? route($route) : '#'); ?>"
                        class="relative inline-flex items-center px-1 pt-1 pb-2 text-[11px] font-black uppercase tracking-widest transition-all group <?php echo e(request()->routeIs($route) ? 'text-blue-600' : 'text-slate-500 hover:text-blue-500'); ?>">

                        <?php echo e($label); ?>


                        
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-500 transform <?php echo e(request()->routeIs($route) ? 'scale-x-100' : 'scale-x-0'); ?> group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('login')); ?>" class="text-[11px] font-black uppercase tracking-widest text-slate-600 hover:text-blue-700 px-4">Connexion</a>
                <a href="<?php echo e(route('register')); ?>" class="bg-blue-600 text-white px-5 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all">S'inscrire</a>
                <?php endif; ?>

                <?php if(auth()->guard()->check()): ?>
                <div class="ms-3 relative">
                    <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['align' => 'right','width' => '48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'right','width' => '48']); ?>
                         <?php $__env->slot('trigger', null, []); ?> 
                            <button class="flex items-center bg-slate-50 p-1 pr-4 rounded-2xl border border-slate-100 hover:bg-white transition-all group">
                                <div class="w-8 h-8 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold text-xs">
                                    <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                                </div>
                                <span class="ms-2 text-[11px] font-black text-slate-700 uppercase tracking-tighter"><?php echo e(Auth::user()->name); ?></span>
                            </button>
                         <?php $__env->endSlot(); ?>
                         <?php $__env->slot('content', null, []); ?> 
                            <?php if(Auth::user()->is_admin == 1): ?>
                            <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('admin.dashboard'),'class' => 'text-blue-600 font-black italic']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.dashboard')),'class' => 'text-blue-600 font-black italic']); ?>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">shield_person</span>
                                    ADMINISTRATION
                                </div>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                            <div class="border-t border-slate-100 my-1"></div>
                            <?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('dashboard.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard.index'))]); ?>Tableau de bord <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('profile.edit')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('profile.edit'))]); ?>Profil <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                            <form method="POST" action="<?php echo e(route('logout')); ?>"> <?php echo csrf_field(); ?>
                                <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('logout'),'class' => 'text-red-500 font-bold','onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'class' => 'text-red-500 font-bold','onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']); ?>Déconnexion <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                            </form>
                         <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-blue-600 hover:bg-blue-50 transition-all">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    
    <div x-show="open"
        x-transition.duration.300ms
        class="sm:hidden absolute inset-x-4 top-20 bg-white/95 backdrop-blur-2xl rounded-[2rem] border border-blue-100 shadow-2xl p-4 z-50 overflow-y-auto max-h-[80vh]">

        <div class="space-y-4">
            
            <nav class="grid grid-cols-2 gap-2 text-center border-b border-slate-50 pb-3">
                <?php $__currentLoopData = $navLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(Route::has($route) ? route($route) : '#'); ?>"
                    class="text-[10px] font-black uppercase tracking-tight text-slate-700 bg-slate-50/50 py-2 rounded-lg">
                    <?php echo e($label); ?>

                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>

            
            <?php if(auth()->guard()->guest()): ?>
            <div class="grid grid-cols-2 gap-2">
                <a href="<?php echo e(route('login')); ?>" class="py-3 text-center text-[10px] font-black uppercase bg-slate-50 rounded-xl text-slate-600 italic">Connexion</a>
                <a href="<?php echo e(route('register')); ?>" class="py-3 text-center text-[10px] font-black uppercase bg-blue-600 rounded-xl text-white shadow-md">S'inscrire</a>
            </div>
            <?php else: ?>
            <div class="bg-blue-50/50 rounded-2xl p-3 border border-blue-100/50">
                
                <div class="flex items-center gap-2 mb-3 bg-white/80 p-1.5 rounded-xl shadow-sm">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold text-xs"><?php echo e(substr(Auth::user()->name, 0, 1)); ?></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-black uppercase text-slate-800 truncate leading-none"><?php echo e(Auth::user()->name); ?></p>
                        <p class="text-[8px] font-bold text-blue-500 uppercase tracking-tighter">Membre Pro</p>
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <?php if(Auth::user()->is_admin): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-2 text-blue-700 font-black text-[10px] uppercase p-2 bg-blue-100 rounded-lg">
                        <span class="material-symbols-outlined text-base">shield_person</span> Admin
                    </a>
                    <?php endif; ?>

                    <div class="grid grid-cols-2 gap-2">
                        <a href="<?php echo e(route('dashboard.index')); ?>" class="flex items-center justify-center gap-1.5 text-[9px] font-bold text-slate-600 p-2 bg-white rounded-lg border border-slate-100">
                            <span class="material-symbols-outlined text-base">dashboard</span> Board
                        </a>
                        <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center justify-center gap-1.5 text-[9px] font-bold text-slate-600 p-2 bg-white rounded-lg border border-slate-100">
                            <span class="material-symbols-outlined text-base">person</span> Profil
                        </a>
                    </div>

                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-1">
                        <?php echo csrf_field(); ?>
                        <button class="w-full py-2.5 flex justify-center items-center gap-2 text-[10px] font-black text-rose-500 uppercase bg-rose-50 rounded-lg border border-rose-100">
                            <span class="material-symbols-outlined text-base">logout</span> Déconnexion
                        </button>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<style>
    .perspective-1000 {
        perspective: 1000px;
    }

    .rotate-x-2 {
        transform: rotateX(4deg) translateY(5px);
    }

    .rotate-x-12 {
        transform: rotateX(-15deg);
    }
</style><?php /**PATH C:\Users\HP\Desktop\opendoor v-final\opendoor\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>