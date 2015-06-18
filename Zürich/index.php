<?php

class Spot{
	public $name;
	public $free;
	public $count;
	public $state;
	public $lat;
	public $lon;
	public $forecast;
	function Spot(){
	}
	function evalMax(){
		touch(explode(" / ",$this->name)[0]);
		$max = file_get_contents(explode(" / ",$this->name)[0]);
		if($this->free > $max){
			$max = $this->free;
			file_put_contents(explode(" / ",$this->name)[0], $max);
		}
		$this->count = $max;
	}
	function checkForecast(){
		if(file_exists('./forecast/'.$this->name.'.csv')){
			$this->forecast = "true";
		}else{
			$this->forecast = "false";
		}
	}
	function calcState(){
		$perc = $this->free / $this->count;
		if($perc < 0.05){
			$this->state = "full";
		}else if($perc < 0.3){
			$this->state = "few";
		}else{
			$this->state = "many";
		}
	}
	function dumpJSon(){
		return "{\"name\":\"".$this->name."\",\"count\":\"".$this->count."\",\"free\":\"".$this->free."\",\"state\":\"".$this->state."\",\"forecast\":\"".$this->forecast."\"}";
	}
}

$site = new DOMDocument();
$site->loadHTML(file_get_contents("http://www.pls-zh.ch/plsFeed/rss"));
$spotlist = $site->getElementsByTagName('item');
$spots = array();
foreach($spotlist as $spot){
	$s = new Spot();
	$s->name=$spot->getElementsByTagName('title')->item(0)->nodeValue;
	$s->free=str_replace(" ", "", explode(" /  ",$spot->getElementsByTagName('description')->item(0)->nodeValue)[1]);
	$s->evalMax();
	$s->checkForecast();
	$s->calcState();
	if(str_replace(" ", "", explode(" / ", $spot->getElementsByTagName('description')->item(0)->nodeValue)[0]) != "open"){
		$s->state = "closed";
	}
	$spots[] = $s;
}

$json = "[{\"name\":\"Zürich\",\"lots\":[";
foreach($spots as $spot){
	$json = $json.$spot->dumpJSon().",";
}
$json = substr($json, 0, -1);
$json = $json."]}]";
print($json);
?>
