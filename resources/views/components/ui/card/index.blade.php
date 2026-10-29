{{-- @aware([
    'state' => 'default',
    'color' => null,
]) --}}
@props([
    'variant' => null,
    'size' => null,
    'state' => 'default',
    'color' => null,
])

@php
    $sizeClasses = match ($size) {
        'sm'
            => 'p-[var(--padding-box-sm)] rounded-[max(calc(var(--radius-item)_-_var(--padding-box-sm)),calc(var(--radius-item)_*_0.7))]',
        'md' => 'p-[var(--padding-box-md)] rounded-item',
        default => 'p-[var(--padding-box-md)] rounded-box',
    };

    $colorVars = match ($color) {
        'accent'
            => '[--color-card:var(--color-accent-600)] [--color-card-soft:var(--color-accent-300)] dark:[--color-card:var(--color-accent-600)] dark:[--color-card-soft:var(--color-accent-700)]',
        'red'
            => '[--color-card:var(--color-red-600)] [--color-card-soft:var(--color-red-300)] dark:[--color-card:var(--color-red-600)] dark:[--color-card-soft:var(--color-red-700)]',
        'orange'
            => '[--color-card:var(--color-orange-600)] [--color-card-soft:var(--color-orange-300)] dark:[--color-card:var(--color-orange-600)] dark:[--color-card-soft:var(--color-orange-700)]',
        'amber'
            => '[--color-card:var(--color-amber-600)] [--color-card-soft:var(--color-amber-300)] dark:[--color-card:var(--color-amber-600)] dark:[--color-card-soft:var(--color-amber-700)]',
        'yellow'
            => '[--color-card:var(--color-yellow-600)] [--color-card-soft:var(--color-yellow-300)] dark:[--color-card:var(--color-yellow-600)] dark:[--color-card-soft:var(--color-yellow-700)]',
        'lime'
            => '[--color-card:var(--color-lime-600)] [--color-card-soft:var(--color-lime-300)] dark:[--color-card:var(--color-lime-600)] dark:[--color-card-soft:var(--color-lime-700)]',
        'green'
            => '[--color-card:var(--color-green-600)] [--color-card-soft:var(--color-green-300)] dark:[--color-card:var(--color-green-600)] dark:[--color-card-soft:var(--color-green-700)]',
        'emerald'
            => '[--color-card:var(--color-emerald-600)] [--color-card-soft:var(--color-emerald-300)] dark:[--color-card:var(--color-emerald-600)] dark:[--color-card-soft:var(--color-emerald-700)]',
        'teal'
            => '[--color-card:var(--color-teal-600)] [--color-card-soft:var(--color-teal-300)] dark:[--color-card:var(--color-teal-600)] dark:[--color-card-soft:var(--color-teal-700)]',
        'cyan'
            => '[--color-card:var(--color-cyan-600)] [--color-card-soft:var(--color-cyan-300)] dark:[--color-card:var(--color-cyan-600)] dark:[--color-card-soft:var(--color-cyan-700)]',
        'sky'
            => '[--color-card:var(--color-sky-600)] [--color-card-soft:var(--color-sky-300)] dark:[--color-card:var(--color-sky-600)] dark:[--color-card-soft:var(--color-sky-700)]',
        'blue'
            => '[--color-card:var(--color-blue-600)] [--color-card-soft:var(--color-blue-300)] dark:[--color-card:var(--color-blue-600)] dark:[--color-card-soft:var(--color-blue-700)]',
        'indigo'
            => '[--color-card:var(--color-indigo-600)] [--color-card-soft:var(--color-indigo-300)] dark:[--color-card:var(--color-indigo-600)] dark:[--color-card-soft:var(--color-indigo-700)]',
        'violet'
            => '[--color-card:var(--color-violet-600)] [--color-card-soft:var(--color-violet-300)] dark:[--color-card:var(--color-violet-600)] dark:[--color-card-soft:var(--color-violet-700)]',
        'purple'
            => '[--color-card:var(--color-purple-600)] [--color-card-soft:var(--color-purple-300)] dark:[--color-card:var(--color-purple-600)] dark:[--color-card-soft:var(--color-purple-700)]',
        'fuchsia'
            => '[--color-card:var(--color-fuchsia-600)] [--color-card-soft:var(--color-fuchsia-300)] dark:[--color-card:var(--color-fuchsia-600)] dark:[--color-card-soft:var(--color-fuchsia-700)]',
        'pink'
            => '[--color-card:var(--color-pink-600)] [--color-card-soft:var(--color-pink-300)] dark:[--color-card:var(--color-pink-600)] dark:[--color-card-soft:var(--color-pink-700)]',
        'rose'
            => '[--color-card:var(--color-rose-600)] [--color-card-soft:var(--color-rose-300)] dark:[--color-card:var(--color-rose-600)] dark:[--color-card-soft:var(--color-rose-700)]',
        default
            => '[--color-card:var(--color-neutral-500)] [--color-card-soft:var(--color-neutral-200)] dark:[--color-card:var(--color-neutral-500)] dark:[--color-card-soft:var(--color-neutral-700)]',
    };

    $isSolid = $variant === 'solid';
    $isOutline = $variant === 'outline';

    $baseClasses = 'border transition-colors duration-200';

    if ($isOutline) {
        $variantClasses = 'flex flex-col p-[var(--padding-box-xs)]';
        if ($state !== 'active') {
            $variantClasses .= ' bg-[color:var(--color-card-soft)]/10  border-[color:var(--color-card)]/25';
        }
        // Only add neutral border when not active (active provides its own colored border)
        if ($state !== 'active') {
            $variantClasses .= ' border-(--color-line-subtle)';
        }

        $stateClasses = match ($state) {
            'hoverable'
                => 'hover:shadow-[0_0_12px_color-mix(in_srgb,var(--color-neutral-600)_5%,transparent)] hover:border-[color:var(--color-card)]/50 dark:hover:border-[color:var(--color-card)]/50 hover:bg-[color:var(--color-card-soft)]/20 dark:hover:bg-[color:var(--color-card-soft)]/20',
            'active'
                => 'border-[color:var(--color-card)]/30 dark:border-[color:var(--color-card)]/30 bg-[color:var(--color-card-soft)]/20 dark:bg-[color:var(--color-card-soft)]/20',
            default => '',
        };

        $innerBorderClass = match ($state) {
            'active' => 'border-[color:var(--color-card)]/60 dark:border-[color:var(--color-card)]/50',
            'hoverable'
                => 'border-[color:var(--color-card)]/30 dark:border-[color:var(--color-card)]/25 hover:border-[color:var(--color-card)]/60 dark:hover:border-[color:var(--color-card)]/40',
            default => 'border-[color:var(--color-card)]/20 dark:border-[color:var(--color-card)]/15',
        };

        $innerClasses = implode(' ', [
            'flex-1',
            'bg-white/70 dark:bg-(--color-neutral-850)/70',
            'border ' . $innerBorderClass,
            'shadow-[0_0_10px_color-mix(in_srgb,var(--color-card)_8%,transparent)]',
            'rounded-item',
            'p-[var(--padding-box-md)]',
            'transition-all duration-200',
        ]);

        $classes = [$colorVars, $baseClasses, $variantClasses, $stateClasses, $sizeClasses];
    } elseif ($isSolid) {
        $variantClasses =
            'bg-(--color-raised) shadow-[0_0_10px_color-mix(in_srgb,var(--color-neutral-400)_5%,transparent)] dark:shadow-[0_0_10px_color-mix(in_srgb,var(--color-neutral-950)_5%,transparent)]';
        if ($state === 'default') {
            $variantClasses .= ' border-(--color-line-subtle)';
        }

        $stateClasses = match ($state) {
            'hoverable'
                => 'cursor-pointer transition-colors border-(--color-line-base) shadow-[0_0px_8px_color-mix(in_srgb,var(--color-neutral-400)_10%,transparent)] hover:shadow-[0_0_10px_color-mix(in_srgb,var(--color-neutral-600)_5%,transparent)] dark:hover:shadow-[0_0_10px_color-mix(in_srgb,var(--color-neutral-950)_10%,transparent)] hover:border-[color:var(--color-card)]/40 dark:hover:border-[color:var(--color-card)]/60 hover:bg-[color:var(--color-card)]/1',
            'active'
                => 'border-[color:var(--color-card)]/60 dark:border-[color:var(--color-card)]/50 shadow-[0_0px_8px_color-mix(in_srgb,var(--color-card)_15%,transparent)] dark:shadow-[0_0px_8px_color-mix(in_srgb,var(--color-card)_20%,transparent)] bg-[color:var(--color-card)]/1',
            default => '',
        };

        $classes = [$colorVars, $baseClasses, $variantClasses, $stateClasses, $sizeClasses];
    } else {
        $variantClasses = 'group/card';
        if ($state === 'default' || $state === 'hoverable') {
            $variantClasses .= ' bg-(--color-surface)/70 border-(--color-line-subtle)';
        }

        $stateClasses = match ($state) {
            'hoverable'
                => 'hover:shadow-[0_0_12px_color-mix(in_srgb,var(--color-neutral-600)_5%,transparent)] hover:border-[color:var(--color-card)]/50 dark:hover:border-[color:var(--color-card)]/50 hover:bg-[color:var(--color-card-soft)]/20 dark:hover:bg-[color:var(--color-card-soft)]/20',
            'active'
                => 'border-[color:var(--color-card)]/30 dark:border-[color:var(--color-card)]/25 bg-[color:var(--color-card)]/10 dark:bg-[color:var(--color-card)]/10',
            default => '',
        };

        $classes = [$colorVars, $baseClasses, $variantClasses, $stateClasses, $sizeClasses];
    }
@endphp

@if ($isOutline)
    <div {{ $attributes->class($classes) }}>
        <div class="{{ $innerClasses }}">
            {{ $slot }}
        </div>
    </div>
@else
    <div {{ $attributes->class($classes) }}>
        {{ $slot }}
    </div>
@endif
