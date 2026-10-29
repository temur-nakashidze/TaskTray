@props(['aligned' => false])
<div
        {{
            $attributes->class([
                'p-4 border-t border-(--color-line-base)',
                // 'row-start-3' => $aligned
            ])
        }}
>
    {{ $slot }}
</div>
