<?php

namespace App\Livewire\Concerns;

use App\Contracts\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use LogicException;

/**
 * Reorder inside one list. Moving between lists is WithTaskMoving.
 */
trait WithSorting
{
    /**
     * Records sortItem() may reorder. Override it to use sortItem();
     * for other models call sortUsing() from your own action.
     */
    protected function sortableQuery(): Builder
    {
        throw new LogicException(
            static::class . " must override sortableQuery() to use sortItem().",
        );
    }

    /** x-sort="$wire.sortItem($item, $position)" */
    public function sortItem(int|string $id, int $position): void
    {
        $this->sortUsing($this->sortableQuery(), $id, $position);
    }

    protected function sortUsing(
        Builder $scope,
        int|string $id,
        int $position,
    ): void {
        $model = $scope->findOrFail($id);

        if (!$model instanceof Sortable) {
            throw new LogicException(
                $model::class . " must implement " . Sortable::class,
            );
        }

        // $this->authorizeSorting($model);

        $model->moveToPosition($position);
    }

    /** Override to customise. Default: fail closed unless a policy allows "update". */
    protected function authorizeSorting(Model $model): void
    {
        Gate::authorize("update", $model);
    }
}
