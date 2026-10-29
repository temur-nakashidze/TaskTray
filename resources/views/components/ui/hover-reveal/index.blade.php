@props(['class' => ''])

<div {{ $attributes->class(['group relative overflow-hidden', $class]) }}>
    {{ $slot }}
</div>
