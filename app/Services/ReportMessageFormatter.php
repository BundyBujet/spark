<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class ReportMessageFormatter
{
    /**
     * Format daily report message for WhatsApp (tasks due today, not done).
     */
    public function formatDaily(Collection $tasks): string
    {
        $date = now()->format('d M Y');

        if ($tasks->isEmpty()) {
            return "*Tasks for today – {$date}*\n\nNo tasks due today.";
        }

        $lines = ["*Tasks for today – {$date}*\n"];
        foreach ($tasks as $task) {
            /** @var Task $task */
            $title = $task->item?->title ?? 'Untitled';
            $due = $task->due_date?->format('h:i A') ?? '–';
            $priority = $task->priority ?? '–';
            $lines[] = "*• {$title}*";
            $lines[] = "Due: {$due} | Priority: {$priority}\n";
        }
        $lines[] = "_You have {$tasks->count()} task(s) to complete today._";

        return implode("\n", $lines);
    }

    /**
     * Format weekly report message for WhatsApp (done, missed, productivity).
     *
     * @param  Collection<int, Item>  $doneItems
     * @param  Collection<int, Item>  $missedItems
     */
    public function formatWeekly(
        Collection $doneItems,
        Collection $missedItems,
        float $productivityPercent,
        string $periodStart,
        string $periodEnd
    ): string {
        $periodLabel = "{$periodStart} – {$periodEnd}";

        if ($doneItems->isEmpty() && $missedItems->isEmpty()) {
            return "*Weekly report – {$periodLabel}*\n\nNo activity this week.";
        }

        $lines = ["*Weekly report – {$periodLabel}*\n"];

        if (! $doneItems->isEmpty()) {
            $lines[] = "*Done ({$doneItems->count()})*";
            foreach ($doneItems as $item) {
                $lines[] = "• {$item->title}";
            }
            $lines[] = '';
        }

        if (! $missedItems->isEmpty()) {
            $lines[] = "*Missed ({$missedItems->count()})*";
            foreach ($missedItems as $item) {
                $expires = $item->expires_at?->format('d M Y') ?? '–';
                $lines[] = "• {$item->title} – expired {$expires}";
            }
            $lines[] = '';
        }

        $pct = $productivityPercent === (float) (int) $productivityPercent
            ? (int) $productivityPercent
            : round($productivityPercent, 1);
        $lines[] = "*Productivity: {$pct}%*";

        return implode("\n", array_filter($lines));
    }
}
