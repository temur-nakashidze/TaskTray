{{--
    ╔═══════════════════════════════════════════════════════════════════════════════╗
    ║  LAYOUT MAIN WRAPPER                                                          ║
    ║                                                                               ║
    ║  Thin wrapper for the main content area. Forwards all attributes.            ║
    ║  The parent layout handles flex-1, min-h-0, overflow-y-auto.                ║
    ║                                                                               ║
    ║  Usage (as a named slot — preferred):                                        ║
    ║      default $slot in the layout component IS the main area.                 ║
    ║                                                                               ║
    ║  Usage (as a standalone component if using the old data-slot approach):      ║
    ║      <x-ui.layout.main>                                                       ║
    ║          page content                                                         ║
    ║      </x-ui.layout.main>                                                      ║
    ╚═══════════════════════════════════════════════════════════════════════════════╝
--}}

@props(['maxWidth' => '1440px'])

<div data-slot="main" class="flex-1 min-h-0 w-full mx-auto p-(--padding-box-sm)"
     style="max-width: {{ $maxWidth }};">
    {{ $slot }}
</div>
