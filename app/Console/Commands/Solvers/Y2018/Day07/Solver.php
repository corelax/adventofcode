<?php

namespace App\Console\Commands\Solvers\Y2018\Day07;

class Solver
{
    private $requiredMap;
    // process[worker][step, timeleft]
    private $process;

    private function init() {
        $this->requiredMap = [];
        $this->process = [];
    }

    public function solvePart1(iterable $input)
    {
        $this->init();

        $ret = [];
        foreach ($input as $line) {
            $arr = $this->parseLine($line);
            $this->addRequirement($arr[0], $arr[1]);
        }

        // var_dump($this->requiredMap);
        while (! empty($this->requiredMap)) {
            $next = min($this->getAvailables());
            $ret[] = $next;
            $this->done($next);
        }
        return implode('', $ret);
    }

    public function solvePart2(iterable $input, int $workerCount, int $initialCost)
    {
        $this->init();

        $ret = [];
        $time = 0;

        foreach ($input as $line) {
            $arr = $this->parseLine($line);
            $this->addRequirement($arr[0], $arr[1]);
        }

        foreach (range(1, $workerCount) as $worker) {
            $this->process[$worker] = null;
        }

        while (! empty($this->requiredMap)) {
            $worker = $this->getIdleWorker();
            // var_dump($worker);
            if (is_null($worker) || empty($this->getAvailablesAndNotProcessing())) {
                $time++;
                foreach ($this->tick() as $done) {
                    $ret[] = $done;
                }
            } else {
                $tmp = $this->getAvailablesAndNotProcessing();
                sort($tmp);
                // print_r($tmp);

                foreach ($tmp as $char) {
                    $cost = ord($char) - ord('A') + 1 + $initialCost;
                    $this->process[$worker] = [$char, $cost];

                    $worker = $this->getIdleWorker();
                    if (is_null($worker)) {
                        break;
                    }
                }
            }
        }

        return [$time, implode('', $ret)];
    }

    private function parseLine(string $line)
    {
        $arr = explode(' ', $line);
        return [$arr[1], $arr[7]];
    }

    private function addRequirement($require, $char)
    {
        if (! isset($this->requiredMap[$require])) {
            $this->requiredMap[$require] = [];
        }
        if (! isset($this->requiredMap[$char])) {
            $this->requiredMap[$char] = [];
        }

        $this->requiredMap[$char][] = $require;
    }

    private function getAvailables()
    {
        $ret = [];
        foreach ($this->requiredMap as $k => $v) {
            // echo $k . " : " . implode(', ', $v) . PHP_EOL;
            if (empty($v)) {
                $ret[] = $k;
            }
        }

        return $ret;
    }

    private function getAvailablesAndNotProcessing()
    {
        $ret = [];
        foreach ($this->requiredMap as $k => $v) {
            // echo $k . " : " . implode(', ', $v) . PHP_EOL;
            if (empty($v)) {
                if (! $this->isProcessing($k)) {
                    $ret[] = $k;
                }
            }
        }

        return $ret;
    }

    private function done($char) {
        unset($this->requiredMap[$char]);

        foreach ($this->requiredMap as $key => $requirements) {
            $this->requiredMap[$key] = array_diff($requirements, [$char]);
        }
    }

    private function getIdleWorker()
    {
        // print_r($this->process);
        foreach ($this->process as $worker => $map) {
            if (is_null($map)) {
                return $worker;
            }
        }

        return null;
    }

    private function tick()
    {
        $done = [];
        foreach ($this->process as $worker => &$map) {
            if (is_array($map)) {
                // echo $map[0];
                if (--$map[1] == 0) {
                    $done[] = $map[0];
                    $this->done($map[0]);
                    $this->process[$worker] = null;
                }
            } else {
                // echo '.';
            }
        }
        // echo PHP_EOL;

        return $done;
    }

    private function isProcessing($char)
    {
        foreach ($this->process as $worker => $map) {
            if (is_array($map)) {
                if ($map[0] === $char) {
                    return true;
                }
            }
        }

        return false;
    }
}
