<?php

namespace App\Enums;

use App\Traits\EnumValueTrait;

enum TasksPriorityEnum: string
{
    use EnumValueTrait;

    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case CRITICAL = 'critical';

    public function name(): string
    {
        return match ($this) {
            static::LOW => 'Low',
            static::MEDIUM => 'Medium',
            static::HIGH => 'High',
            static::CRITICAL => 'Critical',
        };
    }
}
