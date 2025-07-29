<?php

namespace App\Zabbix\Service;

use App\Zabbix\Collection\TreatSet;
use App\Zabbix\Enum\ErrorCode;
use App\Zabbix\Exception\TreatOptimizationException;
use App\Zabbix\Interface\TreatOptimizerInterface;

final class RecursiveTreatOptimizer implements TreatOptimizerInterface
{
    private array $memo = [];

    public function maximize(TreatSet $treatSet): int
    {
        $count = $treatSet->count();

        if ($count === 0) {
            throw new TreatOptimizationException(ErrorCode::EMPTY_TREAT_SET);
        }

        $this->memo = [];
        return $this->dp(0, $count - 1, 1, $treatSet);
    }

    private function dp(int $i, int $j, int $day, TreatSet $treatSet): int
    {
        if ($i > $j) return 0;

        if (isset($this->memo[$i][$j][$day])) {
            return $this->memo[$i][$j][$day];
        }

        $leftValue = $treatSet->get($i)->value;
        $rightValue = $treatSet->get($j)->value;

        $left = $leftValue * $day + $this->dp($i + 1, $j, $day + 1, $treatSet);
        $right = $rightValue * $day + $this->dp($i, $j - 1, $day + 1, $treatSet);

        $max = max($left, $right);

        return $this->memo[$i][$j][$day] = $max;
    }
}
