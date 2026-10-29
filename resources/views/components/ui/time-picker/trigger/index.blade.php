@aware([
    'trigger'     => 'button',
    'placeholder' => 'select a time',
    'clearable'   => false,
    'disabled'    => false,
    'invalid'     => false,
    'size'        => 'default',
    'icon'        => 'clock',
    'iconAfter'   => 'chevron-up-down',
    'openPanel'   => true
])

@php
    $isInput = $trigger === 'input';
    $isPills = $trigger === 'pills';

$baseClasses = [
    'border-red-600/30 border-2 data-open:border-red-500/50 data-open:ring-red-600/20 dark:border-red-400/30 dark:data-open:border-red-400/30 dark:data-open:ring-red-400/20' => $invalid,
    'border-(--color-line-base) data-open:border-(--color-line-strong) data-open:ring-2 data-open:ring-neutral-600/15 dark:data-open:ring-neutral-300/10 shadow-[inset_0_1px_4px_color-mix(in_srgb,var(--color-neutral-700)_8%,transparent)] dark:shadow-[inset_0_1px_4px_color-mix(in_srgb,var(--color-neutral-950)_40%,transparent)] text-sm truncate font-medium transition-color duration-200' => !$invalid,
    'border bg-white dark:bg-neutral-900/80 dark:text-gray-300 pr-8 rounded-input text-sm overflow-hidden',
    'data-open:ring-offset-0 data-open:outline-none',
    match ($size) {
        'sm'    => 'min-h-8 px-2 py-0.',
        default => 'min-h-10 px-2 py-1',
    }
];

    $baseClassesOnlyAttrs = (new \Illuminate\View\ComponentAttributeBag())->class($baseClasses);

    $iconSize = match ($size) {
        'sm' => 'size-6 p-0.75',
        default    => 'size-8 p-1',
    };
@endphp

<div
        x-ref="trigger"
        data-slot="trigger"
        {{ $attributes->class([
            'relative grid place-items-center [:where(&)]:min-w-52 [:where(&)]:max-w-52',
            // pills trigger is flex, others are grid
            'grid-cols-[1fr_auto]'   => $isPills || $isInput,
            'grid-cols-[2rem_1fr_auto]' => !$isInput && !$isPills,
            '[&_[data-slot=icon]]:opacity-40 opacity-60 pointer-events-none' => $disabled,
        ]) }}
>


    @if (!$isInput && !$isPills)
        <x-ui.time-picker.trigger.variant.default :$iconSize :attributes="$baseClassesOnlyAttrs"/>
    @endif


    @if ($isInput)
        <x-ui.time-picker.trigger.variant.input :$iconSize :attributes="$baseClassesOnlyAttrs"/>
    @endif


    @if ($isPills)
        <x-ui.time-picker.trigger.variant.pills :$iconSize :attributes="$baseClassesOnlyAttrs"/>
    @endif

</div>