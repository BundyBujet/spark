<?php

namespace App\Enums;

enum ItemSource: string
{
    case Web = 'web';
    case Tui = 'tui';
    case Telegram = 'telegram';
    case Api = 'api';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
