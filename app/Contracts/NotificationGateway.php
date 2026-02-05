<?php

namespace App\Contracts;

interface NotificationGateway
{
    /**
     * Send one notification to one recipient.
     */
    public function send(string $to, string $message, array $context = []): void;
}
