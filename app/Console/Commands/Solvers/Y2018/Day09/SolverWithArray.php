<?php

namespace App\Console\Commands\Solvers\Y2018\Day09;

class SolverWithArray
{
    public function solvePart1(string $input)
    {
        $a = explode(' ', $input);
        $result = $this->playGame($a[0], $a[6]);
        return $result;
    }

    public function solvePart2(string $input)
    {
        $a = explode(' ', $input);
        $result = $this->playGame($a[0], $a[6] * 100);
        return $result;
    }

    private function playGame($playersCount, $lastMarble)
    {
        ini_set('memory_limit', '768M');
        $model = $this->initModel($lastMarble);
        $model->showCircle();

        $scoreBoard = array_fill(1, $playersCount, 0);

        $player = 1;
        for ($marble = 1; $marble <= $lastMarble; $marble++) {
            $scoreBoard[$player] += $model->processMarble($marble);

            $model->showCircle();

            $player = ($player % $playersCount) + 1;

            // echo "$marble, $player\n";
        }

        // print_r($scoreBoard);

        return max($scoreBoard);
    }

    private function initModel($lastMarble)
    {
        return new class($lastMarble) {
            // circle [
            //     0    : marble0.next
            //     1    : marble0.prev
            //     2    : marble1.next
            //     3    : marble1.prev
            //     4    : marble2.next
            //     ...
            //     N*2  : marbleN.next
            //     N*2+1: marbleN.next
            // ]
            // both next and prev has a marble value(not a index of circle)
            // circle index can get with marble value ( *2 or *2+1 )
            private $circle;
            private $current;

            public function __construct(int $lastMarble)
            {
                $this->circle = array_fill(0, ($lastMarble + 1) * 2, -1);

                $this->circle[0] = 0;
                $this->circle[1] = 0;

                $this->current = 0;
            }

            public function processMarble($marble)
            {
                $current = $this->current;
                $score = 0;
                if ($marble % 23 == 0) {
                    foreach (range(1, 7) as $i) {
                        $current = $this->circle[$current * 2 + 1];
                    }
                    $score = $marble + $current;
                    $next = $this->remove($current);
                } else {
                    foreach (range(1, 2) as $i) {
                        $current = $this->circle[$current * 2];
                    }
                    $next = $this->insert($current, $marble);
                }

                $this->current = $next;
                return $score;
            }

            public function showCircle()
            {
                return; // nothing
                $current = $this->current;
                $p = 0;
                do {
                    if ($p == $current) {
                        echo '(' . $p . ')' . ' ';
                    } else {
                        echo $p . ' ';
                    }
                    $p = $this->circle[$p * 2];
                } while (0 != $p);
                echo PHP_EOL;
            }

            // returns new current
            private function insert($current, $value)
            {
                $this->circle[$value * 2] = $current;
                $this->circle[$value * 2 + 1] = $this->circle[$current * 2 + 1];

                $this->circle[($this->circle[$current * 2 + 1]) * 2] = $value;
                $this->circle[$current * 2 + 1] = $value;

                return $value;
            }

            // returns new current
            private function remove($current)
            {
                $next = $this->circle[$current * 2];
                $this->circle[($this->circle[$current * 2 + 1]) * 2]= $next;
                $this->circle[($this->circle[$current * 2]) * 2 + 1]= $this->circle[$current * 2 + 1];

                return $next;
            }
        };
    }
}
