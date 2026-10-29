@props(['shelf', 'href'])

@php
    $iconColor = 'text-' . $shelf->color . '-600!';

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
    showForm: false,
    open: false,
    color: '{{ $shelf->color }}',

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
}" {{ $attributes->merge([]) }}>
    <x-ui.card color="{{ $shelf->color }}" state="active" class="w-full relative group"
        x-bind:style="` --color-card: var(--color-${colorVars[color][0]});--color-card-soft: var(--color-${colorVars[color][1]});`">
        <div class="grid">
            {{-- Shelf display --}}
            <div class="[grid-area:1/1]" x-show="!showForm" x-transition
                x-on:click="window.location.href = '{{ $href }}'" wire:navigate>
                <div class="flex items-start gap-(--gap-form) h-10">
                    <div class="flex items-center gap-(--gap-micro)">
                        <x-ui.icon name="ps:rows" variant="duotone" class="{{ $iconColor }}  size-6" />

                        <x-ui.heading color="theme" size="lg" weight="semibold" class="{{ $iconColor }} block">
                            {{ $shelf->name }}
                        </x-ui.heading>

                    </div>
                    <div x-on:click.stop>
                        <x-ui.dropdown position="bottom-start">
                            <x-slot:button class="justify-center">
                                <x-ui.button variant="ghost" size="sm" icon="ps:dots-three" iconVariant="bold" />
                            </x-slot:button>

                            <x-slot:menu>
                                <x-ui.dropdown.item icon="pencil-square" x-on:click.stop="showForm = true">
                                    Edit
                                </x-ui.dropdown.item>

                                <x-ui.dropdown.item icon="trash" variant="danger" x-on:click.stop>
                                    Delete
                                </x-ui.dropdown.item>
                            </x-slot:menu>
                        </x-ui.dropdown>
                    </div>

                    <x-ui.spacer />
                    <div x-show="!showForm">
                        <x-ui.handle x-sort:handle class="mt-1.5" />
                    </div>

                </div>

                <div class="flex xl:flex-row flex-col w-full gap-(--gap-form) mt-4">
                    @foreach ($shelf->trays as $tray)
                        <x-ui.card variant="solid" wire:key="tray-{{ $tray->id }}" size="md"
                            color="{{ $shelf->color }}"
                            class="relative p-(--padding-box-xs)! w-full flex items-center justify-between">
                            <x-ui.heading font="label" weight="medium" color="theme">
                                {{ $tray->name }}
                            </x-ui.heading>

                            <x-ui.badge size="sm" variant="soft">
                                {{ $tray->tasks_count }}
                            </x-ui.badge>
                            <div x-sort="$wire.moveTask($item, 'tray:{{ $tray->id }}'); queueMicrotask(() => $el.replaceChildren())"
                                x-sort:group="tasks" x-sort:config="{ draggable: '.no-drag' }"
                                class="absolute inset-0 z-20 overflow-hidden rounded-[inherit] pointer-events-none ring-(--color-card) in-[.sorting]:pointer-events-auto has-[.sortable-ghost]:ring-2">
                            </div>

                        </x-ui.card>
                    @endforeach

                </div>
            </div>


            {{-- Edit form --}}
            <div class="[grid-area:1/1]" x-cloak x-show="showForm" @close-shelf-form.window="showForm = false"
                x-transition>
                <div class="flex items-start gap-(--gap-form) ">
                    <div class="flex items-center gap-(--gap-micro)">
                        <x-ui.input placeholder="Shelf name" value="{{ $shelf->name }}" />
                        {{-- Color selector --}}
                        <div class="relative" @click.outside="open = false">
                            <button type="button" x-on:click="open = !open"
                                class="flex items-center justify-center size-9 rounded-(--radius-input) hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                                <span class="size-4 rounded-full" :class="`bg-${color}-500`"></span>
                            </button>

                            <div x-show="open" x-cloak x-transition
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

                    <x-ui.button variant="subtle" color="emerald" size="sm" icon="ps:check" iconVariant="bold" />

                    <x-ui.button variant="subtle" x-on:click="$dispatch('close-shelf-form')" size="sm"
                        icon="ps:x" iconVariant="bold" />
                </div>

                <div class="mt-4">
                    <div class="flex xl:flex-row flex-col w-full gap-(--gap-form)">
                        @foreach ($shelf->trays as $tray)
                            <x-ui.input placeholder="Todo" value="{{ $tray->name }}" />
                        @endforeach

                        <x-ui.button variant="soft" icon="ps:plus" iconVariant="bold" />
                    </div>
                </div>
            </div>

        </div>
        <div x-sort="$wire.moveTask($item, 'shelf:{{ $shelf->id }}')" x-sort:group="tasks"
            x-sort:config="{ draggable: '.no-drag' }"
            class="absolute inset-0 z-10 overflow-hidden rounded-[inherit] pointer-events-none ring-(--color-card) in-[.sorting]:pointer-events-auto has-[.sortable-ghost]:ring-2">
        </div>
    </x-ui.card>
</div>
