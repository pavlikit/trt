<?php

namespace App\Zabbix\Enum;

enum ErrorCode: string
{
    case EMPTY_TREAT_SET = 'empty_treat_set';
    case INVALID_INDEX = 'invalid_index';

    public function message(): string
    {
        return match ($this) {
            self::EMPTY_TREAT_SET => 'Treat list cannot be empty.',
            self::INVALID_INDEX => 'Requested treat index does not exist.',
        };
    }
}
