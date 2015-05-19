<?php

parse_str(implode('&', array_slice($argv, 1)), $_GET); //cli-only

$spot = $_GET['spot'];

if($spot === "centrumgallerie"){
	$csv = file_get_contents($spot.'.csv');
	$date = $_GET['date'];
	$pattern = "/^.*$date.*\$/m";
	preg_match_all($pattern, $csv, $matches);
	echo implode("\n", $matches[0]);
}else{
	echo file_get_contents('meta.json');
}
?>
