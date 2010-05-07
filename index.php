<?php

	// Ultrasonic header here :)

	require('./app/ultrasonic.inc.php');
	$uri = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);
	if(substr($uri, 0, 1) == '/')
		$uri = substr($uri, 1);

	$application = new Ultrasonic();
	$application->dispatch($uri);

?>