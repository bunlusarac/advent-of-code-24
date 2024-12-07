<?php
$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$left = array();
$right = array();

foreach ($lines as $line) {
    if (trim($line) == '') continue;
    $numbers = preg_split('/\s+/', $line);
    assert(count($numbers) == 2);
    $left[] = (int) $numbers[0];
    $right[] = (int) $numbers[1];
}

$similarity = 0;

$right_counts = array_count_values($right);
foreach ($left as $le) {
    $similarity += $le  * ($right_counts[$le] ?? 0);
}

echo $similarity;


