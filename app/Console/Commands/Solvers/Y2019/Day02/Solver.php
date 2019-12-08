<?php
declare(strict_types=1);

namespace App\Console\Commands\Solvers\Y2019\Day02;

class Solver
{
    private $memory;

    public function solvePart1(iterable $input): int
    {
        $this->parseInput($input);

        $this->memory[1] = 12;
        $this->memory[2] =  2;

        $this->run();

        return $this->memory[0];
    }

    public function solvePart2(iterable $input): int
    {
        return -1;
    }

    private function parseInput(iterable $input): void
    {
        $memory = [];
        foreach ($input as $line) {
            $memory = array_map(fn($it) => intval($it), explode(',', $line));
            break;
        }

        $this->memory = $memory;
    }

    private function run(): void
    {
        for ($pc = 0; $this->memory[$pc] != 99; $pc+=4) {
            $s1 = $this->memory[$pc + 1];
            $s2 = $this->memory[$pc + 2];
            $dest = $this->memory[$pc + 3];
            switch($this->memory[$pc]) {
                case 1:
                    $this->memory[$dest] = $this->memory[$s1] + $this->memory[$s2];
                    break;
                case 2:
                    $this->memory[$dest] = $this->memory[$s1] * $this->memory[$s2];
                    break;
            }
        }
        return;
    }

    private function dump(): string
    {
        return implode(',', $this->memory);
    }
}
