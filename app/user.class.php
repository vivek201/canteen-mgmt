<?php
	class User extends CRUD {
		protected static $table_name = "user";
		protected static $attributes = array(
				'id',
				'username',
				'password',
				'fname',
				'lname',
				'email',
				'permission'
		);
		
		public function full_name() {
			return ucwords($this->fname . " " . $this->lname);
		}
		
		
		protected static function sanitize_data(&$stmt, $passedAttributes) {
			if (array_key_exists('id', $passedAttributes)) $stmt->bindParam(':id', $passedAttributes['id'], PDO::PARAM_INT);
			if (array_key_exists('username', $passedAttributes)) $stmt->bindParam(':username', $passedAttributes['username'], PDO::PARAM_STR, 30);
			if (array_key_exists('password', $passedAttributes)) $stmt->bindParam(':password', $passedAttributes['password'], PDO::PARAM_STR, 32);
			if (array_key_exists('fname', $passedAttributes)) $stmt->bindParam(':fname', $passedAttributes['fname'], PDO::PARAM_STR, 30);
			if (array_key_exists('lname', $passedAttributes)) $stmt->bindParam(':lname', $passedAttributes['lname'], PDO::PARAM_STR, 30);
			if (array_key_exists('email', $passedAttributes)) $stmt->bindParam(':email', $passedAttributes['email'], PDO::PARAM_STR, 50);
			if (array_key_exists('permission', $passedAttributes)) $stmt->bindParam(':permission', $passedAttributes['permission'], PDO::PARAM_STR, 10);
		}
		
		protected function sanitize_object(&$stmt) {
			$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
			$stmt->bindParam(':username', $this->username, PDO::PARAM_STR, 30);
			$stmt->bindParam(':password', $this->password, PDO::PARAM_STR, 32);
			$stmt->bindParam(':fname', $this->fname, PDO::PARAM_STR, 30);
			$stmt->bindParam(':lname', $this->lname, PDO::PARAM_STR, 30);
			$stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 50);
			$stmt->bindParam(':permission', $this->permission, PDO::PARAM_STR, 10);
		}
		
	}

?>