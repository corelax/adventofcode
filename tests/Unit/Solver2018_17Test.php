<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\Solvers\Y2018\Day17\Solver;
use ArrayObject;
use Carbon\Carbon;

class Solver2018_17Test extends TestCase
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

        $this->assertEquals("57", $solver->solvePart1($this->testData));
    }

    // public function testSolvePart2()
    // {
    //     $solver = new Solver();

    //     $this->assertEquals("6,4", $solver->solvePart2($this->testData2));
    // }

    // be careful. it contains backslashes
    private $testData = [
            'x=495, y=2..7',
            'y=7, x=495..501',
            'x=501, y=3..7',
            'x=498, y=2..4',
            'x=506, y=1..2',
            'x=498, y=10..13',
            'x=504, y=10..13',
            'y=13, x=498..504',
        ];
}
