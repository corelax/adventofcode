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

    public function solvePart2(iterable $input)
    {
        // MEMO: to find the only two numbers in each row
        $sum = 0;

        foreach ($input as $row) {
            $arr = explode("\t", $row);
            $sum += $this->getDiv($arr);
        }

        return $sum;
    }

    private function getDiv(array $arr)
    {
        foreach ($arr as $curr) {
            foreach ($arr as $target) {
                if ($curr == $target) {
                    continue;
                }

                if ($target % $curr == 0) {
                    return $target / $curr;
                }
            }
        }

        // assume there are same numbers;
        return 1;
    }
}
