<?php

namespace App\Enums;

enum TaskPriority: string
{
    case Low = 'low';
    case Normal = 'normal';
    case High = 'high';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
