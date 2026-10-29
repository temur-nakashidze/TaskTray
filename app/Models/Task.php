<?php

namespace App\Models;

use App\Concerns\HasPosition;
use App\Concerns\MovesBetweenTrays;
use App\Contracts\Sortable;
use App\Contracts\TrayMovable;
use App\Observers\TaskObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Table('tasks')]
#[
    Fillable([
        'user_id',
        'project_id',
        'tray_id',
        'title',
        'note',
        'completed_at',
        'position',
    ]),
]
#[ObservedBy([TaskObserver::class])]
class Task extends Model implements Sortable, TrayMovable
{
    use HasFactory;
    use HasPosition;
    use MovesBetweenTrays;
    use SoftDeletes;

    public function positionGroupColumns(): array
    {
        return ['tray_id'];
    }

    protected function casts(): array
    {
        return [
            'position' => 'integer',
            'blocked_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function tray(): BelongsTo
    {
        return $this->belongsTo(Tray::class);
    }

    public function cuts(): HasMany
    {
        return $this->hasMany(Cut::class)->orderBy('position');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'task_tag');
    }

    /**
     * Workbench pull references pointing at this task (0, or 1 active
     * reference per workbench in practice, enforced in the app layer).
     */
    public function workbenchReference(): HasOne
    {
        return $this->hasOne(WorkbenchTask::class);
    }

    public function inWorkbench(): bool
    {
        return $this->workbenchReference()->exists();
    }

    /**
     * Whether this task is allowed to be marked complete right now, i.e.
     * it has no incomplete Cuts. Enforced for real in TaskObserver::saving().
     */
    public function canBeCompleted(): bool
    {
        return $this->cuts()->where('completed_at', null)->doesntExist();
    }

    /**
     * Tasks with no project at all - the Dropzone view.
     */
    #[Scope]
    protected function inDropzone(Builder $query): void
    {
        $query->whereNull('project_id');
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->whereNull('completed_at');
    }

    #[Scope]
    protected function scopeCompleted(Builder $query): void
    {
        $query->whereNotNull('completed_at');
    }

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function runningTimeEntry(): HasOne
    {
        return $this->hasOne(TimeEntry::class)->whereNull('ended_at');
    }
}
