<?php
declare(strict_types=1);

namespace App\Console\Commands\Solvers\Y2018\Day19;

class Solver
{
    public function solvePart1(iterable $input)
    {
        list($posIp, $program) = $this->parseInput($input);

        $register = [0, 0, 0, 0, 0, 0];

        while ($register[$posIp] < count($program)) {
            list($op, $a, $b, $c) = $program[$register[$posIp]];
            self::$op($register, $a, $b, $c);
            $register[$posIp]++;
        }

        return $register[0];
    }

    public function solvePart2(iterable $input)
    {
        /*
        list($posIp, $program) = $this->parseInput($input);

        $register = [1, 0, 0, 0, 0, 0];

        while ($register[$posIp] < count($program)) {
            list($op, $a, $b, $c) = $program[$register[$posIp]];
            self::$op($register, $a, $b, $c);
            $register[$posIp]++;
        }

        return $register[0];
        */

        // convert input to code(and optimized a little)
        // part1
        $r4 = 4 * 19 * 11 + (6 * 22 + 21);

        // part2
        $r4 += (27 * 28 + 29) * 30 * 14 * 32;
        $r0 = 0;

        for ($r5 = 1; $r5 <= $r4; $r5++) {
            if ($r4 % $r5 == 0) {
                $r0 += $r5;
            }
        }

        return $r0;
    }

    private function parseInput(iterable $input)
    {
        $pc = 0;
        $program = [];

        preg_match_all('/\d+/', current($input), $matches);
        $pc = current($matches)[0];

        for ($i = 1; $i < count($input); $i++) {
            $program[] = explode(' ', $input[$i]);
        }

        return [$pc, $program];
    }

    
    // instruction set

    private static function addr(&$register, $a, $b, $c)
    {
        $register[$c] = $register[$a] + $register[$b];
    }

    private static function addi(&$register, $a, $b, $c)
    {
        $register[$c] = $register[$a] + $b;
    }

    private static function mulr(&$register, $a, $b, $c)
    {
        $register[$c] = $register[$a] * $register[$b];
    }

    private static function muli(&$register, $a, $b, $c)
    {
        $register[$c] = $register[$a] * $b;
    }

    private static function banr(&$register, $a, $b, $c)
    {
        $register[$c] = $register[$a] & $register[$b];
    }

    private static function bani(&$register, $a, $b, $c)
    {
        $register[$c] = $register[$a] & $b;
    }

    private static function borr(&$register, $a, $b, $c)
    {
        $register[$c] = $register[$a] | $register[$b];
    }

    private static function bori(&$register, $a, $b, $c)
    {
        $register[$c] = $register[$a] | $b;
    }

    private static function setr(&$register, $a, $b, $c)
    {
        $register[$c] = $register[$a];
    }

    private static function seti(&$register, $a, $b, $c)
    {
        $register[$c] = $a;
    }

    private static function gtir(&$register, $a, $b, $c)
    {
        $register[$c] = ($a > $register[$b]) ? 1 : 0;
    }

    private static function gtri(&$register, $a, $b, $c)
    {
        $register[$c] = ($register[$a] > $b) ? 1 : 0;
    }

    private static function gtrr(&$register, $a, $b, $c)
    {
        $register[$c] = ($register[$a] > $register[$b]) ? 1 : 0;
    }

    private static function eqir(&$register, $a, $b, $c)
    {
        $register[$c] = ($a == $register[$b]) ? 1 : 0;
    }

    private static function eqri(&$register, $a, $b, $c)
    {
        $register[$c] = ($register[$a] == $b) ? 1 : 0;
    }

    private static function eqrr(&$register, $a, $b, $c)
    {
        $register[$c] = ($register[$a] == $register[$b]) ? 1 : 0;
    }
}
