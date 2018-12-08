<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\Solvers\Y2018\Day08\Solver;
use ArrayObject;
use Carbon\Carbon;

class Solver2018_08Test extends TestCase
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
            138,
            $solver->solvePart1('2 3 0 3 10 11 12 1 1 0 1 99 2 1 1 2')
        );
    }

    public function testSolvePart2()
    {
        $solver = new Solver();

        $this->assertEquals(
            66,
            $solver->solvePart2('2 3 0 3 10 11 12 1 1 0 1 99 2 1 1 2')
        );
    }
}
