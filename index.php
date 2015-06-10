<?php

$city = $_GET['city'];

function getmeta(){
	$cities = array_values(array_filter(glob('*'), 'is_dir'));
	$mail = ""; //servers mail address
	$meta = array('mail' => $mail, 'cities' => $cities);
	return $meta;
}

function send($msg){
	$header =  "From:  \r\n X-Mailer: PHP/".phpversion(); // mail sender and xmailer
	$title = ""; // mail title
	$to = ""; // servers mail address
	$body = htmlspecialchars($msg, ENT_QUOTES);
	mail($to, $title, $body, $header);

}

if(isset($_POST['msg'])){
	send($_POST['msg']);
	exit(0);
}

if($city === "Dresden"){
	echo file_get_contents('http://jkliemann.de/offenesdresden.de/json.php');
}else{
	echo json_encode(getmeta());
}

?>
