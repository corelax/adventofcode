<?php
declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use App\Console\Commands\Solvers\Y2019\Day03\Solver;

class Solver2019_03Test extends TestCase
{
    private Solver $solver;

    public function setUp(): void
    {
        parent::setUp();

        $this->solver = new Solver();
    }

    public function testSolvePart1()
    {
        $this->assertEquals(6, $this->solver->solvePart1([
            'R8,U5,L5,D3',
            'U7,R6,D4,L4',
        ]));
        $this->assertEquals(159, $this->solver->solvePart1([
            'R75,D30,R83,U83,L12,D49,R71,U7,L72',
            'U62,R66,U55,R34,D71,R55,D58,R83',
        ]));
        $this->assertEquals(135, $this->solver->solvePart1([
            'R98,U47,R26,D63,R33,U87,L62,D20,R33,U53,R51',
            'U98,R91,D20,R16,D67,R40,U7,R15,U6,R7',
        ]));
    }

    public function testSolvePart2()
    {
        $this->assertEquals(30, $this->solver->solvePart2([
            'R8,U5,L5,D3',
            'U7,R6,D4,L4',
        ]));
        $this->assertEquals(610, $this->solver->solvePart2([
            'R75,D30,R83,U83,L12,D49,R71,U7,L72',
            'U62,R66,U55,R34,D71,R55,D58,R83',
        ]));
        $this->assertEquals(410, $this->solver->solvePart2([
            'R98,U47,R26,D63,R33,U87,L62,D20,R33,U53,R51',
            'U98,R91,D20,R16,D67,R40,U7,R15,U6,R7',
        ]));
    }
}
