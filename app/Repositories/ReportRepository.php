<?php

namespace App\Repositories;

use App\Enums\ItemType;
use App\Enums\TaskStatus;
use App\Models\Item;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ReportRepository
{
    /**
     * Tag IDs whose normalized name is "done".
     *
     * @return array<int, int>
     */
    private function getDoneTagIds(): array
    {
        return Tag::query()
            ->get()
            ->filter(fn (Tag $t) => Tag::normalizeName($t->name) === 'done')
            ->pluck('id')
            ->all();
    }

    /**
     * Task items that are "done" (task_status = done or item has tag "done") and in scope for the period
     * (task.due_date or item.expires_at within period).
     *
     * @return Collection<int, Item>
     */
    public function getDoneTaskItemsInPeriod(Carbon $periodStart, Carbon $periodEnd): Collection
    {
        $doneTagIds = $this->getDoneTagIds();

        return Item::query()
            ->where('type', ItemType::Task->value)
            ->whereHas('task')
            ->with('task')
            ->where(function ($q) use ($periodStart, $periodEnd) {
                $q->whereBetween('expires_at', [$periodStart, $periodEnd])
                    ->orWhereHas('task', fn ($t) => $t->whereBetween('due_date', [$periodStart, $periodEnd]));
            })
            ->where(function ($q) use ($doneTagIds) {
                $q->whereHas('task', fn ($t) => $t->where('task_status', TaskStatus::Done->value))
                    ->orWhereHas('tags', fn ($t) => $t->whereIn('tags.id', $doneTagIds));
            })
            ->orderBy('title')
            ->get();
    }

    /**
     * Task items that expired in the period and are not done (missed).
     *
     * @return Collection<int, Item>
     */
    public function getMissedTaskItemsInPeriod(Carbon $periodStart, Carbon $periodEnd): Collection
    {
        $doneTagIds = $this->getDoneTagIds();

        $query = Item::query()
            ->where('type', ItemType::Task->value)
            ->whereNotNull('expires_at')
            ->whereBetween('expires_at', [$periodStart, $periodEnd])
            ->whereHas('task')
            ->with('task')
            ->whereHas('task', fn ($t) => $t->where('task_status', '!=', TaskStatus::Done->value));

        if ($doneTagIds !== []) {
            $query->whereDoesntHave('tags', fn ($t) => $t->whereIn('tags.id', $doneTagIds));
        }

        return $query->orderBy('expires_at')->get();
    }

    /**
     * All task items in scope for the period (due_date or expires_at in period). Used for productivity denominator.
     *
     * @return Collection<int, Item>
     */
    public function getTaskItemsInPeriod(Carbon $periodStart, Carbon $periodEnd): Collection
    {
        return Item::query()
            ->where('type', ItemType::Task->value)
            ->whereHas('task')
            ->with('task')
            ->where(function ($q) use ($periodStart, $periodEnd) {
                $q->whereBetween('expires_at', [$periodStart, $periodEnd])
                    ->orWhereHas('task', fn ($t) => $t->whereBetween('due_date', [$periodStart, $periodEnd]));
            })
            ->get();
    }
}
