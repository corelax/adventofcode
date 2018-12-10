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

    const NEXT = 0;
    const PREV = 1;

    private function playGame($playersCount, $lastMarble)
    {
        ini_set('memory_limit', -1);
        // echo "$playersCount, $lastMarble\n";
        $this->circle = array_fill(0, $lastMarble + 1, [-1, -1]);

        $this->circle[0][self::NEXT] = 0;
        $this->circle[0][self::PREV] = 0;

        $current = 0;

        $scoreBoard = array_fill(1, $playersCount, 0);

        $player = 1;
        $marble = 1;

        $this->showCircle($current);

        while ($marble <= $lastMarble) {
            list($current, $score) = $this->processMarble($current, $marble);
            $scoreBoard[$player] += $score;

            $this->showCircle($current);

            $marble++;
            $player = ($player % $playersCount) + 1;

            // echo "$marble, $player\n";
        }

        // print_r($scoreBoard);

        return max($scoreBoard);
    }

    private function showCircle($current)
    {
        return; // nothing
        $p = 0;
        do {
            if ($p == $current) {
                echo '(' . $p . ')' . ' ';
            } else {
                echo $p . ' ';
            }
            $p = $this->circle[$p][self::NEXT];
        } while (0 != $p);
        echo PHP_EOL;
    }

    private function processMarble($current, $marble)
    {
        $score = 0;
        if ($marble % 23 == 0) {
            foreach (range(1, 7) as $i) {
                $current = $this->circle[$current][self::PREV];
            }
            $score = $marble + $current;
            $next = $this->remove($current);
        } else {
            foreach (range(1, 2) as $i) {
                $current = $this->circle[$current][self::NEXT];
            }
            $next = $this->insert($current, $marble);
        }

        return [$next, $score];
    }

    // returns new current
    private function insert($current, $value)
    {
        $this->circle[$value][self::NEXT] = $current;
        $this->circle[$value][self::PREV] = $this->circle[$current][self::PREV];

        $this->circle[$this->circle[$current][self::PREV]][self::NEXT] = $value;
        $this->circle[$current][self::PREV] = $value;

        return $value;
    }

    // returns new current
    private function remove($current)
    {
        $next = $this->circle[$current][self::NEXT];
        $this->circle[$this->circle[$current][self::PREV]][self::NEXT] = $next;
        $this->circle[$this->circle[$current][self::NEXT]][self::PREV] = $this->circle[$current][self::PREV];

        return $next;
    }
}
