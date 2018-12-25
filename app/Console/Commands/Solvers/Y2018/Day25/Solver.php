<?php
declare(strict_types=1);

namespace App\Console\Commands\Solvers\Y2018\Day25;

class Solver
{
    private $coordinates = [];
    private $constellations = [];

    private function init()
    {
        $this->coordinates = [];
        $this->constellations = [];
    }

    public function solvePart1(iterable $input)
    {
        $this->init();
        $this->parseInput($input);

        $cnt = 0;
        foreach ($this->coordinates as $idx => $coord) {
            $this->addStar($coord);
        }

        print_r($this->constellations);

        return count($this->constellations);;
    }

    public function addStar($coord)
    {
        $idxList = [];
        foreach ($this->constellations as $idx => $group) {
            foreach ($group as $tmp) {
                if ($this->distance(
                            $coord[0], $coord[1], $coord[2], $coord[3], 
                            $tmp[0], $tmp[1], $tmp[2], $tmp[3]) <= 3)
                {
                    $idxList[] = $idx;
                    break;
                }
            }
        }

        // create new group
        if (count($idxList) == 0) {
            $this->constellations[] = [$coord];
            return;
        }

        // combine groups
        if (count($idxList) > 1) {
            for ($i = 1; $i < count($idxList); $i++) {
                $this->constellations[$idxList[0]] = array_merge($this->constellations[$idxList[0]], $this->constellations[$idxList[$i]]);
                unset($this->constellations[$idxList[$i]]);
            }
        }

        $this->constellations[$idxList[0]][] = $coord;
    }

    private function parseInput(iterable $input)
    {
        foreach ($input as $line) {
            preg_match_all('/-?\d+/', $line, $matches);
            list($x, $y, $z, $r) = current($matches);

            $coordinates[] = [$x, $y, $z, $r];
        }

        $this->coordinates = $coordinates;
    }

    private function distance($x1, $y1, $z1, $r1, $x2, $y2, $z2, $r2)
    {
        return abs($x1 - $x2)
            + abs($y1 - $y2)
            + abs($z1 - $z2)
            + abs($r1 - $r2);
    }
}
