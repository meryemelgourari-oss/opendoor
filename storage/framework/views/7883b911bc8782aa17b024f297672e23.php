
<div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:border-primary/30 group">
    <div class="flex items-center justify-between mb-4">
        <div class="p-2 bg-primary/10 rounded-lg text-primary group-hover:bg-primary group-hover:text-white transition-colors">
            <span class="material-symbols-outlined"><?php echo e($icon); ?></span>
        </div>
        <?php if($trend): ?>
            <span class="text-[10px] font-bold text-<?php echo e($trendColor); ?>-500 bg-<?php echo e($trendColor); ?>-50 dark:bg-<?php echo e($trendColor); ?>-500/10 px-2 py-1 rounded-full uppercase">
                <?php echo e($trend); ?>

            </span>
        <?php endif; ?>
    </div>
    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium"><?php echo e($label); ?></p>
    <p class="text-3xl font-black mt-1 text-slate-900 dark:text-white"><?php echo e($value); ?></p>
</div><?php /**PATH C:\Users\HP\Desktop\opendoor v-final\opendoor\resources\views/components/stats-card.blade.php ENDPATH**/ ?>