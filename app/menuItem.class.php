<?php
	require_once 'database.class.php';
	class MenuItem extends CRUD{
		protected static $table_name = 'menu_item';
		protected static $attributes = array(
				'id',
				'name',
				'cost',
				'category_id',
				'halfs',
				'available'
		);

		protected static function sanitize_data(&$stmt, $passedAttributes) {
			if (array_key_exists('id', $passedAttributes)) $stmt->bindParam(':id', $passedAttributes['id'], PDO::PARAM_INT);
			if (array_key_exists('name', $passedAttributes)) $stmt->bindParam(':name', $passedAttributes['name'], PDO::PARAM_STR, 40);
			if (array_key_exists('cost', $passedAttributes)) $stmt->bindParam(':cost', $passedAttributes['cost'], PDO::PARAM_STR, 40);
			if (array_key_exists('category_id', $passedAttributes)) $stmt->bindParam(':category_id', $passedAttributes['category_id'], PDO::PARAM_INT);
			if (array_key_exists('halfs', $passedAttributes)) $stmt->bindParam(':halfs', $passedAttributes['halfs'], PDO::PARAM_INT);
			if (array_key_exists('available', $passedAttributes)) $stmt->bindParam(':available', $passedAttributes['available'], PDO::PARAM_INT);
		}
		
		protected function sanitize_object(&$stmt) {
			$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
			$stmt->bindParam(':name', $this->name, PDO::PARAM_STR, 40);
			$stmt->bindParam(':cost', $this->cost, PDO::PARAM_STR, 40);
			$stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
			$stmt->bindParam(':halfs', $this->halfs, PDO::PARAM_INT);
			$stmt->bindParam(':available', $this->available, PDO::PARAM_INT);
		}
	}

?>