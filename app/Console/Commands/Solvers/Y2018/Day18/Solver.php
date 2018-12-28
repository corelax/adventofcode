<?php
declare(strict_types=1);

namespace App\Console\Commands\Solvers\Y2018\Day18;

class Solver
{
    private $nanobots;
    private $strongest;

    public function solvePart1(iterable $input)
    {
        $this->parseInput($input);

        foreach (range(1, 10) as $i) {
            $this->tick();
        }
        $this->printLand();

        $counts = ['.' => 0, '|' => 0, '#' => 0];
        foreach (range(1, $this->landSize) as $y) {
            $line = $this->land[$y];
            foreach (range(1, $this->landSize) as $x) {
                $acre = $line[$x];
                $counts[$acre]++;
            }
        }

        return $counts['|'] * $counts['#'];
    }

    public function solvePart2(iterable $input)
    {
        $this->parseInput($input);

        $memo = [$this->land];

        $skip = 0;
        $loopStart = 0;
        $loopEnd = 0;

        for ($i = 0; $i < 1000000000; $i++) {
            $this->tick();
            $found = array_search($this->land, $memo);
            if ($found !== false) {
                $this->land = $memo[(1000000000 + 1) % ($i - $found + 1) + $found + 1];
                break;
            }
            else {
                $memo[] = $this->land;
            }
        }
        $this->printLand();

        $counts = ['.' => 0, '|' => 0, '#' => 0];
        foreach (range(1, $this->landSize) as $y) {
            $line = $this->land[$y];
            foreach (range(1, $this->landSize) as $x) {
                $acre = $line[$x];
                $counts[$acre]++;
            }
        }

        return $counts['|'] * $counts['#'];
    }

    private $land;
    private $landSize;

    private function parseInput(iterable $input)
    {
        $this->landSize = strlen(current($input));
        $this->land[] = array_fill(0, $this->landSize + 2, ' ');
        foreach ($input as $line) {
            $tmp = str_split($line);
            array_unshift($tmp, ' ');
            array_push($tmp, ' ');
            $this->land[] = $tmp;
        }
        $this->land[] = array_fill(0, $this->landSize + 2, ' ');
    }

    private function printLand()
    {
        return; // nothing

        foreach (range(1, $this->landSize) as $y) {
            $line = $this->land[$y];
            foreach (range(1, $this->landSize) as $x) {
                $acre = $line[$x];
                echo $acre;
            }
            echo PHP_EOL;
        }
    }

    private function getAdjacents($x, $y)
    {
        $ret = ['.' => 0, '|' => 0, '#' => 0];
        foreach (array_count_values([
            $this->land[$y - 1][$x - 1],
            $this->land[$y - 1][$x],
            $this->land[$y - 1][$x + 1],
            $this->land[$y][$x - 1],
            // $this->land[$y][$x],
            $this->land[$y][$x + 1],
            $this->land[$y + 1][$x - 1],
            $this->land[$y + 1][$x],
            $this->land[$y + 1][$x + 1],
            ]) as $key => $count) {
            $ret[$key] = $count;
        }

        return $ret;
    }

    private function tick()
    {
        $nextLand = $this->land;
        foreach (range(1, $this->landSize) as $y) {
            $line = $this->land[$y];
            foreach (range(1, $this->landSize) as $x) {
                $acre = $line[$x];
                $inf = $this->getAdjacents($x, $y);
                switch ($acre) {
                    case '.':
                        if ($inf['|'] >= 3) {
                            $nextLand[$y][$x] = '|';
                        }
                        break;
                    case '|':
                        if ($inf['#'] >= 3) {
                            $nextLand[$y][$x] = '#';
                        }
                        break;
                    case '#':
                        if ($inf['#'] == 0 || $inf['|'] == 0) {
                            $nextLand[$y][$x] = '.';
                        }
                        break;
                }
            }
        }

        $this->land = $nextLand;
    }
}
