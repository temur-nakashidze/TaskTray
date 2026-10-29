@aware([
    'active' => false,
    'label' => 1,
    'completed' => false,
    'icon' => null,
    'completedIcon' => 'ps:check-fat'
])

@php
    $classes = [
        'relative flex data-[active=true]:border-neutral-300/20',
        '[&:last-child_[data-slot=separator-icon]]:hidden',
    ];

@endphp
<div
        {{ $attributes->class($classes) }}
        data-slot="wizard-step"

        @if ($active)
            data-active
        @endif

        @if ($completed)
            data-completed
        @endif
>
    <div
            @class([
                "size-12 self-center ml-4 rtl:mr-4 rounded-full font-medium flex justify-center items-center",
                "[[data-slot=wizard-step]:is([data-active],[data-completed])_&]:text-(--color-theme-700) dark:[[data-slot=wizard-step]:is([data-active],[data-completed])_&]:text-(--color-theme-300)",
                "[[data-slot=wizard-step]:is([data-completed],[data-active])_&]:border-(--color-theme-500) border-2 border-neutral-600/20 dark:border-neutral-300/20"
            ])
    >
        <div class="[[data-slot=wizard-step][data-completed]_&]:hidden">
            @if (filled($icon))
                <div>
                    {{ $icon }}
                </div>
            @else
                <div class="text-lg font-simibold ">
                    {{ $label }}
                </div>
            @endif
        </div>
        <x-ui.icon :name="$completedIcon" variant="bold"
                   class="text-(--color-theme-500)! [[data-slot=wizard-step]:not([data-completed])_&]:hidden"/>
    </div>

    <div class="p-4 flex-1 self-center">
        {{ $slot }}
    </div>

    <svg fill="none" data-slot="separator-icon" preserveAspectRatio="none" viewBox="0 0 22 80" aria-hidden="true"
         class="absolute end-0 hidden h-full w-5 text-neutral-200 md:block rtl:rotate-180 dark:text-white/5">
        <path d="M0 -2L20 40L0 82" stroke-linejoin="round" stroke="currentcolor" vector-effect="non-scaling-stroke">
        </path>
    </svg>
</div>