<?php

namespace App\Zabbix\Collection;

use App\Zabbix\Dto\Treat;
use App\Zabbix\Enum\ErrorCode;
use App\Zabbix\Exception\TreatOptimizationException;
use ArrayIterator;
use Countable;
use IteratorAggregate;

final class TreatSet implements IteratorAggregate, Countable
{
    /** @var Treat[] */
    private array $treats;

    public function __construct(array $values)
    {
        if (empty($values)) {
            throw new TreatOptimizationException(ErrorCode::EMPTY_TREAT_SET);
        }

        $this->treats = array_map(
            fn(int $value, int $index) => new Treat($value, $index),
            $values,
            array_keys($values)
        );
    }

    public function count(): int
    {
        return count($this->treats);
    }

    public function get(int $index): Treat
    {
        if (!isset($this->treats[$index])) {
            throw new TreatOptimizationException(ErrorCode::INVALID_INDEX);
        }

        return $this->treats[$index];
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->treats);
    }
}
