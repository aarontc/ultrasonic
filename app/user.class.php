<?php

	require_once('./app/config.class.php');

	class User {
		public $login;
		public $first_name;
		public $last_name;
		private $password_hash;
		public $roles;

		private static function escape_login($login) {
			return str_replace('/', '\/', $login);
		}

		// if login is not null, read info from config
		function __construct($login = null) {
			if($login != null) {
				$path = '/users/' . self::escape_login($login);
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
			$path = '/users/' . self::escape_login($this->login);
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

		function validate() {
			$errors = array();
			if(strlen($this->login) < 2)
				$errors['login'] .= "Login name must be 2 characters or longer;";

			if(strlen($this->first_name) < 2)
				$errors['first_name'] .= "First name must be 2 characters or longer;";

			if(strlen($this->last_name) < 2)
				$errors['last_name'] .= "Last name must be 2 characters or longer;";

			if(count($errors)>0)
				return $errors;
			else
				return true;
		}

		static public function get_all() {
			$config = new Config();
			$users = $config->get_array("/users");
			$result = array();
			foreach($users as $user) {
				$result[$user] = new User($user);
			}
			return $result;
		}

		public function delete() {
			$config = new Config();
			$users = $config->get_array('/users');
			$newusers = array();
			foreach($users as $u) {
				if($u != self::escape_login($this->login))
					$newusers[] = $u;
			}
			$config->set_array('/users', $newusers);
			$config->delete_string('/users/' . self::escape_login($this->login) . '/first_name');
			$config->delete_string('/users/' . self::escape_login($this->login) . '/last_name');
			$config->delete_string('/users/' . self::escape_login($this->login) . '/password_hash');
			$config->delete_array('/users/' . self::escape_login($this->login) . '/roles');
			return true;
		}

		public function rename($newlogin) {
			$config = new Config();
			$users = $config->get_array('/users');
			if(in_array($users, self::escape_login($newlogin))) {
				throw new Exception("Login name already exists");
			}
			$newusers = array();
			foreach($users as $u) {
				if($u != self::escape_login($this->login)) {
					$newusers[] = $u;
				} else {
					$newusers[] = self::escape_login($newlogin);
				}
			}
			$config->set_array('/users', $newusers);
			$oldlogin = $this->login;
			$this->login = $newlogin;
			$this->save();
			$config->delete_string('/users/' . self::escape_login($oldlogin) . '/first_name');
			$config->delete_string('/users/' . self::escape_login($oldlogin) . '/last_name');
			$config->delete_string('/users/' . self::escape_login($oldlogin) . '/password_hash');
			$config->delete_array('/users/' . self::escape_login($oldlogin) . '/roles');
			return true;
		}


	}

?>