<?php

namespace App\Livewire\Concerns;

use App\Models\Task;
use App\Models\Tray;
use App\Models\Workbench;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use LogicException;

/**
 * Drop a task on a Workbench: creates a WorkbenchTask representation.
 * The real task is NOT moved and keeps its tray. Not related to WithTaskMoving.
 */
trait WithWorkbenchPulling
{
    /** Tasks THIS page may pull. The browser only sends an id, so this scope is the guard. */
    abstract protected function pullableTasks(): Builder;

    /**
     * Where a task may be pulled, keyed by the alias used in the view:
     *   'workbench:3' -> the Workbench's unsectioned area
     *   'tray:8'      -> a Workbench-owned tray
     * Each value is a Builder (or Closure returning one) of Workbench / Tray models, scoped to this page.
     *
     * @return array<string, Builder|Closure>
     */
    abstract protected function workbenchDestinations(): array;

    /** <x-workbench-drop :workbench="$id"> calls $wire.pullToWorkbench($item, 'workbench:ID') */
    public function pullToWorkbench(int|string $id, string $to): void
    {
        $task = $this->pullableTasks()->findOrFail($id);

        // $this->authorizeWorkbenchPull($task);

        $workbench = $this->resolveWorkbenchDestination($to);

        abort_unless($workbench instanceof Workbench, 403);

        $workbench->pull($task);

        $this->afterWorkbenchPull($workbench, $task);
    }

    /** Override to customise. Default: fail closed unless a policy allows "update". */
    protected function authorizeWorkbenchPull(Model $task): void
    {
        Gate::authorize("update", $task);
    }

    /** Hook, e.g. dispatch an event so an open Workbench page refreshes. */
    protected function afterWorkbenchPull(
        Workbench $workbench,
        Model $task,
    ): void {
        $this->dispatch("workbench-updated");
    }

    private function resolveWorkbenchDestination(string $to): Workbench
    {
        [$alias, $id] = array_pad(explode(":", $to, 2), 2, null);

        $source = $this->workbenchDestinations()[$alias] ?? null;
        $query = $source instanceof Closure ? $source() : $source;
        abort_unless($query instanceof Builder && $id !== null, 403);

        $destination = $query->whereKey($id)->first() ?? abort(403);

        if (!$destination instanceof Workbench) {
            throw new LogicException(
                "A workbench destination must resolve to a Workbench.",
            );
        }

        return $destination;
    }
}
