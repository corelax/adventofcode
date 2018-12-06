<?php

namespace App\Console\Commands\Solvers\Y2018\Day06;

class Solver
{
    public function solvePart1(iterable $input)
    {
        $coordinates = [];
        $maxX = $maxY = 0;
        $minX = $minY = PHP_INT_MAX;

        $xList = $yList = [];
        foreach ($input as $line) {
            sscanf($line, "%d, %d", $x, $y);
            $coordinates[] = [$x, $y];
            $xList[] = $x;
            $yList[] = $y;
        }

        // area which get the coordinate on border is infinite area
        // we can consider only the inner area of the border
        $borderL = min($xList) - 1;
        $borderR = max($xList) + 1;
        $borderT = min($yList) - 1;
        $borderB = max($yList) + 1;

        // echo "$borderL $borderR $borderT $borderB\n";

        $infinits = [];
        $nearestMap = [];
        foreach (range($borderT, $borderB) as $y) {
            foreach (range($borderL, $borderR) as $x) {
                $areaIdList = $this->nearest($coordinates, $x, $y);

                $key = "$x,$y";
                if (count($areaIdList) >= 2) {
                    $nearestMap[$key] = '.';
                    // echo '.';
                } else {
                    $nearestMap[$key] = $areaIdList[0];
                    // echo chr(ord('A') + $nearestMap[$key]);
                }

                if ($x == $borderL || $x == $borderR || $y == $borderT || $y == $borderB) {
                    if (count($areaIdList) == 1) {
                        $infinits[$areaIdList[0]] = true;
                    }
                }
            }
            // echo PHP_EOL;
        }

        // echo "infinits are ";
        // var_dump(array_keys($infinits));

        $areaSizePerId = array_count_values($nearestMap);
        // var_dump($areaSizePerId);

        $maxArea = 0;
        $maxAreaId = -1;
        if (isset($areaSizePerId['.'])) {
            unset($areaSizePerId['.']);
        }
        foreach ($areaSizePerId as $id => $size) {
            // echo $id . ' ' . $size . PHP_EOL;
            if (isset($infinits[$id])) {
                continue;
            }
            if ($size > $maxArea) {
                $maxArea = $size;
                $maxAreaId = $id;
            }
        }

        return $maxArea;
    }

    public function solvePart2(iterable $input, $limit)
    {
        $coordinates = [];
        $maxX = $maxY = 0;
        $minX = $minY = PHP_INT_MAX;

        $xList = $yList = [];
        foreach ($input as $line) {
            sscanf($line, "%d, %d", $x, $y);
            $coordinates[] = [$x, $y];
            $xList[] = $x;
            $yList[] = $y;
        }

        // area which get the coordinate on border is infinite area
        // we can consider only the inner area of the border
        $borderL = min($xList) - 1;
        $borderR = max($xList) + 1;
        $borderT = min($yList) - 1;
        $borderB = max($yList) + 1;

        // echo "$borderL $borderR $borderT $borderB\n";

        $infinits = [];
        $nearestMap = [];
        $regionSize = 0;
        foreach (range($borderT, $borderB) as $y) {
            foreach (range($borderL, $borderR) as $x) {
                if ($this->isInTotalDistance($coordinates, $x, $y, $limit)) {
                    $regionSize++;
                }
            }
        }

        return $regionSize;
    }

    private function distance($x1, $y1, $x2, $y2)
    {
        return abs($x2 - $x1) + abs($y2 - $y1);
    }

    // can be return multiple ids
    private function nearest($coordinates, $x, $y)
    {
        $min = PHP_INT_MAX;
        $idList = [];
        foreach ($coordinates as $id => $coordinate) {
            $d = $this->distance($x, $y, $coordinate[0], $coordinate[1]);
            if ($d == $min) {
                $idList[] = $id;
            } else if ($d < $min) {
                $idList = [$id];
                $min = $d;
            }
        }
        $txt = '';
        foreach ($idList as $id) {
            $txt .= chr(ord('A') + $id) . ", ";
        }
        // echo "$x $y owned by $txt\n";
        return $idList;
    }

    // check if total distance from every coordinates to ($x, $y) LESS THAN $limit
    private function isInTotalDistance($coordinates, $x, $y, $limit)
    {
        $total = 0;
        foreach ($coordinates as $coordinate) {
            $total += $this->distance($x, $y, $coordinate[0], $coordinate[1]);

            if ($total >= $limit) {
                return false;
            }
        }

        return true;
    }
}
