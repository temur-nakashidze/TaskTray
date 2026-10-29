@props([
    'variant' => 'info',
    'icon' => null,
    'color' => null,
    'controls' => null,
])

@php

    $color ??= match ($variant) {
        'success' => 'emerald',
        'warning' => 'yellow',
        'error' => 'red',
        default => 'blue',
    };

$colors = match ($color) {
    'zinc' => [
        '[--bg-color:var(--color-zinc-200)]/40 [--border-color:var(--color-zinc-500)]/70 [--text-color:var(--color-zinc-600)]/80 [--heading-color:var(--color-zinc-600)] [--icon-color:var(--color-zinc-500)]',
        'dark:[--bg-color:var(--color-zinc-900)]/40 dark:[--border-color:var(--color-zinc-500)]/70 dark:[--text-color:var(--color-zinc-400)]/80 dark:[--heading-color:var(--color-zinc-300)] dark:[--icon-color:var(--color-zinc-300)]',
    ],
    'red' => [
        '[--bg-color:var(--color-red-200)]/40 [--border-color:var(--color-red-500)]/70 [--text-color:var(--color-red-600)]/80 [--heading-color:var(--color-red-600)] [--icon-color:var(--color-red-500)]',
        'dark:[--bg-color:var(--color-red-900)]/40 dark:[--border-color:var(--color-red-500)]/70 dark:[--text-color:var(--color-red-400)]/80 dark:[--heading-color:var(--color-red-300)] dark:[--icon-color:var(--color-red-300)]',
    ],
    'orange' => [
        '[--bg-color:var(--color-orange-200)]/40 [--border-color:var(--color-orange-500)]/70 [--text-color:var(--color-orange-600)]/80 [--heading-color:var(--color-orange-600)] [--icon-color:var(--color-orange-500)]',
        'dark:[--bg-color:var(--color-orange-900)]/40 dark:[--border-color:var(--color-orange-500)]/70 dark:[--text-color:var(--color-orange-400)]/80 dark:[--heading-color:var(--color-orange-300)] dark:[--icon-color:var(--color-orange-300)]',
    ],
    'amber' => [
        '[--bg-color:var(--color-amber-200)]/40 [--border-color:var(--color-amber-500)]/70 [--text-color:var(--color-amber-600)]/80 [--heading-color:var(--color-amber-600)] [--icon-color:var(--color-amber-500)]',
        'dark:[--bg-color:var(--color-amber-900)]/40 dark:[--border-color:var(--color-amber-500)]/70 dark:[--text-color:var(--color-amber-400)]/80 dark:[--heading-color:var(--color-amber-300)] dark:[--icon-color:var(--color-amber-300)]',
    ],
    'yellow' => [
        '[--bg-color:var(--color-yellow-200)]/40 [--border-color:var(--color-yellow-500)]/70 [--text-color:var(--color-yellow-600)]/80 [--heading-color:var(--color-yellow-600)] [--icon-color:var(--color-yellow-500)]',
        'dark:[--bg-color:var(--color-yellow-900)]/40 dark:[--border-color:var(--color-yellow-500)]/70 dark:[--text-color:var(--color-yellow-400)]/80 dark:[--heading-color:var(--color-yellow-300)] dark:[--icon-color:var(--color-yellow-300)]',
    ],
    'lime' => [
        '[--bg-color:var(--color-lime-200)]/40 [--border-color:var(--color-lime-500)]/70 [--text-color:var(--color-lime-600)]/80 [--heading-color:var(--color-lime-600)] [--icon-color:var(--color-lime-500)]',
        'dark:[--bg-color:var(--color-lime-900)]/40 dark:[--border-color:var(--color-lime-500)]/70 dark:[--text-color:var(--color-lime-400)]/80 dark:[--heading-color:var(--color-lime-300)] dark:[--icon-color:var(--color-lime-300)]',
    ],
    'green' => [
        '[--bg-color:var(--color-green-200)]/40 [--border-color:var(--color-green-500)]/70 [--text-color:var(--color-green-600)]/80 [--heading-color:var(--color-green-600)] [--icon-color:var(--color-green-500)]',
        'dark:[--bg-color:var(--color-green-900)]/40 dark:[--border-color:var(--color-green-500)]/70 dark:[--text-color:var(--color-green-400)]/80 dark:[--heading-color:var(--color-green-300)] dark:[--icon-color:var(--color-green-300)]',
    ],
    'emerald' => [
        '[--bg-color:var(--color-emerald-200)]/40 [--border-color:var(--color-emerald-500)]/70 [--text-color:var(--color-emerald-600)]/80 [--heading-color:var(--color-emerald-600)] [--icon-color:var(--color-emerald-500)]',
        'dark:[--bg-color:var(--color-emerald-900)]/40 dark:[--border-color:var(--color-emerald-500)]/70 dark:[--text-color:var(--color-emerald-400)]/80 dark:[--heading-color:var(--color-emerald-300)] dark:[--icon-color:var(--color-emerald-300)]',
    ],
    'teal' => [
        '[--bg-color:var(--color-teal-200)]/40 [--border-color:var(--color-teal-500)]/70 [--text-color:var(--color-teal-600)]/80 [--heading-color:var(--color-teal-600)] [--icon-color:var(--color-teal-500)]',
        'dark:[--bg-color:var(--color-teal-900)]/40 dark:[--border-color:var(--color-teal-500)]/70 dark:[--text-color:var(--color-teal-400)]/80 dark:[--heading-color:var(--color-teal-300)] dark:[--icon-color:var(--color-teal-300)]',
    ],
    'cyan' => [
        '[--bg-color:var(--color-cyan-200)]/40 [--border-color:var(--color-cyan-500)]/70 [--text-color:var(--color-cyan-600)]/80 [--heading-color:var(--color-cyan-600)] [--icon-color:var(--color-cyan-500)]',
        'dark:[--bg-color:var(--color-cyan-900)]/40 dark:[--border-color:var(--color-cyan-500)]/70 dark:[--text-color:var(--color-cyan-400)]/80 dark:[--heading-color:var(--color-cyan-300)] dark:[--icon-color:var(--color-cyan-300)]',
    ],
    'sky' => [
        '[--bg-color:var(--color-sky-200)]/40 [--border-color:var(--color-sky-500)]/70 [--text-color:var(--color-sky-600)]/80 [--heading-color:var(--color-sky-600)] [--icon-color:var(--color-sky-500)]',
        'dark:[--bg-color:var(--color-sky-900)]/40 dark:[--border-color:var(--color-sky-500)]/70 dark:[--text-color:var(--color-sky-400)]/80 dark:[--heading-color:var(--color-sky-300)] dark:[--icon-color:var(--color-sky-300)]',
    ],
    'blue' => [
        '[--bg-color:var(--color-blue-200)]/40 [--border-color:var(--color-blue-500)]/70 [--text-color:var(--color-blue-600)]/80 [--heading-color:var(--color-blue-600)] [--icon-color:var(--color-blue-500)]',
        'dark:[--bg-color:var(--color-blue-900)]/40 dark:[--border-color:var(--color-blue-400)]/70 dark:[--text-color:var(--color-blue-400)]/80 dark:[--heading-color:var(--color-blue-300)] dark:[--icon-color:var(--color-blue-300)]',
    ],
    'indigo' => [
        '[--bg-color:var(--color-indigo-200)]/40 [--border-color:var(--color-indigo-500)]/70 [--text-color:var(--color-indigo-600)]/80 [--heading-color:var(--color-indigo-600)] [--icon-color:var(--color-indigo-500)]',
        'dark:[--bg-color:var(--color-indigo-900)]/40 dark:[--border-color:var(--color-indigo-500)]/70 dark:[--text-color:var(--color-indigo-400)]/80 dark:[--heading-color:var(--color-indigo-300)] dark:[--icon-color:var(--color-indigo-300)]',
    ],
    'violet' => [
        '[--bg-color:var(--color-violet-200)]/40 [--border-color:var(--color-violet-500)]/70 [--text-color:var(--color-violet-600)]/80 [--heading-color:var(--color-violet-600)] [--icon-color:var(--color-violet-500)]',
        'dark:[--bg-color:var(--color-violet-900)]/40 dark:[--border-color:var(--color-violet-500)]/70 dark:[--text-color:var(--color-violet-400)]/80 dark:[--heading-color:var(--color-violet-300)] dark:[--icon-color:var(--color-violet-300)]',
    ],
    'purple' => [
        '[--bg-color:var(--color-purple-200)]/40 [--border-color:var(--color-purple-500)]/70 [--text-color:var(--color-purple-600)]/80 [--heading-color:var(--color-purple-600)] [--icon-color:var(--color-purple-500)]',
        'dark:[--bg-color:var(--color-purple-900)]/40 dark:[--border-color:var(--color-purple-500)]/70 dark:[--text-color:var(--color-purple-400)]/80 dark:[--heading-color:var(--color-purple-300)] dark:[--icon-color:var(--color-purple-300)]',
    ],
    'fuchsia' => [
        '[--bg-color:var(--color-fuchsia-200)]/40 [--border-color:var(--color-fuchsia-500)]/70 [--text-color:var(--color-fuchsia-600)]/80 [--heading-color:var(--color-fuchsia-600)] [--icon-color:var(--color-fuchsia-500)]',
        'dark:[--bg-color:var(--color-fuchsia-900)]/40 dark:[--border-color:var(--color-fuchsia-500)]/70 dark:[--text-color:var(--color-fuchsia-400)]/80 dark:[--heading-color:var(--color-fuchsia-300)] dark:[--icon-color:var(--color-fuchsia-300)]',
    ],
    'pink' => [
        '[--bg-color:var(--color-pink-200)]/40 [--border-color:var(--color-pink-500)]/70 [--text-color:var(--color-pink-600)]/80 [--heading-color:var(--color-pink-600)] [--icon-color:var(--color-pink-500)]',
        'dark:[--bg-color:var(--color-pink-900)]/40 dark:[--border-color:var(--color-pink-500)]/70 dark:[--text-color:var(--color-pink-400)]/80 dark:[--heading-color:var(--color-pink-300)] dark:[--icon-color:var(--color-pink-300)]',
    ],
    'rose' => [
        '[--bg-color:var(--color-rose-200)]/40 [--border-color:var(--color-rose-500)]/70 [--text-color:var(--color-rose-600)]/80 [--heading-color:var(--color-rose-600)] [--icon-color:var(--color-rose-500)]',
        'dark:[--bg-color:var(--color-rose-900)]/40 dark:[--border-color:var(--color-rose-500)]/70 dark:[--text-color:var(--color-rose-400)]/80 dark:[--heading-color:var(--color-rose-300)] dark:[--icon-color:var(--color-rose-300)]',
    ],
    'slate' => [
        '[--bg-color:var(--color-slate-200)]/40 [--border-color:var(--color-slate-500)]/70 [--text-color:var(--color-slate-600)]/80 [--heading-color:var(--color-slate-600)] [--icon-color:var(--color-slate-500)]',
        'dark:[--bg-color:var(--color-slate-900)]/40 dark:[--border-color:var(--color-slate-500)]/70 dark:[--text-color:var(--color-slate-400)]/80 dark:[--heading-color:var(--color-slate-300)] dark:[--icon-color:var(--color-slate-300)]',
    ],
    'gray' => [
        '[--bg-color:var(--color-gray-200)]/40 [--border-color:var(--color-gray-500)]/70 [--text-color:var(--color-gray-600)]/80 [--heading-color:var(--color-gray-600)] [--icon-color:var(--color-gray-500)]',
        'dark:[--bg-color:var(--color-gray-900)]/40 dark:[--border-color:var(--color-gray-500)]/70 dark:[--text-color:var(--color-gray-400)]/80 dark:[--heading-color:var(--color-gray-300)] dark:[--icon-color:var(--color-gray-300)]',
    ],
    'neutral' => [
        '[--bg-color:var(--color-neutral-200)]/40 [--border-color:var(--color-neutral-500)]/70 [--text-color:var(--color-neutral-600)]/80 [--heading-color:var(--color-neutral-600)] [--icon-color:var(--color-neutral-500)]',
        'dark:[--bg-color:var(--color-neutral-900)]/40 dark:[--border-color:var(--color-neutral-500)]/70 dark:[--text-color:var(--color-neutral-400)]/80 dark:[--heading-color:var(--color-neutral-300)] dark:[--icon-color:var(--color-neutral-300)]',
    ],
    'stone' => [
        '[--bg-color:var(--color-stone-200)]/40 [--border-color:var(--color-stone-500)]/70 [--text-color:var(--color-stone-600)]/80 [--heading-color:var(--color-stone-600)] [--icon-color:var(--color-stone-500)]',
        'dark:[--bg-color:var(--color-stone-900)]/40 dark:[--border-color:var(--color-stone-500)]/70 dark:[--text-color:var(--color-stone-400)]/80 dark:[--heading-color:var(--color-stone-300)] dark:[--icon-color:var(--color-stone-300)]',
    ],

    default => [],
};

    $containerClass = [
        'border flex items-center rounded-popup gap-2 p-4',
        // if it there is heading and description align the icon to the first.
        '[&:has([data-slot=alert-heading]):has([data-slot=alert-description])]:[&_[data-slot=alert-icon]]:self-start',
        'bg-[var(--bg-color)]/40 border-[var(--border-color)]/70 text-[var(--text-color)]',
        // icon color
        '[&_[data-slot=icon]]:text-(--icon-color)',
        ...filled($color) ? $colors : [],
    ];
@endphp

<div
        {{ $attributes->class(Arr::toCssClasses($containerClass)) }}
        data-slot="alert"
        role="alert"
        aria-live="polite"
>
    @if (filled($icon))
        <div class="shrink-0 flex items-center justify-center" data-slot="alert-icon">
            <x-ui.icon name="{{ $icon }}" class="text-[var(--icon-color)]"/>
        </div>
    @endif

    <div class="space-y-1">
        {{ $slot }}
    </div>

    @if (filled($controls))
        <div {{ $controls->attributes->class('h-full ml-auto') }} data-slot="alert-controls">
            {{ $controls }}
        </div>
    @endif
</div>
