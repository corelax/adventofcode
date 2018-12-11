<?php

namespace App\Console\Commands\Solvers\Y2018\Day11;

use Illuminate\Console\Command;
use Storage;
use SplFileObject;

class Main extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'solver:2018_11';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Day 11: Chronal Charge';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $input = new SplFileObject(storage_path('app/input/2018/day11/input.dat'));
        $input->setFlags(SplFileObject::DROP_NEW_LINE | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY);

        $solver = new Solver();

        list($pos, $peek) = $solver->solvePart1($input);
        echo "part1 : $pos ($peek)" . PHP_EOL;

        list($ans, $peek) = $solver->solvePart2($input);
        echo "part2 : $ans ($peek)" . PHP_EOL;
    }
}
