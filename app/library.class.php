<?php

	require_once('./app/database.class.php');
	require_once('./app/collection.class.php');

	class Library {
		private $db;

		function __construct() {
			$this->db = new Database();
		}

		function get_collections() {
			$collections = array();
			$result = $this->db->ado->Execute("SELECT id FROM collection");
			foreach($result as $c) {
				$collections[] = new Collection($c[0]);
			}
			print_r($collections);
			return $collections;
		}

		function search($input) {
		}
	}