<?php

	// check for config file
	if(file_exists('./config.php')) {
		require('./config.php');
	} else {
		// let the user know
		//header('Location: ./create_config.php');
		throw new Exception('Please create config.php in the root directory. See config.php.dist for hints');
	}

	require_once("./lib/adodb5/adodb-exceptions.inc.php");
	require_once('./lib/adodb5/adodb.inc.php');

	class Database {
		const SCHEMA_VERSION = 4;
		public $ado;
		public $connected = false;

		function __construct() {
			global $_CONFIG;
			$this->ado = ADONewConnection($_CONFIG['Database']['Type']);
			//$this->ado->debug = true;
			$this->connected = $this->ado->Connect($_CONFIG['Database']['Server'],
						$_CONFIG['Database']['Login'],
						$_CONFIG['Database']['Password'],
						$_CONFIG['Database']['Database']);
			if($this->connected === true)
				$this->check_schema_version();
		}

		function query($query) {
			if($this->connected !== true)
				throw new Exception("DB connection does not exist");
			return $this->db->Execute($query);
		}

		private function check_schema_version() {
			global $_CONFIG;

			// validate schema version
			try {
				$result = $this->ado->Execute("SELECT MAX(version) FROM schema_migrations");
			} catch (Exception $e) {
				// no database
				if($_CONFIG['Database']['Type'] == 'sqlite') {
					// create the database
					for($i = 1; $i <= self::SCHEMA_VERSION; $i++) {
						$query = file_get_contents("./db/sqlite/schema_version_${i}.sql");
						$this->ado->StartTrans();
						$this->ado->Execute($query);
						$this->ado->CompleteTrans();
					}
				} else {
					throw new Exception("Please create database schema. See files in db directory.");
				}
			}
			if($result->fields[0] != self::SCHEMA_VERSION) {
				throw new Exception("Schema version ('" . $result->fields[0] . "') outdated. Current is ('" . self::SCHEMA_VERSION . "') See files in db directory.");
			}
		}
	}

?>
