<?php

namespace App\Console\Commands\Solvers\Y2018\Day14;

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
    protected $signature = 'solver:2018_14';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Day 14: Chocolate Charts';

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
        $input = file(storage_path('app/input/2018/day14/input.dat'), FILE_IGNORE_NEW_LINES);

        $solver = new Solver();

        echo "part1 : " . $solver->solvePart1(intval($input[0])) . PHP_EOL;
        echo "part2 : " . $solver->solvePart2(intval($input[0])) . PHP_EOL;
    }
}
