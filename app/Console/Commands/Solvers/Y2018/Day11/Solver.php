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
        $mapTotal = SplFixedArray::fromArray($grid->toArray());

        $peekMax = PHP_INT_MIN;
        $posAt = '';

        echo max($mapTotal->toArray()) . "init\n";

        for ($size = 2; $size < $gridSize; $size++) {
            // grow map total
            echo "grows to $size\n";
            foreach (range(0, $gridSize - $size) as $y) {
                $dY = $y * $gridSize;
                $bottomOffset = $y + $size - 1;
                $dBottom = $bottomOffset * $gridSize;
                foreach (range(0, $gridSize - $size) as $x) {
                    $rightOffset = $x + $size - 1;

                    // when size 0 to 1, mapTotal has (0, 0). add (1, 0), (0, 1), (1, 1) is growed value
                    // right edge and bottom edge and the corner

                    // echo "add right edge of ($x, $y)\n";
                    foreach (range($x, $x + $size - 2) as $pos) {
                        // echo "ii $pos, $bottomOffset\n" . PHP_EOL;
                        $mapTotal[$dY + $x] += $grid[$dBottom + $pos];
                    }

                    // echo "add right side edge of ($x, $y)\n";
                    // avoid to add right bottom corner twice
                    $aX = $x + $size - 1;
                    foreach (range($y, $y + $size - 2) as $pos) {
                        // echo "ii $rightOffset, $pos\n" . PHP_EOL;
                        $mapTotal[$dY + $x] += $grid[$pos * $gridSize + $rightOffset];
                    }

                    // echo "ii $rightOffset, $bottomOffset\n" . PHP_EOL;
                    $mapTotal[$dY + $x] += $grid[$dBottom + $rightOffset];

                    if ($mapTotal[$dY + $x] > $peekMax) {
                        $peekMax = $mapTotal[$dY + $x];

                        // 1 origin
                        $posAt = ($x + 1) . "," . ($y + 1) . "," . $size;
                        echo "max is changed to $peekMax at $size\n";
                    }
                }
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
        $grid = new SplFixedArray($gridSize * $gridSize);

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
        $grid->rewind();
        $i = 0;
        echo "dump grid" . PHP_EOL;
        while ($grid->valid()) {
            printf("%2d ", $grid->current());
            $grid->next();
            $i++;
            if ($i % $gridSize == 0) {
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
