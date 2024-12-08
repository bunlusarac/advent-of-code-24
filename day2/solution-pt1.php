<?php
const INPUT_PATH = "input.txt";
const LINE_DELIMITER = "\n";
const LIST_SPLIT_REGEX = '/\s+/';

function validate_deltas($deltas) {
    $all_decreasing = false;

    assert(count($deltas) > 0);
    $all_decreasing = $deltas[0] < 0;

    foreach ($deltas as $delta) {
        if ($delta > 0 && $all_decreasing ||
            $delta < 0 && !$all_decreasing ||
            $delta == 0 ||
            abs($delta) > 3 ||
            abs($delta) < 1) {
            return false;
        }
    }

    return true;
}

$input = file_get_contents(INPUT_PATH);
$lines = explode(LINE_DELIMITER, $input);

$safe_reports = 0;

foreach ($lines as $report) {
    if (trim($report) == '') continue;
    $levels = preg_split(LIST_SPLIT_REGEX, $report);
    $n_levels = count($levels);

    assert($n_levels >= 2);
    $all_decreasing = false;

    $deltas = array();

    for ($i=1; $i < $n_levels; $i++) { 
        $deltas[] = $levels[$i] - $levels[$i-1];       
    }

    assert(count($deltas) == $n_levels - 1);

    if (!validate_deltas($deltas)) continue;
    $safe_reports++;
}

echo $safe_reports;