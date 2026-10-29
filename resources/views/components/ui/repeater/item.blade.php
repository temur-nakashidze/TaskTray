@props([
    'deleteHandler' => null,
    'duplicateHandler' => null,
    'footer' => null,
])

<div
        {{ $attributes->class('relative flex flex-col space-x-4 rounded-item bg-white  p-[var(--padding-box-md)] transition-all dark:bg-neutral-800 shadow-[0_0_6px_color-mix(in_srgb,var(--color-neutral-600)_5%,transparent)]
                            dark:shadow-[0_0_10px_color-mix(in_srgb,var(--color-neutral-950)_0%,transparent)]
                            border
                            border-(--color-line-subtle)') }}>
    <div class="flex items-center w-full justify-between">
        <div class="ml-auto flex items-center gap-[var(--gap-form)] mb-[var(--padding-box-md)]">
            @if (filled($duplicateHandler))
                <x-ui.button wire:click="{!! $duplicateHandler !!}" wire:target="{!! $duplicateHandler !!}" size="sm"
                             variant="soft" color="neutral" icon="document-duplicate"/>
            @endif

            @if (filled($deleteHandler))
                <x-ui.button wire:click="{!! $deleteHandler !!}" wire:target="{!! $deleteHandler !!}" size="sm"
                             variant="soft" icon="ps:trash" color="red"
                             class="[&_[data-slot=right-icon]]:text-red-500/85 [&_[data-slot=right-icon]]:hover:text-red-500"/>
            @endif
        </div>
    </div>

    <div class="w-full">
        {{ $slot }}
    </div>

    @if (filled($footer))
        <div {{ $footer->attributes->class('flex items-start -mx-(--item-padding)') }}>
            {{ $footer }}
        </div>
    @endif
</div>
