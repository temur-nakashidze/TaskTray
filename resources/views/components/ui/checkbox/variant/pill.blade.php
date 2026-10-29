@aware([
    'disabled' => null,
    'invalid' => null,
    'size' => null,
    'variant' => null,
    'label' => null,
    'description' => null,
    'indicator' => true,
])

@props([
    'label' => null,
])

<span
        x-bind:data-checked="_checked && !_indeterminate"
        x-bind:data-indeterminate="_indeterminate"

        x-bind:aria-checked="_indeterminate ? 'mixed' : (_checked ? 'true' : 'false')"
        x-bind:aria-invalid="@js($invalid) ? 'true' : null"


        x-ref="checkboxControl"
        x-on:click="toggle()"
        x-on:keydown.space.prevent="toggle()"
        x-on:keydown.enter.prevent="toggle()"

        tabindex="{{ $disabled ? '-1' : '0' }}"
        type="button"
        role="checkbox"

        class="cursor-pointer
        rounded-full data-[checked]:bg-[var(--color-theme-500)] dark:data-[checked]:bg-[var(--color-theme-500)]
        data-[checked]:text-[var(--color-white)]
         text-(--color-ink-base)
        hover:text-(--color-ink-strong)
        hover:bg-neutral-600/25 dark:hover:bg-neutral-300/25
        dark:bg-neutral-300/15 bg-neutral-600/15 text-base font-medium w-fit px-3.5 py-1 transition-colors duration-200
    "
>
{{ $label }}
</span>
    