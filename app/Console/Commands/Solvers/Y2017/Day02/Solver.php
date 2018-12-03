<?php

namespace App\Console\Commands\Solvers\Y2017\Day02;

class Solver
{
    public function solvePart1(iterable $input)
    {
        $sum = 0;

        foreach ($input as $row) {
            $coll = collect(explode("\t", $row));
            $sum += $coll->max() - $coll->min();
        }

        return $sum;
    }
}
