@aware(['type' => 'text','name'=> null])

@php
    $classes = [
        'z-0 relative', // reset stacking context
        'focus:z-10', // prevent this input to get clipped from next input
        'rounded-input overflow-visible', // default rounding with zero specificity, allows external classes to override without !
        'text-center text-base  w-10 h-10',
        'bg-white dark:bg-neutral-900/60 dark:disabled:bg-neutral-900/30 disabled:bg-neutral-50', // background
        ' text-(--color-ink-strong) font-semibold   disabled:text-(--color-ink-subtle) placeholder-(--color-ink-subtle) disabled:placeholder-(--color-ink-subtle)',
        'border border-(--color-line-base) disabled:border-(--color-line-subtle) focus:border-(--color-line-strong)', // base border
        'focus:ring-2 focus:ring-offset-0 focus:outline-none focus:ring-neutral-600/15 dark:focus:ring-neutral-300/10',
        'transition duration-200 ease-in-out',
        'shadow-[inset_0_1px_4px_color-mix(in_srgb,var(--color-neutral-700)_8%,transparent)] dark:shadow-[inset_0_1px_4px_color-mix(in_srgb,var(--color-neutral-950)_40%,transparent)]',
        'disabled:cursor-default',
        // overlay for disabled inputs to catch clicks, it a hack but needed for better UX
        'disabled:after:content-[""] disabled:after:absolute disabled:after:inset-0 disabled:after:cursor-text disabled:after:pointer-events-auto',
    ];
@endphp

<input
        {{ $attributes
            ->merge([
                'name' => $name,
                'type' => $type,
            ])
            ->class($classes)
        }}

        required
        maxlength="1"
        data-slot="otp-input"
        x-on:input="handleInput($el)"
        x-on:keydown.enter="handleInput($el)"
        x-on:paste="handlePaste($event)"
        {{-- traits delete key as backspace --}}
        x-on:keydown.delete.prevent="await handleBackspace($event)"
        {{-- handle backspace key --}}
        x-on:keydown.backspace.prevent="await handleBackspace($event)"

        {{-- accessibilty addons --}}
        autocomplete="one-time-code"
        x-on:keydown.right="$focus.within($refs.inputsWrapper).next()"
        x-on:keydown.up="$focus.within($refs.inputsWrapper).next()"
        x-on:keydown.left="$focus.within($refs.inputsWrapper).prev()"
        x-on:keydown.down="$focus.within($refs.inputsWrapper).prev()"

        {{-- on focus select for easy replacement
         NOTE: In Firefox, calling $el.select() immediately after focus does nothing
         if the input was just focused programmatically. Wrapping it in requestAnimationFrame
         defers the selection to the next frame, after the browser has fullly applied focus
         This is the only way I got consistent behavior across Chrome, Safari (maybe haha), and Firefox
         after lot of debugging. --}}
        x-on:focus="requestAnimationFrame(() => $el.select())"
/>
