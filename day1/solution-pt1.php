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

assert(count($left) == count($right));
$count = count($left);

sort($left);
sort($right);
$distance = 0;

for ($i=0; $i < $count; $i++) { 
	$distance += abs($left[$i] - $right[$i]);
}

echo $distance;


