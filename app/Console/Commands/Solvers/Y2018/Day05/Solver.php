<?php

namespace App\Console\Commands\Solvers\Y2018\Day05;

class Solver
{
    public function solvePart1(string $input)
    {
        $data = $this->react($input);

        return strlen($data);
    }

    public function solvePart2(string $input)
    {
        $input1passed = $this->react($input);
        $listC = range('A', 'Z');
        $listS = range('a', 'z');

        $min = strlen($input1passed);
        // Aa, aA, Bb, bB, ... zZ
        $list = [];
        for ($i = 0; $i < 26; $i++) {
            $data = $input1passed;
            $data = str_replace([$listC[$i], $listS[$i]], '', $data);
            $data = $this->react($data);

            if (strlen($data) < $min) {
                $min = strlen($data);
            }
        }

        return $min;
    }

    private function react(string $input)
    {
        $data = $input;
        $listC = range('A', 'Z');
        $listS = range('a', 'z');

        // Aa, aA, Bb, bB, ... zZ
        $list = [];
        for ($i = 0; $i < 26; $i++) {
            $list[] = $listC[$i] . $listS[$i];
            $list[] = $listS[$i] . $listC[$i];
        }

        while(true) {
            $data = str_replace($list, '', $data, $count);
            if ($count === 0) {
                break;
            }
        } 

        return $data;
    }
}
