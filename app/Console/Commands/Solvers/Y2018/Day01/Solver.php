<?php

namespace App\Console\Commands\Solvers\Y2018\Day01;

use SeekableIterator;

class Solver
{
    public function calc(iterable $input) {
        $result = 0;
        foreach ($input as $data) {
            $result += intval($data);
        }
        return $result;
    }

    public function calc2(SeekableIterator $input) {
        $history = [0 => true];
        $result = 0;
        while(true) {
            foreach ($input as $data) {
                $result += intval($data);
                if (isset($history[$result])) {
                    return $result;
                }
                $history[$result] = true;
            }
            $input->rewind();
        }
        return $result;
    }
}
