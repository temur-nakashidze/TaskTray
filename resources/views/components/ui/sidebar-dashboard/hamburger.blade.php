{{--
    ╔═══════════════════════════════════════════════════════════════════════════════╗
    ║  SIDEBAR HAMBURGER BUTTON                                                     ║
    ║                                                                               ║
    ║  Standalone button that opens the sidebar slide-over on mobile.              ║
    ║  Can be placed ANYWHERE in the DOM — it talks to the global                  ║
    ║  Alpine.store('sidebar') directly, so it works regardless of where it        ║
    ║  lives relative to the sidebar component itself.                             ║
    ║                                                                               ║
    ║  Hidden on tablet and above (md:hidden) because on those breakpoints         ║
    ║  the sidebar is always visible in the layout flow.                           ║
    ║                                                                               ║
    ║  Usage:                                                                       ║
    ║      <x-ui.sidebar.hamburger>                                                 ║
    ║          <x-ui.icon name="bars-3" />   ← any content you like               ║
    ║      </x-ui.sidebar.hamburger>                                                ║
    ║                                                                               ║
    ║  All additional attributes (class, wire:click, etc.) are forwarded.          ║
    ╚═══════════════════════════════════════════════════════════════════════════════╝
--}}

@props([])

<button x-data @click="$store.sidebar.toggleMobile()" type="button" class="md:hidden"
        data-slot="dashboard-sidebar-hamburger"
        {{ $attributes }}>
    {{ $slot }}
</button>
