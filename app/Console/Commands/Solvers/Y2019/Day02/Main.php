<?php

namespace App\Console\Commands\Solvers\Y2019\Day02;

use Illuminate\Console\Command;
use Storage;

class Main extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'solver:2019_02';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Day 02: 1202 Program Alarm';

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
        $input = file(storage_path('app/input/2019/day02/input.dat'), FILE_IGNORE_NEW_LINES);

        $solver = new Solver();

        echo "part1 : " . $solver->solvePart1($input, false) . PHP_EOL;
        echo "part2 : " . $solver->solvePart2($input, 19690720) . PHP_EOL;
    }
}
