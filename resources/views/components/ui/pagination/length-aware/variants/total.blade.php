@aware(['paginator' => null ])

@if ($paginator->total() > 0)
    <div {{ $attributes->class("text-sm text-white/70 font-medium") }} role="status" aria-live="polite">
        <span class=" text-(--color-ink-base)">{{ $paginator->firstItem() }}</span>
        <span class="text-(--color-ink-muted)">–</span>
        <span class="text-(--color-ink-base)">{{ $paginator->lastItem() }}</span>
        <span class="text-(--color-ink-muted) mx-1">{{ __('of') }}</span>
        <span class=" text-(--color-ink-base)">{{ $paginator->total() }}</span>
        <span class="sr-only">{{ __('results') }}</span>
    </div>
@endif