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

    public function solvePart2(string $input, int $boxSize = 300)
    {
        $serialNumber = intval($input);

        $width = $boxSize;
        $height = $boxSize;

        $board = $this->buildBoard($width, $height, $serialNumber);

        // $this->dumpBoard($board, $width);


        // init with board. equal to size == 1
        $mapTotal = SplFixedArray::fromArray($board->toArray());

        $peekMax = PHP_INT_MIN;
        $posAt = '';

        echo max($mapTotal->toArray()) . "init\n";

        for ($size = 2; $size < $width; $size++) {
            // grow map total
            echo "grows to $size\n";
            foreach (range(0, $height - $size) as $y) {
                foreach (range(0, $width - $size) as $x) {
                    $idx = $y * $width + $x;

                    // when size 0 to 1, mapTotal has (0, 0). add (1, 0), (0, 1), (1, 1) is growed value
                    // right edge and bottom edge and the corner

                    // echo "add right edge of ($x, $y)\n";
                    foreach (range($x, $x + $size - 2) as $additional) {
                        $aX = $additional;
                        $aY = $y + $size - 1;
                        // echo "ii $aX, $aY\n" . PHP_EOL;
                        $mapTotal[$idx] += $board[$aY * $width + $aX];
                    }

                    // echo "add right side edge of ($x, $y)\n";
                    // avoid to add right bottom corner twice
                    foreach (range($y, $y + $size - 2) as $additional) {
                        $aX = $x + $size - 1;
                        $aY = $additional;
                        // echo "ii $aX, $aY\n" . PHP_EOL;
                        $mapTotal[$idx] += $board[$aY * $width + $aX];
                    }

                    $aX = $x + $size - 1;
                    $aY = $y + $size - 1;
                    $mapTotal[$idx] += $board[$aY * $width + $aX];
                }
            }

            $peek = max($mapTotal->toArray());
            $peekMax = max($peekMax, $peek);

            if ($peekMax == $peek) {
                echo "max is changed to $peekMax at $size\n";
                // I forget to get the pos where is the peek
                $keys = array_keys($mapTotal->toArray(), $peek);
                // 1 origin
                $x = ($keys[0] % $width) + 1;
                $y = intval($keys[0] / $width) + 1;
                $posAt = "$x,$y,$size";
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
