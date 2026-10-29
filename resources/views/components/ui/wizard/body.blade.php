@aware(['contained' => false])


@php
    $classes = [
        'rounded-xl',
        'border border-neutral-600/20 dark:border-neutral-300/20'=> $contained,
    ];
@endphp

<div {{ $attributes->class($classes) }} data-slot="wizard-body">
    {{ $slot }}
</div>
