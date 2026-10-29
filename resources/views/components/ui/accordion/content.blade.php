@aware([
    'variant' => 'bare',
])

@php
    $variantClasses = match ($variant) {
        default => 'px-6 pb-4',
    };
@endphp
<div x-cloak x-show="isVisible" x-collapse class="text-base  text-(--color-ink-base)  ">
    <div {{ $attributes->class($variantClasses) }}>
        {{ $slot }}
    </div>
</div>
