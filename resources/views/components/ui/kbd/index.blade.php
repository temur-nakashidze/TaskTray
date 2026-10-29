@props([
    'keys' => null,
    'separator' => '+'
])

@php
    $baseClasses = 'inline-flex items-center gap-1 font-mono text-sm';
    $kbdClasses = 'pointer-events-none inline-flex h-5 select-none items-center gap-1 rounded border border-(--color-line-base) bg-(--color-surface) px-2 py-2.5 font-sans text-sm font-medium  text-(--color-ink-base) opacity-100';
    
    $keyArray = $keys ? explode($separator, $keys) : [];
@endphp

<span {{ $attributes->merge(['class' => $baseClasses]) }}>
    @if($keyArray)
        @foreach($keyArray as $index => $key)
            <kbd class="{{ $kbdClasses }}">{{ trim($key) }}</kbd>
            @if(!$loop->last)
                <span class="text-neutral-400 text-xs">{{ $separator }}</span>
            @endif
        @endforeach
    @else
        <kbd class="{{ $kbdClasses }}">
            {{ $slot }}
        </kbd>
    @endif
</span>