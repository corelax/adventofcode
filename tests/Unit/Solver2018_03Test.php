<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\Solvers\Y2018\Day03\Solver;
use ArrayObject;

class Solver2018_03Test extends TestCase
{
    public function testSolvePart1()
    {
        $solver = new Solver();

        $this->assertEquals($solver->solvePart1([
            '#1 @ 1,3: 4x4',
            '#2 @ 3,1: 4x4',
            '#3 @ 5,5: 2x2',
        ]), 4);
    }

    public function testSolvePart2()
    {
        $solver = new Solver();

        $this->assertEquals($solver->solvePart2([
            '#1 @ 1,3: 4x4',
            '#2 @ 3,1: 4x4',
            '#3 @ 5,5: 2x2',
        ]), 3);
    }
}
