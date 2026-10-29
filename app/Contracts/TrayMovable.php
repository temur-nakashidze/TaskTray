<?php

namespace App\Contracts;

interface TrayMovable
{
    /**
     * Move into the tray the destination resolves to.
     * $position: 0-based slot in that tray (0 = first place, the default); null = last.
     */
    public function moveTo(
        ResolvesTray $destination,
        ?int $position = 0,
    ): static;
}
