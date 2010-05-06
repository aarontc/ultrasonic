<?php

	// Ultrasonic header here :)

	require('./app/ultrasonic.inc.php');

	$config = new Config();
	echo $config->get_string("/test/string");

?>