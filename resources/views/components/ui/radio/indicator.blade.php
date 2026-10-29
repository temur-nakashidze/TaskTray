@php
    $indicatorClasses = [
        'relative ',
        'shrink-0 size-[1.25rem] rounded-full text-sm shadow-xs bg-neutral-100 dark:bg-neutral-900/40',
        "after:content-[''] after:absolute after:size-[.7rem] after:rounded-full after:top-1/2 after:left-1/2 after:-translate-1/2 dark:after:bg-theme-300 after:bg-theme-600 after:hidden",
        'border border-(--color-line-base)',
    ];
@endphp

<div @class($indicatorClasses) data-slot="radio-item-indicator"></div>
