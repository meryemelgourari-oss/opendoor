<div x-data="{ 
        showCreateModal: false, 
        selectedProperty: null 
    }" class="min-h-screen bg-[#f8fafc] dark:bg-[#0f172a] p-4">

    <div class="max-w-7xl mx-auto">

        <?php if(session('success')): ?>
        <div class="mb-6 p-4 bg-emerald-500 text-white rounded-2xl shadow-lg flex items-center justify-between animate-fade-in">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                <span class="font-bold"><?php echo e(session('success')); ?></span>
            </div>
            <button @click="$el.parentElement.remove()" class="material-symbols-outlined opacity-70 hover:opacity-100">close</button>
        </div>
        <?php endif; ?>

        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 mb-8 shadow-sm border border-slate-200/60 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <h1 class="text-slate-900 dark:text-white text-3xl font-black tracking-tight uppercase italic flex items-center gap-3">
                    <span class="p-2 bg-blue-600 text-white rounded-xl material-symbols-outlined">real_estate_agent</span>
                    Gestion des Annonces
                </h1>
                <p class="text-slate-400 font-medium mt-1">Modérez les publications et gérez le catalogue immobilier.</p>
            </div>

            <div class="flex items-center gap-4">
                <button onclick="exportPropertiesToExcel('properties-table', 'liste-annonces')"
                    class="flex items-center gap-2 rounded-2xl h-14 px-6 bg-emerald-600 text-white font-black uppercase text-[11px] tracking-widest shadow-xl hover:scale-105 active:scale-95 transition-all">
                    <span class="material-symbols-outlined">download</span>
                    Exporter Excel
                </button>

                <a href="<?php echo e(route('admin.properties.create')); ?>" class="flex items-center gap-2 rounded-2xl h-14 px-8 bg-slate-900 dark:bg-blue-600 text-white font-black uppercase text-[11px] tracking-widest shadow-xl hover:scale-105 active:scale-95 transition-all">
                    <span class="material-symbols-outlined">add_circle</span>
                    Ajouter un bien
                </a>
            </div>
        </div>


        <div class="flex flex-wrap items-center gap-3 mb-8">
            <a href="<?php echo e(route('admin.properties.index')); ?>"
                class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all <?php echo e(!request('status') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'bg-white dark:bg-slate-900 text-slate-400 border border-slate-200 dark:border-slate-800'); ?>">
                Toutes (<?php echo e($stats['properties_count']); ?>)
            </a>

            <a href="<?php echo e(route('admin.properties.index', ['status' => 'brouillon'])); ?>"
                class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all <?php echo e(request('status') == 'brouillon' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'bg-white dark:bg-slate-900 text-slate-400 border border-slate-200 dark:border-slate-800'); ?>">
                Brouillons (<?php echo e($stats['draft_count']); ?>)
            </a>

            <a href="<?php echo e(route('admin.properties.index', ['status' => 'archivee'])); ?>"
                class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all <?php echo e(request('status') == 'archivee' ? 'bg-slate-600 text-white shadow-lg shadow-slate-600/20' : 'bg-white dark:bg-slate-900 text-slate-400 border border-slate-200 dark:border-slate-800'); ?>">
                Archivées (<?php echo e($stats['archived_count']); ?>)
            </a>

            <a href="<?php echo e(route('admin.properties.index', ['status' => 'publiée'])); ?>"
                class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all <?php echo e(request('status') == 'publiée' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'bg-white dark:bg-slate-900 text-slate-400 border border-slate-200 dark:border-slate-800'); ?>">
                Publiées (<?php echo e($stats['active_users_count']); ?>)
            </a>
        </div>


        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table id="properties-table" class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Bien & Propriétaire</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Statut</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        <?php $__empty_1 = true; $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="group hover:bg-slate-50/50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="relative size-16 shrink-0 rounded-[1.25rem] overflow-hidden bg-slate-100">
                                        <?php
                                        $resource = $property->ressources->first();
                                        $media = $resource ? $resource->resourceable : null;
                                        ?>
                                        <?php if($media): ?>
                                        <img src="<?php echo e(asset('storage/' . $media->path)); ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center bg-slate-200"><span class="material-symbols-outlined">image</span></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-900 dark:text-white uppercase tracking-tight truncate max-w-[200px] title-field">
                                            <?php echo e($property->title); ?>

                                        </div>
                                        <div class="text-[11px] text-slate-400 flex items-center gap-1 mt-0.5">
                                            <span class="material-symbols-outlined text-[14px]">location_on</span>
                                            <span class="truncate"><?php echo e($property->location); ?></span>
                                        </div>
                                        <div class="text-[10px] font-bold text-blue-500 flex items-center gap-1 views-field">
                                            <span class="material-symbols-outlined text-[13px]">visibility</span>
                                            <span><?php echo e(number_format($property->views_count ?? 0)); ?> vues</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <?php
                                $statusLabels = ['active' => 'Publié', 'pending' => 'En attente', 'rejected' => 'Rejeté'];
                                ?>
                                <span class="status-label px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest 
                                    <?php echo e($property->status == 'active' ? 'bg-emerald-100 text-emerald-600' : ($property->status == 'pending' ? 'bg-amber-100 text-amber-600' : 'bg-rose-100 text-rose-600')); ?>">
                                    <?php echo e($statusLabels[$property->status] ?? $property->status); ?>

                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end items-center gap-2">

                                    
                                    <a href="<?php echo e(route('properties.show', $property)); ?>" target="_blank"
                                        class="p-2 text-blue-500 hover:bg-blue-50 rounded-xl transition-all" title="Voir">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>

                                    
                                    <a href="<?php echo e(route('admin.properties.edit', $property)); ?>"
                                        class="p-2 text-slate-500 hover:bg-slate-100 rounded-xl transition-all" title="Modifier">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>

                                    
                                    <form action="<?php echo e(route('admin.properties.moderate', $property)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <?php if($property->is_approved): ?>
                                        <input type="hidden" name="action" value="rejected">
                                        <button type="submit" class="p-2 text-amber-500 hover:bg-amber-50 rounded-xl transition-all" title="Rejeter / Bloquer">
                                            <span class="material-symbols-outlined text-[20px]">block</span>
                                        </button>
                                        <?php else: ?>
                                        <input type="hidden" name="action" value="active">
                                        <button type="submit" class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-xl transition-all" title="Approuver">
                                            <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                        </button>
                                        <?php endif; ?>
                                    </form>

                                    
                                    <div class="flex items-center gap-1 bg-slate-100 dark:bg-slate-800/50 p-1 rounded-xl">

                                        
                                        <?php if($property->status !== 'publiee'): ?>
                                        <form action="<?php echo e(route('admin.properties.moderate', $property)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                            <input type="hidden" name="action" value="publiee">
                                            <button type="submit" class="p-2 text-emerald-500 hover:bg-white dark:hover:bg-slate-700 rounded-lg shadow-sm transition-all" title="Publier">
                                                <span class="material-symbols-outlined text-[20px]">send</span>
                                            </button>
                                        </form>
                                        <?php endif; ?>

                                        
                                        <?php if($property->status !== 'brouillon'): ?>
                                        <form action="<?php echo e(route('admin.properties.moderate', $property)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                            <input type="hidden" name="action" value="brouillon">
                                            <button type="submit" class="p-2 text-slate-500 hover:bg-white dark:hover:bg-slate-700 rounded-lg shadow-sm transition-all" title="Brouillon">
                                                <span class="material-symbols-outlined text-[20px]">draft</span>
                                            </button>
                                        </form>
                                        <?php endif; ?>

                                        
                                        <?php if($property->status !== 'archivee'): ?>
                                        <form action="<?php echo e(route('admin.properties.moderate', $property)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                            <input type="hidden" name="action" value="archivee">
                                            <button type="submit" class="p-2 text-amber-600 hover:bg-white dark:hover:bg-slate-700 rounded-lg shadow-sm transition-all" title="Archiver">
                                                <span class="material-symbols-outlined text-[20px]">archive</span>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>

                                    
                                    <form action="<?php echo e(route('admin.properties.destroy', $property)); ?>" method="POST"
                                        onsubmit="return confirm('Supprimer définitivement ?')" class="inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="p-2 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
                                            <span class="material-symbols-outlined text-[20px]">delete_forever</span>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="px-8 py-10 text-center text-slate-400 italic font-medium">
                                Aucune annonce trouvée dans cette catégorie.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function exportPropertiesToExcel(tableID, filename = '') {
        let originalTable = document.getElementById(tableID);
        if (!originalTable) return alert("Tableau introuvable");

        let rows = originalTable.querySelectorAll('tbody tr');
        let tempTable = document.createElement('table');

        // 1. Entêtes (6 colonnes maintenant)
        let header = tempTable.createTHead();
        let headerRow = header.insertRow(0);
        ['NUMERO', 'TITRE DU BIEN', 'NOMBRE DE VUES', 'STATUT', 'APPROBATION'].forEach(text => {
            let th = document.createElement('th');
            th.innerText = text;
            headerRow.appendChild(th);
        });

        // 2. Données
        let tbody = tempTable.createTBody();
        rows.forEach((row, index) => {
            if (row.innerText.includes('Aucune annonce')) return;

            let newRow = tbody.insertRow();

            // Col 1 : N°
            newRow.insertCell(0).innerText = index + 1;

            // Col 2 : Titre
            let title = row.querySelector('.title-field')?.innerText.trim() || 'N/A';
            newRow.insertCell(1).innerText = title;

            // Col 3 : Vues
            let views = row.querySelector('.views-field')?.innerText.replace(/[^\d]/g, '').trim() || '0';
            newRow.insertCell(2).innerText = views;

            // Col 4 : Statut (Brouillon, Publiée, etc.)
            let status = row.querySelector('.status-label')?.innerText.trim() || 'N/A';
            newRow.insertCell(3).innerText = status;

            // Col 5 : Approbation (Vérifie si l'icône block ou check est présente)
            // On peut aussi passer par un attribut data-approved sur la ligne pour plus de fiabilité
            let isApproved = row.querySelector('.text-emerald-500 .material-symbols-outlined')?.innerText.includes('check_circle');
            let approvalText = isApproved ? 'APPROUVEE' : 'NON APPROUVEE ';
            newRow.insertCell(4).innerText = approvalText;
        });

        // 3. Téléchargement
        let dataType = 'application/vnd.ms-excel';
        let tableHTML = '\ufeff' + tempTable.outerHTML;

        filename = filename ? filename + '.xls' : 'export_annonces.xls';
        let downloadLink = document.createElement("a");
        document.body.appendChild(downloadLink);

        if (navigator.msSaveOrOpenBlob) {
            let blob = new Blob([tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            downloadLink.href = 'data:' + dataType + ', ' + encodeURIComponent(tableHTML);
            downloadLink.download = filename;
            downloadLink.click();
        }
        document.body.removeChild(downloadLink);
    }
</script><?php /**PATH C:\Users\HP\Desktop\opendoor v-final\opendoor\resources\views/properties/admin/dashboard/partials/properties.blade.php ENDPATH**/ ?>