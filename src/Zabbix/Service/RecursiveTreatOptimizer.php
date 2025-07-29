<?php

namespace App\Zabbix\Service;

use App\Zabbix\Collection\TreatSet;
use App\Zabbix\Interface\TreatOptimizerInterface;

final class RecursiveTreatOptimizer implements TreatOptimizerInterface
{
    private array $memo = [];

    public function maximize(TreatSet $treatSet): int
    {
        $this->memo = [];
        return $this->dp(0, $treatSet->count() - 1, $treatSet);
    }

    private function dp(int $i, int $j, TreatSet $treatSet): int
    {
        if ($i > $j) {
            return 0;
        }

        if (isset($this->memo[$i][$j])) {
            return $this->memo[$i][$j];
        }

        $day = $treatSet->count() - ($j - $i);

        $left = $treatSet->get($i)->value * $day + $this->dp($i + 1, $j, $treatSet);
        $right = $treatSet->get($j)->value * $day + $this->dp($i, $j - 1, $treatSet);

        return $this->memo[$i][$j] = max($left, $right);
    }
}
