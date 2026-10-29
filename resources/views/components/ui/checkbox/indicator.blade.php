{{--
    Checkbox Indicator - Pure visual component, uses @aware for state
--}}
@aware([
    'checked' => false,
    'indeterminate' => false,
    'disabled' => false,
    'invalid' => false,
    'size' => 'md',
])

@props([
    'disabled' => false,
    'invalid' => false,
    'size' => 'md',
])

@php
    /* DEALING WITH SIZES - START */
    $sizeClasses = match ($size) {
        'xs' => 'size-4',
        'sm' => 'size-5',
        'lg' => 'size-7',
        'xl' => 'size-8',
        default => 'size-6',
    };

    $iconVariant = match ($size) {
        'xs', 'sm' => 'regular',
        default => 'bold',
    };

    $iconSizeClasses = match ($size) {
        'xs' => 'size-3',
        'lg', 'xl' => 'size-5',
        default => 'size-4',
    };
    /* SIZES - END */

    // Build button classes array with conditionals
    $buttonClasses = [
        // Base classes
        'flex items-center justify-center border overflow-hidden appearance-none',
        'bg-white dark:bg-neutral-900',
        // 'shadow-xs shadow-neutral-600/15',
        'disabled:cursor-not-allowed disabled:opacity-50',
        'transition-all duration-200',
        'shadow-[inset_0_1.5px_3px_rgba(0,0,0,0.06)]  disabled:shadow-none',
        'focus:outline-none' => !$disabled,
        $sizeClasses,

        'rounded-sm',
        'border-(--color-line-base)' => !$invalid,
        'focus:border-(--color-line-strong)' => !$invalid && !$disabled,
        'border border-red-500/80' => $invalid,

        // Conditional hover styles
        'hover:border-theme-600 dark:hover:border-theme-300 cursor-pointer' => !$disabled,

        // icon like classes
        'data-[checked]:bg-(--color-accent-500) data-[checked]:border-(--color-theme-600) dark:data-[checked]:border-(--color-theme-300) ',
        'data-[indeterminate]:bg-[var(--color-accent-500)] data-[indeterminate]:border-[var(--color-theme-500)]',
    ];

    // Build icon classes array
    $iconClasses = [$iconSizeClasses, '!text-[var(--color-neutral-50)]', 'transition-all duration-200'];
@endphp
<div x-bind:data-checked="_checked && !_indeterminate" x-bind:data-indeterminate="_indeterminate"
    x-bind:aria-checked="_indeterminate ? 'mixed' : (_checked ? 'true' : 'false')"
    x-bind:aria-invalid="@js($invalid) ? 'true' : null" x-ref="checkboxControl"
    @if (!$disabled) x-on:click.stop="toggle()"
     x-on:keydown.space.prevent="toggle()"
     x-on:keydown.enter.prevent="toggle()" @endif
    tabindex="{{ $disabled ? '-1' : '0' }}" type="button" role="checkbox"
    @if ($disabled) disabled
     aria-disabled="true" @endif data-slot="checkbox-indicator"
    {{ $attributes->class($buttonClasses) }}>
    {{-- Check icon for normal checked state --}}
    <x-ui.icon name="ps:check" :variant="$iconVariant" @class($iconClasses) x-show="_checked && !_indeterminate"
        style="display:none" />

    {{-- Minus icon for indeterminate state --}}
    <x-ui.icon name="ps:minus" :variant="$iconVariant" @class($iconClasses) x-show="_indeterminate"
        style="display:none" />
</div>
