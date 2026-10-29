{{--
    ╔═══════════════════════════════════════════════════════════════════════════════╗
    ║  LAYOUT 1 — HEADER ONLY                                                       ║
    ║                                                                               ║
    ║  Structure:                                                                   ║
    ║      ┌──────────────────────────────────────┐  ← max-width (default 1600px)  ║
    ║      │           HEADER (sticky)            │                                 ║
    ║      ├──────────────────────────────────────┤                                 ║
    ║      │         MAIN (scrollable)            │                                 ║
    ║      └──────────────────────────────────────┘                                 ║
    ║                                                                               ║
    ║  Props:                                                                       ║
    ║  • maxWidth (string, default '1600px') — constrains both header and main     ║
    ║                                                                               ║
    ║  Slots:                                                                       ║
    ║  • $header — sticky header content                                            ║
    ║  • $slot   — main scrollable content                                          ║
    ║                                                                               ║
    ║  Usage:                                                                       ║
    ║      <x-ui.layout.header-only>                                                ║
    ║          <x-slot:header>                                                      ║
    ║              <livewire:my-header />                                           ║
    ║          </x-slot:header>                                                     ║
    ║          page content here                                                    ║
    ║      </x-ui.layout.header-only>                                               ║
    ╚═══════════════════════════════════════════════════════════════════════════════╝
--}}

@props(['maxWidth' => '1440px'])

{{--
    The PAGE scrolls naturally — scrollbar is always at the browser edge.
    Header sticks via position:sticky on the normal document flow.
    No overflow-hidden, no isolated scroll containers.
--}}
<div class="min-h-screen w-full mx-auto " style="max-width: {{ $maxWidth }};" data-slot="layout"
     data-layout="header-only">

    @isset($header)
        <div class="sticky top-2 z-50 isolation-isolate backdrop-blur-lg mb-8"
             style="view-transition-name: layout-header;"
             data-slot="header">
            {{ $header }}
        </div>
    @endisset

    <div data-slot="main">
        {{ $slot }}
    </div>

</div>
