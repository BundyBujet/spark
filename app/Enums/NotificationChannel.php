<?php

namespace App\Enums;

enum NotificationChannel: string
{
    case Whatsapp = 'whatsapp';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
