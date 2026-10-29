@props([
    'id' => null,
    'minValue' => 0,
    'maxValue' => 100,
    'step' => null,
    'decimalPlaces' => null,
    'vertical' => false,
    'topToBottom' => false,
    'rtl' => null,
    'fillTrack' => null,
    'tooltips' => false,
    'staticValues' => false,
    'staticValuesFormatter' => null,
    'pips' => false,
    'pipsMode' => null,
    'pipsDensity' => null,
    'pipsFilter' => null,
    'pipsValues' => null,
    'pipsFormatter' => null,
    'arePipsStepped' => false,
    'behavior' => 'tap',
    'margin' => null,
    'limit' => null,
    'rangePadding' => null,
    'nonLinearPoints' => null,
    'handleVariant' => 'default',
])

@php
    if ($pips && is_null($pipsMode)) {
        $pipsMode = 'range';
    }
    $componentId = $id ?? 'slider-' . uniqid();
    $hasPips = filled($pipsMode);
    $hasTooltips = $tooltips !== false;
    $hasStaticValues = $staticValues !== false;

    $modelAttrs = collect($attributes->getAttributes())->keys()->first(fn($key) => str_starts_with($key, 'wire:model'));
    $model = $modelAttrs ? $attributes->get($modelAttrs) : null;
    $isLive = $modelAttrs && str_contains($modelAttrs, '.live');
    $livewireId = isset($__livewire) ? $__livewire->getId() : null;
@endphp

<div @class([
    'slider-wrapper w-full',
    'ps-10' => $vertical && $hasTooltips,
    'pb-8' => !$vertical && $hasPips,
    $attributes->get('class'),
])>
    @if ($hasStaticValues)
        <div x-data="{
            formatter: {{ $staticValuesFormatter ?? 'null' }},
            format(val) {
                return this.formatter ? this.formatter(val) : val;
            },
            minVal: '',
            maxVal: '',
            init() {
                setTimeout(() => {
                    const slider = this.$el.closest('.slider-wrapper').querySelector('[data-slot=slider]');
                    const sliderData = Alpine.$data(slider);
                    const initial = Alpine.raw(sliderData._displayState ?? sliderData._state);
                    this.minVal = this.format(initial[0]);
                    this.maxVal = this.format(initial.at(-1));
                    this.$watch(
                        () => JSON.stringify(Alpine.raw(sliderData._displayState)),
                        () => {
                            const s = Alpine.raw(sliderData._displayState);
                            this.minVal = this.format(s[0]);
                            this.maxVal = this.format(s.at(-1));
                        }
                    );
                }, 100);
            }
        }" class="flex justify-between mb-1">
            <x-ui.text class="font-medium" x-text="minVal"></x-ui.text>
            <x-ui.text class="font-medium" x-text="maxVal"></x-ui.text>
        </div>
    @endif

    <div x-data="sliderComponent({
        model: @js($model),
        livewire: @js(isset($livewireId)) ? window.Livewire.find(@js($livewireId)) : null,
        isLive: @js($isLive),
        arePipsStepped: @js($arePipsStepped),
        behavior: @js($behavior),
        decimalPlaces: @js($decimalPlaces),
        fillTrack: @js($fillTrack),
        isRtl: @js(($rtl ?? $vertical) && !$topToBottom),
        isVertical: @js($vertical),
        limit: @js($limit),
        margin: @js($margin),
        maxValue: @js($maxValue),
        minValue: @js($minValue),
        nonLinearPoints: @js($nonLinearPoints),
        pipsDensity: @js($pipsDensity),
        pipsFormatter: @js($pipsFormatter),
        pipsValues: @js($pipsValues),
        pipsFilter: @js($pipsFilter),
        pipsMode: @js($pipsMode),
        padding: @js($rangePadding),
        step: @js($step),
        tooltips: @js($tooltips),
    })" data-slot="slider" data-variant="{{ $handleVariant }}"
        data-vertical="{{ $vertical ? 'true' : 'false' }}" @class([
            'relative my-5',
            'h-40' => $vertical,
            'w-full' => !$vertical,
            '!mb-8' => !$vertical && $hasPips,
            '!mt-14' => !$vertical && $hasTooltips,
            '!mt-2' => !$vertical && $hasStaticValues && !$hasTooltips,
        ])
        {{ $attributes->except('class') }} wire:ignore></div>
</div>
