<?php

namespace App\Console\Commands\Solvers\Y2018\Day02;

use Illuminate\Console\Command;
use Storage;
use SplFileObject;

class Day02 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'solver:2018_02';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $input = new SplFileObject(storage_path('app/input/2018/day02/input.dat'));
        $input->setFlags(SplFileObject::DROP_NEW_LINE | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY);

        $solver = new Solver();
        echo "part1 : " . $solver->calc($input) . PHP_EOL;
        echo "part2 : " . $solver->calc2($input) . PHP_EOL;
    }
}
