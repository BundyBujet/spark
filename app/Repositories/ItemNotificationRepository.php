<?php

namespace App\Repositories;

use App\Models\ItemNotification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ItemNotificationRepository
{
    public function list(array $filters = [], int $perPage = 30): LengthAwarePaginator
    {
        $query = ItemNotification::query()->with('item')->orderByDesc('sent_at');

        if (! empty($filters['item_id'])) {
            $query->where('item_id', $filters['item_id']);
        }

        if (! empty($filters['notification_type'])) {
            $query->where('notification_type', $filters['notification_type']);
        }

        if (! empty($filters['channel'])) {
            $query->where('channel', $filters['channel']);
        }

        if (! empty($filters['from_date'])) {
            $query->whereDate('sent_at', '>=', $filters['from_date']);
        }

        if (! empty($filters['to_date'])) {
            $query->whereDate('sent_at', '<=', $filters['to_date']);
        }

        return $query->paginate($perPage);
    }

    public function markSent(int $itemId, string $notificationType, string $channel): ItemNotification
    {
        return ItemNotification::create([
            'item_id' => $itemId,
            'notification_type' => $notificationType,
            'sent_at' => now(),
            'channel' => $channel,
        ]);
    }

    public function alreadySent(int $itemId, string $notificationType): bool
    {
        return ItemNotification::query()
            ->where('item_id', $itemId)
            ->where('notification_type', $notificationType)
            ->exists();
    }
}
