<?php

$city = $_GET['city'];

function getmeta(){
	$cities = array_values(array_filter(glob('*'), 'is_dir'));
	$mail = "jklmnn@web.de";
	$meta = array('mail' => $mail, 'cities' => $cities);
	return $meta;
}

if($city === "Dresden"){
	echo file_get_contents('http://jkliemann.de/offenesdresden.de/json.php');
}else{
	echo json_encode(getmeta());
}

?>
