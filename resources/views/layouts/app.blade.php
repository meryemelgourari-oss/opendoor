<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'OpenDoor') }}</title>

    {{-- Google Fonts & Icons --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:700,700i,900|montserrat:300,400,600,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

    {{-- Fond global Premium (Fixe) --}}
    <div class="fixed inset-0 -z-10 h-full w-full bg-white bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
        <div class="absolute inset-0 bg-gradient-to-tr from-blue-50/50 via-slate-50 to-white opacity-80"></div>
    </div>

    {{-- Wrapper Principal --}}
    <div class="flex flex-col flex-grow relative">

        {{-- Navigation (Sticky) --}}
        <nav class="sticky top-0 z-50">
            @include('layouts.navigation')
        </nav>

        {{-- Contenu principal --}}
        <div class="flex-grow flex flex-col backdrop-blur-[1px]">

            @isset($header)
            <header class="relative pt-6 md:pt-10">
                <div class="max-w-7xl mx-auto py-6 px-6 sm:px-8 lg:px-12">
                    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
                        <h2 class="font-serif text-3xl md:text-5xl font-black italic tracking-tight text-slate-900 drop-shadow-sm">
                            {{ $header }}
                        </h2>
                        <div class="h-[2px] w-16 md:w-24 bg-blue-600 rounded-full md:mt-2"></div>
                    </div>
                </div>
            </header>
            @endisset

            {{-- Zone de contenu --}}
            <main class="relative flex-grow w-full">
                {{ $slot }}
            </main>

        </div>
    </div>

</body>
</html>
