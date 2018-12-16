<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Console\Commands\Solvers\Y2018\Day16\Solver;

class Solver2018_16Test extends TestCase
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

        $ops = $this->invoke($solver, "getPossibleOps", [
                [3,2,1,1],  // before
                [3,2,2,1],  // after
                2, 1, 2,
            ]);

        $this->assertCount(3, $ops);
        $this->assertContains('mulr', $ops);
        $this->assertContains('addi', $ops);
        $this->assertContains('seti', $ops);
    }

    // public function testSolvePart2()
    // {
    //     $solver = new Solver();

    //     $this->assertEquals("6,4", $solver->solvePart2($this->testData2));
    // }
}
