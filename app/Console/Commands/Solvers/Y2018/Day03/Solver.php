<?php

namespace App\Console\Commands\Solvers\Y2018\Day03;

use Iterator;

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

    public function solvePart2(iterable $input)
    {
        $this->createWantedMap($input);

        foreach ($input as $line) {
            sscanf($line, "#%d @ %d,%d: %dx%d", $id, $posX, $posY, $w, $h);
            if (!$this->isOverrapped($posX, $posY, $w, $h)) {
                return $id;
            }
        }
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

        if ($input instanceof Iterator) {
            $input->rewind();
        }
    }

    private function isOverrapped($posX, $posY, $w, $h)
    {
        for ($x = $posX; $x < $posX + $w; $x++) {
            for ($y = $posY; $y < $posY + $h; $y++) {
                $key = "{$x}:{$y}";
                if ($this->wantedMap[$key] >= 2) {
                    return true;
                }
            }
        }

        return false;
    }
}
