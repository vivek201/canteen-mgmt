<?php
	class Database {
		public $handle;
		protected static $instance;
		protected $host = "localhost";
		protected $dbname = "cantein";
		protected $user = "root";
		protected $pass = "";
		
		protected function __construct() {
			
			try {
				$this->handle = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->user, $this->pass);
			}
			catch (PDOException $e) {
				echo "Database connection error:" . $e->getMessage() . "<br />";
			}
		}
		
		public static function getInstance() {
			if (!isset(self::$instance)) {
				self::$instance = new Database();
			}
			return self::$instance;
		}
	}
?>