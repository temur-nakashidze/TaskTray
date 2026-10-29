@aware(['disabled'])

<input
        type="text"
        inputmode="numeric"
        placeholder="--"
        maxLength="2"
        min="0"
        max="59"
        x-on:click.stop="handleInputClick"
        x-on:focus="$el.select()"
        x-on:blur="normalizeOnBlur($el.name === 'hours-handler' ? 'h' : 'm')"
        x-on:paste="handleSegmentPaste($event, $el.name === 'hours-handler' ? 'h' : 'm')"
        {{ $attributes->class("w-8 text-center h-7 bg-transparent p-0 text-(--color-ink-base) outline-none border border-(--color-line-base) focus:border-(--color-line-strong) tabular-nums text-(--color-ink-strong) placeholder-(--color-ink-subtle) dark:placeholder-(--color-ink-muted) focus:ring-1 ring-(--color-line-subtle) rounded transition-colors") }}
        @disabled($disabled)
/>