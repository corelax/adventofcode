<?php
declare(strict_types=1);

namespace App\Console\Commands\Solvers\Y2018\Day16;

class Solver
{
    public function solvePart1(iterable $input)
    {
        $ret = 0;

        $skipCount = 0;
        for ($i = 0; $i < count($input); $i++) {
            if ($skipCount == 3) {
                break;
            }
            if ($input[$i] == '') {
                $skipCount++;
                continue;
            }
            if (strpos($input[$i], 'Before') !== false) {
                $skipCount = 0;

                preg_match_all('/\d+/', $input[$i++], $matches);
                $before = $matches[0];

                preg_match_all('/\d+/', $input[$i++], $matches);
                list($opcode, $a, $b, $c) = $matches[0];

                preg_match_all('/\d+/', $input[$i++], $matches);
                $after = $matches[0];

                $ops = $this->getPossibleOps($before, $after, $a, $b, $c);

                if (count($ops) >= 3) {
                    $ret++;
                }
            }
        }

        return $ret;
    }

    public function solvePart2(iterable $input)
    {
        return '';
    }

    private function getPossibleOps($registerBefore, $registerAfter, $a, $b, $c)
    {
        $ret = [];
        foreach ($this->ops as $op) {
            if (self::$op($registerBefore, $a, $b, $c) == $registerAfter) {
                $ret[] = $op;
            }
        }

        return $ret;
    }

    private $ops = [
        'addr', 'addi',
        'mulr', 'muli',
        'banr', 'bani',
        'borr', 'bori',
        'setr', 'seti',
        'gtir', 'gtri', 'gtrr',
        'eqir', 'eqri', 'eqrr',
        ];

    
    // instruction set

    private static function addr($register, $a, $b, $c)
    {
        $register[$c] = $register[$a] + $register[$b];
        return $register;
    }

    private static function addi($register, $a, $b, $c)
    {
        $register[$c] = $register[$a] + $b;
        return $register;
    }

    private static function mulr($register, $a, $b, $c)
    {
        $register[$c] = $register[$a] * $register[$b];
        return $register;
    }

    private static function muli($register, $a, $b, $c)
    {
        $register[$c] = $register[$a] * $b;
        return $register;
    }

    private static function banr($register, $a, $b, $c)
    {
        $register[$c] = $register[$a] & $register[$b];
        return $register;
    }

    private static function bani($register, $a, $b, $c)
    {
        $register[$c] = $register[$a] & $b;
        return $register;
    }

    private static function borr($register, $a, $b, $c)
    {
        $register[$c] = $register[$a] | $register[$b];
        return $register;
    }

    private static function bori($register, $a, $b, $c)
    {
        $register[$c] = $register[$a] | $b;
        return $register;
    }

    private static function setr($register, $a, $b, $c)
    {
        $register[$c] = $register[$a];
        return $register;
    }

    private static function seti($register, $a, $b, $c)
    {
        $register[$c] = $a;
        return $register;
    }

    private static function gtir($register, $a, $b, $c)
    {
        $register[$c] = ($a > $register[$b]) ? 1 : 0;
        return $register;
    }

    private static function gtri($register, $a, $b, $c)
    {
        $register[$c] = ($register[$a] > $b) ? 1 : 0;
        return $register;
    }

    private static function gtrr($register, $a, $b, $c)
    {
        $register[$c] = ($register[$a] > $register[$b]) ? 1 : 0;
        return $register;
    }

    private static function eqir($register, $a, $b, $c)
    {
        $register[$c] = ($a == $register[$b]) ? 1 : 0;
        return $register;
    }

    private static function eqri($register, $a, $b, $c)
    {
        $register[$c] = ($register[$a] == $b) ? 1 : 0;
        return $register;
    }

    private static function eqrr($register, $a, $b, $c)
    {
        $register[$c] = ($register[$a] == $register[$b]) ? 1 : 0;
        return $register;
    }
}
