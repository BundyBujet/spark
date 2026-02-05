<?php

namespace App\Services;

use App\Enums\NotificationType;
use App\Models\Item;
use App\Repositories\ItemNotificationRepository;

class ItemNotificationService
{
    public function __construct(
        protected ItemNotificationRepository $notificationRepository
    ) {}

    /**
     * Check whether we should send an "expiring_soon" notification for this item
     * (expires within 7 days and not yet sent).
     */
    public function shouldSendExpiringSoon(Item $item): bool
    {
        if ($item->expires_at === null) {
            return false;
        }
        if ($item->expires_at->isPast()) {
            return false;
        }
        if ($item->expires_at->isAfter(now()->addDays(7))) {
            return false;
        }

        return ! $this->notificationRepository->alreadySent(
            $item->id,
            NotificationType::ExpiringSoon->value
        );
    }

    /**
     * Record that a notification was sent. Enforces "never send twice" via repository.
     */
    public function recordSent(Item $item, string $notificationType, string $channel): void
    {
        $this->notificationRepository->markSent($item->id, $notificationType, $channel);
    }

    /**
     * Check if a given notification type was already sent for this item.
     */
    public function alreadySent(Item $item, string $notificationType): bool
    {
        return $this->notificationRepository->alreadySent($item->id, $notificationType);
    }
}
