<?php

namespace App\Console\Commands\Solvers\Y2018\Day13;

use SplFixedArray;

class Solver
{
    // be careful. it contains backslashes
    public function solvePart1(iterable $input)
    {
        $circuit = self::createModel($input);

        while (true) {
            $carts = $circuit->getCrushedCarts();
            if (count($carts) != 0) {
                $cart = $carts[0];
                return "{$cart['x']},{$cart['y']}";
            }
            $circuit->tick();
        }
    }

    public function solvePart2(iterable $input)
    {
        $circuit = self::createModel($input);

        while (true) {
            $carts = $circuit->getCarts();
            if (count($carts) == 1) {
                foreach ($carts as $cart) {
                    return "{$cart['x']},{$cart['y']}";
                }
            }
            $circuit->tick();
        }

        return "{$lastCart['x']},{$lastCart['y']}";
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
            private $crushedCarts = [];

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
                                $cart  = [
                                    'x' => $x,
                                    'y' => $y,
                                    'direction' => $line[$x],
                                    'handle' => 0,  // left turn on the first intersection
                                                    // left straight right left straight...
                                    'running' => true,
                                ];
                                $this->carts[$this->makeSortableCartKey($cart)] = $cart;
                                // cart isn't on any corners by definition
                                // > On your initial map, the track under each cart is 
                                // > a straight path matching the direction the cart is facing.
                                break;
                        }
                    }
                }
            }

            public function getCarts()
            {
                return $this->carts;
            }

            public function getCrushedCarts()
            {
                return $this->crushedCarts;
            }

            private $ticks = 0;
            public function tick()
            {
                $this->ticks++;
                ksort($this->carts);
                // $this->printWithWait(0.2);

                // foreach ($carts as $key => $cart) and modify $carts[$key] doesn't work;
                // use only keys for loop.
                $keys = array_keys($this->carts);
                foreach ($keys as $key) {
                    $cart = $this->carts[$key];
                    // go forward and turn if there's a corner or intersection

                    $checkFuture = $checkCurrent = false;
                    if (in_array($cart['direction'], ['<', '^'])) {
                        $checkFuture = true;
                    } else {
                        $checkCurrent = true;
                    }

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

                    $newKey = $this->makeSortableCartKey($cart);
                    if ($checkCurrent) {
                        if (isset($this->carts[$newKey]) && $this->carts[$newKey]['running']) {
                            // crush
                            // echo "crush (current) $key -> $newKey\n";
                            $cart['running'] = false;
                            $this->carts[$newKey]['running'] = false;
                            $this->carts[$key]['running'] = false;
                            $this->crushedCarts[] = $cart;
                        }
                    }
                    if ($checkFuture) {
                        if (isset($newCarts[$newKey])) {
                            // crushed
                            // echo "crush (future)\n";
                            $cart['running'] = false;
                            $this->carts[$key]['running'] = false;
                            $this->crushedCarts[] = $cart;
                            $this->crushedCarts[] = $newCarts[$newKey];
                            unset($newCarts[$newKey]);
                        }
                    }

                    if ($cart['running']) {
                        $newCarts[$this->makeSortableCartKey($cart)] = $cart;
                    }
                }
                $this->carts = $newCarts;
            }

            private function makeSortableCartKey($cart)
            {
                return sprintf("%04d:%04d", $cart['y'], $cart['x']);
            }

            public function printWithWait($wait = 0)
            {
                system('clear');
                echo "print start" . PHP_EOL;

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
                    if ($cart['running']) {
                        $board[$cart['y']][$cart['x']] = $cart['direction'];
                    }
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
