<?php

namespace App\Console\Commands;

use App\Contracts\NotificationGateway;
use App\Enums\NotificationChannel;
use App\Enums\NotificationType;
use App\Repositories\TaskRepository;
use App\Services\ItemNotificationService;
use App\Services\ReportMessageFormatter;
use Illuminate\Console\Command;

class SendDailyReport extends Command
{
    protected $signature = 'reports:daily';

    protected $description = 'Send daily WhatsApp report (tasks due today, not done).';

    public function __construct(
        protected TaskRepository $taskRepository,
        protected ReportMessageFormatter $formatter,
        protected NotificationGateway $gateway,
        protected ItemNotificationService $notificationService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $phone = config('items.notification_phone_whatsapp');
        if (empty($phone)) {
            $this->warn('No notification phone configured. Skipping daily report.');

            return self::SUCCESS;
        }

        $tasks = $this->taskRepository->getTasksDueTodayNotDone();
        $message = $this->formatter->formatDaily($tasks);

        $this->gateway->send($phone, $message, [
            'type' => NotificationType::Daily->value,
        ]);

        $this->notificationService->recordReportSent(
            NotificationType::Daily->value,
            NotificationChannel::Whatsapp->value
        );

        $this->info('Daily report sent.');

        return self::SUCCESS;
    }
}
