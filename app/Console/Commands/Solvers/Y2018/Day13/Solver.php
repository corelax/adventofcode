<?php

namespace App\Console\Commands\Solvers\Y2018\Day13;

use SplFixedArray;

class Solver
{
    // be careful. it contains backslashes
    public function solvePart1(iterable $input)
    {
        $circuit = self::createModel($input);

        while (($ret = $circuit->isSafe()) === true) {
            $circuit->tick();
        }

        return $ret;
    }

    private static function createModel(iterable $seed)
    {
        return new class ($seed) {
            private $debugTickCount = 40;

            private $wholeSize = ['x' => 0, 'y' => 0];

            // contains all corners and intersections.
            private $map;

            // $cart
            private $carts;

            private $handleStat = "<^>";
            private $velocities = [
                '^' => ['y' => -1, 'x' =>  0],
                'v' => ['y' =>  1, 'x' =>  0],
                '<' => ['y' =>  0, 'x' => -1],
                '>' => ['y' =>  0, 'x' =>  1],
            ];

            private $cornering = [
                '\\' => [
                    '^' => '<',
                    '>' => 'v',
                    'v' => '>',
                    '<' => '^',
                    ],
                '/' => [
                    '^' => '>',
                    '>' => '^',
                    'v' => '<',
                    '<' => 'v',
                    ],
                ];
            private $handling = [
                '^' => ['<', '^', '>'],
                '<' => ['v', '<', '^'],
                'v' => ['>', 'v', '<'],
                '>' => ['^', '>', 'v'],
            ];

            public function __construct(iterable $seed)
            {
                $this->wholeSize['y'] = count($seed);
                $this->wholeSize['x'] = strlen($seed[0]);

                for ($y = 0; $y < count($seed); $y++) {
                    $line = $seed[$y];
                    for ($x = 0; $x < strlen($line); $x++) {
                        switch ($line[$x]) {
                            case '\\':
                            case '/':
                                // corner
                            case '+':
                                // intersection
                                $this->map["$x,$y"] = $line[$x];
                                break;
                            case '^':
                            case 'v':
                            case '<':
                            case '>':
                                $this->carts[] = [
                                    'x' => $x,
                                    'y' => $y,
                                    'direction' => $line[$x],
                                    'handle' => 0,  // left turn on the first intersection
                                                    // left straight right left straight...
                                ];
                                // cart isn't on any corners by definition
                                // > On your initial map, the track under each cart is 
                                // > a straight path matching the direction the cart is facing.
                                break;
                        }
                    }
                }
            }

            public function isSafe()
            {
                $m = [];
                foreach ($this->carts as $cart) {
                    $pos = "{$cart['x']},{$cart['y']}";
                    if (isset($m[$pos])) {
                        return $pos;
                    }
                    $m[$pos] = true;
                }

                return true;
            }

            public function tick()
            {
                // $this->printWithWait(0.2);
                foreach ($this->carts as &$cart) {
                    // go forward and turn if there's a corner or intersection

                    $cart['x'] += $this->velocities[$cart['direction']]['x'];
                    $cart['y'] += $this->velocities[$cart['direction']]['y'];

                    if (isset($this->map["{$cart['x']},{$cart['y']}"])) {
                        $item = $this->map["{$cart['x']},{$cart['y']}"];
                        switch ($item) {
                            case '\\';
                            case '/';
                                $cart['direction'] = $this->cornering[$item][$cart['direction']];
                                break;
                            case '+';
                                $cart['direction'] = $this->handling[$cart['direction']][$cart['handle']];
                                $cart['handle'] = ($cart['handle'] + 1) % 3;
                                break;
                        }
                    }
                }
            }

            public function printWithWait($wait = 0)
            {
                system('clear');
                echo "print start" . PHP_EOL;

                // $this->wholeSize = ['x' => 0, 'y' => 0];
                $board = [];
                for ($y = 0; $y < $this->wholeSize['y']; $y++) {
                    for ($x = 0; $x < $this->wholeSize['x']; $x++) {
                        if (isset($this->map["$x,$y"])) {
                            $board[$y][$x] = $this->map["$x,$y"];
                        } else {
                            $board[$y][$x] = ' ';
                        }
                    }
                }

                foreach ($this->carts as $cart) {
                    $board[$cart['y']][$cart['x']] = $cart['direction'];
                }

                for ($y = 0; $y < $this->wholeSize['y']; $y++) {
                    for ($x = 0; $x < $this->wholeSize['x']; $x++) {
                        echo $board[$y][$x];
                    }
                    echo PHP_EOL;
                }

                ob_flush();
                usleep($wait * 1000000);
            }
        };
    }
}
