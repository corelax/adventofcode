<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\Solvers\Y2018\Day07\Solver;
use ArrayObject;
use Carbon\Carbon;

class Solver2018_07Test extends TestCase
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
            'CABDFE',
            $solver->solvePart1([
                'Step C must be finished before step A can begin.',
                'Step C must be finished before step F can begin.',
                'Step A must be finished before step B can begin.',
                'Step A must be finished before step D can begin.',
                'Step B must be finished before step E can begin.',
                'Step D must be finished before step E can begin.',
                'Step F must be finished before step E can begin.',
            ])
        );
    }
}
