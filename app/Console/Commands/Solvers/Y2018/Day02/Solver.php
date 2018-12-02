<?php

namespace App\Console\Commands\Solvers\Y2018\Day02;

class Solver
{
    public function calc(iterable $input)
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

    public function calc2(iterable $input) {
        $inArray = [];
        foreach ($input as $line) {
            $inArray[] = $line;
        }

        $minDiffer = PHP_INT_MAX;
        $lhsIndex = 0;
        $rhsIndex = 0;
        $ans = '';
        for ($i = 0; $i < count($inArray) - 1; $i++) {
            for ($j = $i + 1; $j < count($inArray); $j++) {
                list($differ, $samepart) = $this->differ($inArray[$i], $inArray[$j], $minDiffer);
                if ($differ < $minDiffer) {
                    $minDiffer = $differ;
                    $ans = $samepart;
                    $lhsIndex = $i;
                    $rhsIndex = $j;
                }
            }
        }

        // $this->info("pair(L) : [" . str_pad($lhsIndex, 4) . "]{$inArray[$lhsIndex]}");
        // $this->info("pair(R) : [" . str_pad($rhsIndex, 4) . "]{$inArray[$rhsIndex]}");

        return $ans;
    }

    private function differ(string $l, string $r, int $threshold) {
        $differ = 0;
        $samepart = [];
        for ($i = 0; $i < strlen($l); $i++) {
            if ($l[$i] !== $r[$i]) {
                $differ++;
                if ($differ >= $threshold) {
                    return [$threshold, ""];
                }
            } else {
                $samepart[] = $l[$i];
            }
        }

        return [$differ, implode('', $samepart)];
    }
}
