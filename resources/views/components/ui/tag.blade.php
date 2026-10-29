@props(['name', 'color'])
<x-ui.badge icon="ps:tag" class="flex items-center gap-1 " color="{{ $color }}" variant="soft" size="sm">
    {{ $name }}
</x-ui.badge>
