<?php

namespace App\Console\Commands\Solvers\Y2018\Day17;

use SplFixedArray;

class Solver
{
    public function solvePart1(iterable $input)
    {
        $this->createMap($input);

        $this->fillWater();

        // $this->printMap();
        return $this->countWater();
    }

    public function solvePart2(iterable $input)
    {
        $this->createMap($input);

        $this->fillWater();

        // $this->printMap();
        return $this->countRetainWater();
    }

    private function fillWater()
    {
        $tick = 0;
        while (count($this->spring) !== 0) {
            $curr = array_shift($this->spring);
            // echo "新しい蛇口 (y, x) = (" . $curr[1] . ', ' . $curr[0] . ")\n";
            // $this->printMap();

            $y = $curr[0];
            $break = false;
            while(true) {
                // reach the bottom or another surface, no need to process more
                if ($y == count($this->map) - 1 || $this->map[$y+1][$curr[1]] == '|') {
                    $this->map[$y][$curr[1]] = '|';
                    break;
                }

                if (! in_array($this->map[$y+1][$curr[1]], ['#', '~'])) {
                    $this->map[$y][$curr[1]] = '|';
                    $y++;
                    continue;
                }

                // seek to right
                list($lEdge, $l) = $this->seekEdge($curr[1], $y, -1);
                list($rEdge, $r) = $this->seekEdge($curr[1], $y, 1);
                // echo "left is $lEdge at $l, right is $rEdge at $r\n";

                // both are wall, fill with '~' and add just above point to spring stack
                if ($lEdge == '#' && $rEdge == '#') {
                    // echo "around walls from $l to $r\n";
                    foreach (range($l + 1, $r - 1) as $x) {
                        $this->map[$y][$x] = '~';
                    }
                    $this->spring[] = [$y-1, $curr[1]];
                    break;
                }
                // echo "left is " . $this->map[$y][$l] . "right is " . $this->map[$y][$r] . PHP_EOL;

                // fill middle area with surface
                // echo "fill $l and $r with '|'\n";
                foreach (range($l + 1, $r - 1) as $x) {
                    $this->map[$y][$x] = '|';
                }

                // found edge to spring stack
                if ($lEdge == '|') {
                    $this->spring[] = [$y, $l];
                }
                if ($rEdge == '|') {
                    $this->spring[] = [$y, $r];
                }
                break;
            }

            // $this->printMap();

            // if ($tick++ > 10) {
            //     break;
            // }
        }
    }

    // $dx is 1(right) or -1(left)
    // return
    //   '#' is a wall, '|' is a new spring(may duplicate in spring stack but it's okay)
    //   and its x
    private function seekEdge($x, $y, $dx)
    {
        // echo "seek edge\n";
        $tmpX = $x;
        while (true) {
            $tmpX += $dx;
            if (in_array($this->map[$y][$tmpX], ['#'])) {
                // 壁
                break;
            }

            if (in_array($this->map[$y+1][$tmpX], ['~', '#'])) {
                // 横にまだ流せる
                continue;
            }

            // TODO | の上に落ちたら止めるようにしたらもうちょっと無駄がなくなるかもしれない
            // stackに積む、取り出す、下が | なので終わり ってなるだけなのでそんなに無駄でもない
            if ($this->map[$y+1][$tmpX] == '.') {
                // echo "found hole\n";
                return ['|', $tmpX];
            }
        }
        return [$this->map[$y][$tmpX], $tmpX];
    }

    private $map;

    private function createMap(iterable $input)
    {
        // get field size and set all wall coords to $tmp
        $tmp = [];

        $xList = [];
        $yList = [];
        foreach ($input as $line) {
            // echo $line . PHP_EOL;
            preg_match_all('/\d+/', $line, $matches);
            $matches = $matches[0];
            if ($line[0] == 'x') {
                $xList[] = $matches[0];
                $yList[] = $matches[1];
                $yList[] = $matches[2];
                foreach (range($matches[1], $matches[2]) as $y) {
                    $tmp[] = [$y, $matches[0]];
                }
            } else {
                $yList[] = $matches[0];
                $xList[] = $matches[1];
                $xList[] = $matches[2];
                foreach (range($matches[1], $matches[2]) as $x) {
                    $tmp[] = [$matches[0], $x];
                }
            }
        }

        // minY is always 0. it's not depends on the input.
        // but use for count water. keep it.
        // echo "from (" . min($xList) . ' - 1, ' . min($yList) . " -> 0) to (" . max($xList) . ' + 1, ' . max($yList) . ")\n";

        $this->map = array_fill(0, max($yList), []);
        foreach (range(0, max($yList)) as $y) {
            // +2 for left and right edge
            $this->map[$y] = array_fill(0, max($xList) - min($xList) + 1 + 2, '.');
        }

        $xOffset = min($xList) - 1;
        $width = max($xList) - min($xList) + 2;
        $height = max($yList);
        $this->maxX = $width;
        $this->minY = min($yList);

        foreach ($tmp as $wall) {
            $this->map[$wall[0]][$wall[1] - $xOffset] = '#';
        }

        // initial spring
        $this->spring[0] = [0, 500 - $xOffset];
    }

    private $minX = 0;
    private $maxX = 0;
    private $minY = 0;
    private $spring = [];

    private function printMap()
    {
        echo PHP_EOL;
        echo $this->maxX . PHP_EOL;
        foreach ($this->map as $arr) {
            foreach ($arr as $d) {
                echo $d;
            }
            echo PHP_EOL;
        }
    }

    private function countWater()
    {
        $cnt = 0;
        // foreach ($this->map as $arr) {
        for ($y = $this->minY; $y < count($this->map); $y++) {
            foreach ($this->map[$y] as $d) {
                if (in_array($d, ['|', '~', '+'])) {
                    $cnt++;
                }
            }
        }

        return $cnt;
    }

    private function countRetainWater()
    {
        $cnt = 0;
        // foreach ($this->map as $arr) {
        for ($y = $this->minY; $y < count($this->map); $y++) {
            foreach ($this->map[$y] as $d) {
                if (in_array($d, ['~'])) {
                    $cnt++;
                }
            }
        }

        return $cnt;
    }
}
