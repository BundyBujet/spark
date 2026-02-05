<?php

namespace App\Jobs;

use App\Contracts\NotificationGateway;
use App\Enums\NotificationChannel;
use App\Enums\NotificationType;
use App\Models\Item;
use App\Services\ItemNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendItemExpirationNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Item $item,
        public string $notificationType
    ) {}

    public function handle(NotificationGateway $gateway, ItemNotificationService $notificationService): void
    {
        if ($this->notificationType !== NotificationType::ExpiringSoon->value
            && $this->notificationType !== NotificationType::Expired->value) {
            return;
        }

        if ($notificationService->alreadySent($this->item, $this->notificationType)) {
            return;
        }

        $phone = config('items.notification_phone');
        if (empty($phone)) {
            return;
        }

        $message = $this->buildMessage();

        $gateway->send($phone, $message, [
            'item_id' => $this->item->id,
            'type' => $this->notificationType,
        ]);

        $notificationService->recordSent(
            $this->item,
            $this->notificationType,
            NotificationChannel::Whatsapp->value
        );
    }

    private function buildMessage(): string
    {
        $title = $this->item->title;
        $expiresAt = $this->item->expires_at?->format('Y-m-d H:i');

        if ($this->notificationType === NotificationType::Expired->value) {
            return "Item \"{$title}\" has expired" . ($expiresAt ? " (was: {$expiresAt})" : '.');
        }

        return "Item \"{$title}\" expires soon" . ($expiresAt ? " on {$expiresAt}." : '.');
    }
}
