<?php

namespace App\Zabbix\Exception;

use App\Zabbix\Enum\ErrorCode;
use RuntimeException;

final class TreatOptimizationException extends RuntimeException
{
    public function __construct(
        public readonly ErrorCode $codeEnum
    ) {
        parent::__construct($codeEnum->message());
    }
}
