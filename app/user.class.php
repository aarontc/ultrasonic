<?php

	require_once('./app/config.class.php');

	class User {
		public $login;
		public $first_name;
		public $last_name;
		private $password_hash;
		public $roles;

		// if login is not null, read info from config
		function __construct($login = null) {
			if($login != null) {
				$path = '/users/' . str_replace('/', '\/', $login);
				$this->login = $login;
				$config = new Config();
				$success = $this->first_name = $config->get_string($path . '/first_name');
				$success &= $this->last_name = $config->get_string($path . '/last_name');
				$success &= $this->roles = $config->get_array($path . '/roles');
				$success &= $this->password_hash = $config->get_string($path . '/password_hash');
				if($success !== true)
					return false;
			}
		}

		function check_password($password) {
			return ($this->password_hash == hash('sha512', $password));
		}


		function save() {
			$path = '/users/' . str_replace('/', '\/', $this->login);
			$config = new Config();
			$success = $config->set_string($path . '/first_name', $this->first_name);
			$success &= $config->set_string($path . '/last_name', $this->last_name);
			$success &= $config->set_array($path . '/roles', $this->roles);
			if(isset($this->password_hash))
				$success &= $config->set_string($path . '/password_hash', $this->password_hash);

			return $success;
		}

		function set_password($new_password) {
			$this->password_hash = hash('sha512', $new_password);
			return $this->save();
		}
	}

?>