<?php

namespace App\Console\Commands\Solvers\Y2018\Day03;

use SeekableIterator;

class Solver
{
    public function solvePart1(iterable $input) {
        $wantedMap = [];

        foreach ($input as $line) {
            sscanf($line, "#%d @ %d,%d: %dx%d", $id, $posX, $posY, $w, $h);

            for ($x = $posX; $x < $posX + $w; $x++) {
                for ($y = $posY; $y < $posY + $h; $y++) {
                    $key = "{$x}:{$y}";
                    if (!isset($wantedMap[$key])) {
                        $wantedMap[$key] = 1;
                    } else {
                        $wantedMap[$key]++;
                    }
                }
            }
        }

        $result = 0;
        foreach ($wantedMap as $k => $v) {
            if ($v >= 2) {
                $result++;
            }
        }
        return $result;
    }
}
