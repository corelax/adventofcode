<?php

namespace App\Console\Commands\Solvers\Y2017\Day01;

class Solver
{
    public function solvePart1(string $input)
    {
        $sum = 0;
        $coll = collect(str_split($input));

        $prev = $coll->last();
        foreach ($coll as $curr) {
            if ($curr == $prev) {
                $sum += intval($curr);
            }
            $prev = $curr;
        }

        return $sum;
    }
}
