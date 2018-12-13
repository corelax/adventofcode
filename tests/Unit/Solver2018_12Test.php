<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\Solvers\Y2018\Day12\Solver;
use ArrayObject;
use Carbon\Carbon;

class Solver2018_12Test extends TestCase
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
            325,
            $this->invoke($solver, 'sumPlants', [
                ".#....##....#####...#######....#.#..##.",
                -3,
            ])
        );
    }

    public function testSolvePart1()
    {
        $solver = new Solver();

        $this->assertEquals(325, $solver->solvePart1($this->testData));
    }

    private $testData = [
            "initial state: #..#.#..##......###...###",
            "",
            "...## => #",
            "..#.. => #",
            ".#... => #",
            ".#.#. => #",
            ".#.## => #",
            ".##.. => #",
            ".#### => #",
            "#.#.# => #",
            "#.### => #",
            "##.#. => #",
            "##.## => #",
            "###.. => #",
            "###.# => #",
            "####. => #",
        ];
}
