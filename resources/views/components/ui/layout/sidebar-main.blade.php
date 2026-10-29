{{--
    ╔═══════════════════════════════════════════════════════════════════════════════╗
    ║  LAYOUT 3 — FULL WIDTH WITH SIDEBAR                                           ║
    ║                                                                               ║
    ║  Full-width layout — no global max-width.                                    ║
    ║  Sidebar runs full viewport height on the left.                              ║
    ║  Header is scoped to the right column only (not above the sidebar).          ║
    ║  Only the content area has a configurable max-width.                         ║
    ║                                                                               ║
    ║  Structure:                                                                   ║
    ║      ┌──────────┬──────────────────────────────────────┐                     ║
    ║      │          │       HEADER (sticky)                │                     ║
    ║      │ SIDEBAR  ├──────────────────────────────────────┤                     ║
    ║      │(full ht) │  ┌────────────────────────────────┐  │                     ║
    ║      │          │  │   MAIN (max-width, scrollable) │  │                     ║
    ║      │          │  └────────────────────────────────┘  │                     ║
    ║      └──────────┴──────────────────────────────────────┘                     ║
    ║                                                                               ║
    ║  Props:                                                                       ║
    ║  • maxWidth (string, default '1600px') — constrains main content only        ║
    ║                                                                               ║
    ║  Slots:                                                                       ║
    ║  • $sidebar — sidebar component (use <x-ui.sidebar>)                         ║
    ║  • $header  — header scoped to the right column                               ║
    ║  • $slot    — main scrollable content (wrapped in max-width)                  ║
    ║                                                                               ║
    ║  Usage:                                                                       ║
    ║      <x-ui.layout.sidebar-main>                                               ║
    ║          <x-slot:sidebar>                                                     ║
    ║              <x-ui.sidebar>...</x-ui.sidebar>                                 ║
    ║          </x-slot:sidebar>                                                    ║
    ║                                                                               ║
    ║          <x-slot:header>                                                      ║
    ║              <livewire:my-header />                                           ║
    ║          </x-slot:header>                                                     ║
    ║                                                                               ║
    ║          main content here                                                    ║
    ║      </x-ui.layout.sidebar-main>                                              ║
    ╚═══════════════════════════════════════════════════════════════════════════════╝
--}}

@props(['maxWidth' => '100%'])

{{--
    Full-width layout — no global max-width wrapper.
    The PAGE scrolls naturally — scrollbar at browser edge.
    Sidebar: sticky top-0, manages own height.
    Header: inside the right column, sticky top-0.
    Main: flows with the page, content centered in max-width.
--}}
<div class="min-h-screen w-full flex items-start gap-[var(--gap-card)] [--header-height:0rem]"
    x-bind:class="$sidebar.isMobile ?? 'gap-0'" data-slot="layout" data-layout="sidebar-main">

    @isset($sidebar)
        <div class="sticky z-20 top-0 ">
            {{ $sidebar }}
        </div>
    @endisset

    <div class="flex-1 min-w-0 flex flex-col rounded-none p-0! overflow-y-auto h-screen bg-(--color-neutral-50)/70 dark:bg-(--color-neutral-850)/50  border-l border-(--color-line-subtle)"
        data-slot="main">

        @isset($header)
            <div class="sticky z-50 bg-(--color-neutral-50)/30 dark:bg-(--color-neutral-850)/30 backdrop-blur top-0 shrink-0 border-b border-(--color-line-subtle) py-(--padding-box-sm) px-(--padding-box-lg) min-h-16"
                style="view-transition-name: layout-header;" data-slot="header">
                {{ $header }}
            </div>
        @endisset
        <div class="flex-1 min-h-0 w-full mx-auto" style="max-width: {{ $maxWidth }};">
            {{ $slot }}
        </div>
    </div>

</div>
