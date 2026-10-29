@props([
    'label' => 'command palette'
])

@php
    $classes = [
        "flex flex-col w-full border border-(--color-line-base) dark:bg-neutral-900/80 overflow-hidden bg-white/80   text-(--color-ink-strong) backdrop-blur-lg",
        // radius calculations...
        "rounded-item"
    ];
@endphp

<div
        x-rover
        x-init="
        let inputManager = $rover.input;

        inputManager.enableDefaultInputHandlers();

        inputManager.on('click', () => $rover.activateFirst());

        inputManager.on('keydown', (event, activeItem) => {
            if(event.key === 'Enter'){
                $rover.getOptionElByValue(activeItem)?.click();
            }

            {{-- if we're inside a modal handle escape key  --}}
            if(event.key==='Escape'){
                $data.close?.()
            }
        });

        $rover.options.enableDefaultOptionsHandlers();
    "
        {{ $attributes->class($classes) }}
>
    {{ $slot }}
</div>