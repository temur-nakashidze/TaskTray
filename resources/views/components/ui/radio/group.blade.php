@props([
    'label' => '',
    'required' => false,
    'error' => '',
    'direction' => 'vertical',
    'disabled' => false,
    'variant' => 'default',
    'labelClass' => '',
    'indicator' => true,
    'name' => $attributes->whereStartsWith('wire:model')->first() ?? $attributes->whereStartsWith('x-model')->first(),
])

@php
    $componentId = $id ?? 'radio-group-' . uniqid();

    $labelClasses = [' text-(--color-ink-strong)  font-semibold mb-2 text-base inline-block', $labelClass];

    $variantClass = [
        'space-y-[var(--gap-form)]' => $direction === 'vertical',
        'flex gap-[var(--gap-form)] items-stretch' => $direction === 'horizontal',
        'bg-neutral-100/80 dark:bg-neutral-900/60 border border-(--color-line-base) rounded-button w-fit p-[var(--gap-micro)] gap-[var(--gap-micro)]!' => $variant === 'segmented',
        'p-0' => $variant === 'cards',
    ];

    // Detect if the component is bound to a Livewire model
    $modelAttrs = collect($attributes->getAttributes())->keys()->first(fn($key) => str_starts_with($key, 'wire:model'));

    $model = $modelAttrs ? $attributes->get($modelAttrs) : null;

    // Detect if model binding uses `.live` modifier (for real-time syncing)
    $isLive = $modelAttrs && str_contains($modelAttrs, '.live');
@endphp


<div x-data="function() {
    const $entangle = (prop, live) => {

        const binding = $wire.$entangle(prop);

        return live ? binding.live : binding;
    };

    const $initState = (prop, live, multiple) => {
        // when the env is not livewire
        if (!prop) return null;

        return $entangle(prop, live);
    };

    return {
        _state: $initState(@js($model), @js($isLive)),

        init() {
            this.$nextTick(() => {
                this._state = this.$root?._x_model?.get();
            });

            this.$watch('_state', (value) => {
                // Sync with Alpine state
                this.$root?._x_model?.set(value);
            });
        },
    }
}" {{ $attributes->merge(['class' => 'w-full text-start']) }}>
    @if ($label)
        <label id="{{ $componentId }}-label" @class($labelClasses)>
            {{ $label }}
        </label>
    @endif

    <div role="radiogroup" @class(Arr::toCssClasses($variantClass))
    @if ($label) aria-labelledby="{{ $componentId }}-label" @endif>
        {{ $slot }}
    </div>

    @if ($error && filled($error))
        <p
                class="text-neutral-200 bg-red-500 relative w-fit after:content-[''] after:w-1 after:h-full after:bg-white after:absolute after:left-0 after:top-0  text-sm mt-4 px-4 py-0.5">
            {{ $error }}
        </p>
    @endif
</div>
