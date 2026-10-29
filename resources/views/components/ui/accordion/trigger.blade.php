@aware([
    'disabled' => false,
    'reverse' => false,
])

<button x-on:disabled($disabled)
        {{ $attributes->class(Arr::toCssClasses(['flex w-full items-center gap-2 justify-start px-6 py-4 text-xl font-bold text-(--color-ink-strong)', 'cursor-pointer' => !$disabled, 'flex-row-reverse' => $reverse])) }}
        x-on:click="toggle()" x-bind:aria-expanded="isVisible">
    <span class="flex-1 text-start font-semibold text-base">{{ $slot }}</span>
    <span :class="isVisible ? 'rotate-180' : ''" class="rotate-on-expand transition-transform duration-200">
        <x-ui.icon class="size-5" name="chevron-down"/>
    </span>
</button>
