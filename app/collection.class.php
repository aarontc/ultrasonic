<?php

	require_once('./app/database.class.php');

	class Collection {
		public $path;

		function __construct($path = null) {
			if($path != null) {
				$this->path = $path;
			}
		}

		// Responsible for validating that the path is readable
		// Maybe in the future, look for at least one readable file too
		function validate_path() {
			return is_dir($this->path);
		}

		function save() {
			$db = new Database();
			$s = $db->ado->Prepare('INSERT INTO collection (path) VALUES(' . $db->ado->Param('p') . ')');
			return $db->ado->Execute($s, $this->path);
		}
	}

?>