<?php

	require_once('./app/database.class.php');

	class Config {
		private $db;

		function __construct() {
			$this->db = new Database();
		}

		// Returns a string value by path. If string does not exist, false is returned
		function get_string($path) {
			//$db = new Database();
			$result = $this->db->query("SELECT * FROM BLAH");
			return $result;
		}
	}

?>