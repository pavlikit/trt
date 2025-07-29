<?php

namespace App\Zabbix\Dto;

final readonly class Treat
{
    public function __construct(
        public int $value,
        public int $position
    ) {}
}
