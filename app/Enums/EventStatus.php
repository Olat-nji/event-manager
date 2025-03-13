<?php

namespace App\Enums;

enum EventStatus: string
{
    case LIVE = 'live';
    case DRAFT = 'draft';

  

    public static function colors(): array
    {
        return [
            self::LIVE->value => 'success', // Green for live events
            self::DRAFT->value => 'info', // Grey for drafts
        ];
    }
}
