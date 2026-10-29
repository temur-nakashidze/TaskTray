@aware([
    'variant' => 'default',
    'disabled' => false,
    'indicator' => true,
    'name' => '',
])

@props([
    'value',
    'label' => '',
    'checked' => false,
    'description' => '',
    'icon' => '',
    'iconVariant' => 'regular',
    'iconClass' => '',
])

@php

    $isSegmented = $variant === 'segmented';
    $isCards = $variant === 'cards';
    $isPills = $variant === 'pills';
    $showIcon = ($isSegmented || $isCards) && filled($icon);
    $showInput = !$isSegmented && (!$isCards || $indicator) && !$isPills;
    $hasSlot = $slot->isNotEmpty(); // ✅ NEW

    $labelClasses = [
        'flex-1 cursor-pointer text-base font-medium flex items-center gap-[var(--gap-micro)] transition duration-200',
        ' text-(--color-ink-base)   hover:text-(--color-ink-strong)',
        'peer-checked:[&>[data-slot=radio-item-indicator]]:border-theme-500 peer-checked:[&>[data-slot=radio-item-indicator]]:ring-white peer-checked:[&>[data-slot=radio-item-indicator]]:bg-neutral-500/20',
        'peer-checked:[&>[data-slot=radio-item-indicator]]:after:block',
        'dark:peer-checked:[&>[data-slot=radio-item-indicator]]:border-theme-500 dark:peer-checked:[&>[data-slot=radio-item-indicator]]:bg-neutral-300/20',
        'peer-disabled:opacity-50 cursor-auto',
        'peer-disabled:[&>[data-slot=radio-item-indicator]]:opacity-50 peer-disabled:[&>[data-slot=radio-item-indicator]]:shadow-none',

        ' text-(--color-ink-base) border border-transparent rounded-[calc(var(--radius-button)*0.75)] hover: text-(--color-ink-strong) p-2
peer-checked:shadow-xs
peer-checked:border-theme-500
peer-checked:text-theme-700
peer-checked:hover:text-theme-700
dark:peer-checked:text-theme-200
dark:peer-checked:hover:text-theme-200
peer-checked:bg-theme-200/30
dark:peer-checked:bg-theme-800/30
hover:bg-white/90 dark:hover:bg-neutral-800/90
hover:border-transparent
peer-checked:hover:border-theme-500
peer-checked:hover:bg-theme-200/30
dark:peer-checked:hover:bg-theme-800/30' => $isSegmented,
        'peer-checked:bg-theme-600 peer-checked:text-white px-2 py-0.5 rounded-full peer-checked:hover:text-white' => $isPills,
        '[&>[data-slot=radio-item-indicator]]:order-3 [&>[data-slot=radio-item-indicator]]:ml-auto' => $isCards,
    ];

    $containerClasses = [
        'relative isolate  transition duration-200 text-sm group',
        'flex-1 dark:bg-neutral-600/20 bg-neutral-200/5 px-3 py-2.5 rounded-button border border-(--color-line-base) dark:hover:bg-neutral-700/50 hover:bg-neutral-300/20 hover:border-(--color-line-strong) shadow-xs shadow-neutral-600/10 dark:shadow-neutral-950/30' => $isCards,
        'has-[:checked]:bg-theme-200/30 dark:has-[:checked]:bg-theme-800/30 has-[:checked]:border-theme-500 has-[:checked]:[&_label]:text-theme-700
        hover:has-[:checked]:bg-theme-200/30 dark:hover:has-[:checked]:bg-theme-800/30 hover:has-[:checked]:border-theme-500 has-[:checked]:[&_label]:text-[var(--color-theme-700)]
        dark:has-[:checked]:[&_label]:text-theme-200' => $isCards,
    ];

    $descriptionClasses = [
        'text-(--color-ink-muted) pt-2   w-full text-sm text-start',
        'pl-0!' => $isCards,
        'pl-5 ' => !$isCards,
    ];

@endphp

<div {{ $attributes->class($containerClasses) }} x-init="$nextTick(() => {
    if (@js($checked) && ($data._state == null)) {
        $data._state = @js($value);
    }
})">
    <input data-slot="radio-item-control" class="peer" name="{{ $name }}" hidden
           id="{{ $value }}-{{ $name }}" value="{{ $value }}" type="radio" x-model="$data._state"/>

    <label for="{{ $value }}-{{ $name }}" @class($labelClasses)>
        @if ($indicator && !$isPills)
            <x-ui.radio.indicator/>
        @endif
        @if ($isCards)
            <span class="absolute size-full inset-0"></span>
        @endif

        @if ($showIcon)
            <x-ui.icon name="{{ $icon }}" variant="{{ $iconVariant }}" class="{{ $iconClass }}"/>
        @endif

        <span class="font-semibold ">{{ $label }}</span>
    </label>

    {{-- ✅ NEW: optional slot for images or any custom content --}}
    @if ($hasSlot)
        <div data-slot="radio-item-content">
            {{ $slot }}
        </div>
    @endif

    @if ($description && !$isPills)
        <p data-slot="radio-item-control-description" @class($descriptionClasses)>{{ $description }}</p>
    @endif
</div>
