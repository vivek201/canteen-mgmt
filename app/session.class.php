<?php

	class Session {
		private $logged_in = false;
		public $user_id;
		public $username;
		public $permission;
		public $validity;
		
		function __construct() {
			session_start();
			if (isset($_SESSION['user_id'])){
				$this->logged_in = true;
				$this->user_id = $_SESSION['user_id'];
				$this->username = $_SESSION['username'];
				$this->permission = $_SESSION['permission'];
			}
		}
		
		public function login($user) {
			if ($user) {
				$this->logged_in = true;
				$this->user_id = $_SESSION['user_id'] = $user->id;
				$this->username = $_SESSION['username'] = $user->username;
				$this->permission = $_SESSION['permission'] = strtolower($user->permission);
			}
		}
		
		public function allow($permission) {
			if ($this->logged_in == true) {
				if ($this->permission != $permission) {
					if ($this->permission == 'manager')
						redirect_to($_SERVER['DocumentRoot'] . '/admin/');
					elseif ($this->permission == 'staff')
						redirect_to($_SERVER['DocumentRoot'] . '/staff/');
					elseif ($this->permission == 'employee')
						redirect_to($_SERVER['DocumentRoot'] . '/account.view.php');
				}
			}
			else {
				redirect_to('/');
			}
		}
		
		public function logout() {
			if ($this->logged_in) {
				$this->logged_in = false;
				unset($_SESSION['user_id']);
				unset($_SESSION['username']);
				unset($_SESSION['permission']);
				redirect_to('/');
			}
		}
	}

?>