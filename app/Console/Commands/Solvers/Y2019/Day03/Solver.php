<?php
declare(strict_types=1);

namespace App\Console\Commands\Solvers\Y2019\Day03;

class Solver
{
    public function solvePart1(iterable $input): int
    {
        $routes = $this->parseInput($input);

        return $this->getMinDistance($routes, 1);
    }

    public function solvePart2(iterable $input): int
    {
        // NOTE: you may also need to increase stacksize (like, ulimit -s)
        ini_set('memory_limit', '1024M');
        $routes = $this->parseInput($input);

        return $this->getMinDistance($routes, 2);
    }

    private function parseInput(iterable $input): array
    {
        $routes = [];
        foreach ($input as $line) {
            $route = [];
            foreach (explode(',', $line) as $command) {
                $route[] = ['d' => $command[0], 'l' => substr($command, 1)];
            }
            $routes[] = $route;
        }

        return $routes;
    }

    // only work with just 2 wires
    private function getMinDistance(iterable $routes, $type)
    {
        $map = [];
        $minDistance = PHP_INT_MAX;

        // start
        $s_x = 0;
        $s_y = 0;

        $routeIndex = 0;
        foreach ($routes as $route) {
            // current
            $x = $s_x;
            $y = $s_y;

            $step = 0;
            $routeIndex++;
            foreach ($route as $command) {
                switch($command['d']) {
                    case 'R': $dx =  1; $dy =  0; break;
                    case 'L': $dx = -1; $dy =  0; break;
                    case 'U': $dx =  0; $dy =  1; break;
                    case 'D': $dx =  0; $dy = -1; break;
                }
                for ($i = 0; $i < $command['l']; $i++) {
                    $x += $dx;
                    $y += $dy;
                    $step++;
                    if ($type == 1) {
                        if (isset($map[$x][$y]) && $map[$x][$y] != $routeIndex) {
                            $distance = self::distance($s_x, $s_y, $x, $y);
                            $minDistance = min($distance, $minDistance);
                        }
                        $map[$x][$y] = $routeIndex;
                    } else {
                        // record min step to map
                        if (!isset($map[$x][$y][$routeIndex])) {
                            $map[$x][$y][$routeIndex] = $step;
                        }
                            
                        // MEMO: 1 = first wire
                        if (isset($map[$x][$y][1]) && $routeIndex == 2) {
                            if ($map[$x][$y][1] + $step < $minDistance) {
                                $minDistance = $map[$x][$y][1] + $step;
                            }
                        }
                    }
                }
            }
        }

        return $minDistance;
    }

    private static function distance(int $x1, int $y1, int $x2, int $y2): int
    {
        return abs($x2 - $x1) + abs($y2 - $y1);
    }
}
