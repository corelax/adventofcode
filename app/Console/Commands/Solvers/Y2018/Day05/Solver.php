<?php

namespace App\Console\Commands\Solvers\Y2018\Day05;

class Solver
{
    private $reactPairs = [];

    public function __construct() {
        $this->reactPairs = $this->makeReactPairs();
    }

    public function solvePart1(string $input)
    {
        $data = $this->react($input);

        return strlen($data);
    }

    public function solvePart2(string $input)
    {
        $input1passed = $this->react($input);

        $min = strlen($input1passed);
        foreach(range('a', 'z') as $char) {
            $data = $input1passed;
            $data = str_replace([$char, strtoupper($char)], '', $data);
            $data = $this->react($data);

            if (strlen($data) < $min) {
                $min = strlen($data);
            }
        }

        return $min;
    }

    // Aa, aA, Bb, bB, ... zZ
    private function makeReactPairs()
    {
        $pairs = [];
        foreach(range('a', 'z') as $char) {
            $pairs[] = strtoupper($char) . $char;
            $pairs[] = $char . strtoupper($char);
        }

        return $pairs;
    }

    private function react(string $data)
    {
        return $this->react2($data);
    }

    private function react1(string $data)
    {
        do {
            $data = str_replace($this->reactPairs, '', $data, $count);
        } while($count);

        return $data;
    }

    private function react2(string $data)
    {
        $remainPos = [];
        for ($n = 0, $m = 1; $m < strlen($data); ) {
            if (abs(ord($data[$n]) - ord($data[$m])) == 0x20) {
                $data[$n] = $data[$m] = '.';
                if (! empty($remainPos)) {
                    // data:a..bcd
                    //       nm 
                    //      n  m
                    $n = array_pop($remainPos);
                    $m++;
                } else {
                    // data:...bcd
                    //       nm 
                    //         nm 
                    $n = $m + 1;
                    $m += 2;
                }
            } else {
                // data:apqbcd
                //       nm 
                //        nm 
                array_push($remainPos, $n);
                $n = $m;
                $m++;
            }
        }

        return str_replace('.', '', $data);
    }
}
