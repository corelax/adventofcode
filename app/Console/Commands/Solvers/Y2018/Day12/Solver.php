<?php

namespace App\Console\Commands\Solvers\Y2018\Day12;

use SplFixedArray;

class Solver
{
    public function solvePart1(iterable $input)
    {
        list($state, $patterns) = $this->parseInput($input);

        // print_r($patterns);

        return $this->solveMain($state, $patterns, 20);
    }

    private function solveMain($state, $patterns, $generation)
    {
        $leftValue = 0;
        foreach (range(1, $generation) as $g) {
            list($state, $leftValue) = $this->getNextGeneration($state, $patterns, $leftValue, $g);
        }

        return $this->sumPlants($state, $leftValue);
    }

    private function getNextGeneration(string $state, array $patterns, $leftValue, $generation)
    {
        if ($generation == 1) {
            $this->dumpState($state, $generation - 1, $leftValue);
        }

        $state = '...' . $state . '...';
        $leftValue -= 3;

        $newState = $state;

        // process range : without left and right '..'
        for ($i = 2; $i < strlen($state) - 2; $i++) {
            $match = false;

            foreach ($patterns as $pattern) {
                if ($this->isMatch($pattern, $state, $i)) {
                    $newState[$i] = '#';
                    $match = true;
                    break;
                }
            }

            if (! $match) {
                $newState[$i] = '.';
            }
        }

        // trim left empty pots
        $len = strlen($newState);
        $newState = ltrim($newState, '.');
        $leftValue += $len - strlen($newState);

        $newState = rtrim($newState, '.');


        $this->dumpState($newState, $generation, $leftValue);

        return [$newState, $leftValue];
    }

    private function dumpState($state, $generation, $leftValue)
    {
        return; // nothing

        printf("%6d %2d %5d", $this->sumPlants($state, $leftValue), $generation, $leftValue);
        foreach (range(-30, $leftValue) as $i) {
            echo '_';
        }
        echo $state . PHP_EOL;
    }

    private function isMatch ($pattern, $state, $i) {
        return ($pattern[0] == $state[$i - 2]
            && $pattern[1] == $state[$i - 1]
            && $pattern[2] == $state[$i]
            && $pattern[3] == $state[$i + 1]
            && $pattern[4] == $state[$i + 2]);
    }

    private function sumPlants($state, $leftValue)
    {
        $ret = 0;
        for ($i = 0; $i < strlen($state); $i++) {
            if ($state[$i] == '#') {
                $ret += $i + $leftValue;
            }
        }

        return $ret;
    }

    private function parseInput(array $input)
    {
        $initial = explode(' ', $input[0])[2];
        $patterns = [];

        for ($i = 2; $i < count($input); $i++) {
            $arr = explode(' ', $input[$i]);

            // pickup only productive(or remain) patterns
            if ($arr[2] == '#') {
                $patterns[] = $arr[0];
            }
        }

        return [$initial, $patterns];
    }
}
