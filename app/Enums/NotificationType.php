<?php

namespace App\Enums;

enum NotificationType: string
{
    case ExpiringSoon = 'expiring_soon';
    case Expired = 'expired';
    case TaskDue = 'task_due';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
