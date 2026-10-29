<?php

use App\Models\Project;
use App\Models\Workbench;
use App\Models\WorkbenchTask;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Concerns\Ui\WithHeader;
use App\Livewire\Concerns\WithSorting;
use App\Livewire\Concerns\WithTaskMoving;
use App\Livewire\Concerns\WithWorkbenchPulling;

new #[Layout('layouts.workyard')] class extends Component {
    use WithHeader, WithSorting, WithTaskMoving, WithWorkbenchPulling;

    public Project $project;
    public int $workbenchId;
    public array $taskTitles = [];

    public function mount(Project $project): void
    {
        $this->project = $project;
        $this->workbenchId = $project->workbench->id;
    }

    // Built on every request, so ordering and counts survive re-renders after a drag.
    #[Computed]
    public function trays()
    {
        return $this->project
            ->trays()
            ->ordered()
            ->withCount('tasks')
            ->with(['tasks' => fn($query) => $query->ordered()->with('cuts', 'tags')])
            ->get();
    }

    public function pullableTasks(): Builder
    {
        return Task::query();
    }

    public function workbenchDestinations(): array
    {
        return ['workbench' => fn() => Workbench::query()->where('project_id', $this->project->id)];
    }

    // Tasks this page may move: only those inside this project's trays.
    protected function movableTasks(): Builder
    {
        return Task::query()->whereIn('tray_id', $this->project->trays()->select('id'));
    }

    // Where a task may be dropped: this project's trays ('tray:5' in the view).
    protected function taskDestinations(): array
    {
        return ['tray' => fn() => $this->project->trays()->getQuery()];
    }

    // Reorder trays inside the project (step 1 behaviour).
    public function sortTray(int $id, int $position): void
    {
        $this->sortUsing($this->project->trays()->getQuery(), $id, $position);
    }

    public function removeTaskFromWorkbench(int $taskId): void
    {
        WorkbenchTask::query()->where('task_id', $taskId)->delete();
        $this->dispatch('workbench-updated');
    }

    public function addTask(int $trayId): void
    {
        $this->project->tasks()->create([
            'title' => $this->taskTitles[$trayId] ?? '',
            'tray_id' => $trayId,
            'user_id' => 1,
        ]);

        $this->taskTitles[$trayId] = '';

        $this->dispatch('tasks-updated');
    }

    public function deleteTask(int $taskId): void
    {
        Task::query()->where('id', $taskId)->delete();
        $this->dispatch('tasks-updated');
    }

    // A task was dropped in the sidebar: an empty listener is enough, the component re-renders.
    #[On('tasks-moved')]
    public function refreshAfterMove(): void {}
};
?>
<div>
    {{ $this->header([
        'title' => $this->project->name,
        'editable' => true,
        'parent' => 'PB',
    ]) }}
    <div class="p-(--padding-box-lg) ">
        {{-- Trays are reorderable. Needs an x-sort:handle inside the x-tray header. --}}
        <div x-sort="$wire.sortTray($item, $position)"
            x-sort:config="{
                forceFallback: true,
                fallbackOnBody: true,
                animation: 150
            }"
            class="flex items-start gap-(--gap-layout) overflow-x-auto pb-4">
            @forelse ($this->trays as $tray)
                <x-tray x-sort:item="{{ $tray->id }}" wire:key="tray-{{ $tray->id }}" header="{{ $tray->name }}"
                    :count="$tray->tasks_count"
                    x-sort:config="{
                        forceFallback: true,
                        fallbackOnBody: true,
                        animation: 150
                    }"
                    size="md">

                    <x-slot:input>
                        <div class="py-2">
                            <form wire:submit.prevent="addTask('{{ $tray->id }}')">
                                <x-ui.textarea-ghost wire:model="taskTitles.{{ $tray->id }}" rows="1"
                                    class="pl-6! pr-7!" resize="none">
                                    <x-slot:placeholder>
                                        <x-ui.icon name="plus" variant="bold" class="class" />
                                        <span class="text-md">Add Task</span>
                                    </x-slot:placeholder>
                                </x-ui.textarea-ghost>
                            </form>
                        </div>
                    </x-slot:input>

                    {{-- Tasks reorder inside a tray and move between trays (same x-sort:group).
                         Each list names itself as the destination. --}}
                    <div x-sort="$wire.moveTask($item, 'tray:{{ $tray->id }}', $position);" x-sort:group="tasks"
                        class="flex min-h-16 flex-col gap-(--gap-cards)"
                        x-sort:config="{
                            forceFallback: true,
                            fallbackOnBody: true,
                            animation: 150
                        }">
                        @forelse ($tray->tasks as $task)
                            <x-task x-sort:item="{{ $task->id }}" wire:key="task-{{ $task->id }}"
                                :meta="false" :task="$task" :id="$task->id" :title="$task->title"
                                :tags="$task->tags" :note="$task->body" :workbenchId="$workbenchId" :hasReference="$task->inWorkbench()" />
                        @empty
                            <div x-sort:ignore>
                                <x-ui.empty>
                                    <x-ui.empty.media>
                                        <x-ui.icon name="ps:check-square" class="size-10 text-(--color-theme-400)/50" />
                                    </x-ui.empty.media>
                                    <x-ui.empty.contents>
                                        <x-ui.heading color="muted">No Tasks</x-ui.heading>
                                        <x-ui.text variant="subtle">
                                            Add a task to get started.
                                        </x-ui.text>
                                    </x-ui.empty.contents>
                                </x-ui.empty>
                            </div>
                        @endforelse
                    </div>
                </x-tray>
            @empty
                <x-ui.empty>
                    <x-ui.empty.media>
                        <x-ui.icon name="user" class="size-10" />
                    </x-ui.empty.media>
                    <x-ui.empty.contents>
                        <x-ui.heading>No Trays</x-ui.heading>
                        <x-ui.text variant="muted">
                            Create a new tray to get started.
                        </x-ui.text>
                        <x-ui.button variant="outline" label="Create Tray" icon="ps:tray" />
                    </x-ui.empty.contents>
                </x-ui.empty>
            @endforelse
        </div>
    </div>
</div>
