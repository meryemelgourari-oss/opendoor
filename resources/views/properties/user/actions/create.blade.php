<x-app-layout>
    <main class="flex flex-1 justify-center py-12 px-4 bg-slate-50 dark:bg-slate-950 min-h-screen"
        x-data="{ 
            {{-- Détection automatique de l'étape si des erreurs Laravel sont présentes --}}
step: {{ 
                $errors->hasAny(['price', 'surface', 'city', 'address']) ? 3 : 
                ($errors->hasAny(['images', 'images.*', 'youtube_links', 'youtube_links.*', 'articles', 'articles.*']) ? 2 : 1) 
            }},
            
            isSubmitting: false,
            submitStatus: '',
            handlePublish(status) {
    if (this.isSubmitting) return;
    
    this.isSubmitting = true;
    this.submitStatus = status;

    // Personnalisation du message de chargement si nécessaire
    // (Le changement de texte se fait plus bas dans le HTML via x-text)

    const form = this.$refs.propertyForm;
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'status';
    hiddenInput.value = status;
    form.appendChild(hiddenInput);

    form.submit();
}
        }">

        <div class="layout-content-container flex flex-col max-w-[800px] flex-1 gap-10">

            {{-- 1. ZONE D'ERREURS GLOBALE (Optionnelle si vous avez les erreurs sous les inputs) --}}
            @if ($errors->any())
            <div class="bg-rose-50 dark:bg-rose-950/30 border-l-4 border-rose-500 p-6 rounded-[2rem] shadow-sm mb-4">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-rose-600">error</span>
                    <h3 class="text-rose-800 dark:text-rose-400 font-black uppercase text-xs tracking-widest">Le formulaire contient des erreurs</h3>
                </div>
            </div>
            @endif

            {{-- BARRE DE PROGRESSION --}}
            <div class="flex flex-col gap-6 bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] shadow-sm border border-slate-200/60 dark:border-slate-800">
                <div class="flex gap-6 justify-between items-end">
                    <div class="flex flex-col">
                        <p class="text-primary text-xs font-black uppercase tracking-[0.3em] mb-2" x-text="'Étape ' + step + ' sur 3'"></p>
                        <h1 class="text-slate-900 dark:text-white text-3xl font-black italic uppercase tracking-tighter"
                            x-text="step === 1 ? 'Informations de base' : (step === 2 ? 'Médias & Contenu' : 'Localisation & Prix')">
                        </h1>
                    </div>
                    <p class="text-primary text-xl font-black italic" x-text="Math.round(step * 33.3) + '%'"></p>
                </div>
                <div class="w-full h-2.5 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden shadow-inner">
                    <div class="h-full bg-gradient-to-r from-blue-500 to-primary transition-all duration-700 ease-out"
                        :style="'width: ' + (step * 33.33) + '%'"></div>
                </div>
            </div>

            <form x-ref="propertyForm" action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-8">
                @csrf

                {{-- ÉTAPE 1 : INFOS DE BASE --}}
                <div x-show="step === 1" x-transition class="flex flex-col gap-6">
                    <div class="bg-white dark:bg-slate-900 p-10 rounded-[2.5rem] shadow-sm border border-slate-200/60 dark:border-slate-800 flex flex-col gap-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2">Transaction</label>
                                <select name="type_transaction" class="form-select h-14 rounded-2xl bg-slate-50 dark:bg-slate-800 border-none text-sm font-bold focus:ring-2 focus:ring-primary @error('type_transaction') ring-2 ring-rose-500 @enderror">
                                    <option value="vente" {{ old('type_transaction') == 'vente' ? 'selected' : '' }}>Vendre</option>
                                    <option value="location" {{ old('type_transaction') == 'location' ? 'selected' : '' }}>Louer</option>
                                </select>
                                @error('type_transaction') <p class="mt-1 ml-2 text-[10px] font-black text-rose-600 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2">Nature du bien</label>
                                <select name="type_bien" class="form-select h-14 rounded-2xl bg-slate-50 dark:bg-slate-800 border-none text-sm font-bold focus:ring-2 focus:ring-primary @error('type_bien') ring-2 ring-rose-500 @enderror">
                                    <option value="appartement" {{ old('type_bien') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                                    <option value="maison" {{ old('type_bien') == 'maison' ? 'selected' : '' }}>Maison</option>
                                    <option value="terrain" {{ old('type_bien') == 'terrain' ? 'selected' : '' }}>Terrain</option>
                                    <option value="commercial" {{ old('type_bien') == 'commercial' ? 'selected' : '' }}>Local commercial</option>
                                </select>
                                @error('type_bien') <p class="mt-1 ml-2 text-[10px] font-black text-rose-600 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2">Pièces</label>
                                <input name="rooms" type="number" value="{{ old('rooms') }}" class="form-input h-14 rounded-2xl bg-slate-50 dark:bg-slate-800 border-none text-sm font-bold @error('rooms') ring-2 ring-rose-500 @enderror" placeholder="Ex: 3">
                                @error('rooms') <p class="mt-1 ml-2 text-[10px] font-black text-rose-600 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2">Titre de l'annonce</label>
                            <input name="title" type="text" value="{{ old('title') }}" class="form-input h-14 rounded-2xl bg-slate-50 dark:bg-slate-800 border-none text-sm font-bold @error('title') ring-2 ring-rose-500 @enderror" placeholder="Ex: Maison contemporaine...">
                            @error('title') <p class="mt-1 ml-2 text-[10px] font-black text-rose-600 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2">Description</label>
                            <textarea name="description" class="form-textarea rounded-[2rem] bg-slate-50 dark:bg-slate-800 border-none min-h-[150px] p-6 text-sm font-medium @error('description') ring-2 ring-rose-500 @enderror">{{ old('description') }}</textarea>
                            @error('description') <p class="mt-1 ml-2 text-[10px] font-black text-rose-600 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">call</span> Numéro de téléphone
                            </label>
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 z-10 text-sm">phone_iphone</span>
                                <input name="phone" type="tel" value="{{ old('phone') }}"
                                    placeholder="Ex: 06 12 34 56 78"
                                    class="form-input h-14 w-full pl-12 pr-6 rounded-2xl bg-slate-50 dark:bg-slate-800 border-none text-sm font-bold focus:ring-2 focus:ring-primary @error('phone') ring-2 ring-rose-500 @enderror">
                            </div>
                            @error('phone') <p class="mt-1 ml-2 text-[10px] font-black text-rose-600 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- ÉTAPE 2 : MÉDIAS --}}
                <div x-show="step === 2" x-transition class="flex flex-col gap-6">
                    <div class="bg-white dark:bg-slate-900 p-10 rounded-[2.5rem] shadow-sm border border-slate-200/60 dark:border-slate-800 flex flex-col gap-8">

                        <div class="space-y-4">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">image</span> Photos du bien
                            </label>
                            <input type="file" name="images[]" multiple class="block w-full text-sm text-slate-500 bg-slate-50 dark:bg-slate-800 p-4 rounded-2xl file:bg-primary file:text-white file:border-0 file:rounded-xl file:px-4 file:py-2 @error('images*') ring-2 ring-rose-500 @enderror">
                            @error('images*') <p class="mt-1 ml-2 text-[10px] font-black text-rose-600 uppercase tracking-widest">Erreur dans les images sélectionnées</p> @enderror
                        </div>

                        <hr class="border-slate-100 dark:border-slate-800">

                        <div class="space-y-4" x-data="{ youtubeLinks: {{ old('youtube_links') ? json_encode(old('youtube_links')) : '[]' }} }">
                            <div class="flex justify-between items-center">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm text-red-600">play_circle</span> Liens YouTube
                                </label>
                                <button type="button" @click="youtubeLinks.push('')" class="px-4 py-2 bg-red-50 dark:bg-red-900/20 text-red-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-red-100 dark:border-red-900/30 transition-colors">
                                    + Ajouter un lien
                                </button>
                            </div>
                            <div class="grid gap-3">
                                <template x-for="(link, index) in youtubeLinks" :key="index">
                                    <div class="flex items-center gap-2">
                                        <input type="url" name="youtube_links[]" x-model="youtubeLinks[index]" placeholder="https://youtube.com/..."
                                            class="flex-1 h-12 rounded-xl bg-slate-50 dark:bg-slate-800 border-none text-sm font-bold px-4">
                                        <button type="button" @click="youtubeLinks.splice(index, 1)" class="p-3 text-red-500 bg-red-50 dark:bg-red-900/20 rounded-xl">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            {{-- SECTION ARTICLES (TITRE + CONTENU) --}}
                            <hr class="border-slate-100 dark:border-slate-800">

                            <div class="space-y-4" x-data="{ 
    articles: {{ old('articles') ? json_encode(old('articles')) : '[]' }},
    addArticle() {
        this.articles.push({ title: '', content: '' });
    }
}">
                                <div class="flex justify-between items-center">
                                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm text-indigo-600">ARTICLE</span> Blocs de détails
                                    </label>
                                    <button type="button" @click="addArticle()" class="px-4 py-2 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-indigo-100 dark:border-indigo-900/30 transition-colors hover:bg-indigo-100">
                                        + Ajouter un article
                                    </button>
                                </div>

                                <div class="grid gap-4">
                                    <template x-for="(article, index) in articles" :key="index">
                                        <div class="p-6 rounded-[2rem] bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 relative group">
                                            {{-- Bouton Supprimer --}}
                                            <button type="button" @click="articles.splice(index, 1)"
                                                class="absolute -top-2 -right-2 p-2 bg-white dark:bg-slate-900 text-rose-500 rounded-full shadow-sm border border-slate-100 dark:border-slate-800 hover:scale-110 transition-transform">
                                                <span class="material-symbols-outlined text-sm">close</span>
                                            </button>

                                            <div class="flex flex-col gap-4">
                                                {{-- Champ Titre --}}
                                                <div class="flex flex-col gap-2">
                                                    <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-2">Titre du bloc</label>
                                                    <input type="text"
                                                        :name="'articles[' + index + '][title]'"
                                                        x-model="article.title"
                                                        placeholder="Ex: Proximité & Transport"
                                                        class="h-12 rounded-xl bg-white dark:bg-slate-900 border-none text-sm font-bold px-4 focus:ring-2 focus:ring-primary">
                                                </div>

                                                {{-- Champ Contenu --}}
                                                <div class="flex flex-col gap-2">
                                                    <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-2">Contenu détaillé</label>
                                                    <textarea
                                                        :name="'articles[' + index + '][content]'"
                                                        x-model="article.content"
                                                        placeholder="Détaillez ici..."
                                                        class="min-h-[100px] p-4 rounded-xl bg-white dark:bg-slate-900 border-none text-sm font-medium focus:ring-2 focus:ring-primary"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                {{-- Affichage des erreurs de validation Laravel --}}
                                @if($errors->has('articles.*'))
                                <p class="mt-2 ml-2 text-[10px] font-black text-rose-600 uppercase tracking-widest">
                                    Vérifiez que tous les blocs ont un contenu valide.
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ÉTAPE 3 : PRIX & LOCALISATION --}}
                <div x-show="step === 3" x-transition class="flex flex-col gap-6">
                    <div class="bg-white dark:bg-slate-900 p-10 rounded-[2.5rem] shadow-sm border border-slate-200/60 dark:border-slate-800 flex flex-col gap-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2">Prix (MAD)</label>
                                <input name="price" type="number" step="0.01" value="{{ old('price') }}" class="form-input h-14 rounded-2xl bg-slate-50 dark:bg-slate-800 border-none text-sm font-bold @error('price') ring-2 ring-rose-500 @enderror">
                                @error('price') <p class="mt-1 ml-2 text-[10px] font-black text-rose-600 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2">Surface (m²)</label>
                                <input name="surface" type="number" value="{{ old('surface') }}" class="form-input h-14 rounded-2xl bg-slate-50 dark:bg-slate-800 border-none text-sm font-bold @error('surface') ring-2 ring-rose-500 @enderror">
                                @error('surface') <p class="mt-1 ml-2 text-[10px] font-black text-rose-600 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2">Ville</label>
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 z-10">location_on</span>
                                <select name="city" class="form-select h-14 w-full pl-12 pr-10 rounded-2xl bg-slate-50 dark:bg-slate-800 border-none text-sm font-bold appearance-none @error('city') ring-2 ring-rose-500 @enderror">
                                    <option value="" {{ old('city') == '' ? 'selected' : '' }}>Choisir une ville</option>
                                    <optgroup label="Grandes Villes">
                                        <option value="Casablanca" {{ old('city') == 'Casablanca' ? 'selected' : '' }}>Casablanca</option>
                                        <option value="Rabat" {{ old('city') == 'Rabat' ? 'selected' : '' }}>Rabat</option>
                                        <option value="Marrakech" {{ old('city') == 'Marrakech' ? 'selected' : '' }}>Marrakech</option>
                                    </optgroup>
                                </select>
                            </div>
                            @error('city') <p class="mt-1 ml-2 text-[10px] font-black text-rose-600 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-2">Adresse exacte</label>
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 z-10">map</span>
                                <input name="address" type="text" value="{{ old('address') }}" placeholder="Ex: 45 Rue de la Liberté..."
                                    class="form-input h-14 w-full pl-12 pr-6 rounded-2xl bg-slate-50 dark:bg-slate-800 border-none text-sm font-bold @error('address') ring-2 ring-rose-500 @enderror">
                            </div>
                            @error('address') <p class="mt-1 ml-2 text-[10px] font-black text-rose-600 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- NAVIGATION --}}
                <div class="flex items-center justify-between mt-4">
                    <button type="button" x-show="step > 1" @click="step--" :disabled="isSubmitting"
                        class="h-14 px-8 rounded-2xl border-2 border-slate-200 dark:border-slate-700 font-black uppercase text-[10px] text-slate-500 transition-opacity">
                        Précédent
                    </button>

                    <div x-show="step === 1"></div>

                    <button type="button" x-show="step < 3" @click="step++" class="h-14 px-10 rounded-2xl bg-slate-900 dark:bg-white dark:text-slate-900 text-white font-black uppercase text-[10px] hover:scale-105 transition-transform">
                        Continuer
                    </button>

                    <div x-show="step === 3" class="flex flex-wrap gap-3">
                        {{-- Bouton Publier --}}
                        <button type="button" @click="handlePublish('publiee')"
                            :disabled="isSubmitting"
                            class="h-12 px-6 rounded-xl bg-emerald-600 text-white text-[10px] font-black uppercase shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition-all flex items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">

                            <template x-if="isSubmitting && submitStatus === 'publiee'">
                                <span class="w-3 h-3 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                            </template>

                            {{-- Texte dynamique --}}
                            <span x-text="isSubmitting && submitStatus === 'publiee' ? 'Soumission à l\'admin...' : 'Publier'"></span>
                        </button>





                        {{-- Bouton Brouillon --}}

                        <button type="button" @click="handlePublish('brouillon')"

                            :disabled="isSubmitting"

                            class="h-12 px-6 rounded-xl bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-white text-[10px] font-black uppercase hover:bg-slate-300 transition-all flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">



                            <template x-if="isSubmitting && submitStatus === 'brouillon'">

                                <span class="w-3 h-3 border-2 border-slate-400 border-t-slate-900 rounded-full animate-spin"></span>

                            </template>



                            <span x-text="isSubmitting && submitStatus === 'brouillon' ? 'Envoi...' : 'Brouillon'"></span>

                        </button>



                        {{-- Bouton Archiver --}}

                        <button type="button" @click="handlePublish('archivee')"

                            :disabled="isSubmitting"

                            class="h-12 px-6 rounded-xl bg-rose-500 text-white text-[10px] font-black uppercase shadow-lg shadow-rose-500/20 hover:bg-rose-600 transition-all flex items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">



                            <template x-if="isSubmitting && submitStatus === 'archivee'">

                                <span class="w-3 h-3 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>

                            </template>



                            <span x-text="isSubmitting && submitStatus === 'archivee' ? 'Envoi...' : 'Archiver'"></span>

                        </button>
                       
                    </div>

                </div>

            </form>

        </div>

    </main>

</x-app-layout>