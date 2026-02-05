<?php

namespace App\Enums;

enum ItemType: string
{
    // idea | note | link | file | media | password | task | reference
    case Task = 'task';
    case Password = 'password';
    case Note = 'note';
    case Idea = 'idea';
    case Link = 'link';
    case File = 'file';
    case Media = 'media';
    case Reference = 'reference';


    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
