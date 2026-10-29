@props([
    'date' => null,
    'color' => 'zinc',
])

@php
    $dotColors = match ($color) {
        'blue' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 ring-blue-50 dark:ring-blue-900/20',
        'green'
            => 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 ring-green-50 dark:ring-green-900/20',
        'amber'
            => 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 ring-amber-50 dark:ring-amber-900/20',
        'red' => 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 ring-red-50 dark:ring-red-900/20',
        'primary'
            => 'bg-theme-100 dark:bg-primary/30 text-primary-content dark:text-primary ring-theme-50 dark:ring-theme-900/20',
        default
            => 'bg-theme-100 dark:bg-primary text-primary-content dark:text-primary-content ring-theme-50 dark:ring-theme-800',
    };
@endphp

<li class="ms-12">
    <span
        class="absolute flex items-center justify-center w-12 h-12 rounded-full -start-6 ring-4 ring-white dark:ring-zinc-900 {{ $dotColors }}">
        {{ $icon ?? '' }}
    </span>

    <div class="flex items-center gap-3 mb-1">
        {{ $badge ?? '' }}
        @if ($date)
            <x-ui.badge variant="outline" color="neutral" size="md" pill>{{ $date }}</x-ui.badge>
        @endif
    </div>

    <div>
        {{ $slot }}
    </div>
</li>
