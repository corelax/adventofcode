<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\Solvers\Y2018\Day11\Solver;
use ArrayObject;
use Carbon\Carbon;

class Solver2018_11Test extends TestCase
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

    public function testPrivates()
    {
        $solver = new Solver();

        $this->assertEquals(-5, $this->invoke($solver, 'calcPowerLevel', [122,  79, 57]));
        $this->assertEquals( 0, $this->invoke($solver, 'calcPowerLevel', [217, 196, 39]));
        $this->assertEquals( 4, $this->invoke($solver, 'calcPowerLevel', [101, 153, 71]));
    }

    public function testSolvePart1()
    {
        $solver = new Solver();

        $this->assertEquals(["33,45", 29], 
            $solver->solvePart1("18"));

        $this->assertEquals(["21,61", 30], 
            $solver->solvePart1("42"));
    }

    public function testSolvePart2()
    {
        $solver = new Solver();

        $this->assertEquals(["90,269,16", 113], 
            $solver->solvePart2("18"));

        $this->assertEquals(["232,251,12", 119], 
            $solver->solvePart2("42"));
    }
}
