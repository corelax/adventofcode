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
