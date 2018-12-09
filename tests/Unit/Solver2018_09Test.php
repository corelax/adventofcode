<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\Solvers\Y2018\Day09\Solver;
use ArrayObject;
use Carbon\Carbon;

class Solver2018_09Test extends TestCase
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

        foreach ([
                '9 players; last marble is worth 25 points: high score is 32',
                '10 players; last marble is worth 1618 points: high score is 8317',
                '13 players; last marble is worth 7999 points: high score is 146373',
                '17 players; last marble is worth 1104 points: high score is 2764',
                '21 players; last marble is worth 6111 points: high score is 54718',
                '30 players; last marble is worth 5807 points: high score is 37305',
            ] as $line) {
            $a = explode(' ', $line);
            $this->assertEquals($a[11], $solver->solvePart1($line));
        }
    }
}
