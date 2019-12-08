<?php
declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use App\Console\Commands\Solvers\Y2019\Day02\Solver;

class Solver2019_02Test extends TestCase
{
    private Solver $solver;

    public function setUp(): void
    {
        parent::setUp();

        $this->solver = new Solver();
    }

    public function testSolvePart1()
    {
        $this->assertEquals('2,0,0,0,99',
                $this->s1dump(['1,0,0,0,99']));

        $this->assertEquals('2,3,0,6,99',
                $this->s1dump(['2,3,0,3,99']));

        $this->assertEquals('2,4,4,5,99,9801',
                $this->s1dump(['2,4,4,5,99,0']));

        $this->assertEquals('30,1,1,4,2,5,6,0,99',
                $this->s1dump(['1,1,1,4,99,5,6,0,99']));
    }

    private function s1dump($input)
    {
        $this->solver->solvePart1($input);
        return $this->invoke($this->solver, 'dump', []);
    }

    // public function testSolvePart2()
    // {
    // }

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
}
