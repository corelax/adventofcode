<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\Solvers\Y2018\Day04\Solver;
use ArrayObject;
use Carbon\Carbon;

class Solver2018_04Test extends TestCase
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

    public function testSolverParseLine()
    {
        $solver = new Solver();

        $data = $this->invoke($solver, 'parseLine', [
            '[1518-11-01 00:00] Guard #10 begins shift',
        ]);

        $this->assertInstanceOf(Carbon::class, $data[0]);
        $this->assertEquals(Carbon::parse('1518-11-01 00:00'), $data[0]);
        $this->assertEquals('Guard', $data[1]);
        $this->assertEquals(10, $data[2]);

        $data = $this->invoke($solver, 'parseLine', [
            '[1518-11-01 00:05] falls asleep',
        ]);

        $this->assertEquals('falls', $data[1]);

        $data = $this->invoke($solver, 'parseLine', [
            '[1518-11-01 00:25] wakes up',
        ]);

        $this->assertEquals('wakes', $data[1]);
    }

    public function testSolvePart1()
    {
        $solver = new Solver();

        $this->assertEquals($solver->solvePart1($this->testData), 240);
    }

    public function testSolvePart2()
    {
        $solver = new Solver();

        $this->assertEquals($solver->solvePart2($this->testData), 4455);
    }

    private $testData = [
        '[1518-11-01 00:00] Guard #10 begins shift',
        '[1518-11-01 00:05] falls asleep',
        '[1518-11-01 00:25] wakes up',
        '[1518-11-01 00:30] falls asleep',
        '[1518-11-01 00:55] wakes up',
        '[1518-11-01 23:58] Guard #99 begins shift',
        '[1518-11-02 00:40] falls asleep',
        '[1518-11-02 00:50] wakes up',
        '[1518-11-03 00:05] Guard #10 begins shift',
        '[1518-11-03 00:24] falls asleep',
        '[1518-11-03 00:29] wakes up',
        '[1518-11-04 00:02] Guard #99 begins shift',
        '[1518-11-04 00:36] falls asleep',
        '[1518-11-04 00:46] wakes up',
        '[1518-11-05 00:03] Guard #99 begins shift',
        '[1518-11-05 00:45] falls asleep',
        '[1518-11-05 00:55] wakes up',
    ];
}
