@props([
    'position' => 'bottom-start',
    'teleport' => 'body',
    'portal' => false,
    'trap' => false,
    'offset' => 6,
    'checkbox' => false,
    'radio' => false,
    'resetFocus' => false,
])

@php
    // Normalize position aliases to standard Floating UI / Alpine Anchor position strings
    $anchorPosition = match ($position) {
        'bottom-left' => 'bottom-start',
        'bottom-center' => 'bottom',
        'bottom-right' => 'bottom-end',
        'top-left' => 'top-start',
        'top-center' => 'top',
        'top-right' => 'top-end',
        'left-top' => 'left-start',
        'left-center' => 'left',
        'left-bottom' => 'left-end',
        'right-top' => 'right-start',
        'right-center' => 'right',
        'right-bottom' => 'right-end',
        default => $position,
    };

    $isDefaultDropdownVariant = $checkbox || $radio;
    $classes = [
        ' z-50',
        'grid grid-cols-[auto_1fr_auto]' => !$isDefaultDropdownVariant,
        'grid grid-cols-[auto_auto_1fr_auto]' => $isDefaultDropdownVariant,
        '[:where(&)]:max-w-96 [:where(&)]:min-w-40 text-start',
        'bg-white/40 dark:bg-(--color-neutral-900)/40 backdrop-blur border border-black/10 dark:border-white/10',
        'rounded-popup p-2 space-y-1 shadow-md shadow-neutral-950/5 dark:shadow-neutral-950/15',
    ];
@endphp

<div {{ $attributes->class(['w-full']) }}>
    <div x-data="{
        open: false,
        id: $id('context-menu'),
        main: null,
    
        init() {
            this.main = document.querySelector('[data-slot=\'main\']');
        },
    
        openContextMenu(event) {
            event.preventDefault();
    
            $dispatch('context-menu-opened', { id: this.id });
    
            this.$refs.anchor.style.left = event.clientX + 'px';
            this.$refs.anchor.style.top = event.clientY + 'px';
    
            this.open = true;
    
            if (this.main) {
                this.main.style.overflowY = 'hidden';
            }
        },
    
        close(focusAfter) {
            if (!this.open) return;
    
            this.open = false;
    
            if (this.main) {
                this.main.style.overflowY = '';
            }
    
            focusAfter && focusAfter.focus();
        }
    }" x-id="['context-menu']"
        x-on:context-menu-opened.window="if ($event.detail.id !== id) close()" x-on:keydown.escape.prevent.stop="close()"
        wire:key="context-{{ uniqid() }}" class="relative w-full">
        <!-- Trigger Area -->
        <div x-on:contextmenu.prevent.stop="openContextMenu($event)" {{ $trigger->attributes->class(['w-full']) }}>
            {{ $trigger }}
        </div>

        <!-- Hidden anchor point placed dynamically at cursor location -->
        <div x-ref="anchor" class="fixed pointer-events-none" style="z-index: -1; width: 1px; height: 1px;"></div>

        @if ($portal)
            <template x-teleport="{{ $teleport }}" wire:key="context-portal-{{ uniqid() }}">
        @endif
        <div x-show="open" x-ref="panel" x-anchor.{{ $anchorPosition }}.offset.{{ $offset }}="$refs.anchor"
            x-trap.noscroll="open" x-on:keydown.down.prevent.stop="$focus.wrap().next()"
            x-on:keydown.up.prevent.stop="$focus.wrap().prev()" x-on:keydown.home.prevent.stop="$focus.first()"
            x-on:keydown.page-up.prevent.stop="$focus.first()" x-on:keydown.end.prevent.stop="$focus.last()"
            x-on:keydown.page-down.prevent.stop="$focus.last()" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" x-on:click.away="close()" x-bind:id="id"
            style="display: none;" {{ $menu->attributes->class($classes) }}>
            {{ $menu }}
        </div>
        @if ($portal)
            </template>
        @endif
    </div>
</div>
