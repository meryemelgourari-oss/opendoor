<div x-data="{ 
        showCreateModal: false, 
        showEditModal: false,
        editUser: { id: '', name: '', email: '' } 
    }" class="min-h-screen bg-[#f6f7f8] dark:bg-[#101922] p-2 lg:p-4">

    <div class="max-w-7xl mx-auto">

        <?php if(session('success')): ?>
        <div class="mb-6 p-4 bg-emerald-500 text-white rounded-2xl shadow-lg flex items-center gap-3 animate-bounce">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="font-bold"><?php echo e(session('success')); ?></span>
        </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
        <div class="mb-6 p-4 bg-rose-500 text-white rounded-2xl shadow-lg">
            <div class="flex items-center gap-3 mb-2 font-black uppercase text-xs">
                <span class="material-symbols-outlined text-sm">error</span>
                Attention : Erreurs de saisie
            </div>
            <ul class="list-disc list-inside text-sm opacity-90">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-10">
            <div>
                <h1 class="text-slate-900 dark:text-slate-100 text-4xl font-black italic tracking-tight uppercase">Utilisateurs</h1>
                <p class="text-slate-500 font-medium">Gestion centralisée des membres du portail.</p>
            </div>

            <div class="flex items-center gap-4">
                <button onclick="exportTableToExcel('users-table', 'liste-utilisateurs')"
                    class="flex items-center gap-2 rounded-2xl h-14 px-6 bg-emerald-600 text-white font-bold shadow-xl shadow-emerald-600/30 hover:scale-105 active:scale-95 transition-all">
                    <span class="material-symbols-outlined">download</span>
                    <span>Exporter Excel</span>
                </button>

                <button @click="showCreateModal = true" class="flex items-center gap-2 rounded-2xl h-14 px-8 bg-blue-600 text-white font-bold shadow-xl shadow-blue-600/30 hover:scale-105 active:scale-95 transition-all">
                    <span class="material-symbols-outlined">person_add</span>
                    <span>Nouveau Membre</span>
                </button>
            </div>
        </div>

        <div class="mb-10">
            <form action="<?php echo e(route('admin.users.index')); ?>" method="GET" class="max-w-4xl">
                <div class="flex items-center gap-0 bg-white dark:bg-slate-900 rounded-2xl shadow-sm ring-1 ring-slate-200 dark:ring-slate-800 focus-within:ring-4 focus-within:ring-blue-600/10 transition-all overflow-hidden h-16">
                    <div class="flex items-center justify-center w-14 h-full text-slate-400">
                        <span class="material-symbols-outlined">search</span>
                    </div>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Rechercher un nom ou un email..." class="flex-1 h-full border-none bg-transparent text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-0 text-sm">

                    <div class="flex items-center gap-2 px-3 h-full bg-slate-50/50 dark:bg-slate-800/50 border-l border-slate-100 dark:border-slate-800">
                        <?php if(request('search')): ?>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center justify-center size-9 rounded-lg text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-all">
                            <span class="material-symbols-outlined text-lg">close</span>
                        </a>
                        <?php endif; ?>
                        <button type="submit" class="h-10 px-6 bg-slate-900 dark:bg-blue-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:scale-105 active:scale-95 transition-all shadow-sm">
                            Filtrer
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table id="users-table" class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Membre</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Statut Compte</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right export-ignore">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="group hover:bg-slate-50/50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="size-12 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-500 flex items-center justify-center text-white font-black shadow-lg shadow-blue-600/20">
                                        <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors"><?php echo e($user->name); ?></div>
                                        <div class="text-xs text-slate-500 font-medium"><?php echo e($user->email); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <form action="<?php echo e(route('admin.users.toggle', $user)); ?>" method="POST">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="flex items-center gap-3 group/toggle">
                                        <div class="w-12 h-6 rounded-full p-1 transition-colors duration-300 <?php echo e($user->is_active ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-700'); ?>">
                                            <div class="size-4 bg-white rounded-full shadow-sm transition-transform duration-300 <?php echo e($user->is_active ? 'translate-x-6' : ''); ?>"></div>
                                        </div>
                                        <span class="text-[10px] font-black uppercase tracking-widest <?php echo e($user->is_active ? 'text-emerald-600' : 'text-slate-400'); ?>">
                                            <?php echo e($user->is_active ? 'Actif' : 'Suspendu'); ?>

                                        </span>
                                    </button>
                                </form>
                            </td>
                            <td class="px-8 py-5 export-ignore">
                                <div class="flex justify-end items-center gap-2">
                                    <button @click="editUser = { id: '<?php echo e($user->id); ?>', name: '<?php echo e($user->name); ?>', email: '<?php echo e($user->email); ?>' }; showEditModal = true"
                                        class="p-3 text-slate-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-2xl transition-all">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>

                                    <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" onsubmit="return confirm('Supprimer ce membre définitivement ?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="p-3 text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-2xl transition-all">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="px-8 py-20 text-center text-slate-400 italic">Aucun utilisateur trouvé.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($users->hasPages()): ?>
            <div class="p-8 bg-slate-50/50 dark:bg-slate-800/30 border-t border-slate-100 dark:border-slate-800">
                <?php echo e($users->links()); ?>

            </div>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
            <div class="p-8 rounded-[2rem] bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center gap-6 shadow-sm">
                <div class="size-16 rounded-2xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                    <span class="material-symbols-outlined text-3xl">group</span>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Utilisateurs Totaux</p>
                    <p class="text-3xl font-black text-slate-900 dark:text-white"><?php echo e($stats['users_count'] ?? 0); ?></p>
                </div>
            </div>

            <div class="p-8 rounded-[2rem] bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center gap-6 shadow-sm">
                <div class="size-16 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                    <span class="material-symbols-outlined text-3xl">person_check</span>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Utilisateurs Actifs</p>
                    <p class="text-3xl font-black text-slate-900 dark:text-white"><?php echo e($stats['active_users_count'] ?? 0); ?></p>
                </div>
            </div>

            <div class="p-8 rounded-[2rem] bg-slate-900 dark:bg-blue-600 flex items-center gap-6 shadow-2xl shadow-blue-600/20">
                <div class="size-16 rounded-2xl bg-white/10 flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-3xl">person_off</span>
                </div>
                <div>
                    <p class="text-[10px] font-black text-white/50 uppercase tracking-widest">Membres Inactifs</p>
                    <p class="text-3xl font-black text-white leading-none mt-1"><?php echo e($stats['inactive_users_count'] ?? 0); ?></p>
                </div>
            </div>
        </div>

        <!-- CREATE MODAL -->
        <div x-show="showCreateModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-md" x-transition.opacity x-cloak>
            <div @click.away="showCreateModal = false" class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-blue-600"></div>
                <h3 class="text-3xl font-black text-slate-900 dark:text-white mb-2 italic uppercase">Nouveau Membre</h3>
                <form action="<?php echo e(route('admin.users.store')); ?>" method="POST" class="space-y-5">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Nom Complet</label>
                        <input type="text" name="name" class="w-full h-14 px-5 rounded-2xl border-slate-100 dark:border-slate-800 dark:bg-slate-800 bg-slate-50 focus:ring-blue-600 focus:border-blue-600 text-slate-900 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Adresse Email</label>
                        <input type="email" name="email" class="w-full h-14 px-5 rounded-2xl border-slate-100 dark:border-slate-800 dark:bg-slate-800 bg-slate-50 focus:ring-blue-600 focus:border-blue-600 text-slate-900 dark:text-white" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Mot de passe</label>
                            <input type="password" name="password" class="w-full h-14 px-5 rounded-2xl border-slate-100 dark:border-slate-800 dark:bg-slate-800 bg-slate-50 focus:ring-blue-600 focus:border-blue-600 text-slate-900 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Confirmation</label>
                            <input type="password" name="password_confirmation" class="w-full h-14 px-5 rounded-2xl border-slate-100 dark:border-slate-800 dark:bg-slate-800 bg-slate-50 focus:ring-blue-600 focus:border-blue-600 text-slate-900 dark:text-white" required>
                        </div>
                    </div>
                    <div class="flex gap-4 pt-6">
                        <button type="button" @click="showCreateModal = false" class="flex-1 h-14 rounded-2xl font-bold text-slate-400 hover:bg-slate-50 transition-colors">Annuler</button>
                        <button type="submit" class="flex-1 h-14 rounded-2xl bg-blue-600 text-white font-black uppercase tracking-widest shadow-lg">Créer le compte</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- EDIT MODAL (CORRIGÉ) -->
        <div x-show="showEditModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-md" x-transition.opacity x-cloak>
            <div @click.away="showEditModal = false" class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-amber-500"></div>
                <h3 class="text-3xl font-black text-slate-900 dark:text-white mb-2 italic uppercase">Modifier</h3>
                <p class="text-slate-500 mb-8 text-sm">Mise à jour de : <span x-text="editUser.name" class="text-blue-600 font-bold"></span></p>
                
                <!-- La route génère '/admin/utilisateurs', et JavaScript y ajoute '/{id}' pour déclencher la route UPDATE -->
                <form :action="`<?php echo e(route('admin.users.index')); ?>/${editUser.id}`" method="POST" class="space-y-5">
                    <?php echo csrf_field(); ?> 
                    <?php echo method_field('PUT'); ?>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Nom Complet</label>
                        <input type="text" name="name" x-model="editUser.name" class="w-full h-14 px-5 rounded-2xl border-slate-100 dark:border-slate-800 dark:bg-slate-800 bg-slate-50 focus:ring-blue-600 text-slate-900 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Adresse Email</label>
                        <input type="email" name="email" x-model="editUser.email" class="w-full h-14 px-5 rounded-2xl border-slate-100 dark:border-slate-800 dark:bg-slate-800 bg-slate-50 focus:ring-blue-600 text-slate-900 dark:text-white" required>
                    </div>
                    <div class="flex gap-4 pt-6">
                        <button type="button" @click="showEditModal = false" class="flex-1 h-14 rounded-2xl font-bold text-slate-400 hover:bg-slate-50 transition-colors">Annuler</button>
                        <button type="submit" class="flex-1 h-14 rounded-2xl bg-slate-900 text-white font-black uppercase tracking-widest shadow-lg">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function exportTableToExcel(tableID, filename = '') {
        let tableSelect = document.getElementById(tableID);
        let originalRows = tableSelect.querySelectorAll('tbody tr');
        let tempTable = document.createElement('table');

        let header = tempTable.createTHead();
        let headerRow = header.insertRow(0);
        ['NUMERO', 'NOM', 'GMAIL', 'STATUT'].forEach((text, i) => {
            let th = document.createElement('th');
            th.innerText = text;
            headerRow.appendChild(th);
        });

        let tbody = tempTable.createTBody();

        originalRows.forEach((row, index) => {
            if (row.cells.length < 2) return;

            let newRow = tbody.insertRow();
            newRow.insertCell(0).innerText = index + 1;

            let memberCell = row.cells[0];
            let name = memberCell.querySelector('.font-bold')?.innerText.trim() || '';
            let email = memberCell.querySelector('.text-xs')?.innerText.trim() || '';
            newRow.insertCell(1).innerText = name;
            newRow.insertCell(2).innerText = email;

            let statusCellText = row.cells[1].innerText.trim();
            let isActif = /Actif/i.test(statusCellText);

            let statusFinal = isActif ? 'ACTIF' : 'SUSPENDU';
            let statusCell = newRow.insertCell(3);
            statusCell.innerText = statusFinal;
            statusCell.style.color = isActif ? '#059669' : '#e11d48';
        });

        let dataType = 'application/vnd.ms-excel';
        let tableData = '\ufeff' + tempTable.outerHTML;

        filename = filename ? filename + '.xls' : 'liste_utilisateurs.xls';
        let downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);

        if (navigator.msSaveOrOpenBlob) {
            let blob = new Blob([tableData], { type: dataType });
            navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            downloadLink.href = 'data:' + dataType + ', ' + encodeURIComponent(tableData);
            downloadLink.download = filename;
            downloadLink.click();
        }

        document.body.removeChild(downloadLink);
    }
</script><?php /**PATH C:\Users\HP\Desktop\opendoor v-final\opendoor\resources\views/properties/admin/dashboard/partials/users.blade.php ENDPATH**/ ?>