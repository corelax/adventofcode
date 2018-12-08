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

    public function solvePart2(string $input)
    {
        $this->init();

        $nodeStack = [];

        $inputArray = explode(' ', $input);
        list($tree, $consume) = $this->takeNode($inputArray, 0);

        return $this->getNodeValue($tree);
    }

    private function sumMetadata($node)
    {
        $sum = array_sum($node['metadata']);

        foreach ($node['children'] as $child) {
            $sum += $this->sumMetadata($child);
        }

        return $sum;
    }

    private function getNodeValue($node)
    {
        $value = 0;
        if (empty($node['children'])) {
            return $this->sumMetadata($node);
        }

        foreach ($node['metadata'] as $meta) {
            if (isset($node['children'][$meta - 1])) {
                $value += $this->getNodeValue($node['children'][$meta - 1]);
            }
        }

        return $value;
    }

    private function takeNode($arr, $start)
    {
        $consume = 0;
        $node = $this->createNode();

        $count     = $arr[$start + $consume++];
        $metaCount = $arr[$start + $consume++];

        for ($i = 0; $i < $count; $i++) {
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
            'children' => [],
            'metadata' => [],
        ];
    }
}
