<?php
	require_once 'database.class.php';
	class Order extends CRUD{
		protected static $table_name = 'orders';
		protected static $attributes = array(
				'id',
				'menu_item_id',
				'quantity',
				'user_id',
				'date',
				'served'
		);
		
		public function __construct() {
			parent::__construct();
			if (empty($this->date)) $this->date = today();
		}

		protected static function sanitize_data(&$stmt, $passedAttributes) {
			if (array_key_exists('id', $passedAttributes)) $stmt->bindParam(':id', $passedAttributes['id'], PDO::PARAM_INT);
			if (array_key_exists('menu_item_id', $passedAttributes)) $stmt->bindParam(':menu_item_id', $passedAttributes['menu_item_id'], PDO::PARAM_INT);
			if (array_key_exists('quantity', $passedAttributes)) $stmt->bindParam(':quantity', $passedAttributes['quantity'], PDO::PARAM_STR);
			if (array_key_exists('user_id', $passedAttributes)) $stmt->bindParam(':user_id', $passedAttributes['user_id'], PDO::PARAM_INT);
			if (array_key_exists('date', $passedAttributes)) $stmt->bindParam(':date', $passedAttributes['date'], PDO::PARAM_STR);
			if (array_key_exists('served', $passedAttributes)) $stmt->bindParam(':served', $passedAttributes['served'], PDO::PARAM_INT);
		}
		
		protected function sanitize_object(&$stmt) {
			$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
			$stmt->bindParam(':menu_item_id', $this->menu_item_id, PDO::PARAM_INT);
			$stmt->bindParam(':quantity', $this->quantity, PDO::PARAM_STR);
			$stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
			$stmt->bindParam(':date', $this->date, PDO::PARAM_STR);
			$stmt->bindParam(':served', $this->served, PDO::PARAM_INT);
		}
	}

?>