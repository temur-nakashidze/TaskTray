{{--
    ╔═══════════════════════════════════════════════════════════════════════════════╗
    ║  SIDEBAR TOGGLE BUTTON                                                        ║
    ║                                                                               ║
    ║  Placed INSIDE the sidebar to collapse/expand its width.                     ║
    ║  Talks to Alpine.store('sidebar').toggle().                                  ║
    ║  Hidden on mobile (sidebar uses slide-over there, not collapse).             ║
    ║                                                                               ║
    ║  Usage:                                                                       ║
    ║      <x-ui.sidebar.toggle>                                                    ║
    ║          <x-ui.icon name="chevron-left" />                                    ║
    ║      </x-ui.sidebar.toggle>                                                   ║
    ╚═══════════════════════════════════════════════════════════════════════════════╝
--}}

@props([])

<x-ui.button x-data @click="$store.sidebar.toggle()"
             data-slot="sidebar-toggle" icon="ps:sidebar" squared>
</x-ui.button>
