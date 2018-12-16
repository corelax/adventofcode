<?php
declare(strict_types=1);

namespace App\Console\Commands\Solvers\Y2018\Day16;

class Solver
{
    public function solvePart1(iterable $input)
    {
        list($parsed, $program) = $this->parseInput($input);

        $ret = 0;
        foreach ($parsed as $info) {
            if (count($info['possibleOps']) >= 3) {
                $ret++;
            }
        }

        return $ret;
    }

    public function solvePart2(iterable $input)
    {
        list($parsed, $program) = $this->parseInput($input);

        $ret = 0;
        foreach ($parsed as $info) {
            if (count($info['possibleOps']) >= 3) {
                $ret++;
            }
        }

        $opMap = [];
        do {
            $parsed = array_unique($parsed, SORT_REGULAR);

            foreach ($parsed as $info) {
                if (count($info['possibleOps']) == 1) {
                    $opName = $info['possibleOps'][0];
                    $opMap[$info['opcode']] = $opName;
                    break;
                }
            }

            $remain = false;
            foreach ($parsed as &$info) {
                $info['possibleOps'] = array_values(array_diff($info['possibleOps'], [$opName]));
                if (count($info['possibleOps']) != 0) {
                    $remain = true;
                }
            }
            unset($info);
        } while ($remain);

        // > The registers start with the value 0.
        $register = [0, 0, 0, 0];
        foreach ($program as $arr) {
            list($op, $a, $b, $c) = $arr;
            $register = $this->{$opMap[$op]}($register, $a, $b, $c);
        }

        return $register[0];
    }

    private function parseInput(iterable $input)
    {
        $parsed = [];
        $program = [];

        $skipCount = 0;
        for ($i = 0; $i < count($input); $i++) {
            if ($skipCount == 2) {
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

                $parsed[] = ['opcode' => $opcode, 'possibleOps' => $ops];
            }
        }

        for (; $i < count($input); $i++) {
            preg_match_all('/\d+/', $input[$i], $matches);
            $program[] = $matches[0];
        }

        return [$parsed, $program];
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
