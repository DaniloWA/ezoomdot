<?php

namespace App\Enums;

use App\Traits\EnumValueTrait;

enum TasksStatusEnum: string
{
    use EnumValueTrait;

    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';


    public function name(): string
    {
        return match ($this) {
            static::PENDING => 'Pending',
            static::COMPLETED => 'Completed',
            static::CANCELED => 'Canceled',
        };
    }
}
