<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\Solvers\Y2018\Day13\Solver;
use ArrayObject;
use Carbon\Carbon;

class Solver2018_13Test extends TestCase
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

        $this->assertEquals(
            325, 325
        );
    }

    public function testSolvePart1()
    {
        $solver = new Solver();

        $this->assertEquals("7,3", $solver->solvePart1($this->testData));
    }

    // be careful. it contains backslashes
    private $testData = [
            '/->-\        ',
            '|   |  /----\\',
            '| /-+--+-\  |',
            '| | |  | v  |',
            '\-+-/  \-+--/',
            '  \------/   ',
        ];
}
