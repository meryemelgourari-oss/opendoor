<x-app-layout>
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
        <strong>Oups ! Quelques erreurs à corriger :</strong>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <main class="max-w-7xl mx-auto px-6 py-10 lg:py-16" x-data="propertyEditor()">
        <form action="{{ route('admin.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- HEADER SECTION --}}
            <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-black text-slate-900">
                        Modifier : <span class="text-primary">{{ $property->title }}</span>
                    </h1>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard.my-properties') }}" class="px-6 py-3 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50">Annuler</a>
                    <button type="submit" class="px-8 py-3 bg-primary text-black font-bold rounded-xl shadow-lg">Sauvegarder</button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <div class="lg:col-span-8 space-y-12">

                    {{-- SECTION 01: MÉDIAS --}}
                    <section class="space-y-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold flex items-center gap-2">
                                <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center text-sm">01</span>
                                Médias & Galerie
                            </h2>
                            <div class="flex gap-4">
                                <label class="cursor-pointer text-sm font-bold text-primary flex items-center gap-1 hover:underline">
                                    <span class="material-symbols-outlined text-sm">add_circle</span>
                                    Ajouter Photos/Vidéos
                                    <input type="file" name="resources[]" multiple class="hidden" @change="previewMedia" accept="image/*,video/*">
                                </label>
                                <button type="button" @click="youtubeLinks.push('')" class="text-sm font-bold text-red-600 flex items-center gap-1 hover:underline">
                                    <span class="material-symbols-outlined text-sm">play_circle</span>
                                    Lien YouTube
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {{-- 1. MÉDIAS EXISTANTS --}}
                            @foreach($property->ressources as $res)
                            @php $media = $res->resourceable; @endphp
                            @if($media)
                            <div class="relative group rounded-2xl overflow-hidden bg-slate-100 aspect-video shadow-sm ring-1 ring-slate-200"
                                x-data="{ deleted: false }" x-show="!deleted">

                                @if($res->resourceable_type === \App\Models\Image::class)
                                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $media->path) }}">
                                @elseif($res->resourceable_type === \App\Models\Video::class)
                                @if($media->url)
                                <iframe src="{{ str_replace('watch?v=', 'embed/', $media->url) }}" class="w-full h-full" frameborder="0"></iframe>
                                @else
                                <video muted class="w-full h-full object-cover">
                                    <source src="{{ asset('storage/' . $media->path) }}">
                                </video>
                                @endif
                                @endif

                                <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button" @click="if(confirm('Supprimer ?')) { deleteStoredMedia({{ $res->id }}, $data) }" class="size-10 bg-red-500 text-white rounded-xl">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </div>
                            </div>
                            @endif
                            @endforeach

                            {{-- 2. NOUVEAUX MÉDIAS (Prévisualisation) --}}
                            <template x-for="(item, index) in newPreviews" :key="index">
                                <div class="relative group rounded-2xl overflow-hidden bg-slate-100 aspect-video shadow-md ring-2 ring-primary/50">

                                    <template x-if="item.type === 'image'">
                                        <img :src="item.url" class="w-full h-full object-cover">
                                    </template>

                                    <template x-if="item.type === 'video'">
                                        <video :src="item.url" class="w-full h-full object-cover" muted autoplay loop></video>
                                    </template>

                                    <div class="absolute top-2 left-2 px-2 py-1 bg-primary rounded text-[10px] text-white font-bold uppercase italic">Nouveau</div>
                                    <button type="button" @click="newPreviews.splice(index, 1)" class="absolute top-2 right-2 size-8 bg-white/90 text-red-600 rounded-lg flex items-center justify-center">
                                        <span class="material-symbols-outlined">close</span>
                                    </button>
                                </div>
                            </template>
                        </div>

                        {{-- Liens YouTube --}}
                        <div class="space-y-3">
                            <template x-for="(link, index) in youtubeLinks" :key="index">
                                <div class="flex items-center gap-3 p-3 bg-red-50 rounded-2xl border border-red-100">
                                    <span class="material-symbols-outlined text-red-600">link</span>
                                    <input type="url" name="new_video_links[]" x-model="youtubeLinks[index]" placeholder="URL YouTube..." class="flex-1 bg-transparent border-none text-sm focus:ring-0">
                                    <button type="button" @click="youtubeLinks.splice(index, 1)" class="text-red-400"><span class="material-symbols-outlined">close</span></button>
                                </div>
                            </template>
                        </div>
                    </section>
                    {{-- SECTION 02: INFOS --}}
                    <section class="space-y-6">
                        <h2 class="text-xl font-bold flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center text-sm">02</span>
                            Informations
                        </h2>
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label class="text-[10px] font-bold uppercase text-slate-400">Titre de l'annonce</label>
                                <input name="title" value="{{ old('title', $property->title) }}" class="w-full bg-slate-50 border-none rounded-xl h-14 px-6 focus:ring-2 focus:ring-primary" type="text" placeholder="Ex: Villa moderne avec piscine">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold uppercase text-slate-400">Prix (€)</label>
                                <input name="price" value="{{ old('price', $property->price) }}" class="w-full bg-slate-50 border-none rounded-xl h-14 px-6 focus:ring-2 focus:ring-primary" type="number">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold uppercase text-slate-400">Surface (m²)</label>
                                <input name="surface" value="{{ old('surface', $property->surface) }}" class="w-full bg-slate-50 border-none rounded-xl h-14 px-6 focus:ring-2 focus:ring-primary" type="number">
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="text-[10px] font-bold uppercase text-slate-400">Nombre de pièces</label>
                                <div class="relative group">
                                    <input name="rooms" value="{{ old('rooms', $property->rooms) }}"
                                        class="w-full bg-slate-50 border-none rounded-xl h-14 pl-12 pr-6 focus:ring-2 focus:ring-primary transition-all @error('rooms') ring-2 ring-red-500 @enderror"
                                        type="number" min="1" placeholder="Ex: 4">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">meeting_room</span>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label class="text-[10px] font-bold uppercase text-slate-400">Ville (Maroc)</label>
                                <select name="city" class="w-full bg-slate-50 border-none rounded-xl h-14 px-6 focus:ring-2 focus:ring-primary appearance-none">
                                    <option value="">Sélectionnez une ville</option>
                                    @php
                                    $villes = [
                                    'Agadir', 'Al Hoceima', 'Béni Mellal', 'Casablanca', 'Chefchaouen', 'Dakhla', 'El Jadida', 'Errachidia', 'Essaouira', 'Fès', 'Guelmim', 'Ifrane', 'Kénitra', 'Khouribga', 'Laâyoune', 'Marrakech', 'Meknès', 'Mohammédia', 'Nador', 'Ouarzazate', 'Oujda', 'Rabat', 'Safi', 'Salé', 'Settat', 'Tanger', 'Taza', 'Tétouan', 'Témara'
                                    ];
                                    @endphp
                                    @foreach($villes as $ville)
                                    <option value="{{ $ville }}" {{ old('city', $property->city) == $ville ? 'selected' : '' }}>
                                        {{ $ville }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Adresse Complète (NOUVEAU) --}}
                            <div class="col-span-2 md:col-span-1">
                                <label class="text-[10px] font-bold uppercase text-slate-400">Adresse complète</label>
                                <div class="relative group">
                                    <input name="address" value="{{ old('address', $property->address) }}"
                                        class="w-full bg-slate-50 border-none rounded-xl h-14 pl-12 pr-6 focus:ring-2 focus:ring-primary transition-all"
                                        type="text" placeholder="Ex: 45 Rue de la Liberté, Apt 12...">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">map</span>
                                </div>
                            </div>

                            <div class="col-span-2">
                                <label class="text-[10px] font-bold uppercase text-slate-400">Description</label>
                                <textarea name="description" rows="4" class="w-full bg-slate-50 border-none rounded-xl px-6 py-4 focus:ring-2 focus:ring-primary">{{ old('description', $property->description) }}</textarea>
                            </div>
                        </div>
                    </section>
                    {{-- SECTION 03: ARTICLE --}}
                    <section x-data="{ hasArticle: {{ $property->ressources->where('resourceable_type', \App\Models\Article::class)->count() > 0 ? 'true' : 'false' }} }">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-bold">03 Article SEO</h2>
                            <button type="button" @click="hasArticle = !hasArticle" class="text-xs font-bold uppercase p-2 rounded" :class="hasArticle ? 'bg-red-100 text-red-600' : 'bg-primary text-black'">
                                <span x-text="hasArticle ? 'Supprimer l\'article' : 'Ajouter un article'"></span>
                            </button>
                        </div>
                        <input type="hidden" name="has_article" :value="hasArticle ? '1' : '0'">
                        <div x-show="hasArticle" class="bg-white p-8 rounded-2xl border border-slate-100 space-y-4">
                            @php $art = $property->ressources->where('resourceable_type', \App\Models\Article::class)->first()?->resourceable; @endphp
                            <input name="article_title" value="{{ old('article_title', $art?->title) }}" placeholder="Titre de l'article" class="w-full bg-slate-50 border-none rounded-xl h-12 px-4">
                            <textarea name="article_content" rows="6" placeholder="Contenu..." class="w-full bg-slate-50 border-none rounded-xl px-4 py-3">{{ old('article_content', $art?->content) }}</textarea>
                        </div>
                    </section>
                </div>

                <aside class="lg:col-span-4">
                    <div class="sticky top-24 bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                        <button type="submit" class="w-full py-4 bg-primary text-primary font-bold rounded-xl shadow-lg">Mettre à jour l'annonce</button>
                    </div>
                </aside>
            </div>
        </form>
    </main>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('propertyEditor', () => ({
                youtubeLinks: [],
                newPreviews: [],

                previewMedia(event) {
                    const files = Array.from(event.target.files);
                    files.forEach(file => {
                        const reader = new FileReader();
                        const isVideo = file.type.startsWith('video/');
                        const isImage = file.type.startsWith('image/');

                        if (isImage || isVideo) {
                            reader.onload = (e) => {
                                this.newPreviews.push({
                                    url: e.target.result,
                                    type: isVideo ? 'video' : 'image'
                                });
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                },

                async deleteStoredMedia(resId, alpineComponent) {
                    try {
                        const response = await fetch(`/ressources/${resId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });
                        if (response.ok) alpineComponent.deleted = true;
                    } catch (e) {
                        console.error(e);
                    }
                }
            }));
        });
    </script>
</x-app-layout>