<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'OpenDoor')); ?></title>

    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:700,700i,900|montserrat:300,400,600,800&display=swap" rel="stylesheet" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        body { overflow-x: hidden; width: 100%; }

        @keyframes slowZoom {
            from { transform: scale(1.1); }
            to { transform: scale(1.15); }
        }
        .animate-slow-zoom { animation: slowZoom 20s ease-in-out infinite alternate; }

        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans  { font-family: 'Montserrat', sans-serif; }
    </style>
</head>

<body class="font-sans antialiased text-slate-900 selection:bg-blue-100 selection:text-blue-900 flex flex-col min-h-screen">

    
    <div class="fixed inset-0 -z-10 h-full w-full bg-white bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
        <div class="absolute inset-0 bg-gradient-to-tr from-blue-50/50 via-slate-50 to-white opacity-80"></div>
    </div>

    
    <div class="flex flex-col flex-grow relative">

        
        <nav class="sticky top-0 z-50">
            <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </nav>

        
        <div class="flex-grow flex flex-col backdrop-blur-[1px]">

            <?php if(isset($header)): ?>
            <header class="relative pt-6 md:pt-10">
                <div class="max-w-7xl mx-auto py-6 px-6 sm:px-8 lg:px-12">
                    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
                        <h2 class="font-serif text-3xl md:text-5xl font-black italic tracking-tight text-slate-900 drop-shadow-sm">
                            <?php echo e($header); ?>

                        </h2>
                        <div class="h-[2px] w-16 md:w-24 bg-blue-600 rounded-full md:mt-2"></div>
                    </div>
                </div>
            </header>
            <?php endif; ?>

            
            <main class="relative flex-grow w-full">
                <?php echo e($slot); ?>

            </main>

        </div>
    </div>

</body>
</html>
<?php /**PATH C:\Users\HP\Desktop\opendoor v-final\opendoor\resources\views/layouts/app.blade.php ENDPATH**/ ?>