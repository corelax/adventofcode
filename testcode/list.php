<?php

$obj = new MyClass();
$obj->main();

class Node {
    public $value;
    public $next;
    public $prev;
    public function __construct($value)
    {
        $this->value = $value;
        $this->next = null;
        $this->prev = null;
    }
}

class MyClass
{
    public function main()
    {
        $root = new Node(0);
        $root->next = $root;
        $root->prev = $root;
        $p = $root;
        foreach (range(1, 1 * 1000 * 1000) as $i) {
            $p = $this->insert($p, $i);
            // $this->showList($root);
        }
    }

    // returns inserted
    public function insert($node, $value)
    {
        $newNode = new Node($value);
        $newNode->next = $node;
        $newNode->prev = $node->prev;

        $node->prev->next = $newNode;
        $node->prev = $newNode;

        return $newNode;
    }

    private function showList($root)
    {
        $p = $root;
        do {
            echo $p->value . ' ';
            $p = $p->next;
        } while ($root != $p);
        echo PHP_EOL;

        $p = $root;
        do {
            echo $p->value . ' ';
            $p = $p->prev;
        } while ($root != $p);
        echo PHP_EOL;
    }
}
