<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\Solvers\Y2017\Day01\Solver;
use ArrayObject;

class Solver2017_01Test extends TestCase
{
    private $solver;

    public function setUp()
    {
        parent::setUp();

        $this->solver = new Solver();
    }

    public function testSolvePart1()
    {
        $this->assertEquals($this->solver->solvePart1('1122'    ), 3);
        $this->assertEquals($this->solver->solvePart1('1111'    ), 4);
        $this->assertEquals($this->solver->solvePart1('1234'    ), 0);
        $this->assertEquals($this->solver->solvePart1('91212129'), 9);
    }
}
