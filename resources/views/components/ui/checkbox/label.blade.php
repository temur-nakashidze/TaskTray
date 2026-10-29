@aware(['label', 'labelSize'])

{{-- Label --}}
@php
    $classes = [
        'font-normal cursor-pointer tracking-snug-wide font-sans [:where(&)]: text-(--color-ink-strong)  [:where(&)]: select-none',
        match ($labelSize) {
            'xs' => 'text-xs',
            'sm' => 'text-sm',
            'lg' => 'text-base',
            'xl' => 'text-lg',
            default => 'text-md',
        },
    ];
@endphp

<label @class($classes) data-slot="checkbox-label">
    {{ $label }}
</label>
