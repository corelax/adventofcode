<?php

namespace App\Console\Commands\Solvers\Y2018;

use Illuminate\Console\Command;
use Storage;
use SplFileObject;

class Solver2018_01 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'solver:2018_01';

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
        $input = new SplFileObject(storage_path('app/input/2018/day01/input'));
        $input->setFlags(SplFileObject::DROP_NEW_LINE);
        echo $this->calc($input) . PHP_EOL;
    }

    private function calc(iterable $input) {
        $result = 0;
        foreach ($input as $data) {
            $result += intval($data);
        }
        return $result;
    }
}
