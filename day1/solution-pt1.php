<?php
const INPUT_PATH = "input.txt";
const LINE_DELIMITER = "\n";
const LIST_SPLIT_REGEX = '/\s+/';

$input = file_get_contents(INPUT_PATH);
$lines = explode(LINE_DELIMITER, $input);

$left = array();
$right = array();

foreach ($lines as $line) {
    if (trim($line) == '') continue;
    $numbers = preg_split(LIST_SPLIT_REGEX, $line);
    assert(count($numbers) == 2);
    $left[] = (int) $numbers[0];
    $right[] = (int) $numbers[1];
}

assert(count($left) == count($right));
$count = count($left);

sort($left);
sort($right);

$distance = 0;

for ($i=0; $i < $count; $i++) { 
    $distance += abs($left[$i] - $right[$i]);
}

echo $distance;