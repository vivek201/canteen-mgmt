<?php
	require_once 'database.class.php';
	class MenuItemCategory extends CRUD{
		protected static $table_name = 'menu_item_category';
		protected static $attributes = array(
				'id',
				'name'
		);

		protected static function sanitize_data(&$stmt, $passedAttributes) {
			if (array_key_exists('id', $passedAttributes)) $stmt->bindParam(':id', $passedAttributes['id'], PDO::PARAM_INT);
			if (array_key_exists('name', $passedAttributes)) $stmt->bindParam(':name', $passedAttributes['name'], PDO::PARAM_STR, 40);
		}
		
		protected function sanitize_object(&$stmt) {
			$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
			$stmt->bindParam(':name', $this->name, PDO::PARAM_STR, 40);
		}
	}

?>