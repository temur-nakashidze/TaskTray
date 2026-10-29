<?php
namespace App\Services;

use App\Models\Task;
use App\Models\TimeEntry;

class TaskTimer
{
    public function runningEntry(Task $task): ?TimeEntry
    {
        return $task->runningTimeEntry;
    }

    public function isRunning(Task $task): bool
    {
        return $task->runningTimeEntry !== null;
    }

    public function elapsedSeconds(Task $task): int
    {
        $seconds = $task
            ->timeEntries()
            ->whereNotNull("ended_at")
            ->get()
            ->sum(
                fn(TimeEntry $entry) => $entry->started_at->diffInSeconds(
                    $entry->ended_at,
                ),
            );

        if ($entry = $task->runningTimeEntry) {
            $seconds += $entry->started_at->diffInSeconds(now());
        }

        return $seconds;
    }

    public function data(Task $task): array
    {
        $entry = $task->runningTimeEntry;

        return [
            "elapsed" => $this->elapsedSeconds($task),
            "started_at" => $entry?->started_at?->toIso8601String(),
            "running" => $entry !== null,
        ];
    }
}
