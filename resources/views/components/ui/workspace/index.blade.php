@props([
    'title' => 'გვერდის სათაური',
    'icon' => null,
    'color' => 'text-theme-600',
    'parent' => false,
    'editable' => true,
])

<div x-data="{ editing: false }" class="p-(--padding-box-lg) space-y-(--gap-layout)">
    <div class="flex items-center gap-(--gap-form) h-16">
        <div class="flex items-center gap-(--gap-micro)">
            @if ($parent)
                <x-ui.badge size="lg" variant="outline" class="mr-3">
                    PB
                </x-ui.badge>
            @endif

            @if ($icon)
                <x-ui.icon name="{{ $icon }}" variant="duotone" class="size-9 {{ $color }}" />
            @endif

            <div class="relative ">
                <x-ui.heading x-show="!editing" x-transition size="3xl"
                    class="{{ $color }}! capitalize text-nowrap" weight="bold">
                    {{ $title }}
                </x-ui.heading>
                @if ($editable)
                    <div x-show="editing" x-cloak x-transition
                        class="absolute left-0 top-1/2 -translate-y-1/2 flex items-center gap-(--gap-micro)">
                        <x-ui.input class="w-44!" placeholder="Project name" value="{{ $title }}" />

                        <x-ui.button variant="outline" icon="ps:check" x-on:click="editing = false" />
                    </div>
                @endif
            </div>
            @if ($editable)
                <x-ui.button x-show="!editing" x-transition variant="subtle" icon="pencil-square"
                    x-on:click="editing = true" />
            @endif
        </div>

        <x-ui.spacer />

        @isset($actions)
            {{ $actions }}
        @endisset
    </div>

    {{ $slot }}
</div>
