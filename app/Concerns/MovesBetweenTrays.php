<?php

namespace App\Concerns;

use App\Contracts\ResolvesTray;
use App\Models\Tray;
use App\Models\Workbench;
use InvalidArgumentException;

/**
 * For Task. Requires a tray() BelongsTo relation and the HasPosition trait
 * (group columns ['tray_id']).
 */
trait MovesBetweenTrays
{
    public function moveTo(
        ResolvesTray $destination,
        ?int $position = 0,
    ): static {
        $tray = $destination->trayForTasks();

        $this->guardTray($tray);

        $this->getConnection()->transaction(function () use ($tray, $position) {
            if (
                (string) $this->getAttribute("tray_id") !==
                (string) $tray->getKey()
            ) {
                $this->tray()->associate($tray);
                $this->save();
            }

            // Now inside the destination tray: place it. (Same tray = plain reorder.)
            // The old tray keeps a harmless gap in its numbering, every reorder re-numbers its list.
            $this->moveToPosition($position ?? PHP_INT_MAX);
        });

        return $this;
    }

    /** Safety net: tasks never live in a Workbench tray (those hold WorkbenchTask references). */
    protected function guardTray(Tray $tray): void
    {
        if ($tray->trayable_type === new Workbench()->getMorphClass()) {
            throw new InvalidArgumentException(
                "Tasks cannot be moved into a Workbench tray.",
            );
        }
    }
}
