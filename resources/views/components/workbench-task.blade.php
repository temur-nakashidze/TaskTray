@props([
    'meta' => true,
    'task' => null,
    'draggable' => true,
    'context' => 'todo',
    'id' => null,
])
@php
    $cardClass = match ($context) {
        'todo' => '',
        'active' => '',
        'completed' => 'opacity-80!',
        default => '',
    };
@endphp

<div {{ $attributes }}>
    <x-ui.context :trap="true">
        <x-slot:trigger>
            <x-ui.card variant="solid" size="md"
                {{ $attributes->merge([
                    'class' => \Illuminate\Support\Arr::toCssClasses(['p-2!', 'relative', 'group/parent', $cardClass]),
                ]) }}>

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
                    @if ($draggable)
                        <x-ui.handle x-sort:handle
                            class="absolute -left-1.5 top-0.75 group-hover/task:opacity-100 opacity-30 transition-opacity" />
                    @endif
                    <x-ui.text size="md" class="w-full">{{ $task->title }}</x-ui.text>

                    @php
                        if ($task->runningTimeEntry === null) {
                            $icon = 'ps:play';
                        } else {
                            $icon = 'ps:pause';
                        }
                    @endphp
                    <div x-data="{
                        elapsed: {{ $task->timeEntries->whereNotNull('ended_at')->sum(fn($entry) => $entry->started_at->diffInSeconds($entry->ended_at)) }},
                        startedAt: {{ $task->runningTimeEntry?->started_at?->timestamp ?? 'null' }},
                        now: Math.floor(Date.now() / 1000),
                    
                        get seconds() {
                            if (!this.startedAt) {
                                return this.elapsed;
                            }
                    
                            return this.elapsed + Math.max(0, this.now - this.startedAt);
                        },
                    
                        formatTime(seconds) {
                            const hours = Math.floor(seconds / 3600);
                            const minutes = Math.floor((seconds % 3600) / 60);
                            const secs = seconds % 60;
                    
                            if (hours > 0) {
                                return [
                                    hours,
                                    minutes,
                                    secs,
                                ].map(value => String(value).padStart(2, '0')).join(':');
                            }
                    
                            return [
                                minutes,
                                secs,
                            ].map(value => String(value).padStart(2, '0')).join(':');
                        },
                    
                        init() {
                            setInterval(() => {
                                this.now = Math.floor(Date.now() / 1000);
                            }, 1000);
                        }
                    }" class="flex items-center gap-2">
                        <x-ui.text x-text="formatTime(seconds)">00:00</x-ui.text>

                        @if ($context !== 'completed')
                            <x-ui.button variant="soft" wire:click="toggleTimer({{ $id }})"
                                icon="{{ $task->runningTimeEntry ? 'ps:pause' : 'ps:play' }}" size="sm" />
                        @endif
                        @if ($context === 'completed')
                            <x-ui.button wire:click="restoreTask({{ $id }})" variant="soft"
                                icon="ps:arrow-u-right-up" size="sm" />
                        @endif

                        @if ($context === 'active')
                            <x-ui.button wire:click="completeTask({{ $id }})" variant="soft" icon="ps:check"
                                size="sm" />
                        @endif
                    </div>


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
