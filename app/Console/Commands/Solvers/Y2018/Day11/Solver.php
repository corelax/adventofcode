<?php

namespace App\Console\Commands\Solvers\Y2018\Day11;

use SplFixedArray;

class Solver
{
    public function solvePart1(string $input)
    {
        $serialNumber = intval($input);

        $gridSize = 300;

        $grid = $this->buildGrid($gridSize, $serialNumber);

        // $this->dumpGrid($grid, $gridSize);

        return $this->findPeek($grid, $gridSize, 3);
    }

    public function solvePart2(string $input, int $gridSize = 300)
    {
        $serialNumber = intval($input);

        $grid = $this->buildGrid($gridSize, $serialNumber);

        // $this->dumpGrid($grid, $gridSize);


        // init with grid. equal to size == 1
        $mapTotal = $grid;

        // subSum keeps a sum of specific direction.
        // target of sum length equals to size
        //   when size is 5
        //      subSumH(0, 0) has sum of (0, 0) to (4, 0)
        //      subSumV(0, 0) has sum of (0, 0) to (0, 4)
        //    generally
        //      subSumH(x, y) has sum of (x, y) to (x + size - 1, y)
        $subSumH = $subSumV = array_fill(0, $gridSize * $gridSize, 0); // horizontal and vertical

        // for result
        $peekMax = PHP_INT_MIN;
        $posAt = '';

        for ($size = 2; $size < $gridSize; $size++) {
            echo "grows to $size\n";

            // grow subSum(length = $size - 1) to avoid the corner adding twice
            $dY = 0;
            foreach (range(0, $gridSize - $size) as $y) {
                $bottomOffset = ($y + $size - 1) * $gridSize;
                foreach (range(0, $gridSize - $size) as $x) {
                    $rightOffset = $x + $size - 1;

                    // keep remind one size small
                    // Y - 1
                    $subSumV[$dY + $x] += $grid[$bottomOffset - $gridSize + $x];
                    // X - 1
                    $subSumH[$dY + $x] += $grid[$dY + $rightOffset - 1];
                }
                $dY += $gridSize;
            }

            // grow map total
            $dY = 0;
            foreach (range(0, $gridSize - $size) as $y) {
                $bottomOffset = ($y + $size - 1) * $gridSize;
                foreach (range(0, $gridSize - $size) as $x) {
                    $rightOffset = $x + $size - 1;

                    // apply grow differs to map
                    $mapTotal[$dY + $x] += 0
                        // add new X cols subSum
                        + $subSumV[$dY + $rightOffset]
                        // add new Y rows subSum
                        + $subSumH[$bottomOffset + $x]
                        // finally, add the corner
                        + $grid[$bottomOffset + $rightOffset];

                    if ($mapTotal[$dY + $x] > $peekMax) {
                        $peekMax = $mapTotal[$dY + $x];

                        // 1 origin
                        $posAt = ($x + 1) . "," . ($y + 1) . "," . $size;
                        echo "max is changed to $peekMax at $size\n";
                    }
                }
                $dY += $gridSize;
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
        $grid = array_fill(0, $gridSize * $gridSize, 0);

        // grid is 0 origin
        foreach (range(0, $gridSize - 1) as $y) {
            $dY = $y * $gridSize;
            foreach (range(0, $gridSize - 1) as $x) {
                // parameter is 1 origin
                $grid[$dY + $x] = $this->calcPowerLevel($x + 1, $y + 1, $serial);
            }
        }

        return $grid;
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

    private function findPeek($grid, $gridSize, $size)
    {
        $peek = PHP_INT_MIN;
        $pos = '';
        // x y are 0 origin
        foreach (range(0, $gridSize - $size) as $y) {
            foreach (range(0, $gridSize - $size) as $x) {
                $sum = $this->calcTotal($grid, $gridSize, $x, $y, $size);

                $peek = max($peek, $sum);

                if ($peek == $sum) {
                    $pos = ($x + 1) . ',' . ($y + 1);
                }
            }
        }

        return [$pos, $peek];
    }

    private function calcTotal($grid, $gridSize, $x, $y, $size)
    {
        $sum = 0;
        foreach (range(0, $size - 1) as $offsetY) {
            $dY = ($y + $offsetY) * $gridSize;
            foreach (range(0, $size - 1) as $offsetX) {
                $sum += $grid[$dY + ($x + $offsetX)];
            }
        }

        return $sum;
    }
}
