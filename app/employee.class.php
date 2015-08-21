<?php
	require_once 'database.class.php';
	class Employee extends User{
		protected static $table_name = 'employee';
		protected static $attributes = array(
				'user_id',
				'balance',
				'validity'
		);
		
		public function __construct() {
			if (empty($this->user_id)) $this->user_id = '';
			if (empty($this->balance)) $this->balance = 0;
			date_default_timezone_set('Asia/Kathmandu');
			if (empty($this->validity)) $this->validity = date('Y-m-d', strtotime('+1 month'));
		}
		
		protected function sanitize_object(&$stmt) {
			$this->balance = strval($this->balance);
			$this->validity = strval($this->validity);
			$stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
			$stmt->bindParam(':balance', $this->balance, PDO::PARAM_STR);
			$stmt->bindParam(':validity', $this->validity, PDO::PARAM_STR);
		}

		protected static function sanitize_data(&$stmt, $passedAttributes) {
			if (array_key_exists('user_id', $passedAttributes)) $stmt->bindParam(':user_id', $passedAttributes['user_id'], PDO::PARAM_INT);
			if (array_key_exists('balance', $passedAttributes)) $stmt->bindParam(':balance', $passedAttributes['balance'], PDO::PARAM_STR);
			if (array_key_exists('validity', $passedAttributes)) $stmt->bindParam(':validity', $passedAttributes['validity'], PDO::PARAM_STR);
		}
		
		public function valid_days() {
			return (strtotime($this->validity) - strtotime("Today"))/(60*60*24);
		}
	}

?>