<?php

	require_once('./app/user.class.php');

	// Ultrasonic header here :)
	ob_start();
	session_start();

	// Disable caching
	header('Expires: 0');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('cache-control: no-store, no-cache, must-revalidate');
	header('Pragma: no-cache');

	require('./app/ultrasonic.class.php');

	// Returns all but the first element of the array (see clisp's 'rest' function)
	function array_leftover($input) {
		if(!is_array($input))
			return false;
		if(count($input) < 2)
			return array();
		return array_slice($input, 1);
	}


	function virtual_uri($uri = null) {
		if($uri == null) {
			$uri = $_SERVER['REQUEST_URI'];
		}

		if(strlen($uri) <= strlen($_SERVER['SCRIPT_NAME'])) {
			$uri = '/';
		} else {
			$uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
		}

		return $uri;
	}

	function string_not_empty($str) {
		return (strlen(trim($str))>0);
	}

	function array_remove_empty_strings($array) {
		$new = array();
		foreach($array as $a) {
			if(strlen(trim($a)) > 0) {
				$new[] = $a;
			}
		}
		//return array_filter($array, 'string_not_empty');
		return $new;
	}
?>