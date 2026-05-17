
    <div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-950 font-sans">
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden relative">
            <header class="h-24 flex items-center justify-between px-10 bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-800/50 z-10">
                <div class="flex items-center gap-6">
                    <a href="<?php echo e(route('dashboard.index')); ?>" class="group size-12 flex items-center justify-center bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 rounded-2xl hover:bg-primary hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined">arrow_back</span>
                    </a>
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tighter italic">Messagerie</h2>
                    </div>
                </div>
                <div class="px-5 py-2.5 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="text-xs font-black text-primary uppercase tracking-widest"><?php echo e($messages->count()); ?> Messages</span>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
                <div class="max-w-4xl mx-auto space-y-12">
                    
                    <?php
                        $unread = $messages->where('is_read', false);
                        $recent = $messages->where('is_read', true)->where('created_at', '>=', now()->subDay());
                        $others = $messages->where('is_read', true)->where('created_at', '<', now()->subDay());
                    ?>

                    
                    <?php $__currentLoopData = ['Nouveaux' => $unread, 'Récents' => $recent, 'Archives' => $others]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($group->count() > 0): ?>
                            <section>
                                <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mb-6"><?php echo e($label); ?></h3>
                                <div class="space-y-4">
                                    <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        
                                        <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border <?php echo e(!$message->is_read ? 'border-primary/30 shadow-lg' : 'border-slate-200/60'); ?> flex items-center gap-6 group">
                                            <div class="w-14 h-14 rounded-2xl <?php echo e(!$message->is_read ? 'bg-primary text-white' : 'bg-slate-100 text-slate-400'); ?> flex items-center justify-center font-black text-xl">
                                                <?php echo e(substr($message->visitor_name ?? 'V', 0, 1)); ?>

                                            </div>
                                            <div class="flex-1">
                                                <div class="flex justify-between">
                                                    <h4 class="font-black text-slate-900 dark:text-white"><?php echo e($message->visitor_name); ?></h4>
                                                    <span class="text-[10px] text-slate-400 uppercase font-bold"><?php echo e($message->created_at->diffForHumans()); ?></span>
                                                </div>
                                                <p class="text-xs text-primary font-bold uppercase mb-1"><?php echo e($message->visitor_email); ?></p>
                                                <p class="text-sm text-slate-500 italic">"<?php echo e($message->content); ?>"</p>
                                            </div>
                                            <div class="flex gap-2">
                                                <a href="mailto:<?php echo e($message->visitor_email); ?>" class="p-3 bg-slate-100 dark:bg-slate-800 rounded-xl hover:bg-primary hover:text-white transition-all">
                                                    <span class="material-symbols-outlined text-sm">reply</span>
                                                </a>
                                            </div>
                                        </div>
                                        
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </section>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($messages->isEmpty()): ?>
                        <div class="text-center py-20 bg-white rounded-[3rem] border-2 border-dashed border-slate-200">
                            <p class="text-slate-400 font-bold uppercase tracking-widest">Aucun message trouvé</p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </main>
    </div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #1e293b; }
</style><?php /**PATH C:\Users\HP\Desktop\opendoor v-final\opendoor\resources\views/properties/user/dashboard/partials/messages.blade.php ENDPATH**/ ?>