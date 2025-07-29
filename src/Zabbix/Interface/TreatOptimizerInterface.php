<?php

namespace App\Zabbix\Interface;

use App\Zabbix\Collection\TreatSet;

interface TreatOptimizerInterface
{
    public function maximize(TreatSet $treatSet): int;
}

