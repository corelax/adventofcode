<?php

namespace App\Console\Commands\Solvers\Y2018;

use Illuminate\Console\Command;
use Storage;
use SplFileObject;
use SeekableIterator;

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
        $input = new SplFileObject(storage_path('app/input/2018/day01/input.dat'));
        $input->setFlags(SplFileObject::DROP_NEW_LINE | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY);
        echo "part1 : " . $this->calc($input) . PHP_EOL;
        echo "part2 : " . $this->calc2($input) . PHP_EOL;
        // echo $this->calc2((new \ArrayObject([+3, +3, +4, -2, -4]))->getIterator()) . PHP_EOL;
    }

    private function calc(iterable $input) {
        $result = 0;
        foreach ($input as $data) {
            $result += intval($data);
        }
        return $result;
    }

    private function calc2(SeekableIterator $input) {
        $history = [0 => true];
        $result = 0;
        while(true) {
            foreach ($input as $data) {
                $result += intval($data);
                if (isset($history[$result])) {
                    return $result;
                }
                $history[$result] = true;
            }
            $input->rewind();
        }
        return $result;
    }
}
