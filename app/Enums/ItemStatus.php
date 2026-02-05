<?php

namespace App\Enums;

enum ItemStatus: string
{
    case Active = 'active';
    case Archived = 'archived';
    case Expired = 'expired';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
