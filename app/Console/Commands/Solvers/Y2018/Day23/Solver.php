<?php
declare(strict_types=1);

namespace App\Console\Commands\Solvers\Y2018\Day23;

class Solver
{
    private $nanobots;
    private $strongest;

    public function solvePart1(iterable $input)
    {
        $this->parseInput($input);

        $cnt = 0;
        $strongestRange = $this->nanobots[$this->strongest][3];
        foreach ($this->nanobots as $idx => $nanobot) {
            if ($strongestRange >= $this->distanceByIdx($this->strongest, $idx)) {
                $cnt++;
            }
        }

        return $cnt;
    }

    public function solvePart2(iterable $input)
    {
        $this->parseInput($input);

        $rate = pow(2, 30);
        $reducePower = 2;
        $candidates = [[0, 0, 0]];
        while ($rate != 1) {
            $rate /= $reducePower;

            // echo "rate : " . $rate . PHP_EOL;
            list($reducedMap, $minX, $maxX, $minY, $maxY, $minZ, $maxZ) = $this->makeReducedMap($rate);

            $newCandidates = [];
            $maxCnt = 0;
            foreach ($candidates as $pos) {
                list($bX, $bY, $bZ) = $pos;
                list($tmpCandidates, $cnt) = $this->getCandidates(
                        $reducedMap,
                        ($bX - 1) * $reducePower, ($bX + 1) * $reducePower,
                        ($bY - 1) * $reducePower, ($bY + 1) * $reducePower,
                        ($bZ - 1) * $reducePower, ($bZ + 1) * $reducePower);

                if ($cnt > $maxCnt) {
                    $newCandidates = [];
                    $maxCnt = $cnt;
                }

                if ($cnt >= $maxCnt) {
                    foreach ($tmpCandidates as $tmp) {
                        $newCandidates[] = $tmp;
                    }
                }
            }

            // shrink candidates only nearest positions
            list($distance, $candidates) = $this->getNearest($newCandidates);
            // print_r($cnt);
            // print_r($distance);
            // print_r($candidates);
        }

        list($distance, $posList) = $this->getNearest($candidates);

        return $distance;
    }

    private function getNearest($posList)
    {
        $nearest = [];
        $min = PHP_INT_MAX;
        foreach ($posList as $pos) {
            $distance = $this->distance(0, 0, 0, $pos[0], $pos[1], $pos[2]);
            if ($min > $distance) {
                $nearest = [];
                $min = $distance;
            }

            if ($min >= $distance) {
                $nearest[] = $pos;
            }
        }

        return [$min, $nearest];
    }

    private function parseInput(iterable $input)
    {
        $strongestIndex = null;
        $strongestRange = PHP_INT_MIN;
        $nanobots = [];
        foreach ($input as $line) {
            preg_match_all('/-?\d+/', $line, $matches);
            list($x, $y, $z, $r) = current($matches);

            $nanobots[] = [$x, $y, $z, $r];

            if ($r > $strongestRange) {
                $strongestIndex = count($nanobots) - 1;
                $strongestRange = $r;
            }
        }

        $this->nanobots = $nanobots;
        $this->strongest = $strongestIndex;
    }

    private function distance($x1, $y1, $z1, $x2, $y2, $z2)
    {
        return abs($x1 - $x2)
            + abs($y1 - $y2)
            + abs($z1 - $z2);
    }

    private function distanceByIdx($lhs, $rhs)
    {
        return $this->distance(
                $this->nanobots[$lhs][0],
                $this->nanobots[$lhs][1],
                $this->nanobots[$lhs][2],
                $this->nanobots[$rhs][0],
                $this->nanobots[$rhs][1],
                $this->nanobots[$rhs][2]
                );
    }

    private function distanceFrom($x, $y, $z, $map, $idx)
    {
        return $this->distance(
                $x, $y, $z,
                $map[$idx][0],
                $map[$idx][1],
                $map[$idx][2]
                );
    }

    private function makeReducedMap($rate)
    {
        foreach ($this->nanobots as $nanobot) {
            $x = intval($nanobot[0] / $rate);
            $y = intval($nanobot[1] / $rate);
            $z = intval($nanobot[2] / $rate);
            $r = ceil($nanobot[3] / $rate);
            $reducedNanobots[] = [$x, $y, $z, $r];
            $xList[] = $x;
            $yList[] = $y;
            $zList[] = $z;
            $rList[] = $r;
        }

        return [$reducedNanobots,
               min($xList), max($xList),
               min($yList), max($yList),
               min($zList), max($zList),
               ];
    }

    private function getCandidates($map, $minX, $maxX, $minY, $maxY, $minZ, $maxZ)
    {
        // echo "reduced maprange : $minX, $maxX, $minY, $maxY, $minZ, $maxZ\n";

        $candidates = [];
        $maxNanobotsInrange = 0;
        foreach (range($minZ, $maxZ) as $z) {
            foreach (range($minY, $maxY) as $y) {
                foreach (range($minX, $maxX) as $x) {
                    $inrangeNanobotsCount = 0;
                    foreach ($map as $idx => $nanobot) {
                        if ($this->distanceFrom($x, $y, $z, $map, $idx) <= $map[$idx][3]) {
                            $inrangeNanobotsCount++;
                        }
                    }
                    if ($inrangeNanobotsCount > $maxNanobotsInrange) {
                        $candidates = [];
                        $maxNanobotsInrange = $inrangeNanobotsCount;
                    }

                    if ($inrangeNanobotsCount >= $maxNanobotsInrange) {
                        $candidates[] = [$x, $y, $z];
                    }
                }
            }
        }

        return [$candidates, $maxNanobotsInrange];
    }
}
