@props([
    'header' => null,
    'title' => null,
    'count' => 0,
    'wire' => null,
    'trayId' => null,
    'context' => null,
    'icon' => 'ps:tray',
    'size' => 'full',
    'dragable' => true,
    'input' => null,
])

@php
    $width = match ($size) {
        'full' => 'w-full',
        'xs' => 'w-40',
        'sm' => 'w-60',
        'md' => 'w-86',
        'lg' => 'w-100',
    };
@endphp

<x-ui.card {{ $attributes->merge(['class' => $width . ' bg-(--color-surface)!']) }}>
    <div class="flex items-center justify-between relative group">
        <div class="flex items-center gap-2">
            @if ($dragable)
                <x-ui.handle x-sort:handle class="group-hover:opacity-100 opacity-30 transition-opacity" />
            @endif
            <x-ui.heading size="xl" font="mono" class="Capitalize" color="theme" weight="semibold"
                color="muted">{{ $header }}</x-ui.heading>
        </div>
        <div class="relative">
            @if ($icon)
                <x-ui.icon name="{{ $icon }}" variant="thin"
                    class="size-10 text-(--color-theme-600)/30 dark:text-(--color-theme-400)/30" />
            @endif

            @if ($count !== null)
                <span
                    class="absolute inset-0 -translate-y-0.5 font-mono flex items-center justify-center text-xs text-(--color-theme-400) dark:text-(--color-theme-500) font-medium">
                    {{ $count }}
                </span>
            @endif
        </div>

    </div>
    @if ($input)
        {{ $input }}
    @endif
    <div class="space-y-2 mt-2">
        {{ $slot }}
    </div>
</x-ui.card>
