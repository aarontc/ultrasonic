<?php

	// Ultrasonic header here :)

	// Disable caching
	header('Expires: 0');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('cache-control: no-store, no-cache, must-revalidate');
	header('Pragma: no-cache');

	require('./app/config.class.php');

?>