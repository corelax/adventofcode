<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Console\Commands\Solvers\Y2018\Day19\Solver;

class Solver2018_19Test extends TestCase
{
    /**
     * invoke method anyway.
     */
    private function invoke(Solver $obj, string $name, array $args)
    {
        $ref = new \ReflectionClass(Solver::class);
        $method = $ref->getMethod($name);

        $method->setAccessible(true);

        return $method->invokeArgs($obj, $args);
    }

    public function testSolvePart1()
    {
        $solver = new Solver();

        $this->assertEquals(
            6,
            $solver->solvePart1([
                '#ip 0',
                'seti 5 0 1',
                'seti 6 0 2',
                'addi 0 1 0',
                'addr 1 2 3',
                'setr 1 0 0',
                'seti 8 0 4',
                'seti 9 0 5',
            ]));
    }
}
