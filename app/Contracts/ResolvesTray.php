<?php

namespace App\Contracts;

use App\Models\Tray;

/**
 * Something a task can be dropped on. It always resolves to ONE tray:
 *   Tray    -> itself
 *   Shelf   -> its unsorted tray
 *   Project -> its unsorted tray (the one owned directly by the project)
 * Workbench does not implement it, so it can never be a task destination.
 */
interface ResolvesTray
{
    public function trayForTasks(): Tray;
}
