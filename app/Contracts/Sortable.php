<?php

namespace App\Contracts;

interface Sortable
{
    /** Integer column that stores the order (0-based index inside the group). */
    public function getPositionColumn(): string;

    /**
     * Columns that together identify the list this record lives in.
     *
     *   Task  -> ['tray_id']
     *   Shelf -> ['project_id']
     *   Tray  -> ['trayable_type', 'trayable_id']   (polymorphic owner)
     *
     * Return [] when the whole table is a single list.
     *
     * @return array<int, string>
     */
    public function positionGroupColumns(): array;

    /** Move this record to a 0-based index inside its CURRENT group and re-number the group. */
    public function moveToPosition(int $position): static;
}
