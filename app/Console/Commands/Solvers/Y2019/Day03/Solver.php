<?php
declare(strict_types=1);

namespace App\Console\Commands\Solvers\Y2019\Day03;

class Solver
{
    public function solvePart1(iterable $input): int
    {
        $routes = $this->parseInput($input);

        return $this->getMinDistance($routes);
    }

    public function solvePart2(iterable $input): int
    {
        $this->parseInput($input);
        return -1;
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
    private function getMinDistance(iterable $routes)
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
                    if (isset($map[$x][$y]) && $map[$x][$y] != $routeIndex) {
                        $distance = self::distance($s_x, $s_y, $x, $y);
                        $minDistance = min($distance, $minDistance);
                    }
                    $map[$x][$y] = $routeIndex;
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
