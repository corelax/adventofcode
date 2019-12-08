<?php
declare(strict_types=1);

namespace App\Console\Commands\Solvers\Y2019\Day01;

class Solver
{
    private $masslist;

    public function solvePart1(iterable $input): int
    {
        $this->parseInput($input);

        return array_sum(array_map(
                    fn($n) => self::calcRequiredFuel($n), $this->masslist)
                );
    }

    public function solvePart2(iterable $input): int
    {
        return -1;
    }

    private function parseInput(iterable $input): void
    {
        $masslist = [];
        foreach ($input as $line) {
            $masslist[] = intval($line);
        }

        $this->masslist = $masslist;
    }

    private static function calcRequiredFuel(int $mass): int
    {
        return intval($mass / 3) - 2;
    }
}
