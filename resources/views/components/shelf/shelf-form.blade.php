@props(['color' => 'neutral'])

@php
    $colors = [
        'neutral',
        'red',
        'orange',
        'amber',
        'yellow',
        'lime',
        'green',
        'emerald',
        'teal',
        'cyan',
        'sky',
        'blue',
        'indigo',
        'violet',
        'purple',
        'fuchsia',
        'pink',
        'rose',
    ];
@endphp

<div x-data="{
    open: false,
    color: '{{ $color }}',
    colorVars: {
        neutral: ['neutral-500', 'neutral-200'],
        red: ['red-600', 'red-300'],
        orange: ['orange-600', 'orange-300'],
        amber: ['amber-600', 'amber-300'],
        yellow: ['yellow-600', 'yellow-300'],
        lime: ['lime-600', 'lime-300'],
        green: ['green-600', 'green-300'],
        emerald: ['emerald-600', 'emerald-300'],
        teal: ['teal-600', 'teal-300'],
        cyan: ['cyan-600', 'cyan-300'],
        sky: ['sky-600', 'sky-300'],
        blue: ['blue-600', 'blue-300'],
        indigo: ['indigo-600', 'indigo-300'],
        violet: ['violet-600', 'violet-300'],
        purple: ['purple-600', 'purple-300'],
        fuchsia: ['fuchsia-600', 'fuchsia-300'],
        pink: ['pink-600', 'pink-300'],
        rose: ['rose-600', 'rose-300'],
    }
}">
    <x-ui.card color="{{ $color }}" variant="outline" state="active" class="w-full"
        x-bind:style="`
                                                            --color-card: var(--color-${colorVars[color][0]});
                                                            --color-card-soft: var(--color-${colorVars[color][1]});
                                                        `">
        <div class="flex items-start gap-(--gap-form)">
            <div class="flex items-center gap-(--gap-micro)">
                <x-ui.input placeholder="Shelf name" value="Todo" />

                {{-- Color selector --}}
                <div class="relative" @click.outside="open = false">
                    <button type="button" x-on:click="open = !open"
                        class="flex items-center justify-center size-9 rounded-(--radius-input) hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                        <span class="size-4 rounded-full" :class="`bg-${color}-500`"></span>
                    </button>

                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute left-0 top-full z-50 mt-1 w-44 p-3 rounded-(--radius-card) border border-neutral-200 bg-white shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                        <div class="grid grid-cols-6 gap-2">
                            @foreach ($colors as $colorOption)
                                <button type="button" x-on:click="color = '{{ $colorOption }}'; open = false"
                                    class="flex items-center justify-center size-6 rounded-md hover:bg-neutral-100 dark:hover:bg-neutral-800">
                                    <span class="size-4 rounded-full bg-{{ $colorOption }}-500"></span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <x-ui.spacer />

            <x-ui.button variant="soft" size="sm" icon="ps:check" iconVariant="bold" />
            <x-ui.button variant="soft" x-on:click="$dispatch('close-shelf-form')" size="sm" icon="ps:x"
                iconVariant="bold" />
        </div>

        <div class="mt-4">
            <div class="flex xl:flex-row flex-col w-full gap-(--gap-form)">
                <x-ui.input placeholder="Todo" value="Todo" />
                <x-ui.input placeholder="Later" value="Later" />
                <x-ui.input placeholder="Ideas" value="Ideas" />
                <x-ui.input placeholder="Parked" value="Parked" />
                <x-ui.button variant="outline" icon="ps:plus" iconVariant="bold" />
            </div>
        </div>
    </x-ui.card>
</div>
