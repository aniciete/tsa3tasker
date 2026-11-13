<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent model for the Tasker `tasks` table with reusable date query scopes.
 */
#[Fillable(['title', 'status', 'task_date'])]
class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_COMPLETED = 'completed';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'task_date' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Scope a query to tasks scheduled for the current calendar date.
     */
    #[Scope]
    protected function forToday(Builder $query): void
    {
        $query->whereDate('task_date', now()->toDateString());
    }

    /**
     * Scope a query to order tasks chronologically by scheduled date and ID.
     */
    #[Scope]
    protected function orderedByDate(Builder $query): void
    {
        $query->orderBy('task_date', 'asc')->orderBy('id', 'asc');
    }
}
