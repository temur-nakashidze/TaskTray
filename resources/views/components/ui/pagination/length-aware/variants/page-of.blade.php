@aware(['paginator' => null])

<div
        {{ $attributes->class('text-sm font-medium') }}
        role="status"
        aria-live="polite"
>
    <span class="text-(--color-ink-muted)">{{ __('Page') }}</span>
    <span class=" text-(--color-ink-base)mx-1">{{ $paginator->currentPage() }}</span>
    <span class="text-(--color-ink-muted)">{{ __('of') }}</span>
    <span class=" text-(--color-ink-base) ml-1">{{ $paginator->lastPage() }}</span>
</div>