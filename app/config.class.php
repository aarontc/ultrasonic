<?php

	require_once('./app/database.class.php');

	class Config {
		private $db;

		function __construct() {
			$this->db = new Database();
		}

		// Returns a string value by path. If string does not exist, false is returned
		function get_string($path) {
			$stmt = $this->db->ado->Prepare('SELECT value FROM strings WHERE path=' . $this->db->ado->Param('p') . '');
			$result = $this->db->ado->query($stmt, $path);
			return $result;
		}
	}

?>