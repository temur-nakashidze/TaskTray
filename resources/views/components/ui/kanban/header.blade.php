@props([
    'count' => null,
    'icon' => null,
    'header' => 'header',
    'iconName' => 'ps:tray',
])
<div class="px-2 pt-2 row-start-1 ">
    <div class="flex items-center justify-between ml-3">
        <x-ui.heading size="xl" font="mono" class="Capitalize" color="theme"
            weight="semibold">{{ $header }}</x-ui.heading>

        <div class="relative">
            @if ($icon)
                <x-ui.icon name="{{ $iconName }}" variant="thin"
                    class="size-11.5 text-(--color-theme-600)/30 dark:text-(--color-theme-400)/30" />
            @endif

            @if ($count !== null)
                <span
                    class="absolute inset-0 -translate-y-1 font-mono flex items-center justify-center text-sm text-(--color-theme-600) dark:text-(--color-theme-200) font-medium">
                    {{ $count }}
                </span>
            @endif
        </div>
    </div>
    @if ($slot)
        <div class="pt-2">
            {{ $slot }}
        </div>
    @endif
</div>
