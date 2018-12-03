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

    public function solvePart2(string $input)
    {
        $sum = 0;

        $arr = str_split($input);
        $half = count($arr) / 2;

        for ($i = 0; $i < $half; $i++) {
            if ($arr[$i] == $arr[$i + $half]) {
                $sum += intval($arr[$i]) * 2;
            }
        }

        return $sum;
    }
}
