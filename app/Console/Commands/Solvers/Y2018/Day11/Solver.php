<?php

namespace App\Console\Commands\Solvers\Y2018\Day11;

use SplFixedArray;

class Solver
{
    public function solvePart1(string $input)
    {
        $serialNumber = intval($input);

        $gridSize = 300;

        $sumGrid = $this->buildGrid($gridSize, $serialNumber);

        // $this->dumpGrid($sumGrid, $gridSize);

        return $this->findPeek($sumGrid, $gridSize, 3);
    }

    public function solvePart2(string $input, int $gridSize = 300)
    {
        $serialNumber = intval($input);

        $sumGrid = $this->buildGrid($gridSize, $serialNumber);

        // $this->dumpGrid($sumGrid, $gridSize);

        // for result
        $peekMax = PHP_INT_MIN;
        $posAt = '';

        for ($size = 1; $size <= $gridSize; $size++) {
            echo "grows to $size\n";

            list($pos, $peek) = $this->findPeek($sumGrid, $gridSize, $size);
            if ($peek > $peekMax) {
                $peekMax = $peek;
                $posAt = $pos . "," . $size;
                echo "max is changed to $peekMax at $size\n";
            }
        }

        return [$posAt, $peekMax];
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

        // grid is 0 origin
        foreach (range(0, $gridSize - 1) as $y) {
            $dY = $y * $gridSize;
            foreach (range(0, $gridSize - 1) as $x) {
                $idx = $dY + $x;
                // parameter is 1 origin
                $sum = $this->calcPowerLevel($x + 1, $y + 1, $serial);
                if ($x !== 0) {
                    $sum += $sumGrid[$idx - 1];
                }
                if ($y !== 0) {
                    $sum += $sumGrid[$idx - $gridSize];
                }
                if ($x !== 0 && $y !== 0) {
                    $sum -= $sumGrid[$idx - $gridSize - 1];
                }

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

    private function findPeek($sumGrid, $gridSize, $size)
    {
        $peek = PHP_INT_MIN;
        $pos = '';
        // x y are 0 origin
        $topY = 0;
        $bottomY = ($size - 1) * $gridSize;
        foreach (range(0, $gridSize - $size) as $y) {
            foreach (range(0, $gridSize - $size) as $x) {
                $sum = $this->calcTotal($sumGrid, $gridSize, $x, $topY, $x + $size - 1, $bottomY);

                $peek = max($peek, $sum);

                if ($peek == $sum) {
                    $pos = ($x + 1) . ',' . ($y + 1);
                }
            }
            $topY += $gridSize;
            $bottomY += $gridSize;
        }

        return [$pos, $peek];
    }

    private function calcTotal($sumGrid, $gridSize, $x, $topY, $rightX, $bottomY)
    {
        // total of (x1, y1) to (x2, y2) is
        // sumGrid's
        //    (x2, y2) - (x2, y1 - 1) - (x1 - 1, y2) + (x1 - 1, y1 - 1)
        $sum = $sumGrid[$bottomY + $rightX];

        if ($topY != 0) {
            $sum -= $sumGrid[$topY + $rightX - $gridSize];
        }
        if ($x != 0) {
            $sum -= $sumGrid[$bottomY + $x - 1];
        }
        if ($topY != 0 && $x != 0) {
            $sum += $sumGrid[$topY + $x - $gridSize - 1];
        }

        return $sum;
    }
}
