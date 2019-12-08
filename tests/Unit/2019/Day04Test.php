<?php
declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use App\Console\Commands\Solvers\Y2019\Day04\Solver;

class Solver2019_04Test extends TestCase
{
    private Solver $solver;

    public function setUp(): void
    {
        parent::setUp();

        $this->solver = new Solver();
    }

    public function testSolvePart1()
    {
        $this->assertTrue($this->invoke($this->solver, 'neverDecreases', [123]));
        $this->assertFalse($this->invoke($this->solver, 'neverDecreases', [132]));

        $this->assertTrue($this->invoke($this->solver, 'hasDouble', [11]));
        $this->assertFalse($this->invoke($this->solver, 'hasDouble', [12]));
        $this->assertTrue($this->invoke($this->solver, 'hasDouble', [211]));

        $this->assertTrue($this->invoke($this->solver, 'isValid', [111111]));
        $this->assertFalse($this->invoke($this->solver, 'isValid', [223450]));
        $this->assertFalse($this->invoke($this->solver, 'isValid', [123789]));
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
