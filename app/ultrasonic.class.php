<?php

	require('./app/config.class.php');
	require('./lib/smarty3/Smarty.class.php');

	class Ultrasonic {
		private $conf;
		private $smarty;

		function __construct() {
			$this->conf = new Config();
			$this->smarty = new Smarty();
		}



		function page_home($path) {
			// count number of users
			$users = $this->conf->get_array('/users');
			if($users === false || count($users) < 1)
				header('Location: /index.php/admin/createuser');

			$this->smarty->display('./tpl/home.tpl');
		}

		function page_about($path) {
		}

		function page_404($path) {
			$this->smarty->display('./tpl/404.tpl');
		}


		// Main workhorse
		// Given the requested path, evaluate where to send the request
		function dispatch($path) {
			$elements = explode('/', $path);
			$count = count($elements);

			if($count == 0) {
				$this->page_home(array());
			} else {
				$leftover = array_reverse($elements);
				$leftover = array_pop($leftover);
				$leftover = array_reverse($leftover);

				switch($elements[0]) {
					case '':
					case 'home':
						$this->page_home($leftover);
						break;

					case 'about':
						$this->page_about($leftover);
						break;

					default:
						$this->page_404($leftover);
				}
			}
		}

	}

?>