{{--
    ╔═══════════════════════════════════════════════════════════════════════════════╗
    ║  LAYOUT 2 — HEADER + SIDEBAR                                                  ║
    ║                                                                               ║
    ║  Structure (all inside global max-width):                                    ║
    ║      ┌──────────────────────────────────────┐  ← max-width (default 1600px)  ║
    ║      │           HEADER (sticky)            │                                 ║
    ║      ├──────────┬───────────────────────────┤                                 ║
    ║      │ SIDEBAR  │  MAIN (scrollable)        │                                 ║
    ║      │(sticky)  │                           │                                 ║
    ║      └──────────┴───────────────────────────┘                                 ║
    ║                                                                               ║
    ║  Props:                                                                       ║
    ║  • maxWidth (string, default '1600px') — constrains entire layout            ║
    ║                                                                               ║
    ║  Slots:                                                                       ║
    ║  • $header  — sticky header spanning full width                               ║
    ║  • $sidebar — sidebar component (use <x-ui.sidebar>)                         ║
    ║  • $slot    — main scrollable content                                         ║
    ║                                                                               ║
    ║  Usage:                                                                       ║
    ║      <x-ui.layout.header-sidebar>                                             ║
    ║          <x-slot:header>                                                      ║
    ║              <livewire:my-header />                                           ║
    ║          </x-slot:header>                                                     ║
    ║                                                                               ║
    ║          <x-slot:sidebar>                                                     ║
    ║              <x-ui.sidebar scrollable>                                        ║
    ║                  <x-slot:footer>...</x-slot:footer>                           ║
    ║                  nav content                                                  ║
    ║              </x-ui.sidebar>                                                  ║
    ║          </x-slot:sidebar>                                                    ║
    ║                                                                               ║
    ║          main content here                                                    ║
    ║      </x-ui.layout.header-sidebar>                                            ║
    ╚═══════════════════════════════════════════════════════════════════════════════╝
--}}

@props(['maxWidth' => '1440px'])

{{--
    The PAGE scrolls naturally — scrollbar at browser edge.
    Header: sticky top-0 on the document flow.
    Sidebar: sticky below the header, scrolls independently inside itself.
    Main: flows normally with the page.

    CSS variable --header-height (default 4rem) is used by the sidebar
    to know where to stick. Override it on the layout div if your header
    is a different height:
        style="--header-height: 5rem; max-width: 1600px;"
--}}
<div class="min-h-screen w-full mx-auto" style="max-width: {{ $maxWidth }};" data-slot="layout"
     data-layout="header-sidebar">

    {{-- ── Sticky header ──────────────────────────────────────────────────── --}}
    @isset($header)
        <x-ui.layout.header>
            {{ $header }}
        </x-ui.layout.header>
    @endisset

    {{-- ── Content row: sidebar + main ───────────────────────────────────── --}}
    <div class="flex items-stretch">
        {{-- Sidebar sticks below header, manages own height/scroll --}}
        @isset($sidebar)
            {{ $sidebar }}
        @endisset

        {{-- Main flows with the page --}}
        <div class="flex-1 min-w-0 h-full overflow-y-auto" data-slot="main">
            {{ $slot }}
        </div>

    </div>

</div>
