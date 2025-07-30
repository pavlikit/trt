<?php

namespace App\Zabbix\Collection;

use App\Zabbix\Interface\MemoizationInterface;

/** A helper class for storing intermediate results in 3D DP memoization.*/
final class MemoizationMap implements MemoizationInterface
{
    private array $cache = [];

    public function has(int $start, int $end, int $day): bool
    {
        return isset($this->cache[$start][$end][$day]);
    }

    public function get(int $start, int $end, int $day): int
    {
        return $this->cache[$start][$end][$day];
    }

    public function set(int $start, int $end, int $day, int $value): void
    {
        $this->cache[$start][$end][$day] = $value;
    }

    public function reset(): void
    {
        $this->cache = [];
    }
}
