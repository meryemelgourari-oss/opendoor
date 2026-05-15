{{-- Conteneur qui force la forme circulaire et masque les bords (overflow-hidden) --}}
<div {{ $attributes->merge(['class' => 'h-20 w-20 rounded-full overflow-hidden inline-block']) }}>
    {{-- L'image remplit tout le conteneur --}}
    <img src="{{ asset('images/logo-opendoor.png') }}" class="w-full h-full object-cover object-center" alt="Open Door Logo">
</div>