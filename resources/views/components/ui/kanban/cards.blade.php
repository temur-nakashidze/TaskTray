@php

@endphp

<div {{ $attributes->class('px-[var(--padding-box-md)] space-y-[var(--padding-box-md)]') }}>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @endif

    @if ($slot->isEmpty() && $empty)
        <div class="flex items-center justify-center py-(--padding-box-lg) text-center">
            {{ $empty }}
        </div>
    @endif
</div>
