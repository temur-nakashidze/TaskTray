@aware([
    'label',
    'clearable' => false
])

@props([
    'placeholder' => 'Search...',
    'label' => 'command pallete',
    'icon' => 'magnifying-glass',
    'clearable' => false,
])


<div
        {{ $attributes->class("flex justify-between items-center border-b border-(--color-line-subtle) px-3 py-1") }}
>
    <span class="sr-only">{{ $label }}</span>

    @if ($icon instanceof \Illuminate\View\ComponentSlot)
        {{ $icon }}
    @else
        <x-ui.icon :name="$icon" :variant="$attributes->get('icon:variant')"/>
    @endif

    <input
            data-slot="input"
            placeholder="{{ $placeholder }}"
            class="flex w-full rounded-md bg-transparent pl-3 min-h-10 border-none focus:outline-none focus:ring-0 py-3 text-sm outline-none placeholder:text-(--color-ink-muted) disabled:cursor-not-allowed disabled:opacity-50"
            type="text"
            x-rover:input
            autocomplete="off"
            aria-autocomplete="list"
            autocorrect="off"
    />

    @if($clearable)
        <button
                type="button"
                class="hover:bg-neutral-200/20 dark:hover:bg-neutral-600/20 transition-colors duration-150 p-1 rounded-button"
                x-on:click="$rover.input.reset()"
        >
            <x-ui.icon name="x-mark" variant="mini"/>
        </button>
    @endif
</div>