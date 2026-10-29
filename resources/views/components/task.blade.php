@props([
    'disabled' => false,
    'checked' => false,
    'meta' => true,
    'task' => null,
    'context' => 'tray',
    'hasReference' => false,
    'workbenchId' => null,
])
<div {{ $attributes }}>
    <x-ui.context :trap="true">
        <x-slot:trigger>
            <x-ui.card variant="solid" size="md"
                {{ $attributes->merge(['class' => 'p-2! relative group/parent ']) }}>

                @if ($meta)
                    <div>
                        <div class="flex items-center justify-start mb-2">
                            <x-ui.badge color="green" class="rounded-xs" variant="outline" size="sm">PB</x-ui.badge>
                            <x-ui.badge color="amber" class="rounded-xs" icon="ps:books" variant="soft"
                                size="sm">Admin
                                panel</x-ui.badge>
                        </div>
                        <x-ui.line-divider />
                    </div>
                @endif
                <div class="flex items-start relative pl-4 group/task">

                    <x-ui.handle x-sort:handle
                        class="absolute -left-1.5 top-0.75 group-hover/task:opacity-100 opacity-30 transition-opacity" />
                    <x-ui.text size="md" class="w-full">{{ $task->title }}</x-ui.text>

                    @if ($context === 'bench')
                        <x-ui.checkbox size="lg" :disabled="$disabled" :checked="$checked" class="-mr-3" />
                    @endif
                    @if ($context === 'tray' && !$hasReference)
                        <x-ui.button wire:click="pullToWorkbench({{ $task->id }}, 'workbench:{{ $workbenchId }}')"
                            variant="soft" icon="ps:plus" squared size="sm" />
                    @endif
                    @if ($context === 'tray' && $hasReference)
                        <x-ui.button variant="soft" wire:click="removeTaskFromWorkbench({{ $task->id }})"
                            color="accent" squared size="sm" class="relative group">
                            <x-ui.icon name="wrench-screwdriver"
                                class="absolute inset-1 opacity-100 group-hover:opacity-0 transition-opacity" />
                            <x-ui.icon name="ps:x" variant="regular"
                                class="absolute inset-1 opacity-0 group-hover:opacity-100 transition-opacity" />
                        </x-ui.button>
                    @endif

                </div>
                @if ($task->note or $task->tags->isNotEmpty())
                    <div>
                        <x-ui.line-divider opacity="10" class="mt-1" />
                        <div class="flex items-end justify-between mt-1.5">
                            @if ($task->tags->isNotEmpty())
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($task->tags as $tag)
                                        <x-ui.tag name="{{ $tag->name }}" color="{{ $tag->color }}" />
                                    @endforeach
                                </div>
                            @endif
                            @if ($task->note)
                                <x-ui.spacer />

                                <x-ui.popover>
                                    <x-ui.popover.trigger>
                                        <x-ui.icon name="ps:notebook" variant="duotone"
                                            class="text-(--color-theme-400) hover:text-(--color-theme-600) dark:hover:text-(--color-theme-100)"
                                            size="sm" />
                                    </x-ui.popover.trigger>

                                    <x-ui.popover.overlay class="w-xl" position="bottom-right">
                                        <div class="p-(--padding-box-md)">
                                            <x-ui.heading>Add Note</x-ui.heading>
                                            <x-ui.text size="md">{{ $task->description ?? '' }}</x-ui.text>
                                        </div>
                                    </x-ui.popover.overlay>
                                </x-ui.popover>
                            @endif
                        </div>
                    </div>
                @endif
                @if ($task->cuts->isNotEmpty())
                    <div
                        class="space-y-(--gap-micro) bg-neutral-100/50 mt-2 rounded-sm border border-(--color-line-subtle)">
                        @foreach ($task->cuts as $cut)
                            <div class="relative group/child">
                                <div class="w-full flex items-start p-1 ml-1">
                                    <x-ui.checkbox size="sm" class="mt-0.5" :disabled="$disabled" :checked="$checked" />
                                    <x-ui.textarea
                                        class="bg-transparent! border-none! shadow-none! outline-none! ring-0! p-0! mr-6 focus:ring-0! focus:border-none!"
                                        rows="1" resize="none">{{ $cut->title }}</x-ui.textarea>
                                </div>
                                @if (!$loop->last)
                                    <x-ui.line-divider opacity="10" class="-mt-0.5" />
                                @endif
                                <div
                                    class="absolute top-1.5 right-1 opacity-0 group-hover/child:opacity-100 transition-opacity cursor-grab">
                                    <x-ui.icon name="ps:dots-six-vertical"
                                        class="text-(--color-theme-600) dark:text-(--color-theme-300)" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-ui.card>
        </x-slot:trigger>

        <x-slot:menu>
            <x-ui.context.item icon="pencil">
                Edit
            </x-ui.context.item>

            <x-ui.context.item icon="document-duplicate">
                Duplicate
            </x-ui.context.item>

            <x-ui.context.item icon="shield-check" disabled>
                Protected Action
            </x-ui.context.item>

            <x-ui.context.item icon="trash" variant="danger" wire:click="deleteTask({{ $task->id }})">
                Delete
            </x-ui.context.item>
        </x-slot:menu>
    </x-ui.context>
</div>
