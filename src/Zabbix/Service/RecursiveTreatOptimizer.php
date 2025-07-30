<?php

namespace App\Zabbix\Service;

use App\Zabbix\Collection\TreatSet;
use App\Zabbix\Enum\ErrorCode;
use App\Zabbix\Exception\TreatOptimizationException;
use App\Zabbix\Interface\MemoizationInterface;
use App\Zabbix\Interface\TreatOptimizerInterface;

final class RecursiveTreatOptimizer implements TreatOptimizerInterface
{
    private MemoizationInterface $memo;

    public function __construct(MemoizationInterface $memo)
    {
        $this->memo = $memo;
    }

    public function maximize(TreatSet $treatSet): int
    {
        if ($treatSet->count() === 0) {
            throw new TreatOptimizationException(ErrorCode::EMPTY_TREAT_SET);
        }

        $this->memo->reset();

        return $this->calculateMaxValue(0, $treatSet->count() - 1, 1, $treatSet);
    }

    private function calculateMaxValue(
        int $start,
        int $end,
        int $day,
        TreatSet $treatSet
    ): int
    {
        if ($start > $end) {
            return 0;
        }

        if ($this->memo->has($start, $end, $day)) {
            return $this->memo->get($start, $end, $day);
        }

        $pickLeft = $treatSet->get($start) * $day
            + $this->calculateMaxValue($start + 1, $end, $day + 1, $treatSet);

        $pickRight = $treatSet->get($end) * $day
            + $this->calculateMaxValue($start, $end - 1, $day + 1, $treatSet);

        $maxValue = max($pickLeft, $pickRight);
        $this->memo->set($start, $end, $day, $maxValue);

        return $maxValue;
    }
}
