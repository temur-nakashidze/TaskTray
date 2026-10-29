@php
    $classes = [
        "absolute z-50 bg-white/80 dark:bg-neutral-900/80 backdrop-blur-lg [:where(&)]:w-full mt-1.5 border border-black/12 dark:border-white/10 rounded-(--popup-round) shadow-md py-(--popup-padding)
        shadow-neutral-950/5 dark:shadow-neutral-950/15 py-2",
    ]
@endphp
<div
        @class($classes)
        x-transition
        x-on:click.away="handleClickAway($event.target)"
        x-anchor="$refs.autocompleteControl"
        x-show="isShown"
        x-cloak
>
    <ul
            x-rover:options
            class="flex flex-col  px-2"
            role="listbox"
    >
        {{ $slot }}
    </ul>
</div>