<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\Solvers\Y2018\Day01\Solver;
use ArrayObject;

class Solver2018_01Test extends TestCase
{
    public function testCalc()
    {
        $solver = new Solver();

        $this->assertEquals($solver->calc([+1, +1, +1]), 3);
        $this->assertEquals($solver->calc([+1, +1, -2]), 0);
        $this->assertEquals($solver->calc([-1, -2, -3]), -6);
    }

    public function testCalc2()
    {
        $solver = new Solver();

        $this->assertEquals($solver->calc2((new ArrayObject([+1, -1]))->getIterator()), 0);
        $this->assertEquals($solver->calc2((new ArrayObject([+3, +3, +4, -2, -4]))->getIterator()), 10);
        $this->assertEquals($solver->calc2((new ArrayObject([-6, +3, +8, +5, -6]))->getIterator()), 5);
        $this->assertEquals($solver->calc2((new ArrayObject([+7, +7, -2, -7, -4]))->getIterator()), 14);
    }
}
