<?php


namespace CLI;

use IO\FileWriter;

class Main
{

    public function main(int $argc, array $argv): void
    {
        if ($argc >= 3) {
            $choose = $argv[1]; // -w one word, -p paragraph, -f file
            $execCalc = new ExecDurationCalculator();
            $execCalc->start();
            $resultStr = (new UserInput)->textHyphenationUI($choose, $argv[2]);
            if ($resultStr !== false) {
                $execCalc->finish();
                $execDuration = $execCalc->getDuration();
                if ($argc > 3) { // save result to file
                    $filename = $argv[3];
                    if ((new FileWriter())->writeToFile($filename, $resultStr)) {
                        echo "Result saved to file '$filename'\n";
                    } else {
                        echo "Error: can not save result to file '$filename'";
                    }
                } else {
                    echo $resultStr;
                }
            }
            echo "\nExecution duration: $execDuration seconds\n";
        } else {
            (new Helper())->printHelp();
        }
    }
}