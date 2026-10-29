<?php

use App\Actions\TimeTracking\PauseTaskTimer;
use App\Actions\TimeTracking\StartTaskTimer;
use App\Actions\Workbench\ClearCompletedTasks;
use App\Actions\Workbench\CompleteTask;
use App\Actions\Workbench\RestoreTask;
use App\Concerns\Ui\WithHeader;
use App\Livewire\Concerns\WithSorting;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Workbench;
use App\Models\WorkbenchTask;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

new #[Layout('layouts.workyard')] class extends Component
{
    use WithHeader, WithSorting;

    public Workbench $workbench;

    public User $user;

    public function mount(Project $project)
    {
        $this->workbench = $project->workbench;
        $this->user = User::findOrFail(1);
    }

    #[Computed]
    public function workbenchTasks()
    {
        return $this->workbench
            ->workbenchTasks()
            ->with(['task', 'task.cuts', 'task.tags', 'task.timeEntries', 'task.runningTimeEntry'])
            ->ordered()
            ->get();
    }

    #[Computed]
    public function unplayedTasks()
    {
        return $this->workbenchTasks->filter(fn (WorkbenchTask $wt) => $wt->task->timeEntries->isEmpty());
    }

    #[Computed]
    public function playedTasks()
    {
        return $this->workbenchTasks->filter(fn (WorkbenchTask $wt) => $wt->task->timeEntries->isNotEmpty() && $wt->task->completed_at === null);
    }

    #[Computed]
    public function completedTasks()
    {
        return $this->workbenchTasks->filter(fn (WorkbenchTask $wt) => $wt->task->completed_at !== null);
    }

    #[Computed]
    public function runningTask(): ?Task
    {
        return $this->workbenchTasks->first(fn (WorkbenchTask $wt) => $wt->task->runningTimeEntry)?->task;
    }

    // Reorder trays inside the project (step 1 behaviour).
    public function sortWorkbenchTask(int $id, int $position): void
    {
        $this->sortUsing($this->workbench->workbenchTasks()->getQuery(), $id, $position);
    }

    public function toggleTimer(WorkbenchTask $workbenchTask): void
    {
        $task = $workbenchTask->task;

        if ($task->runningTimeEntry) {
            app(PauseTaskTimer::class)->handle($this->user);
        } else {
            app(StartTaskTimer::class)->handle($task, $this->user);
        }

        unset($this->workbenchTasks);
    }

    public function toggleGlobalTimer(): void
    {
        $user = User::findOrFail(1);

        $runningEntry = $user->timeEntries()->whereNull('ended_at')->first();

        if ($runningEntry) {
            app(PauseTaskTimer::class)->handle($this->user);

            unset($this->workbenchTasks);

            return;
        }

        $lastEntry = $user->timeEntries()->whereNotNull('ended_at')->latest('started_at')->first();

        if (! $lastEntry) {
            return;
        }

        app(StartTaskTimer::class)->handle($lastEntry->task, $this->user);

        unset($this->workbenchTasks);
    }

    public function completeTask(WorkbenchTask $workbenchTask)
    {
        app(CompleteTask::class)->handle($workbenchTask->task, $this->user);
    }

    public function restoreTask(WorkbenchTask $workbenchTask)
    {
        app(RestoreTask::class)->handle($workbenchTask->task);
    }

    public function clearCompleted(): void
    {
        app(ClearCompletedTasks::class)->handle($this->workbench);

        unset($this->workbenchTasks);
    }

    // A task was pulled in from the sidebar: an empty listener is enough, the component re-renders.
    #[On('workbench-changed')]
    public function refreshAfterPull(): void {}
};
?>
<div>
    {{ $this->header([
        'title' => $this->workbench->project->name,
        'editable' => false,
        'isWorkbench' => true,
        'icon' => 'ps:hammer',
    ]) }}

    <x-ui.working-surface>


        <div class="p-(--gap-layout) min-h-screen grid grid-cols-2 gap-(--gap-layout)">
            <div class="space-y-(--gap-layout)">


                {{-- Tasks in Progress --}}
                <x-ui.card class="border-emerald-600/50!">
                    <div class="flex items-center justify-between pb-3">
                        <x-ui.heading size="xl" class="text-emerald-700" font="mono">Active</x-ui.heading>
                        <x-ui.button variant="soft" :icon="$this->runningTask ? 'ps:pause' : 'ps:play'" color="emerald" size="sm"
                            wire:click="toggleGlobalTimer" />
                    </div>

                    <div class="-mx-4">
                        <x-ui.line-divider opacity="25" thickness="1" color="var(--color-emerald-700)" />
                    </div>
                    <div x-sort="$wire.sortWorkbenchTask($item, $position)"
                        class="flex flex-col mt-4 space-y-(--gap-cards)">
                        @forelse ($this->playedTasks as $playedTask)
                            <x-workbench-task context="active" x-sort:item="{{ $playedTask->id }}"
                                wire:key="wt-{{ $playedTask->id }}" :meta="false" :task="$playedTask->task"
                                id="{{ $playedTask->id }}" class="h-full" />
                        @empty
                            <x-ui.empty>
                                <x-ui.empty.media>
                                    <x-ui.icon name="ps:hammer" class="size-10 text-emerald-700" />
                                </x-ui.empty.media>
                                <x-ui.empty.contents>
                                    <x-ui.heading font="sans" class="text-emerald-700">Nothing on the
                                        bench</x-ui.heading>
                                    <x-ui.text font="sans" class="text-emerald-700/60">Drop a task on the Workbench
                                        button to pull
                                        it
                                        in.</x-ui.text>
                                </x-ui.empty.contents>
                            </x-ui.empty>
                        @endforelse
                    </div>
                </x-ui.card>


                {{-- Completed Tasks --}}
                <x-ui.card color="neutral" state="active">
                    <div class="flex items-center justify-between pb-3">
                        <x-ui.heading size="xl" color="subtle" font="mono">Done</x-ui.heading>
                        <x-ui.button variant="soft" icon="ps:broom" color="neutral" size="sm" />

                    </div>
                    <div class="-mx-4">
                        <x-ui.line-divider opacity="25" thickness="1" />
                    </div>
                    <div x-sort="$wire.sortWorkbenchTask($item, $position)" class="flex flex-col space-y-(--gap-cards)">
                        @forelse ($this->completedTasks as $completedTask)
                            <x-workbench-task context="completed" x-sort:item="{{ $completedTask->id }}"
                                wire:key="wt-{{ $completedTask->id }}" :meta="false" id="{{ $completedTask->id }}"
                                :task="$completedTask->task" class="h-full" />
                        @empty
                            <x-ui.empty>
                                <x-ui.empty.contents>
                                    <x-ui.text variant="muted">
                                        you have no completed tasks
                                    </x-ui.text>
                                </x-ui.empty.contents>
                            </x-ui.empty>
                        @endforelse
                    </div>

                </x-ui.card>

            </div>

            <x-ui.card>
                <div class="flex items-center justify-between pb-3">
                    <x-ui.heading size="xl" class="text-sky-700" font="mono">Todo</x-ui.heading>
                    {{-- <x-ui.button variant="soft" icon="ps:pause" color="emerald" size="sm" /> --}}
                </div>

                <div class="-mx-4">
                    <x-ui.line-divider opacity="25" thickness="1" color="var(--color-sky-700)" />
                </div>
                <div x-sort="$wire.sortWorkbenchTask($item, $position)"
                    class="flex flex-col mt-4 space-y-(--gap-cards)">
                    @forelse ($this->unplayedTasks as $unplayedTask)
                        <x-workbench-task context="todo" x-sort:item="{{ $unplayedTask->id }}"
                            wire:key="wt-{{ $unplayedTask->id }}" :meta="false" :task="$unplayedTask->task"
                            id="{{ $unplayedTask->id }}" class="h-full" />
                    @empty
                        <x-ui.empty>
                            <x-ui.empty.media>
                                <x-ui.icon name="ps:hammer" class="size-10 text-(--color-theme-400)/50" />
                            </x-ui.empty.media>
                            <x-ui.empty.contents>
                                <x-ui.heading color="muted">Nothing on the bench</x-ui.heading>
                                <x-ui.text variant="subtle">Drop a task on the Workbench button to pull it
                                    in.</x-ui.text>
                            </x-ui.empty.contents>
                        </x-ui.empty>
                    @endforelse
                </div>
            </x-ui.card>
        </div>

    </x-ui.working-surface>
</div>
