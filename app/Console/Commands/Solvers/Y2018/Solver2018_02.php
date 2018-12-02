<?php

namespace App\Console\Commands\Solvers\Y2018;

use Illuminate\Console\Command;
use Storage;
use SplFileObject;
use SeekableIterator;

class Solver2018_02 extends Command
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
        echo "part1 : " . $this->calc($input) . PHP_EOL;
    }

    private function calc(iterable $input)
    {
        $countArray = [0];
        foreach ($input as $data) {
            for ($i = count($countArray); $i <= strlen($data); $i++) {
                // initialize when longer line found
                $countArray[$i] = 0;
            }

            // count duplicate count per char
            $wk = [];
            foreach (str_split($data) as $char) {
                if (!isset($wk[$char])) {
                    $wk[$char] = 0;
                }

                $wk[$char]++;
            }

            // apply to countArray
            // counts once when same duplicate counts
            foreach (array_unique(array_values($wk)) as $count) {
                $countArray[$count]++;
            }
        }

        return $countArray[2] * $countArray[3];
    }
}
