<?php

namespace App\Console\Commands\Solvers\Y2018\Day09;

class Solver
{
    public function solvePart1(string $input)
    {
        $a = explode(' ', $input);
        $result = $this->playGame($a[0], $a[6]);
        return $result;
    }

    private function playGame($playersCount, $lastMarble)
    {
        // echo "game start $playersCount, $lastMarble\n";
        $circle = [0];
        $current = 0;

        $scoreBoard = array_fill(1, $playersCount, 0);

        $player = 1;
        $marble = 1;

        $this->showCircle($circle, $current, '-');

        while ($marble <= $lastMarble) {
            list($circle, $current, $score) = $this->putMarble($circle, $current, $marble);
            $this->showCircle($circle, $current, $player);

            $scoreBoard[$player] += $score;

            $marble++;
            $player = ($player % $playersCount) + 1;

            // echo "$marble, $player\n";
        }

        // print_r($scoreBoard);

        return max($scoreBoard);
    }

    private function putMarble($circle, $current, $marble)
    {
        $score = 0;
        if ($marble % 23 == 0) {
            // remove
            $next = $this->getPos($circle, $current, -7);
            $score = $marble + $circle[$next];
            array_splice($circle, $next, 1);
        } else {
            $next = $this->getPos($circle, $current, 2);
            array_splice($circle, $next, 0, $marble);
        }

        return [$circle, $next, $score];
    }

    private function showCircle($circle, $current, $player)
    {
        return; // nothing

        echo "[$player]";
        for ($i = 0; $i < count($circle); $i++) {
            echo ' ';
            if ($i == $current) {
                echo "({$circle[$i]})";
            } else {
                echo "{$circle[$i]}";
            }
        }
        echo PHP_EOL;
    }

    private function getPos($circle, $current, $offset)
    {
        if ($offset < 0) {
            if ($current < -1 * $offset) {
                $next = $current + $offset + count($circle);
            } else {
                $next = $current + $offset;
            }
        } else {
            if (count($circle) == 1) {
                $next = 1;
            } else {
                $next = $current + $offset;
                if ($next == count($circle)) {
                    // keep
                } else {
                    $next = $next % count($circle);
                }
            }
        }

        return $next;
    }
}
