<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\Solvers\Y2017\Day02\Solver;

class Solver2017_02Test extends TestCase
{
    private $solver;

    public function setUp(): void
    {
        parent::setUp();

        $this->solver = new Solver();
    }

    public function testSolvePart1()
    {
		// change test data to tsv
        $this->assertEquals($this->solver->solvePart1([
			'5	1	9	5',
			'7	5	3',
			'2	4	6	8',
        ]), 18);
    }

    public function testSolvePart2()
    {
		// change test data to tsv
        $this->assertEquals($this->solver->solvePart2([
			'5	9	2	8',
			'9	4	7	3',
			'3	8	6	5',
        ]), 9);

		// contains same numbers
        $this->assertEquals($this->solver->solvePart2([
			'3	2	3',
        ]), 1);
    }
}
