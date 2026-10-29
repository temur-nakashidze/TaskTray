@php
    $classes = ['flex items-center gap-x-2', 'px-1'];
@endphp

<div {{ $attributes->class($classes) }} data-slot="navbar">
    {{ $slot }}
</div>
