<?php

namespace App\Console\Commands\Solvers\Y2018\Day14;

class Solver
{
    public function solvePart1(int $input)
    {
        $scoreboard = "37";
        $elf1 = 0;
        $elf2 = 1;

        for ($count = 2; $count < $input + 10; ) {
            // create recipe
            $next = $scoreboard[$elf1] + $scoreboard[$elf2];

            // append recipe
            $scoreboard .= $next;

            // count up
            // maybe count by hand is better than strlen
            if ($next >= 10) {
                $count += 2;
            } else {
                $count += 1;
            }

            // move elves
            $elf1 = ($elf1 + $scoreboard[$elf1] + 1) % $count;
            $elf2 = ($elf2 + $scoreboard[$elf2] + 1) % $count;

            // echo " $count $elf1 $elf2\n";
            // echo $scoreboard . PHP_EOL;
        }

        // show after 10 scores
        echo substr($scoreboard, $input, 10) . PHP_EOL;
    }

    public function solvePart2(int $input)
    {
        // "320851"
        $matchPattern = '' . $input;
        // $matchPattern = '92510';
        // $matchPattern = '59414';
        $len = strlen($matchPattern);
        $scoreboard = "37";
        $elf1 = 0;
        $elf2 = 1;

        $p = 0;

        $found = false;
        for ($count = 2; ! $found; ) {
            // create recipe
            $next = '' . ($scoreboard[$elf1] + $scoreboard[$elf2]);

            // matching
            // $p $matchPattern $next 6 $count

            if ($matchPattern[$p] == $next[0]) {
                // echo 'いっしょだねー[0] ' . $matchPattern[$p] . ' ' . $next[0] . PHP_EOL;
                $p++;
            } else {
                if ($matchPattern[0] == $next[0]) {
                    $p = 1;
                } else {
                    $p = 0;
                }
            }

            if ($p == $len) {
                echo "found." . PHP_EOL;
                echo $count + 1 - $len. PHP_EOL;

                return;
                $found = true;
            }

            if ($next >= 10 && $p != $len) {
                if ($matchPattern[$p] == $next[1]) {
                    // echo 'いっしょだねー[1] ' . $matchPattern[$p] . ' ' . $next[1] . PHP_EOL;
                    $p++;
                } else {
                    if ($matchPattern[0] == $next[1]) {
                        $p = 1;
                    } else {
                        $p = 0;
                    }
                }

                if ($p == $len) {
                    echo "found." . PHP_EOL;
                    echo $count + 2 - $len. PHP_EOL;

                    return;
                    $found = true;
                }
            }

            // append recipe
            $scoreboard .= $next;

            // count up
            // maybe count by hand is better than strlen
            if ($next >= 10) {
                $count += 2;
            } else {
                $count += 1;
            }

            // move elves
            $elf1 = ($elf1 + $scoreboard[$elf1] + 1) % $count;
            $elf2 = ($elf2 + $scoreboard[$elf2] + 1) % $count;

            // echo " $count $elf1 $elf2\n";
            // if ($count % 10000 == 0) {
            //     echo $count . PHP_EOL;
            // }
            // echo $scoreboard . PHP_EOL;
        }

        // show after 10 scores
        echo substr($scoreboard, $input, 10) . PHP_EOL;
    }
}
