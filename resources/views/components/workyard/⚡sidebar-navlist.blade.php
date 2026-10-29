<?php

use App\Models\Project;
use App\Models\Workbench;
use App\Models\Tag;
use App\Models\Task;
use App\Models\Tray;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Livewire\Concerns\WithSorting;
use App\Livewire\Concerns\WithTaskMoving;
use App\Livewire\Concerns\WithWorkbenchPulling;

new class extends Component {
    use WithSorting, WithTaskMoving, WithWorkbenchPulling;

    public string $projectName = '';
    public string $trayName = '';

    // Built on every request, so ordering survives re-renders after a drag.
    #[Computed]
    public function projects()
    {
        return Project::query()
            ->ordered()
            ->with([
                'trays' => fn($q) => $q->ordered()->withCount('tasks'),
                'workbench' => fn($q) => $q->withCount('workbenchTasks'),
            ])
            ->get();
    }

    #[Computed]
    public function tags()
    {
        return Tag::all();
    }

    // Trays that belong to projects (trays are polymorphic: trayable_type / trayable_id).
    private function projectTrays(): Builder
    {
        return Tray::query()
            ->where('trayable_type', new Project()->getMorphClass())
            ->whereIn('trayable_id', Project::query()->select('id'));
    }

    // Default action sortItem(): projects.
    protected function sortableQuery(): Builder
    {
        return Project::query();
    }

    // Tasks the sidebar may move (dragged in from the page).
    protected function movableTasks(): Builder
    {
        return Task::query();
    }

    // Drop on a project -> its unsorted tray, drop on a tray row -> that tray (first place).
    protected function taskDestinations(): array
    {
        return [
            'project' => fn() => Project::query(),
            'tray' => fn() => $this->projectTrays(),
        ];
    }

    // Tasks the sidebar may pull into a Workbench.
    protected function pullableTasks(): Builder
    {
        return Task::query();
    }

    // 'workbench:ID' -> the project's Workbench.
    protected function workbenchDestinations(): array
    {
        return ['workbench' => fn() => Workbench::query()->whereIn('project_id', Project::query()->select('id'))];
    }

    // An open Workbench page (other component) should refresh.
    protected function afterWorkbenchPull(Workbench $workbench, Model $task): void
    {
        $this->dispatch('workbench-changed');
    }

    // The open page lives in another component: tell it to refresh.
    protected function afterTaskMoved(Model $task): void
    {
        $this->dispatch('tasks-moved');
    }

    // x-sort="$wire.sortTray($item, $position)": reorder trays inside a project.
    public function sortTray(int $id, int $position): void
    {
        $this->sortUsing($this->projectTrays(), $id, $position);
    }

    public function addProject(): void
    {
        $this->validate([
            'projectName' => 'required|string|max:255',
        ]);

        Project::create([
            'name' => $this->projectName,
            'user_id' => 1,
        ]);

        $this->projectName = '';

        $this->dispatch('close-modal', id: 'AddProjectModal');
    }

    // Created through the relation so trayable_type / trayable_id are set before HasPosition appends it.
    public function addTray(int $projectId): void
    {
        $this->validate([
            'trayName' => 'required|string|max:255',
        ]);

        Project::query()
            ->findOrFail($projectId)
            ->trays()
            ->create([
                'name' => $this->trayName,
            ]);

        $this->trayName = '';
    }

    #[On('workbench-updated')]
    public function refreshAfterPull(): void {}
};
?>

<div>

    <div class="max-w-80 p-3">
        <div
            class="flex items-center border-b border-(--color-line-subtle) px-(--padding-box-sm) pb-(--padding-box-sm) -mx-(--padding-box-sm)">
            <x-ui.brand name="TaskTray">
                <x-slot:logo>
                    <x-ui.icon name="ps:kanban" variant="duotone" class="text-theme-500 size-10" />
                </x-slot:logo>
            </x-ui.brand>
        </div>
        <div class="mt-3 space-y-(--gap-section)">

            <div class="p-1! flex items-center gap-2 group" x-on:click="window.location.href = '{{ route('dropzone') }}'"
                wire:navigate>
                <div class="bg-(--color-neutral-100) p-2 rounded-sm">
                    <x-ui.icon name="ps:box-arrow-down" variant="duotone" class="fill-(--color-ink-muted)" />
                </div>
                <x-ui.heading
                    class="text-(--color-ink-muted)! group-hover:text-(--color-ink-base)! transition-colors duration-150">Dropzone</x-ui.heading>
                <x-ui.spacer />
                <x-ui.badge size="sm" variant="soft">23</x-ui.badge>

            </div>

            <div class="text-(--color-ink-muted) mt-4 ">

                <div class="flex items-center gap-2 mb-2 px-1 group">
                    <x-ui.description>
                        Projects
                    </x-ui.description>
                    <x-ui.spacer />
                    <x-ui.modal.trigger id="AddProjectModal">
                        <x-ui.button variant="soft" icon="ps:plus" size="xs"
                            class="opacity-0 group-hover:opacity-100 transition-opacity" />
                    </x-ui.modal.trigger>
                </div>

                <div x-sort="$wire.sortItem($item, $position)" class="space-y-(--gap-form)">
                    @foreach ($this->projects as $project)
                        <x-ui.card x-sort:item="{{ $project->id }}" wire:key="project-{{ $project->id }}"
                            x-data="{ open: false }" x-transition size="md" class="p-1! group/project">
                            <div class="p-1 flex items-center justify-between w-full gap-2 relative group">
                                <div class="flex items-center gap-1">
                                    <x-ui.handle x-sort:handle x-on:click.stop group="project"
                                        class="opacity-30 group-hover:opacity-100" />
                                    <a href="{{ route('project', $project) }}" wire:navigate>
                                        <x-ui.heading
                                            class="text-(--color-ink-muted)! group-hover:text-(--color-ink-base)! transition-colors duration-150">{{ $project->name }}</x-ui.heading>
                                    </a>
                                    <x-ui.button variant="ghost" icon="ps:caret-down"
                                        class="opacity-30 group-hover:opacity-100" size="xs"
                                        x-on:click.stop="open = !open" />
                                </div>
                                <a href="{{ route('workbench', $project) }}">
                                    <x-workbench-drop :workbench="$project->workbench?->id">
                                        <x-ui.badge color="neutral" variant="outline" icon="ps:hammer"
                                            iconVariant="duotone">{{ $project->workbench?->workbench_tasks_count ?? 0 }}</x-ui.badge>
                                    </x-workbench-drop>
                                </a>

                                {{-- drop target: task -> project's unsorted tray --}}
                                {{-- <div x-sort="$wire.moveTask($item, 'project:{{ $project->id }}'); queueMicrotask(() => $el.replaceChildren())"
                                    x-sort:group="tasks"
                                    class="absolute inset-0 z-10 pointer-events-none in-[.sorting]:pointer-events-auto">
                                </div> --}}
                            </div>
                            <div x-bind:class="{ 'grid-rows-[1fr]!': open }"
                                class="grid grid-rows-[0fr] group-has-[a[data-current]]/project:grid-rows-[1fr]
                                       transition-[grid-template-rows] duration-300 ease-out motion-reduce:transition-none">

                                <div class="min-h-0 overflow-hidden">
                                    <div
                                        class="mt-1 bg-(--color-neutral-100)/40 p-1.5 rounded-sm border border-(--color-line-subtle)/50 flex flex-col items-start">

                                        {{-- Trays of this project: reorder with the handle, drop a task on a row to put it first in that tray. --}}
                                        <div x-sort="$wire.sortTray($item, $position)" class="w-full">
                                            @foreach ($project->trays as $tray)
                                                <div x-sort:item="{{ $tray->id }}" x-transition
                                                    wire:key="tray-{{ $tray->id }}" class="w-full">
                                                    <div
                                                        class="relative w-full flex items-center group px-1 py-2 gap-2 rounded-sm">

                                                        <x-ui.handle x-sort:handle
                                                            class="opacity-30 group-hover:opacity-100 transition-opacity" />
                                                        <a href="{{ route('project', $project) }}#tray-{{ $tray->id }}"
                                                            wire:navigate class="flex-1">
                                                            <x-ui.heading color="muted"
                                                                font="mono">{{ $tray->name }}</x-ui.heading>
                                                        </a>
                                                        <x-ui.badge size="sm"
                                                            variant="soft">{{ $tray->tasks_count }}</x-ui.badge>

                                                        {{-- drop target: task -> this tray, first place --}}
                                                        <div x-sort="$wire.moveTask($item, 'tray:{{ $tray->id }}'); queueMicrotask(() => $el.replaceChildren())"
                                                            x-sort:group="tasks"
                                                            class="absolute inset-0 z-10 pointer-events-none in-[.sorting]:pointer-events-auto">
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>

                                        <div x-sort:ignore x-data="{ trayInput: false }" @click.outside="trayInput = false"
                                            class="w-full relative">
                                            <x-ui.button variant="ghost" icon="plus" label="Add Tray"
                                                class="w-full justify-start! pl-1 opacity-50 hover:opacity-100"
                                                x-on:click.stop="trayInput = !trayInput" />
                                            <div x-show="trayInput" class="w-full absolute top-0" x-transition x-cloak>
                                                <form wire:submit.prevent="addTray({{ $project->id }})"
                                                    x-on:submit="trayInput = false">
                                                    <x-ui.input wire:model="trayName" placeholder="" />
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </x-ui.card>
                    @endforeach

                </div>
            </div>

            <div class="text-(--color-ink-muted)">
                <div class="flex items-center gap-2 mb-2 px-1 group">
                    <x-ui.description>
                        tags
                    </x-ui.description>
                    <x-ui.spacer />
                    <x-ui.button variant="ghost" icon="ps:plus" size="xs"
                        class="opacity-0 group-hover:opacity-100" />
                </div>
                <x-ui.card class="flex flex-inline flex-wrap gap-(--gap-form)">
                    @foreach ($this->tags as $tag)
                        <x-ui.tag name="{{ $tag->name }}" color="{{ $tag->color }}" />
                    @endforeach
                </x-ui.card>
            </div>


        </div>
    </div>



    <x-ui.modal id="AddProjectModal" heading="Add New Project">
        <x-ui.field>
            <x-ui.label>Project Name</x-ui.label>
            <x-ui.input wire:model="projectName" type="text" placeholder="Placeholder" />
            <x-ui.error name="projectName" />
        </x-ui.field>


        <x-slot name="footer">
            <div class="flex w-full justify-end space-x-3">
                <x-ui.button x-on:click="$data.close();" variant="ghost">
                    Cancel
                </x-ui.button>
                <x-ui.button wire:click="addProject" variant="primary">
                    Add
                </x-ui.button>
            </div>
        </x-slot>
    </x-ui.modal>

</div>
