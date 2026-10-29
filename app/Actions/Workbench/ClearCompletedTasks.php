<?php

namespace App\Actions\Workbench;

use App\Models\Workbench;
use Illuminate\Support\Facades\DB;

final class ClearCompletedTasks
{
    public function handle(Workbench $workbench): int
    {
        return DB::transaction(function () use ($workbench) {
            $workbenchTasks = $workbench->workbenchTasks()
                ->with('task.timeEntries')
                ->whereHas(
                    'task',
                    fn ($query) => $query->whereNotNull('completed_at')
                )
                ->get();

            foreach ($workbenchTasks as $workbenchTask) {
                $task = $workbenchTask->task;

                $duration = $task->timeEntries
                    ->whereNotNull('ended_at')
                    ->sum(
                        fn ($entry) => $entry->started_at
                            ->diffInSeconds($entry->ended_at)
                    );

                $task->update([
                    'duration' => $duration,
                ]);

                $task->timeEntries()->delete();
            }

            $count = $workbenchTasks->count();

            $workbenchTasks->each->delete();

            return $count;
        });
    }
}
