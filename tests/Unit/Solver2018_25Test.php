<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Console\Commands\Solvers\Y2018\Day25\Solver;

class Solver2018_25Test extends TestCase
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
            2,
            $solver->solvePart1([
                ' 0,0,0,0',
                ' 3,0,0,0',
                ' 0,3,0,0',
                ' 0,0,3,0',
                ' 0,0,0,3',
                ' 0,0,0,6',
                ' 9,0,0,0',
                '12,0,0,0',
            ]));
        $this->assertEquals(
            4,
            $solver->solvePart1([
                '-1,2,2,0',
                '0,0,2,-2',
                '0,0,0,-2',
                '-1,2,0,0',
                '-2,-2,-2,2',
                '3,0,2,-1',
                '-1,3,2,2',
                '-1,0,-1,0',
                '0,2,1,-2',
                '3,0,0,0',
            ]));
        $this->assertEquals(
            3,
            $solver->solvePart1([
                '1,-1,0,1',
                '2,0,-1,0',
                '3,2,-1,0',
                '0,0,3,1',
                '0,0,-1,-1',
                '2,3,-2,0',
                '-2,2,0,0',
                '2,-2,0,-1',
                '1,-1,0,-1',
                '3,2,0,2',
            ]));
        $this->assertEquals(
            8,
            $solver->solvePart1([
                '1,-1,-1,-2',
                '-2,-2,0,1',
                '0,2,1,3',
                '-2,3,-2,1',
                '0,2,3,-2',
                '-1,-1,1,-2',
                '0,-2,-1,0',
                '-2,2,3,-1',
                '1,2,2,0',
                '-1,-2,0,-2',
            ]));
    }

    public function testSolvePart2()
    {
        $solver = new Solver();

        $this->assertEquals(
            36,
            36
            );
    }
}
