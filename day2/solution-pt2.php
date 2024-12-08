<?php
const INPUT_PATH = "input.txt";
const LINE_DELIMITER = "\n";
const LIST_SPLIT_REGEX = '/\s+/';
const MAX_LEVEL_TOLERANCE = 1;

function validate_deltas($deltas, $levels, $depth = 0) {
    $n_deltas = count($deltas);
    assert($n_deltas > 0);

    $all_decreasing = $deltas[0] < 0;

    for ($i=0; $i < $n_deltas; $i++) { 
        $delta = $deltas[$i];

        if (!validate_delta($delta, $all_decreasing)) {
            if ($depth == MAX_LEVEL_TOLERANCE) return false;

            for ($j=0; $j <= $i + 1; $j++) { 
                $discarded_levels = discard_level($levels, $j);
                $recalculated_deltas = calculate_deltas($discarded_levels);

                if(!validate_deltas($recalculated_deltas, $discarded_levels, $depth + 1)) 
                    continue;

                return true;
            }

            return false;
        }
    }

    return true;
}

function validate_delta($delta, $all_decreasing) {
    return !(
        $delta > 0 && $all_decreasing ||
        $delta < 0 && !$all_decreasing ||
        $delta == 0 ||
        abs($delta) > 3 ||
        abs($delta) < 1
    );
}

function discard_level($levels, $level_idx)
{
    $n_levels = count($levels);

    assert($n_levels > 0);
    assert($level_idx < $n_levels);
    assert($level_idx >= 0);

    $discarded_levels = array();

    for ($i=0; $i < $n_levels; $i++) { 
        if ($i == $level_idx) continue;
        $discarded_levels[] = $levels[$i];
    }

    return $discarded_levels;
}

function calculate_deltas($levels)
{
    $deltas = array();

    $n_levels = count($levels);
    assert($n_levels >= 2);

    for ($i=1; $i < $n_levels; $i++) { 
        $deltas[] = $levels[$i] - $levels[$i-1];       
    }

    assert(count($deltas) == $n_levels - 1);
    return $deltas;
}

$input = file_get_contents(INPUT_PATH);
$lines = explode(LINE_DELIMITER, $input);

$safe_reports = 0;

foreach ($lines as $report) {
    if (trim($report) == '') continue;
    $levels = preg_split(LIST_SPLIT_REGEX, $report);
    $deltas = calculate_deltas($levels);
    if (validate_deltas($deltas, $levels)) ++$safe_reports;
}

echo $safe_reports;
