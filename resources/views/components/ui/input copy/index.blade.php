@props([
    'name' => $attributes->whereStartsWith('wire:model')->first() ?? $attributes->whereStartsWith('x-model')->first(),
    'prefix' => null,
    'suffix' => null,
    'leftIcon' => null,
    'rightIcon' => null,
    'prefixIcon' => null,
    'suffixIcon' => null,
    'clearable' => null,
    'copyable' => null,
    'revealable' => null,
    'invalid' => null,
    'type' => 'text',
    'mask' => null,
    'size' => null,
    'kbd' => null,
    'as' => null,
    'bindScopeToParent' => false,
])

@php

    $invalid ??= $name && $errors->has($name);

    $classes = [
        'isolate',
        'relative flex items-stretch w-full shadow-inner  disabled:shadow-none  transition-colors duration-200',
        'rounded-input min-h-10',
        '[&:has([data-slot=input-prefix])_input]:rounded-l-none',
        '[&:has([data-slot=input-suffix])_input]:rounded-r-none',
        '[&:has([data-slot=input-prefix]):has([data-slot=input-suffix])_input]:rounded-none',
    ];

    $hasLeftIconSlot = $leftIcon instanceof \Illuminate\View\ComponentSlot;
    $hasLeftIcon = filled($leftIcon);
    $hasRightIconSlot = $rightIcon instanceof \Illuminate\View\ComponentSlot;
    $asButton = $as === 'button';
    $hasModelLive = str(
        collect($attributes->whereStartsWith('wire:model')->getAttributes())
            ->keys()
            ->first() ?? '',
    )->contains('live');

    $iconCount = count(array_filter([$clearable, $copyable, $revealable, $rightIcon || $hasModelLive]));

    $hasClickAction = filled($attributes->whereStartsWith('wire:click')->first());
    $hasWireLoading = filled($attributes->whereStartsWith('wire:loading')->first());
    $loadingAttributes = new \Illuminate\View\ComponentAttributeBag();
    if ($hasWireLoading || $hasClickAction || $hasModelLive) {
        $loadingAttributes = $loadingAttributes->merge([
            'wire:loading.attr' => 'data-loading',
            'wire:target' => $attributes->has('wire:target')
                ? $attributes->get('wire:target')
                : $attributes->whereStartsWith('wire:click')->first() ??
                    $attributes->whereStartsWith('wire:model')->first(),
        ]);
    }
@endphp

<div class="{{ Arr::toCssClasses(array_merge($classes, [$attributes->get('class')])) }}">
    {{-- HANDLE PREFIX SLOTS --}}
    @if (filled($prefix) || filled($prefixIcon))
        <x-ui.input.extra-slot data-slot="input-prefix" class="border-r-0">
            @if ($prefix instanceof \Illuminate\View\ComponentSlot)
                {{ $prefix }}
            @elseif ($prefixIcon)
                <x-ui.icon name="{{ $prefixIcon }}"/>
            @endif
        </x-ui.input.extra-slot>
    @endif

    <div @unless ($bindScopeToParent)
             x-data
            @endunless
            @class([
            'w-full grid isolate',

            '[&:not(:has([data-slot=left-icon]))>[data-slot=input-actions]]:col-start-2',
            '[&:has([data-slot=left-icon])>[data-slot=input-actions]]:col-start-3',

            '[&>[data-slot=input-actions]]:row-start-1',
            '[&>[data-slot=input-actions]]:place-self-center',
            '[&>[data-slot=input-actions]]:z-10',

            '[&>[data-slot=control]]:col-start-1',
            '[&>[data-slot=control]]:row-start-1',
            '[&>[data-slot=control]]:col-span-3',

            '[&:has([data-slot=left-icon])>[data-slot=left-icon]]:col-start-1',
            '[&:has([data-slot=left-icon])>[data-slot=left-icon]]:row-start-1',
            '[&:has([data-slot=left-icon])>[data-slot=left-icon]]:place-self-center',
            '[&:has([data-slot=left-icon])>[data-slot=left-icon]]:!z-20',

            '[&:has([data-slot=left-icon])>[data-slot=control]]:pl-[2.2rem]',

            '[&:has([data-slot=input-actions]):has([data-slot=input-option])>[data-slot=control]]:pr-[1.9rem]',
            '[&:has([data-slot=input-actions]):has([data-slot=input-option]+[data-slot=input-option])>[data-slot=control]]:pr-[3.8rem]',
            '[&:has([data-slot=input-actions]):has([data-slot=input-option]+[data-slot=input-option]+[data-slot=input-option])>[data-slot=control]]:pr-[5.7rem]',
            '[&:has([data-slot=input-actions]):has([data-slot=input-option]+[data-slot=input-option]+[data-slot=input-option]+[data-slot=input-option])>[data-slot=control]]:pr-[7.6rem]',
        ])
            @style(['--icon-count: ' . $iconCount, '--icon-width: 2rem', 'grid-template-columns: 1fr calc(var(--icon-width) * var(--icon-count))' => !$hasLeftIcon, 'grid-template-columns: 2.3rem 1fr calc(var(--icon-width) * var(--icon-count))' => $hasLeftIcon])>

        @if ($hasLeftIcon)
            <div class="!text-neutral-500 dark:!text-neutral-500" data-slot="left-icon">
                @if ($hasLeftIconSlot)
                    {{ $leftIcon }}
                @else
                    <x-ui.icon :name="$leftIcon" class="!size-[1.15rem]"/>
                @endif
            </div>
        @endif

        <input @class([
            'z-10',
            'inline-block border p-2 w-full text-sm text-(--color-ink-strong) disabled:text-(--color-ink-subtle) placeholder-(--color-ink-subtle) disabled:placeholder-(--color-ink-subtle)',
            'bg-white dark:bg-neutral-900/80  dark:disabled:bg-neutral-900/30 disabled:bg-neutral-50',
            'disabled:cursor-default transition duration-200 ease-in-out',
            'rounded-input shadow-[inset_0_1px_4px_color-mix(in_srgb,var(--color-neutral-700)_8%,transparent)] dark:shadow-[inset_0_1px_4px_color-mix(in_srgb,var(--color-neutral-950)_40%,transparent)] disabled:shadow-none',
            'focus:ring-2 focus:ring-offset-0 focus:outline-none focus:ring-neutral-600/15 dark:focus:ring-neutral-300/10',
            'border-(--color-line-base) disabled:border-(--color-line-subtle) focus:border-(--color-line-strong)' => !$invalid,
            'border-red-500/80 focus:border-red-500/50' => $invalid,
            'cursor-pointer caret-transparent select-none shadow-xs' => $asButton,
        ]) name="{{ $name }}" type="{{ $type }}" data-slot="control"
               @if($asButton)
                   role="button"
               autocomplete="off"
               @endif
               {{ $attributes->except('class') }} data-control-id="input"
               @if ($invalid) invalid @endif />

        <div class="flex items-center justify-center h-full mr-1" data-slot="input-actions">
            @if ($copyable)
                <x-ui.input.options.copyable/>
            @endif
            @if ($clearable)
                <x-ui.input.options.clearable/>
            @endif
            @if ($revealable)
                <x-ui.input.options.revealable/>
            @endif

            @if ($rightIcon || $kbd)
                <div class="!text-(--color-ink-muted)" data-slot="input-option">
                    @if($rightIcon)
                        @if($hasRightIconSlot)
                            {{ $rightIcon }}
                        @else
                            <x-ui.icon :name="$rightIcon"/>
                        @endif
                    @elseif($kbd)
                        <span class="cursor-pointer bg-surface border border-(--color-line-subtle) px-2 py-0.5 rounded-sm font-mono text-sm flex mr-12 items-center justify-center">{{ $kbd }}</span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- HANDLE SUFFIX SLOTS --}}
    @if (filled($suffix) || filled($suffixIcon))
        <x-ui.input.extra-slot data-slot="input-suffix" class="border-l-0">
            @if ($suffix instanceof \Illuminate\View\ComponentSlot)
                {{ $suffix }}
            @elseif ($suffixIcon)
                <x-ui.icon name="{{ $suffixIcon }}"/>
            @endif
        </x-ui.input.extra-slot>
    @endif
</div>
