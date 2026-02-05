<?php

namespace App\Services;

use App\Contracts\NotificationGateway;
use Illuminate\Support\Facades\Log;

class LogNotificationGateway implements NotificationGateway
{
    public function send(string $to, string $message, array $context = []): void
    {
        Log::info('NotificationGateway: would send', [
            'to' => $to,
            'message' => $message,
            'context' => $context,
        ]);
    }
}
