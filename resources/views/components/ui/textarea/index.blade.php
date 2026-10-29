@props([
    'disabled' => false,
    'resize' => 'vertical',
    'name' => $attributes->whereStartsWith('wire:model')->first() ?? $attributes->whereStartsWith('x-model')->first(),
    'rows' => null,
    'invalid' => null,
])

@php
    $rows ??= 1;
    $initialHeight = $rows * 0.75 + 1.0;

    $classes = [
        'inline-block font-sans border p-2 w-full text-md tracking-snug-wide  text-(--color-ink-strong) disabled:text-(--color-ink-subtle) placeholder-(--color-ink-muted) disabled:placeholder-(--color-ink-subtle)',
        'bg-white dark:bg-neutral-900/60 dark:disabled:bg-neutral-900/30 disabled:bg-neutral-50',
        'disabled:cursor-default transition-colors duration-200',
        'rounded-input shadow-[inset_0_1px_4px_color-mix(in_srgb,var(--color-neutral-700)_8%,transparent)] dark:shadow-[inset_0_1px_4px_color-mix(in_srgb,var(--color-neutral-950)_40%,transparent)] disabled:shadow-none',
        'focus:ring-2 focus:ring-offset-0 focus:outline-none focus:ring-neutral-600/15 dark:focus:ring-neutral-300/10',
        'border-(--color-line-base) disabled:border-(--color-line-subtle) focus:border-(--color-line-strong)' => !$invalid,
        'border-red-500/80 focus:border-red-500/50' => $invalid,
        match ($resize) {
            'none' => 'resize-none',
            'both' => 'resize',
            'horizontal' => 'resize-x',
            'vertical' => 'resize-y',
        },
    ];
@endphp

<textarea x-data="{
    initialHeightRem: @js($initialHeight),
    get minHeightPx() {
        return this.initialHeightRem * parseFloat(getComputedStyle(document.documentElement).fontSize);
    },
    resize() {
        if (!this.$el) return;

        // Read directly from the element's current value instead of an Alpine state variable
        if (!this.$el.value || this.$el.value.trim() === '') {
            this.$el.style.height = this.initialHeightRem + 'rem';
            return;
        }

        this.$el.style.height = 'auto';
        let scrollHeight = this.$el.scrollHeight;

        if (scrollHeight <= this.minHeightPx) {
            this.$el.style.height = this.initialHeightRem + 'rem';
        } else {
            this.$el.style.height = scrollHeight + 'px';
        }
    }
}" x-init="// Watch for external data changes from Livewire updating the element value
$watch('$el.value', () => $nextTick(() => resize()));

const observer = new ResizeObserver(() => resize());
observer.observe($el);" style="height: {{ $initialHeight }}rem;"
    {{ $attributes->class(Arr::toCssClasses($classes)) }} @disabled($disabled) @if ($invalid)
    aria-invalid="true" data-slot="invalid" @endif data-slot="textarea" rows="{{ $rows }}" name="{{ $name }}"
    x-on:input="resize()" x-on:resize.window="resize()" x-on:keydown="resize()">{{ $slot }}</textarea>
