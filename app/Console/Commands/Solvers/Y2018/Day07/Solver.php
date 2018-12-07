<?php

namespace App\Console\Commands\Solvers\Y2018\Day07;

class Solver
{
    private $requiredMap = [];

    public function solvePart1(iterable $input)
    {
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

    private function done($char) {
        unset($this->requiredMap[$char]);

        foreach ($this->requiredMap as $key => $requirements) {
            $this->requiredMap[$key] = array_diff($requirements, [$char]);
        }
    }
}
