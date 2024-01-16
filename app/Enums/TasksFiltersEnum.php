<?php

namespace App\Enums;

use App\Traits\EnumValueTrait;

enum TasksFiltersEnum: string
{
    use EnumValueTrait;

    case USER = 'user';
    case STATUS = 'status';
    case PRIORITY = 'priority';
    case DEADLINE_START = 'deadline_start';
    case DEADLINE_END = 'deadline_end';

    public function name(): string
    {
        return match ($this) {
            static::USER => 'User',
            static::STATUS => 'Status',
            static::PRIORITY => 'Priority',
            static::DEADLINE_START => 'Deadline Start',
            static::DEADLINE_END => 'Deadline End',
        };
    }
}
