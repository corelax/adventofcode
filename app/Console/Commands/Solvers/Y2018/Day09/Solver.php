<?php

namespace App\Console\Commands\Solvers\Y2018\Day09;

class Node
{
    public $value;
    public $next;
    public $prev;

    public function __construct($value)
    {
        $this->value = $value;
        $this->next = null;
        $this->prev = null;
    }
}

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
        // echo "$playersCount, $lastMarble\n";

        // in this rule, root never change.
        $root = new Node(0);
        $root->next = $root;
        $root->prev = $root;

        $current = $root;

        $scoreBoard = array_fill(1, $playersCount, 0);

        $player = 1;
        $marble = 1;

        $this->showCircle($root, $current);

        while ($marble <= $lastMarble) {
            list($current, $score) = $this->processMarble($current, $marble);
            $scoreBoard[$player] += $score;

            $this->showCircle($root, $current);

            $marble++;
            $player = ($player % $playersCount) + 1;

            // echo "$marble, $player\n";
        }

        // print_r($scoreBoard);

        return max($scoreBoard);
    }

    private function showCircle($root, $current)
    {
        return; // do nothing

        $p = $root;
        do {
            if ($p == $current) {
                echo '(' . $p->value . ')' . ' ';
            } else {
                echo $p->value . ' ';
            }
            $p = $p->next;
        } while ($root != $p);
        echo PHP_EOL;
    }

    private function processMarble($current, $marble)
    {
        $score = 0;
        if ($marble % 23 == 0) {
            foreach (range(1, 7) as $i) {
                $current = $current->prev;
            }
            $score = $marble + $current->value;
            $next = $this->remove($current);
        } else {
            foreach (range(1, 2) as $i) {
                $current = $current->next;
            }
            $next = $this->insert($current, $marble);
        }

        return [$next, $score];
    }

    // returns new current
    private function insert($node, $value)
    {
        $newNode = new Node($value);
        $newNode->next = $node;
        $newNode->prev = $node->prev;

        $node->prev->next = $newNode;
        $node->prev = $newNode;

        return $newNode;
    }

    // returns new current
    private function remove($node)
    {
        $node->prev->next = $node->next;
        $node->next->prev = $node->prev;

        return $node->next;
    }
}
