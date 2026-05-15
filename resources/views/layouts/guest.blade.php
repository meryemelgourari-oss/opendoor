<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'OpenDoor') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
   <body class="font-sans text-slate-900 antialiased bg-slate-50 dark:bg-slate-950">
    
    {{-- Arrière-plan --}}
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-[10%] -left-[10%] w-[70%] sm:w-[40%] h-[40%] rounded-full bg-blue-600/5 blur-[120px]"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[70%] sm:w-[40%] h-[40%] rounded-full bg-rose-500/5 blur-[120px]"></div>
    </div>

    {{-- Conteneur Principal : padding-x adaptatif pour mobile --}}
    <div class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 lg:p-8">
        
        {{-- Logo : Taille réduite sur mobile --}}
        <div class="drop-shadow-[0_10px_10px_rgba(0,0,0,0.1)] hover:scale-105 transition-transform duration-500">
            <a href="/">
                <x-application-logo class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 fill-current text-blue-600" />
            </a>
        </div>

        {{-- Le Conteneur Effet 3D --}}
        <div class="w-full 
                    {{-- Largeurs selon l'écran --}}
                    max-w-[95%]     {{-- Mobile : Presque toute la largeur --}}
                    sm:max-w-md     {{-- Tablette : Taille fixe --}}
                    md:max-w-lg     {{-- PC : Un peu plus large pour le confort --}}
                    
                    mt-6 sm:mt-8 
                    {{-- Padding interne adaptatif --}}
                    px-6 py-8 
                    sm:px-10 sm:py-12 
                    
                    bg-white dark:bg-slate-900 
                    shadow-[0_20px_50px_rgba(0,0,0,0.1),0_1px_2px_rgba(0,0,0,0.05)] 
                    border border-white/20 dark:border-slate-800
                    rounded-[2rem] {{-- Toujours arrondi, même sur mobile --}}
                    relative overflow-hidden group">
            
            {{-- Reflet Bevel --}}
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/50 to-transparent"></div>

            <div class="relative z-10">
                {{ $slot }}
            </div>
        </div>

        {{-- Footer --}}
        <p class="mt-6 sm:mt-8 text-xs sm:text-sm text-slate-400 font-medium text-center">
            &copy; {{ date('Y') }} {{ config('app.name') }}. 
            <span class="block sm:inline">Tous droits réservés.</span>
        </p>
    </div>
</body>
</html>
