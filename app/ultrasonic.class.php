<?php

	require_once('./app/config.class.php');
	require_once('./app/user.class.php');
	require_once('./app/library.class.php');
	require_once('./app/collection.class.php');
	require_once('./lib/smarty3/Smarty.class.php');

	class Ultrasonic {
		private $conf;
		private $smarty;
		private $content = null;
		private $secondarycontent = null;

		function __construct() {
			$this->conf = new Config();
			$this->smarty = new Smarty();
		}

		private function genesis() {
			// count number of users
			$users = $this->conf->get_array('/users');
			if($users === false || count($users) < 1)
				return true;
			else
				return false;
		}

		function page_home($path) {

			$this->content='./tpl/home.tpl';
		}

		function page_about($path) {
		}

		function page_404($path) {
			$this->content='./tpl/404.tpl';
		}


		function flash_info($message) {
			$_SESSION['Flash']['Info'][] = $message;
		}

		function flash_success($message) {
			$_SESSION['Flash']['Success'][] = $message;
		}

		function flash_warning($message) {
			$_SESSION['Flash']['Warning'][] = $message;
		}

		function flash_error($message) {
			$_SESSION['Flash']['Error'][] = $message;
		}


		function page_user($path) {
			if(count($path) > 0) {
				switch($path[0]) {
					case 'login':
						if(isset($_POST['login']) && isset($_POST['password'])) {
							$user = new User($_POST['login']);
							if($user->check_password($_POST['password'])) {
								$_SESSION['User'] = $user;
								self::flash_success("Login successful");
								if(isset($_SESSION['LastRequest'])) {
									header('Location: ' . $_SESSION['LastRequest']);
								} else {
									header('Location: /index.php');
								}
								exit;
							} else {
								self::flash_error("Invalid credentials");
								$this->smarty->assign('login', $_POST['login']);
							}
						}
						$this->content='./tpl/user/login.tpl';
						break;
					case 'logout':
						session_destroy();
						session_start();
						self::flash_success("Logout successful");
						header("Location: /index.php");
						exit;
						break;
					case 'settings':
						break;
					default:
						$this->page_404($path);
				}
			} else {
				$this->page_404($path);
			}
		}

		// verifies that the currently logged user has the necessary role(s)
		// if $role is an array, and $all is false, only one or more roles in $role
		// must be held. if $all is true, then ALL roles in $role must be held.
		// if $role is not an array, $all is ignored
		function require_role($role, $all = false) {
			if(is_array($role)) {
				throw new Exception('fixme: handle role arrays');
			} else {
				if(isset($_SESSION['User']) && in_array($role, $_SESSION['User']->roles)) {
					return true;
				} else {
					self::flash_error('You do not have permission for the requested operation');

					return false;
				}
			}
		}

		function page_admin($path) {
			if(!self::genesis() && !self::require_role('admin'))
				return;

			if(count($path) > 0) {
				switch($path[0]) {
					case 'collections':
						$lib = new Library();
						$this->smarty->assign('Collections', $lib->get_collections());
						$this->secondarycontent = './tpl/admin/collections_right.tpl';
						$this->content = './tpl/admin/collections.tpl';
						break;

					case 'create_collection':
						if(isset($_POST['path'])) {
							$success = true;
							$collection = new Collection();
							$collection->path = $_POST['path'];
							if($collection->validate_path()) {
								if($collection->save()) {
									self::flash_success('Collection added');
								} else {
									self::flash_error('Unable to save collection to database.');
								}
							} else {
								$this->smarty->assign('path', $_POST['path']);
								self::flash_error('Collection could not be added. Check path.');
							}
						}
						$this->content='./tpl/admin/create_collection.tpl';
						break;


					case 'create_user':
						// If the form is POSTed, validate data and save user
						if(isset($_POST['login'])) {
							$success = true;

							// login valid?
							if(!isset($_POST['login']) || strlen($_POST['login']) < 2) {
								$success = false;
								self::flash_error("Login must be 2 characters or longer");
							}

							// firstname valid?
							if(!isset($_POST['first_name']) || strlen($_POST['first_name']) < 2) {
								$success = false;
								self::flash_error("First name must be 2 characters or longer");
							}

							// lastname valid?
							if(!isset($_POST['last_name']) || strlen($_POST['last_name']) < 2) {
								$success = false;
								self::flash_error("Last name must be 2 characters or longer");
							}


							// password check?
							if(!isset($_POST['password']) || !isset($_POST['password_verify']) || strlen($_POST['password']) < 2) {
								$success = false;
								self::flash_error("Password must be 2 characters or longer");
							} else {
								if( $_POST['password'] != $_POST['password_verify']) {
									$success = false;
									self::flash_error("Password confirmation did not match");
								}
							}

							// unique login?
							$users = $this->conf->get_array('/users');
							if(is_array($users) && in_array($_POST['login'], $users)) {
								$success = false;
								self::flash_error("Login already in use");
							}


							$user = new User();
							$user->login = $_POST['login'];
							$user->first_name = $_POST['first_name'];
							$user->last_name = $_POST['last_name'];
							$user->roles = $_POST['roles'];

							// enforce admin if genesis
							if(self::genesis())
								$user->roles[] = 'admin';

							$success &= $user->set_password($_POST['password']);
							$users[] = $user->login;
							$success &= $this->conf->set_array('/users', $users);

							if($success) {
								self::flash_success("User created");
							} else {
								self::flash_error("User creation failed");
								$this->smarty->assign('login', $_POST['login']);
								$this->smarty->assign('first_name', $_POST['first_name']);
								$this->smarty->assign('last_name', $_POST['last_name']);
							}

						}
						if(self::genesis()) {
							$this->smarty->assign('admin_checked', 'checked');
							$this->smarty->assign('admin_disabled', 'disabled');
						}
						$this->content='./tpl/admin/create_user.tpl';
						break;
					default:
						$this->page_404($path);
				}
			} else {
				$this->content='./tpl/admin/index.tpl';
				$this->secondarycontent = './tpl/admin/rightmenu.tpl';
			}
		}



		// Main workhorse
		// Given the requested path, evaluate where to send the request
		function dispatch($path) {
			// check for genesis
			if($this->genesis()) {
				if($path != 'admin/create_user') {
					$this->flash_info("Welcome new user! Please create your account");
					header('Location: /index.php/admin/create_user');
					exit;
				}
			} else {
				if($path != 'user/login') {
					$_SESSION['LastRequest'] = $_SERVER['REQUEST_URI'];
				}
			}

			$elements = explode('/', $path);
			$count = count($elements);

			if($count == 0) {
				$this->page_home(array());
			} else {
				if($count > 1) {
					$leftover = array_reverse($elements);
					array_pop($leftover);
					$leftover = array_reverse($leftover);
				} else {
					$leftover = array();
				}

				switch($elements[0]) {
					case '':
					case 'home':
						$this->page_home($leftover);
						break;

					case 'about':
						$this->page_about($leftover);
						break;

					case 'admin':
						$this->page_admin($leftover);
						break;

					case 'user':
						$this->page_user($leftover);
						break;

					default:
						$this->page_404($leftover);
				}
			}

			if(isset($_SESSION['User']))
				$this->smarty->assign('CurrentLogin', $_SESSION['User']->login);
			$this->smarty->assign('FlashInfo', $_SESSION['Flash']['Info']);
			$this->smarty->assign('FlashSuccess', $_SESSION['Flash']['Success']);
			$this->smarty->assign('FlashWarning', $_SESSION['Flash']['Warning']);
			$this->smarty->assign('FlashError', $_SESSION['Flash']['Error']);
			$this->smarty->assign('ContentBody', $this->content);
			if($this->secondarycontent != null)
				$this->smarty->assign('SecondaryContent', $this->secondarycontent);
			$this->smarty->display('./tpl/application/layout.tpl');
			unset($_SESSION['Flash']);
		}

	}

?>
