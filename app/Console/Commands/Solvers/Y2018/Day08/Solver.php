<?php

namespace App\Console\Commands\Solvers\Y2018\Day08;

class Solver
{
    private $requiredMap;

    private function init() {
    }

    public function solvePart1(string $input)
    {
        $this->init();

        $nodeStack = [];

        $inputArray = explode(' ', $input);
        list($tree, $consume) = $this->takeNode($inputArray, 0);

        return $this->sumMetadata($tree);
    }

    private function sumMetadata($node)
    {
        $sum = 0;
        if (is_array($node['metadata'])) {
            $sum += array_sum($node['metadata']);
        }

        foreach ($node['children'] as $child) {
            $sum += $this->sumMetadata($child);
        }

        return $sum;
    }

    private function takeNode($arr, $start)
    {
        $consume = 0;
        $node = $this->createNode();

        $node['count'] = $arr[$start + $consume++];

        $metaCount = $arr[$start + $consume++];

        for ($i = 0; $i < $node['count']; $i++) {
            list($child, $subConsume) = $this->takeNode($arr, $start + $consume);
            $node['children'][] = $child;
            $consume += $subConsume;
        }

        for ($i = 0; $i < $metaCount; $i++) {
            $node['metadata'][] = $arr[$start + $consume++];
        }

        return [$node, $consume];
    }

    private function createNode()
    {
        return [
            'count' => 0,
            'children' => [],
            'metadata' => [],
        ];
    }
}
