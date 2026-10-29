@props([
    'alignment' => 'start',
    'ariaLabelledby' => null,
    'autofocus' => true,
    'closeButton' => true,
    'closeByClickingAway' => true,
    'closeByEscaping' => true,
    'openEventName' => 'open-modal',
    'closeEventName' => 'close-modal',
    'description' => null,
    'displayClasses' => 'inline-block',
    'footer' => null,
    'header' => null,
    'heading' => null,
    'headerIcon' => null,
    'headerIconVariant' => 'primary',
    'id' => null,
    'slideover' => false,
    'stickyFooter' => false,
    'stickyHeader' => false,
    'trigger' => null,
    'visible' => true,
    'width' => 'lg',
    'backdrop' => 'blur', // blur, dark, transparent
    'persistent' => false, // prevents closing by clicking away or escape
    'animation' => null, // scale, slide, fade
    'position' => 'center', // center, top, bottom
    'bare' => false,
])

@php
    $hasDescription = filled($description);
    $hasFooter = filled($footer);
    $hasHeading = filled($heading);
    $hasIcon = filled($headerIcon);
    $hasSlot = !empty(trim($slot ?? ''));

    // Set default animation based on slideover state
    $animation = $animation ?? ($slideover ? 'slide' : 'scale');

    $modalId = $id ?? 'modal-' . uniqid();

    // Width classes mapping
    $widthClass = match ($width) {
        'xs' => 'max-w-xs',
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        '5xl' => 'max-w-5xl',
        '6xl' => 'max-w-6xl',
        '7xl' => 'max-w-7xl',
        'full' => 'max-w-full',
        'screen-sm' => 'max-w-screen-sm',
        'screen-md' => 'max-w-screen-md',
        'screen-lg' => 'max-w-screen-lg',
        'screen-xl' => 'max-w-screen-xl',
        'screen-2xl' => 'max-w-screen-2xl',
        'screen' => 'fixed inset-0',
        default => $width,
    };

    // Alignment classes
    $alignmentClass = match ($alignment) {
        'start' => 'text-left',
        'center' => 'text-center',
        'end' => 'text-right',
        'left' => 'text-left',
        'right' => 'text-right',
        default => $alignment,
    };

    // Icon color classes
    $iconColorClass = match ($headerIconVariant) {
        'primary' => 'bg-theme-200/30 text-theme-600 dark:bg-theme-900/30 dark:text-theme-300 border border-theme-600/30 dark:border-theme-400/30',
        'accent' => 'bg-accent-200/30 text-accent-600 dark:bg-accent-900/30 dark:text-accent-400 border border-accent-600/30 dark:border-accent-400/30',
        'success' => 'bg-green-200/30 text-green-600 dark:bg-green-900/30 dark:text-green-400 border border-green-600/30 dark:border-green-400/30',
        'warning' => 'bg-yellow-200/30 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-600/30 dark:border-yellow-400/30',
        'danger' => 'bg-red-200/30 text-red-600 dark:bg-red-900/30 dark:text-red-400 border border-red-600/30 dark:border-red-400/30',
        'info' => 'bg-sky-200/30 text-sky-600 dark:bg-sky-900/30 dark:text-sky-400 border border-sky-600/30 dark:border-sky-400/30',
        default => 'bg-white text-primary dark:bg-white/5', // fallback to primary
    };
@endphp

<div x-data="{
    isOpen: false,

    // Configuration
    persistent: @js($persistent),
    closeByClickingAway: @js($closeByClickingAway),
    closeByEscaping: @js($closeByEscaping),
    autofocus: @js($autofocus),

    // Event names
    closeEventName: @js($closeEventName),
    openEventName: @js($openEventName),

    // Modal ID
    modalId: @js($modalId),

    init() {
        // Set up global event listeners
        this.setupEventListeners();

        // Handle autofocus
        this.$watch('isOpen', (value) => {
            if (value && this.autofocus) {
                this.$nextTick(() => {
                    const firstFocusable = this.$refs.modalContent?.querySelector('input, button, select, textarea');
                    if (firstFocusable) {
                        firstFocusable.focus();
                    }
                });
            }

            document.body.style.overflow = value ? 'hidden' : '';

            // Dispatch custom events
            if (value) {
                this.$dispatch('modal-opened', { id: this.modalId });
            } else {
                this.$dispatch('modal-closed', { id: this.modalId });
            }
        });
    },

    setupEventListeners() {
        // Listen for specific modal events
        window.addEventListener(this.closeEventName, (e) => {
            if (e.detail?.id === this.modalId) {
                this.close();
            }
        });

        window.addEventListener(this.openEventName, (e) => {
            if (e.detail?.id === this.modalId) {
                this.open();
            }
        });
    },

    open() {
        this.isOpen = true;
    },

    close() {
        if (this.persistent) return;
        // clean the global $modal store (mandantory even for isolated modals)
        $modal.close(this.modalId);
        this.isOpen = false;
    },
    forseClose() {
        // clean the global $modal store (mandantory even for isolated modals)
        $modal.close(this.modalId);
        this.isOpen = false;
    },

    handleBackdropClick(event) {
        if (this.closeByClickingAway && !this.persistent && event.target === event.currentTarget) {
            // Ensure we're not selecting text
            if (document.activeElement?.selectionStart === undefined &&
                document.activeElement?.selectionEnd === undefined) {
                this.close();
            }
        }
    },

    handleEscapeKey(event) {
        if (event.key === 'Escape' && this.closeByEscaping && !this.persistent) {
            this.close();
        }
    },

    // Public API methods
    toggle() {
        this.isOpen ? this.close() : this.open();
    },

    destroy() {
        this.close();
        document.body.style.overflow = '';
    },
}" x-id="['modal']" x-bind:data-modal-open="isOpen" x-bind:data-modal-id="modalId" @if ($ariaLabelledby)
    aria-labelledby="{{ $ariaLabelledby }}"
     @elseif($hasHeading)
         x-bind:aria-labelledby="$id('modal') + '-heading'"
     @endif

     {{ $attributes->class(['modal-component', $displayClasses, 'hidden' => !$visible]) }}
     x-on:keydown.window="handleEscapeKey($event)"
>
    {{-- Trigger Element --}}
    @if ($trigger)
        <div x-on:click="open()" {{ $trigger->attributes->class('modal-trigger cursor-pointer') }}>
            {{ $trigger }}
        </div>
    @endif

    {{-- Modal Overlay and Content --}}
    <template x-teleport="body">
        <div x-show="isOpen" class="fixed inset-0  overflow-y-auto" aria-modal="true" role="dialog"
             style="display: none;z-index:9999">
            {{-- Backdrop --}}
            <x-ui.modal.backdrop/>

            {{-- Modal Container --}}
            <div data-slot="modal-container" @if ($slideover) data-slideover="true" @endif
            x-on:click="handleBackdropClick($event)" @class([
                    'relative flex min-h-full z-50 items-center justify-center',
                    'p-4' => !$slideover && $width !== 'screen',
                    'items-start pt-16' =>
                        $width !== 'screen' && ($position === 'top' && !$slideover),
                    'items-end pb-16' => $position === 'bottom' && !$slideover,
                    ' overflow-x-hidden' => $slideover,
                ])>
                {{-- Modal Content --}}
                <div x-ref="modalContent" data-slot="modal-contents" x-show="isOpen"
                     @if ($animation === 'scale') x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     @elseif($animation === 'slide')
                         x-transition:enter-start="translate-x-full rtl:-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full rtl:-translate-x-full"
                     @else
                         x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0" @endif
                     @class([
                         'relative flex w-full flex-col bg-white/90 backdrop-blur-lg shadow-xl dark:bg-neutral-850/90',
                         'ring-1 ring-neutral-900/8 dark:ring-neutral-50/8' => !$bare,
                         $widthClass,
                         'rounded-[var(--radius-item)]' => !$slideover && $width !== 'screen',
                         'h-[100vh]' => $slideover || $width === 'screen',
                         'ml-auto ' => $slideover,
                         'overflow-hidden' => $stickyHeader || $stickyFooter,
                     ]) style="display: none;">
                    {{-- close by swap feature --}}
                    <x-ui.modal.grab-handle/>
                    {{-- Header --}}
                    @if ($bare)
                        {{ $slot }}
                    @else
                        @if ($hasHeading || $closeButton)
                            <div @class([
                                'modal-header flex  items-start',
                                'px-6 pb-6 pt-5' => in_array($width, [
                                    'xs',
                                    'sm',
                                    'md',
                                    'lg',
                                    'xl',
                                    '2xl',
                                    '3xl',
                                    '4xl',
                                    'screen-md',
                                    'screen-sm',
                                    'screen-lg',
                                    'screen-xl',
                                    'screen-2xl',
                                ]),
                                'p-8' => in_array($width, ['5xl', '6xl', '7xl', 'full']),
                                'p-12' => $width === 'screen',
                                'relative bg-neutral-200/15 dark:bg-neutral-950/15 border-neutral-300/20 dark:border-neutral-700/20 rounded-t-[var(--radius-item)] ' =>
                                    $hasSlot || $hasFooter,
                                'sticky top-0 z-40 bg-neutral-200/15 dark:bg-neutral-950/15 backdrop-blur-lg' => $stickyHeader,
                                'border-b' => $hasHeading,
                                $alignmentClass,
                            ])>
                                <div class="w-full flex items-center">
                                    @if ($hasIcon)
                                        <div class="mr-4 flex-shrink-0">
                                            <div @class(['rounded-[var(--radius-button)] p-3 ', $iconColorClass])>
                                                <x-ui.icon :name="$headerIcon" size="lg"/>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($hasHeading || $hasDescription)
                                        <div class="flex-1 min-w-0">
                                            @if ($hasHeading)
                                                <x-ui.heading size="xl" :uppercase="true" weight="semibold"
                                                              x-bind:id="$id('modal') + '-heading'" muted>
                                                    {{ $heading }}
                                                </x-ui.heading>
                                            @endif

                                            @if ($hasDescription)
                                                <p class="mt-1 text-sm text-(--color-ink-muted)  ">
                                                    {{ $description }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>


                                {{-- Close Button --}}
                                @if ($closeButton)
                                    <x-ui.button
                                            class="absolute -top-2 -right-3 focus:outline-none focus-visible:outline-none focus:ring-0"
                                            x-on:click="$data.close();" variant="soft" :icon="null" size="sm"
                                            color="neutral" icon-after="x-mark"/>
                                @endif
                            </div>
                        @endif

                        {{-- ACTUAL SLOT CONTENTS --}}
                        @if ($hasSlot)
                            <div @class([
                                'modal-content text-sm flex-1 px-6 py-6 min-h-0  text-(--color-ink-strong)',
                                'overflow-y-auto' =>
                                    $slideover || $width === 'screen' || $stickyFooter || $stickyHeader,
                                'max-h-[calc(100vh-13.8rem)]' =>
                                    ($stickyHeader || $stickyFooter) && !$slideover && $width !== 'screen',
                            ])>
                                {{ $slot }}
                            </div>
                        @endif

                        {{-- FOOTER --}}
                        @if ($hasFooter)
                            <div @class([
                                'modal-footer px-4 py-4 bg-neutral-200/15 dark:bg-neutral-950/15 rounded-b-[var(--radius-item)]',
                                'border-t border-neutral-300/20 dark:border-neutral-700/20',
                                'sticky bottom-0 z-10 bg-neutral-200/15 dark:bg-neutral-950/15 backdrop-blur-lg ' => $stickyFooter,
                                'flex flex-wrap gap-3',
                            ])>
                                {{ $footer }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </template>
</div>
