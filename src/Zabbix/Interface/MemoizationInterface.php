<?php

namespace App\Zabbix\Interface;

interface MemoizationInterface
{
    public function has(int $start, int $end, int $day): bool;

    public function get(int $start, int $end, int $day): int;

    public function set(int $start, int $end, int $day, int $value): void;

    public function reset(): void;
}
