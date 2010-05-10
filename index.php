<?php

	// Ultrasonic header here :)

	require('./app/ultrasonic.inc.php');

	$application = new Ultrasonic();
	$application->dispatch(virtual_uri());

?>