<?php
declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use App\Console\Commands\Solvers\Y2020\Day01\Solver;

class Solver2020_01Test extends TestCase
{
    private Solver $solver;

    public function setUp(): void
    {
        parent::setUp();

        $this->solver = new Solver();
    }

    public function testSolvePart1()
    {
        $this->assertEquals(0, $this->solver->solvePart1(
                    [
                        2020,
                           0,
                    ]));
        $this->assertEquals(1020000, $this->solver->solvePart1(
                    [
                        1000,
                        1020,
                    ]));
        $this->assertEquals(514579, $this->solver->solvePart1(
                    [
                        1721,
                        979 ,
                        366 ,
                        299 ,
                        675 ,
                        1456,
                    ]));
    }

    public function testSolvePart2()
    {
        $this->assertEquals(241861950, $this->solver->solvePart2(
                    [
                        1721,
                        979 ,
                        366 ,
                        299 ,
                        675 ,
                        1456,
                    ]));
    }
}
