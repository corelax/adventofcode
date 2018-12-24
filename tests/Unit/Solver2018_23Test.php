<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Console\Commands\Solvers\Y2018\Day23\Solver;

class Solver2018_23Test extends TestCase
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
            7,
            $solver->solvePart1([
                'pos=<0,0,0>, r=4',
                'pos=<1,0,0>, r=1',
                'pos=<4,0,0>, r=3',
                'pos=<0,2,0>, r=1',
                'pos=<0,5,0>, r=3',
                'pos=<0,0,3>, r=1',
                'pos=<1,1,1>, r=1',
                'pos=<1,1,2>, r=1',
                'pos=<1,3,1>, r=1',
            ]));
    }
}
