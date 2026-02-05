<?php

namespace App\Console\Commands;

use App\Enums\NotificationType;
use App\Jobs\SendItemExpirationNotificationJob;
use App\Repositories\ItemRepository;
use App\Services\ItemNotificationService;
use App\Services\ItemService;
use Illuminate\Console\Command;

class CheckItemExpirations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:check-expirations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find expiring/expired items and dispatch WhatsApp notifications (stub logs for now).';

    public function __construct(
        protected ItemRepository $itemRepository,
        protected ItemNotificationService $notificationService,
        protected ItemService $itemService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $days = config('items.expiring_soon_days', 7);

        $expiredItems = $this->itemRepository->getExpiredItems();
        foreach ($expiredItems as $item) {
            if (! $this->notificationService->alreadySent($item, NotificationType::Expired->value)) {
                $this->itemService->expireItem($item);
                SendItemExpirationNotificationJob::dispatch($item, NotificationType::Expired->value);
            }
        }

        $expiringSoonItems = $this->itemRepository->getExpiringSoonItems($days);
        foreach ($expiringSoonItems as $item) {
            if ($this->notificationService->shouldSendExpiringSoon($item)) {
                SendItemExpirationNotificationJob::dispatch($item, NotificationType::ExpiringSoon->value);
            }
        }

        return self::SUCCESS;
    }
}
