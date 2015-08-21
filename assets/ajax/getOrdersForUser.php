<?php
	require $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
	$session = new Session();
	$session->allow('staff');
	header("content-type:application/json");
	if (isset($_POST['username']) || isset($_GET['username'])) {
		$db = Database::getInstance();
		$username = $_POST['username'];
// 		$username = $_GET['username'];
		$sql = "SELECT 
					orders.id as ID, 
					menu_item.name as name, 
					orders.quantity as quantity
				FROM 
					orders 
					INNER JOIN menu_item ON orders.menu_item_id = menu_item.id 
				WHERE 
					orders.user_id = (
						SELECT 
							id 
						FROM 
							user 
						WHERE 
							user.username = :username 
							AND user.permission = 'EMPLOYEE'
					) 
					AND orders.date = ' ". today() ."' AND orders.served = '0'";
		$stmt = $db->handle->prepare($sql);
		$stmt->bindValue(':username', $username, PDO::PARAM_STR);
		if ($stmt->execute())
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (count($rows) == 0)
			$rows['username'] = '0';
		else
			$rows['username'] = $username;
		

		echo json_encode($rows);
		exit();
	}
	
?>