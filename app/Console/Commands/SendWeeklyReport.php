<?php

namespace App\Console\Commands;

use App\Contracts\NotificationGateway;
use App\Repositories\ReportRepository;
use App\Repositories\WeeklyReportRepository;
use App\Services\ReportMessageFormatter;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendWeeklyReport extends Command
{
    protected $signature = 'reports:weekly';

    protected $description = 'Send weekly WhatsApp report (done tasks, missed tasks, productivity).';

    public function __construct(
        protected ReportRepository $reportRepository,
        protected ReportMessageFormatter $formatter,
        protected NotificationGateway $gateway,
        protected WeeklyReportRepository $weeklyReportRepository
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $phone = config('items.notification_phone_whatsapp');
        if (empty($phone)) {
            $this->warn('No notification phone configured. Skipping weekly report.');

            return self::SUCCESS;
        }

        $periodStart = now()->subWeek()->startOfWeek(Carbon::MONDAY);
        $periodEnd = now()->subWeek()->endOfWeek(Carbon::SUNDAY);

        $doneItems = $this->reportRepository->getDoneTaskItemsInPeriod($periodStart, $periodEnd);
        $missedItems = $this->reportRepository->getMissedTaskItemsInPeriod($periodStart, $periodEnd);
        $allInPeriod = $this->reportRepository->getTaskItemsInPeriod($periodStart, $periodEnd);

        $total = $allInPeriod->count();
        $doneCount = $doneItems->count();
        $productivityPercent = $total > 0 ? ($doneCount / $total) * 100 : 0.0;

        $periodStartStr = $periodStart->format('d M Y');
        $periodEndStr = $periodEnd->format('d M Y');

        $message = $this->formatter->formatWeekly(
            $doneItems,
            $missedItems,
            $productivityPercent,
            $periodStartStr,
            $periodEndStr
        );

        $this->gateway->send($phone, $message, [
            'type' => 'weekly_report',
        ]);

        $this->weeklyReportRepository->create([
            'period_start' => $periodStart->toDateString(),
            'period_end' => $periodEnd->toDateString(),
            'summary' => $message,
            'sent_at' => now(),
        ]);

        $this->info('Weekly report sent.');

        return self::SUCCESS;
    }
}
