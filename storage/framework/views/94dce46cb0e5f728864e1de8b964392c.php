<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'OpenDoor')); ?></title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
   <body class="font-sans text-slate-900 antialiased bg-slate-50 dark:bg-slate-950">
    
    
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-[10%] -left-[10%] w-[70%] sm:w-[40%] h-[40%] rounded-full bg-blue-600/5 blur-[120px]"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[70%] sm:w-[40%] h-[40%] rounded-full bg-rose-500/5 blur-[120px]"></div>
    </div>

    
    <div class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 lg:p-8">
        
        
        <div class="drop-shadow-[0_10px_10px_rgba(0,0,0,0.1)] hover:scale-105 transition-transform duration-500">
            <a href="/">
                <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 fill-current text-blue-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 fill-current text-blue-600']); ?>
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
            </a>
        </div>

        
        <div class="w-full 
                    
                    max-w-[95%]     
                    sm:max-w-md     
                    md:max-w-lg     
                    
                    mt-6 sm:mt-8 
                    
                    px-6 py-8 
                    sm:px-10 sm:py-12 
                    
                    bg-white dark:bg-slate-900 
                    shadow-[0_20px_50px_rgba(0,0,0,0.1),0_1px_2px_rgba(0,0,0,0.05)] 
                    border border-white/20 dark:border-slate-800
                    rounded-[2rem] 
                    relative overflow-hidden group">
            
            
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/50 to-transparent"></div>

            <div class="relative z-10">
                <?php echo e($slot); ?>

            </div>
        </div>

        
        <p class="mt-6 sm:mt-8 text-xs sm:text-sm text-slate-400 font-medium text-center">
            &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. 
            <span class="block sm:inline">Tous droits réservés.</span>
        </p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\HP\Desktop\opendoor v-final\opendoor\resources\views/layouts/guest.blade.php ENDPATH**/ ?>