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

        return $this->findPeek($board, $width, $height);
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

    private function findPeek($board, $width, $height)
    {
        $peek = PHP_INT_MIN;
        $pos = '';
        // x y are 0 origin
        $area = [
            [0, 0], [1, 0], [2, 0],
            [0, 1], [1, 1], [2, 1],
            [0, 2], [1, 2], [2, 2],
            ];
        foreach (range(0, $height - 1 - 2) as $y) {
            foreach (range(0, $width - 1 - 2) as $x) {
                $sum = 0;
                foreach ($area as $offset) {
                    $sum += $board[($y + $offset[1]) * $width + ($x + $offset[0])];
                }
                $peek = max($peek, $sum);

                if ($peek == $sum) {
                    $pos = ($x + 1) . ',' . ($y + 1);
                }
            }
        }

        return [$pos, $peek];
    }
}
