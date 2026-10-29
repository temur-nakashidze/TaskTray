@php
    // needs refactoring to use badge component instead
    $colorClasses = match($tagColor){
        default=> ' text-(--color-ink-base)   bg-neutral-500/10 dark:bg-neutral-400/10 border-neutral-700/20 dark:border-neutral-400/20',
'red'
                => 'text-red-700 dark:text-red-300 bg-red-200/20 dark:bg-red-800/20 border-red-900/40 dark:border-red-400/50 border',
            'orange'
                => 'text-orange-700 dark:text-orange-300 bg-orange-200/20 dark:bg-orange-800/20 border-orange-700/40 dark:border-orange-400/40 border',
            'amber'
                => 'text-amber-700 dark:text-amber-300 bg-amber-200/20 dark:bg-amber-800/20 border-amber-700/40 dark:border-amber-400/40 border',
            'yellow'
                => 'text-yellow-700 dark:text-yellow-300 bg-yellow-200/20 dark:bg-yellow-800/20 border-yellow-700/40 dark:border-yellow-400/40 border',
            'lime'
                => 'text-lime-700 dark:text-lime-300 bg-lime-200/20 dark:bg-lime-800/20 border-lime-700/40 dark:border-lime-400/40 border',
            'green'
                => 'text-green-700 dark:text-green-300 bg-green-200/20 dark:bg-green-800/20 border-green-700/40 dark:border-green-400/40 border',
            'emerald'
                => 'text-emerald-700 dark:text-emerald-300 bg-emerald-200/20 dark:bg-emerald-800/20 border-emerald-700/40 dark:border-emerald-400/40 border',
            'teal'
                => 'text-teal-700 dark:text-teal-300 bg-teal-200/20 dark:bg-teal-800/20 border-teal-700/40 dark:border-teal-400/40 border',
            'cyan'
                => 'text-cyan-700 dark:text-cyan-300 bg-cyan-200/20 dark:bg-cyan-800/20 border-cyan-700/40 dark:border-cyan-400/40 border',
            'sky'
                => 'text-sky-700 dark:text-sky-300 bg-sky-200/20 dark:bg-sky-800/20 border-sky-700/40 dark:border-sky-400/40 border',
            'blue'
                => 'text-blue-700 dark:text-blue-300 bg-blue-200/20 dark:bg-blue-800/20 border-blue-700/40 dark:border-blue-400/40 border',
            'indigo'
                => 'text-indigo-700 dark:text-indigo-300 bg-indigo-200/20 dark:bg-indigo-800/20 border-indigo-700/40 dark:border-indigo-400/40 border',
            'violet'
                => 'text-violet-700 dark:text-violet-300 bg-violet-200/20 dark:bg-violet-800/20 border-violet-700/40 dark:border-violet-400/40 border',
            'purple'
                => 'text-purple-700 dark:text-purple-300 bg-purple-200/20 dark:bg-purple-800/20 border-purple-700/40 dark:border-purple-400/40 border',
            'fuchsia'
                => 'text-fuchsia-700 dark:text-fuchsia-300 bg-fuchsia-200/20 dark:bg-fuchsia-800/20 border-fuchsia-700/40 dark:border-fuchsia-400/40 border',
            'pink'
                => 'text-pink-700 dark:text-pink-300 bg-pink-200/20 dark:bg-pink-800/20 border-pink-700/40 dark:border-pink-400/40 border',
            'rose'
                => 'text-rose-700 dark:text-rose-300 bg-rose-200/20 dark:bg-rose-800/20 border-rose-700/40 dark:border-rose-400/40 border',
    };

    $variantClasses = match($tagVariant){
        'rounded'=> 'rounded-md  border',
        'pill'=> 'rounded-full border '
    };

    $classes = [
        'px-2 py-1 text-sm font-medium',
        "cursor-default inline-flex items-center rounded-[calc(var(--radius-button)*0.75)] font-medium
                                 text-(--color-ink-base)   bg-neutral-500/10 dark:bg-neutral-400/10 border-neutral-700/20 dark:border-neutral-400/20 border
                                max-w-full",
        $variantClasses,
        $colorClasses
    ];

@endphp

<div
        @class(Arr::toCssClasses($classes))
        draggable="true"
        x-on:dragstart="onDragStart(index)"
        x-on:dragover.prevent=""
        x-bind:class="{ 'opacity-50': dragIndex === index }"
        x-on:drop="onDrop(event,index)"
>
    <span x-text="tag" class="select-none text-start"></span>
    <button
            type="button"
            class="cursor-pointer ml-1 -mr-1 rounded-sm hover:bg-black/5 dark:hover:bg-white/10
                        focus:outline-none p-1 text-current transition"
            x-on:click="deleteTag(index)"
    >
        <x-ui.icon name="ps:x" variant="bold" class="size-3"/>
    </button>
</div>