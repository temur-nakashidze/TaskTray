<div
    {{ $attributes->class([
        'flex isolate',
        '*:not-first:-ml-2',
        '**:ring-white **:dark:ring-theme-900',
        '**:[data-slot=avatar]:ring-4',
        '**:[data-slot=avatar]:[data-size=sm]:ring-2',
        '**:[data-slot=avatar]:[data-size=lg]:ring-4',
        '**:[data-slot=avatar]:[data-size=xs]:ring-2',
    ]) }}>
    {{ $slot }}
</div>
