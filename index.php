<?php

	// Ultrasonic header here :)

	require('./app/ultrasonic.inc.php');

	$config = new Config();
	echo $config->get_string("/test/string");

	$config->set_string("/test/string", "Aaron");
	echo $config->get_string("/test/string");

	$array = array("hello" => "stuff", "goodbye" => "tomorrow");

	$config->set_array('/test/array', $array);

?>