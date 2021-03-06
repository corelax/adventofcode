<?php
declare(strict_types=1);

namespace App\Console\Commands\Solvers\Y2019\Day04;

class Solver
{
    private $masslist;

    public function solvePart1(iterable $input): int
    {
        list($min, $max) = $this->parseInput($input);

        return array_sum(array_map(fn($n) => self::isValid($n) ? 1 : 0, range($min, $max)));
    }

    public function solvePart2(iterable $input): int
    {
        list($min, $max) = $this->parseInput($input);

        return array_sum(array_map(fn($n) => self::isValid2($n) ? 1 : 0, range($min, $max)));
    }

    private function parseInput(iterable $input): array
    {
        return array_map(fn($n) => intval($n), explode('-', $input[0]));
    }

    private static function isValid(int $challenge): bool
    {
        if (!self::neverDecreases(strval($challenge))) {
            return false;
        }
        if (!self::hasDouble(strval($challenge))) {
            return false;
        }
        return true;
    }

    private static function isValid2(int $challenge): bool
    {
        if (!self::neverDecreases(strval($challenge))) {
            return false;
        }
        if (!self::hasJustDouble(strval($challenge))) {
            return false;
        }
        return true;
    }

    private static function neverDecreases(string $val): bool
    {
        $prev = $val[0];

        foreach (str_split(substr($val, 1)) as $c) {
            if ($c < $prev) {
                return false;
            }
            $prev = $c;
        }

        return true;
    }

    private static function hasDouble(string $val): bool
    {
        $prev = $val[0];

        foreach (str_split(substr($val, 1)) as $c) {
            if ($c == $prev) {
                return true;
            }
            $prev = $c;
        }

        return false;
    }

    private static function hasJustDouble(string $val): bool
    {
        $val = 'AB' . $val . 'BA'; // sentinel

        for ($i = 2; $i < strlen($val) - 2; $i++) {
            $c = $val[$i];
            if (($c == $val[$i - 2] ? 1 : 0) +
                ($c == $val[$i - 1] ? 1 : 0) +
                ($c == $val[$i + 1] ? 1 : 0) +
                ($c == $val[$i + 2] ? 1 : 0) == 1) {
                return true;
            }
            $prev = $c;
        }

        return false;
    }
}
