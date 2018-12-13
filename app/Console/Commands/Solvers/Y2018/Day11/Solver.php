<?php

namespace App\Console\Commands\Solvers\Y2018\Day11;

use SplFixedArray;

class Solver
{
    public function solvePart1(string $input)
    {
        $serialNumber = intval($input);

        $gridSize = 300;

        list($grid, $sumGrid) = $this->buildGrid($gridSize, $serialNumber);

        // $this->dumpGrid($grid, $gridSize);
        // $this->dumpGrid($sumGrid, $gridSize);

        return $this->findPeek($grid, $sumGrid, $gridSize, 3);
    }

    public function solvePart2(string $input, int $gridSize = 300)
    {
        $serialNumber = intval($input);

        list ($grid, $sumGrid) = $this->buildGrid($gridSize, $serialNumber);

        // $this->dumpGrid($grid, $gridSize);
        // $this->dumpGrid($sumGrid, $gridSize);


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
                    //
                    // . : the square before grow cells
                    // V : new X cols (is in subSumV. already calcurated.
                    // H : new H cols (is in subSumH. already calcurated.
                    // C : corner
                    // 
                    //   ...V
                    //   ...V
                    //   ...V
                    //   HHHC
                    $mapTotal[$dY + $x] += 0
                        // add new X cols sum
                        // it saved at top-right coord of subSumV
                        + $subSumV[$dY + $rightOffset]
                        // add new Y rows sum
                        // it saved at bottom-left coord of subSumH
                        + $subSumH[$bottomOffset + $x]
                        // finally, add the corner.
                        // of course it is bottom-right
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
        $sumGrid = array_fill(0, $gridSize * $gridSize, 0);

        // grid is 0 origin
        foreach (range(0, $gridSize - 1) as $y) {
            $dY = $y * $gridSize;
            foreach (range(0, $gridSize - 1) as $x) {
                $idx = $dY + $x;
                // parameter is 1 origin
                $grid[$idx] = $this->calcPowerLevel($x + 1, $y + 1, $serial);

                $sum = $grid[$idx];
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

        return [$grid, $sumGrid];
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

    private function findPeek($grid, $sumGrid, $gridSize, $size)
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
