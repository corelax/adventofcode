<?php

namespace App\Console\Commands\Solvers\Y2018\Day11;

use SplFixedArray;

class Solver
{
    public function solvePart1(string $input)
    {
        $serialNumber = intval($input);

        $width = 300;
        $height = 300;

        $board = $this->buildBoard($width, $height, $serialNumber);

        // $this->dumpBoard($board, $width);

        return $this->findPeek($board, $width, $height, 3);
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

    private function buildBoard($width, $height, $serial)
    {
        $board = new SplFixedArray($width * $height);

        // board is 0 origin
        foreach (range(0, $height - 1) as $y) {
            foreach (range(0, $width - 1) as $x) {
                // parameter is 1 origin
                $board[$y * $width + $x] = $this->calcPowerLevel($x + 1, $y + 1, $serial);
            }
        }

        return $board;
    }

    private function dumpBoard($board, $width)
    {
        $board->rewind();
        $i = 0;
        echo "dump board" . PHP_EOL;
        while ($board->valid()) {
            printf("%2d ", $board->current());
            $board->next();
            $i++;
            if ($i % $width == 0) {
                echo PHP_EOL;
            }
        }
    }

    private function findPeek($board, $width, $height, $size)
    {
        $peek = PHP_INT_MIN;
        $pos = '';
        // x y are 0 origin
        foreach (range(0, $height - $size) as $y) {
            foreach (range(0, $width - $size) as $x) {
                $sum = $this->calcTotal($board, $width, $height, $x, $y, $size);

                $peek = max($peek, $sum);

                if ($peek == $sum) {
                    $pos = ($x + 1) . ',' . ($y + 1);
                }
            }
        }

        return [$pos, $peek];
    }

    private function calcTotal($board, $width, $height, $x, $y, $size)
    {
        $sum = 0;
        foreach (range(0, $size - 1) as $offsetY) {
            foreach (range(0, $size - 1) as $offsetX) {
                $sum += $board[($y + $offsetY) * $width + ($x + $offsetX)];
            }
        }

        return $sum;
    }
}
