<x-app-layout>
    <div x-data="locationScanner()" class="bg-white/70 min-h-screen py-10 px-4 relative overflow-hidden text-slate-900">

        {{-- Background FX --}}
        <div class="absolute top-0 left-1/4 w-72 h-72 bg-blue-100/40 blur-[80px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-72 h-72 bg-indigo-50/40 blur-[80px] rounded-full pointer-events-none"></div>

        <div class="max-w-6xl mx-auto relative z-10">

            {{-- HEADER --}}
            <div class="mb-10 text-center">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <span class="h-px w-8 bg-blue-600/30"></span>
                    <span class="text-blue-600 font-black uppercase tracking-[0.3em] text-[10px]">Exploration</span>
                    <span class="h-px w-8 bg-blue-600/30"></span>
                </div>

                <h2 class="text-slate-900 font-serif text-3xl md:text-4xl italic font-black mb-6 leading-tight">
                    Pépites <span class="text-blue-600">à proximité.</span>
                </h2>

                {{-- Status badge --}}
                <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-white border border-slate-200/60 shadow-sm mb-6 transition-all"
                    :class="isScanning ? 'bg-blue-50/50' : ''">
                    <span class="relative flex h-2 w-2">
                        <span :class="isScanning ? 'animate-ping bg-blue-400' : (userLat ? 'bg-emerald-500' : 'bg-slate-300')"
                            class="absolute h-full w-full rounded-full opacity-75"></span>
                        <span :class="isScanning ? 'bg-blue-600' : (userLat ? 'bg-emerald-500' : 'bg-slate-300')"
                            class="relative rounded-full h-2 w-2"></span>
                    </span>
                    <span class="text-slate-500 font-bold uppercase tracking-widest text-[9px]" x-text="statusText"></span>
                </div>

                <br>

                {{-- Controls row --}}
                <div class="flex flex-wrap items-center justify-center gap-3 mb-2">
                    {{-- Detect button --}}
                    <button @click="findMe()" :disabled="isScanning"
                        class="group relative inline-flex items-center gap-3 px-8 py-4 bg-slate-900 hover:bg-blue-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-xl hover:shadow-blue-500/30 active:scale-95 disabled:opacity-50 overflow-hidden">
                        <div class="absolute inset-0 w-1/2 h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                        <span class="material-symbols-outlined text-base" x-text="isScanning ? 'sync' : 'near_me'" :class="isScanning && 'animate-spin'"></span>
                        <span x-text="isScanning ? 'Détection...' : 'Détecter ma position'"></span>
                    </button>

                    {{-- Filters (Shown after detection) --}}
                    <template x-if="userLat">
                        <div class="flex flex-wrap items-center justify-center gap-3">
                            {{-- Radius selector --}}
                            <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-2xl px-4 py-3 shadow-sm">
                                <span class="material-symbols-outlined text-blue-600 text-sm">radar</span>
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Rayon</span>
                                <select x-model="radius" @change="filterByDistance()"
                                    class="text-[11px] font-black text-slate-900 bg-transparent border-none focus:ring-0 cursor-pointer">
                                    <option value="5">5 km</option>
                                    <option value="10">10 km</option>
                                    <option value="20">20 km</option>
                                    <option value="50">50 km</option>
                                </select>
                            </div>

                            {{-- Type filter --}}
                            <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-2xl px-4 py-3 shadow-sm">
                                <span class="material-symbols-outlined text-blue-600 text-sm">home_work</span>
                                <select x-model="filterType" @change="filterByDistance()"
                                    class="text-[11px] font-black text-slate-900 bg-transparent border-none focus:ring-0 cursor-pointer">
                                    <option value="">Tous les types</option>
                                    <option value="appartement">Appartement</option>
                                    <option value="maison">Maison</option>
                                    <option value="terrain">Terrain</option>
                                    <option value="commercial">Commercial</option>
                                </select>
                            </div>

                            {{-- Transaction filter --}}
                            <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-2xl px-4 py-3 shadow-sm">
                                <span class="material-symbols-outlined text-blue-600 text-sm">sell</span>
                                <select x-model="filterTransaction" @change="filterByDistance()"
                                    class="text-[11px] font-black text-slate-900 bg-transparent border-none focus:ring-0 cursor-pointer">
                                    <option value="">Vente & Location</option>
                                    <option value="vente">Vente</option>
                                    <option value="location">Location</option>
                                </select>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Results count --}}
                <div x-show="userLat" x-transition class="mt-4">
                    <span class="text-[11px] text-slate-400">
                        <span class="font-black text-blue-600" x-text="nearbyProperties.length"></span>
                        bien<span x-show="nearbyProperties.length > 1">s</span> trouvé<span x-show="nearbyProperties.length > 1">s</span>
                        dans un rayon de <span class="font-black text-slate-600" x-text="radius + ' km'"></span>
                    </span>
                </div>
            </div>

            {{-- MAP --}}
            <div class="relative bg-white p-2 rounded-[2.5rem] shadow-lg border border-slate-50 mb-10">
                <div id="map" class="h-[420px] w-full rounded-[2.2rem] z-0 shadow-inner" wire:ignore></div>
                <div x-show="!userLat" x-transition
                    class="absolute inset-2 rounded-[2.2rem] bg-slate-900/60 backdrop-blur-sm flex flex-col items-center justify-center gap-4 z-10 pointer-events-none">
                    <span class="material-symbols-outlined text-white text-5xl">location_searching</span>
                    <p class="text-white font-black text-sm">Cliquez sur « Détecter ma position »</p>
                </div>
            </div>

            {{-- GRID --}}
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-serif text-2xl italic font-black text-slate-900">
                        <span x-show="!userLat">Toutes les annonces</span>
                        <span x-show="userLat">Annonces à proximité</span>
                    </h3>
                </div>

                {{-- Grid : All (Blade) or Nearby (Alpine) --}}
                <div x-show="!userLat" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($properties as $prop)
                        <div class="group bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-500">
                            <div class="h-48 relative overflow-hidden bg-slate-100">
                                <img src="{{ $prop['image'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" onerror="this.src='{{ asset('images/default.jpg') }}'">
                                <div class="absolute top-3 right-3 font-black text-blue-600 text-[11px] bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-lg shadow-sm">
                                    {{ number_format($prop['price'], 0, ',', ' ') }} DH
                                </div>
                            </div>
                            <div class="p-5">
                                <h3 class="text-slate-900 font-bold text-sm truncate">{{ $prop['title'] }}</h3>
                                <p class="text-[10px] text-slate-400 mt-1 italic">{{ $prop['address'] }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-center py-10 text-slate-400 italic">Aucun bien disponible.</p>
                    @endforelse
                </div>

                <div x-show="userLat" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="p in nearbyProperties" :key="p.id">
                        <div class="group bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-500">
                            <div class="h-48 relative overflow-hidden bg-slate-100">
                                <img :src="p.image" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute top-3 right-3 font-black text-blue-600 text-[11px] bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-lg shadow-sm" x-text="new Intl.NumberFormat('fr-FR').format(p.price) + ' DH'"></div>
                                <div class="absolute top-3 left-3 font-black text-emerald-600 text-[10px] bg-white/90 backdrop-blur-md px-2 py-1 rounded-lg shadow-sm flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">near_me</span>
                                    <span x-text="p.distance + ' km'"></span>
                                </div>
                            </div>
                            <div class="p-5">
                                <h3 class="text-slate-900 font-bold text-sm truncate" x-text="p.title"></h3>
                                <p class="text-[10px] text-slate-400 mt-1 italic" x-text="p.address"></p>
                            </div>
                        </div>
                    </template>
                    
                    <div x-show="nearbyProperties.length === 0" class="col-span-full py-16 text-center bg-white rounded-[2rem] border border-dashed border-slate-200">
                        <span class="material-symbols-outlined text-4xl text-slate-300 mb-3 block">location_off</span>
                        <p class="text-slate-500 font-bold text-sm">Aucun bien trouvé dans ce rayon.</p>
                        <button @click="radius = 50; filterByDistance()" class="mt-4 text-blue-600 font-black text-[10px] uppercase tracking-widest border border-blue-100 px-4 py-2 rounded-xl">Élargir à 50 km</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        function locationScanner() {
            return {
                isScanning: false,
                statusText: 'Prêt à détecter',
                map: null,
                userLat: null,
                userLng: null,
                userMarker: null,
                userCircle: null,
                radius: 10,
                filterType: '',
                filterTransaction: '',
                nearbyProperties: [],
                allProperties: @json($properties),
                propertyMarkers: [],

                init() {
                    this.map = L.map('map', { zoomControl: true, attributionControl: false }).setView([31.7917, -7.0926], 6);
                    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png').addTo(this.map);
                    this.addAllMarkers();
                },

                addAllMarkers() {
                    this.allProperties.forEach(p => {
                        if (p.latitude && p.longitude) {
                            const icon = L.divIcon({
                                className: 'custom-div-icon',
                                html: `<div class="marker-pin" style="width:12px;height:12px;background:#94a3b8;border:2px solid white;border-radius:50%"></div>`,
                                iconSize: [12, 12],
                                iconAnchor: [6, 6]
                            });

                            const marker = L.marker([p.latitude, p.longitude], { 
                                icon: icon,
                                propertyId: p.id 
                            }).addTo(this.map);

                            this.propertyMarkers.push(marker);
                        }
                    });
                },

                findMe() {
                    if (!navigator.geolocation) return;
                    this.isScanning = true;
                    this.statusText = 'Localisation...';

                    navigator.geolocation.getCurrentPosition((pos) => {
                        this.userLat = pos.coords.latitude;
                        this.userLng = pos.coords.longitude;
                        this.map.flyTo([this.userLat, this.userLng], 12);

                        if (this.userMarker) this.map.removeLayer(this.userMarker);
                        if (this.userCircle) this.map.removeLayer(this.userCircle);

                        this.userMarker = L.circleMarker([this.userLat, this.userLng], {
                            radius: 8, color: '#white', weight: 3, fillColor: '#3b82f6', fillOpacity: 1
                        }).addTo(this.map);

                        this.userCircle = L.circle([this.userLat, this.userLng], {
                            radius: this.radius * 1000, color: '#3b82f6', weight: 1, fillColor: '#3b82f6', fillOpacity: 0.05, dashArray: '5, 5'
                        }).addTo(this.map);

                        this.isScanning = false;
                        this.statusText = 'Position OK';
                        this.filterByDistance();
                    }, () => {
                        this.isScanning = false;
                        this.statusText = 'Erreur GPS';
                    });
                },

                filterByDistance() {
                    if (!this.userLat) return;
                    if (this.userCircle) this.userCircle.setRadius(this.radius * 1000);

                    const toRad = (d) => d * Math.PI / 180;
                    
                    this.nearbyProperties = this.allProperties.filter(p => {
                        if (!p.latitude || !p.longitude) return false;
                        if (this.filterType && p.type_bien !== this.filterType) return false;
                        if (this.filterTransaction && p.type_transaction !== this.filterTransaction) return false;

                        const R = 6371;
                        const dLat = toRad(p.latitude - this.userLat);
                        const dLng = toRad(p.longitude - this.userLng);
                        const a = Math.sin(dLat/2)**2 + Math.cos(toRad(this.userLat)) * Math.cos(toRad(p.latitude)) * Math.sin(dLng/2)**2;
                        const d = R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                        
                        p.distance = d.toFixed(1);
                        return d <= parseFloat(this.radius);
                    }).sort((a, b) => a.distance - b.distance);

                    this.highlightMarkers();
                },

                highlightMarkers() {
                    const nearbyIds = new Set(this.nearbyProperties.map(p => p.id));
                    this.propertyMarkers.forEach(m => {
                        const isNearby = nearbyIds.has(m.options.propertyId);
                        m.getElement().style.opacity = isNearby ? '1' : '0.15';
                        m.setZIndexOffset(isNearby ? 1000 : 0);
                    });
                }
            }
        }
    </script>

    <style>
        .marker-pin { transition: all 0.3s ease; }
        @keyframes shimmer { 100% { transform: translateX(250%) skewX(-12deg); } }
    </style>
</x-app-layout>