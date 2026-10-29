<?php

namespace App\Livewire\Concerns;

use App\Contracts\ResolvesTray;
use App\Contracts\TrayMovable;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use LogicException;

trait WithTaskMoving
{
    /** Tasks THIS page may move. The browser only sends an id, so this scope is the guard. */
    abstract protected function movableTasks(): Builder;

    /**
     * What a task may be dropped on, keyed by the alias used in the view ('tray:5', 'shelf:3').
     * Each value is a Builder (or Closure returning one) of ResolvesTray models, scoped to this page.
     *
     * @return array<string, Builder|Closure>
     */
    abstract protected function taskDestinations(): array;

    /**
     * Exact slot in a tray list:  x-sort="$wire.moveTask($item, 'tray:{{ $tray->id }}', $position)"
     * Card / chip / menu item:    $wire.moveTask($item, 'shelf:3')   -> first place by default
     */
    public function moveTask(
        int|string $id,
        string $to,
        ?int $position = 0,
    ): void {
        $task = $this->movableTasks()->findOrFail($id);

        if (!$task instanceof TrayMovable) {
            throw new LogicException(
                $task::class . " must implement " . TrayMovable::class,
            );
        }

        // $this->authorizeTaskMove($task);

        $task->moveTo($this->resolveTaskDestination($to), $position);
    }

    /** Override to customise. Default: fail closed unless a policy allows "update". */
    protected function authorizeTaskMove(Model $task): void
    {
        Gate::authorize("update", $task);
    }

    private function resolveTaskDestination(string $to): ResolvesTray
    {
        [$alias, $id] = array_pad(explode(":", $to, 2), 2, null);

        $source = $this->taskDestinations()[$alias] ?? null;
        $query = $source instanceof Closure ? $source() : $source;

        abort_unless($query instanceof Builder && $id !== null, 403);

        $destination = $query->whereKey($id)->first() ?? abort(403);

        if (!$destination instanceof ResolvesTray) {
            throw new LogicException(
                $destination::class . " must implement " . ResolvesTray::class,
            );
        }

        return $destination;
    }
}
