@props([
    'reverse' => false,
    'independent' => false,
])

<div x-data="{ active: null }" {{ $attributes->merge(['class' => 'w-full flex flex-col gap-[var(--gap-form)]']) }}>
    {{ $slot }}
</div>
