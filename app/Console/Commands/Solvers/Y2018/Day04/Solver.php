<?php

namespace App\Console\Commands\Solvers\Y2018\Day04;

use Iterator;
use ArrayObject;
use Carbon\Carbon;
use Log;

class Solver
{
    public function solvePart1(iterable $input)
    {
        $data = $this->regularData($input);
        $sleepMemory = $this->createSleepMemory($data);

        $mostSleptId = null;
        $mostSleptMinutes = 0;
        foreach ($sleepMemory as $guard => $memory) {
            Log::info("ID $guard : " . array_sum($memory) . " minutes");
            $sleptMinutes = array_sum($memory);
            if ($sleptMinutes > $mostSleptMinutes) {
                $mostSleptMinutes = $sleptMinutes;
                $mostSleptId = $guard;
            }
        }

        $theMinute = null;
        $maxTimes = 0;
        foreach ($sleepMemory[$mostSleptId] as $minute => $times) {
            if ($times > $maxTimes) {
                $maxTimes = $times;
                $theMinute = $minute;
            }
        }

        return $mostSleptId * $theMinute;
    }

    private function createSleepMemory(iterable $data) {
        $sleepMemory = [];

        $guard = null;
        $sleepStart = null;
        foreach ($data as $line) {
            list($time, $action, $id) = $line;

            if (is_null($guard) && $action != 'Guard') {
                // I don't know who the the guard is
                continue;
            }

            // adjust to [00:00..01:00)
            if ($time->hour != 0) {
                $minute = 0;
            } else {
                $minute = $time->minute;
            }

            Log::debug("$time : $action : $id  -> $minute");

            switch ($action) {
                case 'Guard':
                    $guard = $id;
                    if (! isset($sleepMemory[$guard])) {
                        $sleepMemory[$guard] = array_fill(0, 60, 0);
                    }
                    break;
                case 'falls':
                    if (is_null($sleepStart)) {
                        $sleepStart = $minute;
                    } else {
                        // already sleep
                    }
                    break;
                case 'wakes':
                    if (! is_null($sleepStart)) {
                        // not include wakes up time
                        for ($i = $sleepStart; $i < $minute; $i++) {
                            $sleepMemory[$guard][$i]++;
                        }

                        $sleepStart = null;
                    } else {
                        // already wake up
                    }
                    break;
            }
        }

        return $sleepMemory;
    }

    private function regularData(iterable $input)
    {
        if ($input instanceof Iterator) {
            $sorted = [];
            foreach ($input as $line) {
                $sorted[] = $line;
            }
            sort($sorted);
        } elseif (is_array($input)) {
            $sorted = $input;
            sort($sorted);
        }

        $ret = [];
        foreach ($sorted as $line) {
            $ret[] = $this->parseLine($line);
        }

        return $ret;
    }

    private function parseLine(string $line)
    {
        $arr = explode(' ', $line);
        $time = Carbon::parse(substr($arr[0], 1) . " " . substr($arr[1], 0, -1));
        $action = $arr[2];
        if ($action == 'Guard') {
            $id = intval(substr($arr[3], 1));
        } else {
            $id = null;
        }

        return [$time, $action, $id];
    }
}
