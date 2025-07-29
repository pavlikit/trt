<?php

use App\Zabbix\Collection\TreatSet;
use App\Zabbix\Exception\TreatOptimizationException;
use App\Zabbix\Service\RecursiveTreatOptimizer;

it('computes the correct maximum value for simple treat sets', function () {
    $optimizer = new RecursiveTreatOptimizer();

    $tests = [
        [[1, 3, 1, 5, 2], 43],
        [[1], 1],
        [[5, 4], max(5 * 1 + 4 * 2, 4 * 1 + 5 * 2)], // 13
        [[3, 1, 2], 13],
    ];

    foreach ($tests as [$treats, $expected]) {
        $treatSet = new TreatSet($treats);
        $result = $optimizer->maximize($treatSet);

        expect($result)->toBe($expected);
    }
});

it('throws an exception for empty treat list', function () {
    $optimizer = new RecursiveTreatOptimizer();
    $treatSet = new TreatSet([]);
    $optimizer->maximize($treatSet);
})->throws(TreatOptimizationException::class, 'Treat list cannot be empty.');


