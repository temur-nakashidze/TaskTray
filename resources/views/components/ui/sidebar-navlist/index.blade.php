@php
    $classes = ['relative flex flex-col w-full gap-y-1'];
@endphp

<div {{ $attributes->class($classes) }} data-slot="sidebar-navlist" x-data="{
    indicator: { top: 0, left: 0, width: 0, height: 0, opacity: 0 },
    ready: false,
    animated: false,
    move(el) {
        if (!this.ready) return;
        const parent = el.closest('[data-slot=sidebar-navlist]');
        const parentRect = parent.getBoundingClientRect();
        const rect = el.getBoundingClientRect();
        this.indicator = {
            top: rect.top - parentRect.top,
            left: rect.left - parentRect.left,
            width: rect.width,
            height: rect.height,
            opacity: 1
        };
        this.$nextTick(() => this.animated = true);
    },
    reset() {
        this.indicator.opacity = 0;
    }
}" @mousemove.once="ready = true"
    @mouseleave="animated = false; indicator.opacity = 0;">

    {{-- Flying box --}}
    <div class="absolute rounded-popup-item bg-neutral-500/10 dark:bg-neutral-300/10  pointer-events-none"
        :style="`top: ${indicator.top}px; left: ${indicator.left}px;
                                                                width: ${indicator.width}px;
                                                                height: ${indicator.height}px;
                                                                opacity: ${indicator.opacity};
                                                                transition: opacity 100ms ease-out, ${animated ? 'top 150ms ease-out, left 150ms ease-out, width 150ms ease-out, height 150ms ease-out' : 'none'};`">
    </div>

    {{ $slot }}
</div>
