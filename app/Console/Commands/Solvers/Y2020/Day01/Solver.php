<?php
declare(strict_types=1);

namespace App\Console\Commands\Solvers\Y2020\Day01;

class Solver
{
    private $list;

    public function solvePart1(iterable $input): int
    {
        $this->parseInput($input);

        $count = count($input);
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i+1; $j < $count; $j++) {
                if ($this->list[$i] + $this->list[$j] == 2020) {
                    return $this->list[$i] * $this->list[$j];
                }
            }
        }
    }

    public function solvePart2(iterable $input): int
    {
        $this->parseInput($input);

        $count = count($input);
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i+1; $j < $count; $j++) {
                for ($k = $j+1; $k < $count; $k++) {
                    if ($this->list[$i] + $this->list[$j] + $this->list[$k] == 2020) {
                        return $this->list[$i] * $this->list[$j] * $this->list[$k];
                    }
                }
            }
        }
    }

    private function parseInput(iterable $input): void
    {
        $list = [];
        foreach ($input as $line) {
            $list[] = intval($line);
        }

        $this->list = $list;
    }
}
