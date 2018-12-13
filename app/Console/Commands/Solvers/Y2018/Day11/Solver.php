<?php

namespace App\Console\Commands\Solvers\Y2018\Day11;

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

        foreach (range(1, $gridSize - 1) as $size) {
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
        // sumGrid keeps sum of rect area (1, 1) to (x, y)
        // can get sum of any rect area easily
        //   Think of a square that top-left is (x, y) and size = 3
        //     x0 = x - 1
        //     y0 = y - 1
        //     x1 = x + size - 1 (= x0 + size)
        //     y1 = y + size - 1 (= y0 + size)
        //
        //       0      x0   x      x1
        //     +---+---+---+---+---+---+  
        //   0 |   |   |   |   |   |   |  
        //     +---+---+---+---+---+---+  
        //     |   |   |   |   |   |   |  
        //     +---+---+---+---+---+---+  
        //  y0 |   |   | A |   |   | C |  
        //     +---+---+---+---+---+---+  
        //  y  |   |   |   |   |   |   |  
        //     +---+---+---+---+---+---+  
        //     |   |   |   |   |   |   |  
        //     +---+---+---+---+---+---+  
        //  y1 |   |   | B |   |   | D |  
        //     +---+---+---+---+---+---+  
        // 
        //  A = sum of rect area (0, 0) to (x0, y0)
        //  B = sum of rect area (0, 0) to (x0, y1)
        //  C = sum of rect area (0, 0) to (x1, y0)
        //  D = sum of rect area (0, 0) to (x1, y1)
        //  and the sum of rect area (x, y) to (x1, y1) is
        //    D - C(includes A) - B(includes A) + A
        // 
        // Can use for any rect not only square.
        $sumGrid = array_fill(0, $gridSize * $gridSize, 0);

        $range = range(1, $gridSize - 1);

        // all (0, y) and (x, 0) are buffer for simplify
        $y0 = 0;
        $y1= $gridSize;
        foreach ($range as $y) {
            foreach ($range as $x) {
                $x0 = $x - 1;
                $x1 = $x;

                // current cell + upper cell + left cell - upper-left cell
                // 
                // Process all cells from top-left to bottom-right, 
                // the value of current cell equals to the sum of (1, 1) to current cell.
                $sumGrid[$y1 + $x1] =
                    $this->calcPowerLevel($x, $y, $serial)
                    + $sumGrid[$y1 + $x0]
                    + $sumGrid[$y0 + $x1]
                    - $sumGrid[$y0 + $x0];
            }
            $y0 = $y1;
            $y1 += $gridSize;
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

        $range = range(1, $gridSize - $size);

        // x y are 1 origin
        $y0 = 0;                    // y of current box - 1
        $y1 = $size * $gridSize;    // bottom y of current box
        foreach ($range as $y) {
            foreach ($range as $x) {
                $x0 = $x - 1;       // x of current box - 1
                $x1 = $x0 + $size;  // right x of current box

                $sum = 
                    $sumGrid[$y1 + $x1]
                    - $sumGrid[$y0 + $x1]
                    - $sumGrid[$y1 + $x0]
                    + $sumGrid[$y0 + $x0];

                if ($sum > $peak) {
                    $peak = $sum;
                    $pos = "$x,$y";
                }
            }
            $y0 += $gridSize;
            $y1 += $gridSize;
        }

        return [$pos, $peak];
    }
}
