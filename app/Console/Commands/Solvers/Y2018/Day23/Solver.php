<?php
declare(strict_types=1);

namespace App\Console\Commands\Solvers\Y2018\Day23;

class Solver
{
    private $nanobots;
    private $strongest;

    public function solvePart1(iterable $input)
    {
        $this->parseInput($input);

        $cnt = 0;
        $strongestRange = $this->nanobots[$this->strongest][3];
        foreach ($this->nanobots as $idx => $nanobot) {
            if ($strongestRange >= $this->distance($this->strongest, $idx)) {
                $cnt++;
            }
        }

        return $cnt;
    }

    private function parseInput(iterable $input)
    {
        $strongestIndex = null;
        $strongestRange = PHP_INT_MIN;
        $nanobots = [];
        foreach ($input as $line) {
            preg_match_all('/-?\d+/', $line, $matches);
            list($x, $y, $z, $r) = current($matches);

            $nanobots[] = [$x, $y, $z, $r];

            if ($r > $strongestRange) {
                $strongestIndex = count($nanobots) - 1;
                $strongestRange = $r;
            }
        }

        $this->nanobots = $nanobots;
        $this->strongest = $strongestIndex;
    }

    private function distance($lhs, $rhs)
    {
        return abs($this->nanobots[$lhs][0] - $this->nanobots[$rhs][0])
            + abs($this->nanobots[$lhs][1] - $this->nanobots[$rhs][1])
            + abs($this->nanobots[$lhs][2] - $this->nanobots[$rhs][2]);
    }
}
