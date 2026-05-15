
<div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:border-primary/30 group">
    <div class="flex items-center justify-between mb-4">
        <div class="p-2 bg-primary/10 rounded-lg text-primary group-hover:bg-primary group-hover:text-white transition-colors">
            <span class="material-symbols-outlined">{{ $icon }}</span>
        </div>
        @if($trend)
            <span class="text-[10px] font-bold text-{{ $trendColor }}-500 bg-{{ $trendColor }}-50 dark:bg-{{ $trendColor }}-500/10 px-2 py-1 rounded-full uppercase">
                {{ $trend }}
            </span>
        @endif
    </div>
    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">{{ $label }}</p>
    <p class="text-3xl font-black mt-1 text-slate-900 dark:text-white">{{ $value }}</p>
</div>