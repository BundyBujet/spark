<?php

namespace App\Enums;

enum TelegramFileSource: string
{
    case Channel = 'channel';
    case Web = 'web';
    case Telegram = 'telegram';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
