<?php

	// check for config file
	if(file_exists('./config.php')) {
		require('./config.php');
	} else {
		// let the user know
		//header('Location: ./create_config.php');
		die('Please create config.php in the root directory. See config.php.dist for hints');
	}

	require('./lib/adodb5/adodb.inc.php');

	class Database {
		const SCHEMA_VERSION = 0;
		private $db;
		public $connected = false;

		function __construct() {
			global $_CONFIG;
			$this->db = ADONewConnection($_CONFIG['Database']['Type']);
			$this->db->debug = true;
			$this->connected = $this->db->Connect($_CONFIG['Database']['Server'],
						$_CONFIG['Database']['Login'],
						$_CONFIG['Database']['Password'],
						$_CONFIG['Database']['Database']);
			if($this->connected === true)
				$this->check_schema_version();
		}

		function query($query) {
			if($this->connected !== true)
				die("DB connection does not exist");
			return $this->db->Execute($query);
		}

		private function check_schema_version() {
			global $_CONFIG;

			// validate schema version
			$result = $this->db->Execute("SELECT MAX(version) FROM schema");
			if(!$result) {
				// no database
				if($_CONFIG['Database']['Type'] == 'sqlite') {
					// create the database
					$query = file_get_contents("./db/sqlite/schema_version_0.sql");
					$result = $this->db->Execute($query);
					if(!$result)
						die($this->db->ErrorMsg());
				} else {
					die("Please create database schema. See files in db directory.");
				}
			} else {
				if($result->fields[0] != SCHEMA_VERSION) {
					die("Schema version outdated. See files in db directory.");
				}
			}
		}
	}

?>
