<?php

namespace App\Repositories;

use App\Enums\TaskStatus;
use App\Models\Item;
use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    /**
     * Paginated list of items where type=task, with task relation. Filters: priority, task_status, due_from, due_to.
     */
    public function listTaskItems(array $filters = [], int $perPage = 30): LengthAwarePaginator
    {
        $query = Item::query()
            ->where('items.type', 'task')
            ->join('tasks', 'items.id', '=', 'tasks.item_id')
            ->select('items.*')
            ->with('task')
            ->orderByDesc('tasks.due_date');

        if (! empty($filters['priority'])) {
            $query->where('tasks.priority', $filters['priority']);
        }

        if (! empty($filters['task_status'])) {
            $query->where('tasks.task_status', $filters['task_status']);
        }

        if (! empty($filters['due_from'])) {
            $query->where('tasks.due_date', '>=', $filters['due_from']);
        }

        if (! empty($filters['due_to'])) {
            $query->where('tasks.due_date', '<=', $filters['due_to']);
        }

        return $query->paginate($perPage);
    }

    public function findByItemId(int $itemId): ?Task
    {
        return Task::query()->where('item_id', $itemId)->first();
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);

        return $task->fresh();
    }

    /**
     * Tasks due today (date only, app timezone) that are not done, with item loaded.
     *
     * @return Collection<int, Task>
     */
    public function getTasksDueTodayNotDone(): Collection
    {
        $today = now()->toDateString();

        return Task::query()
            ->with('item')
            ->whereDate('due_date', $today)
            ->where('task_status', '!=', TaskStatus::Done->value)
            ->orderBy('due_date')
            ->get();
    }
}
