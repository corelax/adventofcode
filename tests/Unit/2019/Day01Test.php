<?php
declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use App\Console\Commands\Solvers\Y2019\Day01\Solver;

class Solver2019_01Test extends TestCase
{
    private Solver $solver;

    public function setUp(): void
    {
        parent::setUp();

        $this->solver = new Solver();
    }

    public function testSolvePart1()
    {
        $this->assertEquals(    2, $this->solver->solvePart1([    12]));
        $this->assertEquals(    2, $this->solver->solvePart1([    14]));
        $this->assertEquals(  654, $this->solver->solvePart1([  1969]));
        $this->assertEquals(33583, $this->solver->solvePart1([100756]));

        $this->assertEquals(    4, $this->solver->solvePart1(
                    [
                        12,
                        14,
                    ]));
    }

    public function testSolvePart2()
    {
    }
}
