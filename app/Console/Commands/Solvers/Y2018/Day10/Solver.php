<?php

namespace App\Console\Commands\Solvers\Y2018\Day10;

class Solver
{
    public function solvePart1(iterable $input)
    {
        $infos = $this->parseInput($input);

        $timeElapsed = $this->calcTimeElapsed($infos);
        $this->timeElapsed = $timeElapsed;

        foreach ($infos as $info) {
            $xList[] = $x = $info[0] + $info[2] * $timeElapsed;
            $yList[] = $y = $info[1] + $info[3] * $timeElapsed;
            $map["$x,$y"] = true;
        }

        foreach (range(min($yList), max($yList)) as $y) {
            $line = [];
            foreach (range(min($xList), max($xList)) as $x) {
                if (isset($map["$x,$y"])) {
                    $line[] = "#";
                } else {
                    $line[] = ".";
                }
            }
            $result[$y - min($yList)] = implode('', $line);
        }

        return $result;
    }

    public function solvePart2(iterable $input)
    {
        $infos = $this->parseInput($input);

        return $this->calcTimeElapsed($infos);
    }

    private function parseInput(iterable $input)
    {
        $infos = [];
        foreach ($input as $line) {
            $a = explode(',', str_replace(['<', '>'], ',', $line));
            $infos[] = [
                intval($a[1]), // posX
                intval($a[2]), // posY
                intval($a[4]), // vX
                intval($a[5]), // vY
            ];
        }

        return $infos;
    }

    private function calcTimeElapsed($infos)
    {
        foreach ($infos as $info) {
            $ylist_vero[$info[3]][] = $info[1];
        }

        foreach ($ylist_vero as $v => $ylist) {
            // actual height is max - min + 1. but it doesn't matter here.
            $heights[$v] = max($ylist) - min($ylist);
        }

        // verocities have max height
        $vList = array_keys($heights, max($heights));

        // it needs at least two verocities for calc
        if (count($vList) < 2) {
            echo 'sorry' . PHP_EOL;
            exit(1);
        }

        // if vList are 1, 2
        // min($ylist[1]) + 1 * $n == min($ylist[2]) + 2 * $n;
        //      t=0   t=1   t=2
        // v: | 1 2 | 1 2 | 1 2 |
        //    +-----+-----+-----+
        //    |   # |     |     |
        //    |   # |     |     |
        //    | # # |   # |     |
        //    | #   | # # |     |
        //    | #   | # # | # # |
        //    |     | #   | # # |
        //    |     |     | # # |
        //    |     |     |     |

        $timeElapsed = (min($ylist_vero[$vList[0]]) - min($ylist_vero[$vList[1]])) / ($vList[1] - $vList[0]);

        return $timeElapsed;
    }
}
