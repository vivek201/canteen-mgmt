<?php

	abstract class CRUD {
		protected $db;
		protected static $table_name;
		protected static $attributes;
		
		public function __construct() {
			$this->db = Database::getInstance();
			foreach (static::$attributes as $key) {
				if (!isset($this->$key)) $this->$key = '';
			}
		}
		
		public function instantiate($array) {
			foreach ($array as $key => $value) {
				if (in_array($key, static::$attributes)){
					$this->$key = trim($value);
				}
			}
		}
		
		public function insert() {
			$sql = "INSERT INTO " . static::$table_name . " (" . implode(',', static::$attributes) . ") ";
			$sql .= "VALUES (:" . implode(',:', static::$attributes) . ")";
			
			$db = Database::getInstance();
			$stmt = $db->handle->prepare($sql);
			$this->sanitize_object($stmt);
			if ($stmt->execute()) {
				// SUCCESSFULLY INSERTED
				if (in_array('id', static::$attributes))
					$this->id = $db->handle->lastInsertId();
				return TRUE;
			}
			else {
				return FALSE;
			}
		}
		
		public static function select($testCondition = null, $order_by = null) {
			$sql = "SELECT " . implode(',', static::$attributes);
			$sql .= " FROM " . static::$table_name;
// 			var_dump($sql);
			$db = Database::getInstance();
			$objectArray = array();
			if (!is_null($testCondition) && is_array($testCondition)) {
				$sql .= " WHERE ";	
				foreach ($testCondition as $key => $value) {
					if (in_array($key, static::$attributes))
						$sql .= $key . "=:" . $key . " AND ";
				}
				$sql = substr($sql, 0, -5);

				if (isset($order_by)) {
					$sql .= " ORDER BY " .$order_by;
				}
			}
			if (!is_null($testCondition) && is_string($testCondition)) {
				$sql = $testCondition;
			}
			$stmt = $db->handle->prepare($sql);
			if (!is_null($testCondition) && is_array($testCondition)) {
				static::sanitize_data($stmt, $testCondition);
			}
			if ($stmt->execute()) {
				while ($obj = $stmt->fetchObject(get_called_class())) {
					$objectArray[] = $obj;
				}
				if (count($objectArray) == 1)
					return array_shift($objectArray);
				elseif (count($objectArray) == 0)
					return 0;
				return $objectArray;
			}
			else
				return 0;
		}
		
		public function delete() {
			$sql = "DELETE FROM " . static::$table_name . " WHERE id=:id";
			$db = Database::getInstance();
			$stmt = $db->handle->prepare($sql);
			$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
			return $stmt->execute();
		}
	
		public function update($primary_key = NULL) {
			$attribArray = array();
			$sql = "UPDATE " . static::$table_name . " SET ";
			foreach (static::$attributes as $prop) {
				if (!empty($this->$prop) || $this->$prop === 0) {
					$sql .= $prop . "=:" . $prop . ",";
					$attribArray[$prop] = $this->$prop;
				}
			}
			$sql = substr($sql, 0, -1);
			if (isset($primary_key))
				$sql .= " WHERE $primary_key=:$primary_key";
			else
				$sql .= " WHERE id=:id";
			
			$db = Database::getInstance();
			$stmt = $db->handle->prepare($sql);
			static::sanitize_data($stmt, $attribArray);
			if ($stmt->execute())
				return true;
			else 
				return 0;
		}
		
		
		
		public static function count($condition = NULL) {
			$sql = "SELECT COUNT(*) FROM " . static::$table_name;
			if (isset($condition))
				$sql .= " WHERE " . $condition;
			$db = Database::getInstance();
			$rows = $db->handle->query($sql, PDO::FETCH_ASSOC);
			$row = $rows->fetch();
			return  $row['COUNT(*)'];
		}
	}


?>