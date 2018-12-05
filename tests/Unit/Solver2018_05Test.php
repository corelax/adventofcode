<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\Solvers\Y2018\Day05\Solver;
use ArrayObject;
use Carbon\Carbon;

class Solver2018_05Test extends TestCase
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

        $this->assertEquals(10, $solver->solvePart1('dabAcCaCBAcCcaDA'));
    }

    public function testSolvePart2()
    {
        $solver = new Solver();

        $this->assertEquals(4, $solver->solvePart2('dabAcCaCBAcCcaDA'));
    }
}
