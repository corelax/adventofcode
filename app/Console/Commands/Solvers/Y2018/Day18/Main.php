<?php

namespace App\Console\Commands\Solvers\Y2018\Day18;

use Illuminate\Console\Command;
use Storage;

class Main extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'solver:2018_18';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Day 18: Settlers of The North Pole';

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
        $input = file(storage_path('app/input/2018/day18/input.dat'), FILE_IGNORE_NEW_LINES);

        $solver = new Solver();

        echo "part1 : " . $solver->solvePart1($input) . PHP_EOL;
        echo "part2 : " . $solver->solvePart2($input) . PHP_EOL;
    }
}
