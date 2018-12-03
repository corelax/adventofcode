<?php

namespace App\Console\Commands\Solvers\Y2018\Day03;

use SeekableIterator;

class Solver
{
    private $wantedMap = [];

    public function solvePart1(iterable $input)
    {
        $this->createWantedMap($input);

        $result = 0;
        foreach ($this->wantedMap as $k => $v) {
            if ($v >= 2) {
                $result++;
            }
        }
        return $result;
    }

    private function createWantedMap(iterable $input)
    {
        $this->wantedMap = [];
        foreach ($input as $line) {
            sscanf($line, "#%d @ %d,%d: %dx%d", $id, $posX, $posY, $w, $h);

            for ($x = $posX; $x < $posX + $w; $x++) {
                for ($y = $posY; $y < $posY + $h; $y++) {
                    $key = "{$x}:{$y}";
                    if (!isset($this->wantedMap[$key])) {
                        $this->wantedMap[$key] = 1;
                    } else {
                        $this->wantedMap[$key]++;
                    }
                }
            }
        }

        if ($input instanceof SeekableIterator) {
            $input->rewind();
        }
    }
}
