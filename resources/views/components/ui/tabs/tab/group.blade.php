@aware(['variant' => 'outlined'])

@php


    $variantClasses = match($variant){
        'outlined' => [
            'gap-2 overflow-x-auto',
        ],
        'non-contained' => [
            // all handled on thier wrapper below
        ],
        'pills' => [
            'my-2 gap-[var(--gap-micro)]'
        ],
        default => []
    };
    $classes = [
        'flex [:where(&)]:items-center [:where(&)]:justify-center', // all tabs group are centred until they can be overiden without !
        ...$variantClasses,
    ];
@endphp

<ul
        {{ $attributes->class(Arr::toCssClasses($classes))}}
        x-ref="tabItem"
        x-on:keydown.right.prevent.stop="$focus.wrap().next()"
        x-on:keydown.home.prevent.stop="$focus.first()"
        x-on:keydown.page-up.prevent.stop="$focus.first()"
        x-on:keydown.left.prevent.stop="$focus.wrap().prev()"
        x-on:keydown.end.prevent.stop="$focus.last()"
        x-on:keydown.page-down.prevent.stop="$focus.last()"
        role="tablist"
        data-slot="tabs-group"
>

    {{-- non contained needs a wrapper for   --}}
    @if($variant === 'non-contained')
        <div class="flex gap-[var(--gap-micro)] w-fit bg-neutral-100/80 dark:bg-neutral-900/80 border-1 border-neutral-600/20 dark:border-neutral-300/20 rounded-item p-[var(--gap-micro)] ">
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</ul>
