<?php

namespace App\Zabbix\Collection;

use App\Zabbix\Enum\ErrorCode;
use App\Zabbix\Exception\TreatOptimizationException;
use Countable;

final class TreatSet implements Countable
{
    private array $items = [];

    public function __construct(array $items = [])
    {
        if (empty($items)) {
            throw new TreatOptimizationException(ErrorCode::EMPTY_TREAT_SET);
        }

        $this->items = $items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function get(int $index): int
    {
        if (!isset($this->items[$index])) {
            throw new TreatOptimizationException(ErrorCode::INVALID_INDEX);
        }

        return $this->items[$index];
    }
}
