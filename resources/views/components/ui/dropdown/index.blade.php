@props([
    'position' => 'bottom-center',
    'teleport' => 'body',
    'portal' => false,
    'trap' => false,
    'offset' => 6,
    'checkbox' => false,
    'radio' => false,
    'resetFocus' => false,
])

@php
    $isDefaultDropdownVariant = $checkbox || $radio;
    $classes = [
        'isolate z-90 backdrop-blur',
        'grid grid-cols-[auto_1fr_auto]' => !$isDefaultDropdownVariant,
        'grid grid-cols-[auto_auto_1fr_auto]' => $isDefaultDropdownVariant,
        '[:where(&)]:max-w-96 [:where(&)]:min-w-40 text-start',
        'bg-white/40 dark:bg-(--color-neutral-900)/40 border border-black/12 dark:border-white/10',
        'rounded-popup p-2  shadow-md shadow-neutral-950/5 dark:shadow-neutral-950/15',
    ];

    $safeId = $attributes->get('id') ?? ($attributes->wire('key')->value() ?? 'dropdown-' . str()->random(8));
@endphp

<div {{ $attributes }}>
    <div x-data="{
        open: false,
        resetFocus: @js($resetFocus),
    
        init() {
            // ✅ global mousedown handles both portal and non-portal cases
            // checks button AND panel so clicks inside (checkboxes etc) don't close
            window.addEventListener('mousedown', (e) => {
                if (!this.open) return
    
                const button = this.$refs.button
                const panel = this.$refs.panel
    
                if (button && button.contains(e.target)) return
                if (panel && panel.contains(e.target)) return
    
                this.close()
            })
        },
    
        toggle() {
            if (this.open) {
                return this.close()
            }
    
            $focus.getFirst().focus()
            this.open = true
        },
        isOpen() {
            return this.open
        },
        close(focusAfter) {
            if (!this.open) return
    
            this.open = false
    
            focusAfter && this.resetFocus && requestAnimationFrame(() => $focus.getFirst().focus())
        },
    
        handleFocusInOut(event) {
            const panel = this.$refs.panel
            const button = this.$refs.button
            const target = event.target
    
            if (!panel || !button) return
    
            if (panel.contains(target) || button.contains(target)) return
    
            const lastFocusedElement = document.activeElement
    
            if (this.shouldCloseDropdown(button, panel, lastFocusedElement)) this.close(button)
        },
        shouldCloseDropdown(button, panel, lastFocusedElement) {
            return (!button.contains(lastFocusedElement) && !panel.contains(lastFocusedElement)) &&
                (lastFocusedElement && (button.compareDocumentPosition(lastFocusedElement) & Node.DOCUMENT_POSITION_FOLLOWING))
        },
    
    }" wire:ignore x-on:keydown.escape.prevent.stop="close($refs.button)"
        x-on:focusin.window="handleFocusInOut($event)" x-id="['dropdown-button']" class="relative">

        <div x-ref="button" {{ $button->attributes->class('inline-flex') }}
            x-on:keydown.tab.prevent.stop="$focus.focus($focus.within($refs.panel).getFirst())"
            x-on:keydown.down.prevent.stop="$focus.focus($focus.within($refs.panel).getFirst())"
            x-on:keydown.space.stop.prevent="toggle()" x-on:keydown.enter.stop.prevent="toggle()"
            x-on:click.stop="toggle()" x-bind:aria-expanded="open" x-bind:data-open="open"
            x-bind:aria-controls="$id('dropdown-button')">
            {{ $button }}
        </div>

        @if ($portal)
            <template x-teleport="{{ $teleport }}" wire:key="portal-template-{{ $safeId }}">
        @endif

        <div x-show="open" @if ($trap) x-trap="open" @endif x-ref="panel" wire:ignore.self
            x-anchor.{{ $position }}.offset.{{ $offset }}="$refs.button;"
            x-on:keydown.down.prevent.stop="$focus.next()" x-on:keydown.up.prevent.stop="$focus.prev()"
            x-on:keydown.home.prevent.stop="$focus.first()" x-on:keydown.page-up.prevent.stop="$focus.first()"
            x-on:keydown.end.prevent.stop="$focus.last()" x-on:keydown.page-down.prevent.stop="$focus.last()"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            x-bind:id="$id('dropdown-button')" style="display: none;"
            @if ($radio) role="radiogroup" @else role="menu" @endif
            {{ $menu->attributes->class(Arr::toCssClasses($classes)) }}>
            {{ $menu }}
        </div>

        @if ($portal)
            </template>
        @endif
    </div>
</div>
