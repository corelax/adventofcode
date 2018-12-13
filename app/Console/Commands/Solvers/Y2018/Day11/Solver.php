<?php

namespace App\Console\Commands\Solvers\Y2018\Day11;

use SplFixedArray;

class Solver
{
    public function solvePart1(string $input)
    {
        $serialNumber = intval($input);

        $gridSize = 300 + 1;

        $sumGrid = $this->buildGrid($gridSize, $serialNumber);

        // $this->dumpGrid($sumGrid, $gridSize);

        return $this->findPeak($sumGrid, $gridSize, 3);
    }

    public function solvePart2(string $input, int $gridSize = 300 + 1)
    {
        $serialNumber = intval($input);

        $sumGrid = $this->buildGrid($gridSize, $serialNumber);

        // $this->dumpGrid($sumGrid, $gridSize);

        // for result
        $peakMax = PHP_INT_MIN;
        $posAt = '';

        for ($size = 1; $size <= $gridSize - 1; $size++) {
            echo "grows to $size\n";

            list($pos, $peak) = $this->findPeak($sumGrid, $gridSize, $size);
            if ($peak > $peakMax) {
                $peakMax = $peak;
                $posAt = $pos . "," . $size;
                echo "max is changed to $peakMax at $size\n";
            }
        }

        return [$posAt, $peakMax];
    }

    /**
     * Find the fuel cell's rack ID, which is its X coordinate plus 10.
     * Begin with a power level of the rack ID times the Y coordinate.
     * Increase the power level by the value of the grid serial number (your puzzle input).
     * Set the power level to itself multiplied by the rack ID.
     * Keep only the hundreds digit of the power level (so 12345 becomes 3; numbers with no hundreds digit become 0).
     * Subtract 5 from the power level.
     */
    private function calcPowerLevel($x, $y, $serial)
    {
        $rackId = $x + 10;

        $power = $rackId * $y;
        $power += $serial;
        $power *= $rackId;
        $level = intval($power / 100) % 10;

        return $level - 5;
    }

    private function buildGrid($gridSize, $serial)
    {
        $sumGrid = array_fill(0, $gridSize * $gridSize, 0);

        // all (0, y) and (x, 0) are buffer for simplify
        foreach (range(1, $gridSize - 1) as $y) {
            $dY = $y * $gridSize;
            foreach (range(1, $gridSize - 1) as $x) {
                $idx = $dY + $x;
                $sum =
                    $this->calcPowerLevel($x, $y, $serial)
                    + $sumGrid[$idx - 1]
                    + $sumGrid[$idx - $gridSize]
                    - $sumGrid[$idx - $gridSize - 1];

                $sumGrid[$idx] = $sum;
            }
        }

        return $sumGrid;
    }

    private function dumpGrid($grid, $gridSize)
    {
        for ($i = 0; $i < $gridSize * $gridSize; $i++) {
            printf("%2d ", $grid[$i]);
            if (($i + 1) % $gridSize == 0) {
                echo PHP_EOL;
            }
        }
    }

    private function findPeak($sumGrid, $gridSize, $size)
    {
        $peak = PHP_INT_MIN;
        $pos = '';
        // x y are 1 origin
        $topY = $gridSize;
        $bottomY = $size * $gridSize;
        foreach (range(1, $gridSize - $size) as $y) {
            foreach (range(1, $gridSize - $size) as $x) {
                $sum = calcTotal($sumGrid, $gridSize, $x, $topY, $x + $size - 1, $bottomY);

                $peak = max($peak, $sum);

                if ($peak == $sum) {
                    $pos = "$x,$y";
                }
            }
            $topY += $gridSize;
            $bottomY += $gridSize;
        }

        return [$pos, $peak];
    }

    private function calcTotal($sumGrid, $gridSize, $x, $topY, $rightX, $bottomY)
    {
        // total of (x1, y1) to (x2, y2) is
        // sumGrid's
        //    (x2, y2) - (x2, y1 - 1) - (x1 - 1, y2) + (x1 - 1, y1 - 1)
        $sum = 
            $sumGrid[$bottomY + $rightX]
            - $sumGrid[$topY + $rightX - $gridSize]
            - $sumGrid[$bottomY + $x - 1]
            + $sumGrid[$topY + $x - $gridSize - 1];

        return $sum;
    }
}
