@props([
    'collapsable' => false,
    'variant' => 'default',
    'label' => false,
])

@php

    $classes = ['flex flex-col gap-y-1 mt-4'];
@endphp

<div {{ $attributes->class($classes) }} data-slot="sidebar-navlist-group" x-data="{
    expanded: true,
    expand() {
        this.expanded = !this.expanded;
    }
}">
    @switch($variant)
        @case('compact')
            <x-ui.sidebar-navlist.group.variant.compact
                    :$collapsable {{-- using @aware in this case isn't proper way !  --}}>
                {{ $slot }}
            </x-ui.sidebar-navlist.group.variant.compact>
            @break

        @default
            <x-ui.sidebar-navlist.group.variant.default
                    :$collapsable {{-- using @aware in this case isn't proper way !  --}}>
                {{ $slot }}
            </x-ui.sidebar-navlist.group.variant.default>
    @endswitch
</div>
