<?php

$city = $_GET['city'];

if($city === "Dresden"){
	echo file_get_contents('http://jkliemann.de/offenesdresden.de/json.php');
}else{
	echo file_get_contents('meta.json');
}

?>
