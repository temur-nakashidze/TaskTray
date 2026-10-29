@props([
    'disabled' => false,
    'resize' => 'vertical',
    'name' => $attributes->whereStartsWith('wire:model')->first() ?? $attributes->whereStartsWith('x-model')->first(),
    'rows' => null,
    'invalid' => null,
])

@php
    $rows ??= 3;
    $initialHeight = $rows * 0.75 + 1.0;

    $classes = [
        'inline-block font-sans w-full outline-none! text-md tracking-snug-wide text-(--color-ink-strong) disabled:text-(--color-ink-subtle) placeholder-(--color-ink-subtle) disabled:placeholder-(--color-ink-subtle)',
        match ($resize) {
            'none' => 'resize-none',
            'both' => 'resize',
            'horizontal' => 'resize-x',
            'vertical' => 'resize-y',
        },
    ];
@endphp

<div x-data="{
    initialHeightRem: @js($initialHeight),
    isEmpty: true,
    bump: false,
    focused: false,
    get minHeightPx() {
        return this.initialHeightRem * parseFloat(getComputedStyle(document.documentElement).fontSize);
    },
    resize() {
        const el = this.$refs.textarea;
        if (!el) return;

        this.isEmpty = !el.value || el.value.trim() === '';

        if (this.isEmpty) {
            el.style.height = this.initialHeightRem + 'rem';
            return;
        }

        el.style.height = 'auto';
        let scrollHeight = el.scrollHeight;

        el.style.height = scrollHeight <= this.minHeightPx ?
            this.initialHeightRem + 'rem' :
            scrollHeight + 'px';
    }
}" x-init="$watch('$refs.textarea.value', () => $nextTick(() => resize()));
const observer = new ResizeObserver(() => resize());
observer.observe($refs.textarea);
setTimeout(() => resize(), 50);" class="relative">


    <div class="relative mb-2">
        <div class="transition-opacity duration-200 ease-in-out" x-bind:style="focused ? 'opacity: 0' : 'opacity: 1'">
            <x-ui.line-divider opacity="15" gap="6" dash="16" />
        </div>
        <div x-cloak class="absolute inset-0 transition-opacity duration-200 ease-in-out"
            x-bind:style="focused ? 'opacity: 1' : 'opacity: 0'">
            <x-ui.line-divider opacity="45" gap="4" dash="26" />
        </div>
    </div>


    <textarea x-ref="textarea" style="height: {{ $initialHeight }}rem;"
        {{ $attributes->class(Arr::toCssClasses($classes)) }} @disabled($disabled)
        @if ($invalid) aria-invalid="true" data-slot="invalid" @endif data-slot="textarea"
        rows="{{ $rows }}" name="{{ $name }}" x-on:input="resize()" x-on:resize.window="resize()"
        x-on:keydown="resize()" x-on:focus="focused = true" x-on:blur="focused = false"
        x-on:keydown.enter="if ($event.shiftKey) { return; } $event.preventDefault(); bump = true; setTimeout(() => bump = false, 250); $el.closest('form')?.requestSubmit();"></textarea>

    @isset($placeholder)
        <div x-show="isEmpty"
            class="absolute top-2.5 pointer-events-none flex items-center gap-1 text-(--color-ink-subtle)">
            {{ $placeholder }}
        </div>
    @endisset

    <div x-show="!isEmpty" x-cloak class="absolute right-2 top-3.5 pointer-events-none">
        <x-ui.icon name="ps:key-return" class="size-5 transition-all"
            x-bind:style="bump
                ?
                'transform: scale(1.16); transition-duration: 20ms; transition-timing-function: ease-in-out;' :
                'transform: scale(1); transition-duration: 120ms; transition-timing-function: ease-in-out;'"
            x-bind:class="bump ? 'text-(--color-ink-strong)' : 'text-(--color-ink-subtle)'" />
    </div>

    <div class="relative mt-1">
        <div class="transition-opacity duration-200 ease-in-out" x-bind:style="focused ? 'opacity: 0' : 'opacity: 1'">
            <x-ui.line-divider opacity="15" gap="6" dash="16" />
        </div>
        <div x-cloak class="absolute inset-0 transition-opacity duration-200 ease-in-out"
            x-bind:style="focused ? 'opacity: 1' : 'opacity: 0'">
            <x-ui.line-divider opacity="45" gap="4" dash="26" />
        </div>
    </div>

</div>
