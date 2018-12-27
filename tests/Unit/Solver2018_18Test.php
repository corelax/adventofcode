<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Console\Commands\Solvers\Y2018\Day18\Solver;

class Solver2018_18Test extends TestCase
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
            1147,
            $solver->solvePart1([
                '.#.#...|#.',
                '.....#|##|',
                '.|..|...#.',
                '..|#.....#',
                '#.#|||#|#|',
                '...#.||...',
                '.|....|...',
                '||...#|.#|',
                '|.||||..|.',
                '...#.|..|.',
            ]));
    }
}
