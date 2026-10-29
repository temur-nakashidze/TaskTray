{{--
    ╔═══════════════════════════════════════════════════════════════════════════════╗
    ║  LAYOUT HEADER WRAPPER                                                        ║
    ║                                                                               ║
    ║  Thin wrapper — passes through all attributes and forwards $slot.            ║
    ║  The layout component (header-only / header-sidebar / sidebar-main)          ║
    ║  handles all sticky/z-index behaviour on this element.                       ║
    ║                                                                               ║
    ║  Usage (as a named slot inside a layout):                                    ║
    ║      <x-slot:header>                                                          ║
    ║          <livewire:my-header />                                               ║
    ║      </x-slot:header>                                                         ║
    ║                                                                               ║
    ║  Or as a standalone component if targeting via data-slot:                    ║
    ║      <x-ui.layout.header>                                                     ║
    ║          <livewire:my-header />                                               ║
    ║      </x-ui.layout.header>                                                    ║
    ╚═══════════════════════════════════════════════════════════════════════════════╝
--}}

@props([])

<x-ui.card {{ $attributes }} data-slot="header"
           class="w-full px-8 sticky top-2 z-60 isolation-isolate backdrop-blur-lg rounded-2xl mb-8"
           style="view-transition-name: layout-header;" data-slot="header" x-data x-init="const layout = $el.closest('[data-slot=layout]');
            const update = () => layout.style.setProperty('--header-height', ($el.offsetHeight + 16) + 'px');
            update();
            new ResizeObserver(update).observe($el);">
    {{ $slot }}
</x-ui.card>
